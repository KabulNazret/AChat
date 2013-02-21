<?php

/**
 * Simple Ajax-based Chat
 *
 * @author Anthony
 * @link https://github.com/KabulNazret/AChat
 * @version 0.1
 */

class JsonController extends CController {

   public $defaultAction = 'get';

    public function init() {
        if(!Yii::app()->request->getIsAjaxRequest()) {
            Yii::app()->end();
        }

        parent::init();
    }

    /**
     * Post new message into database
     */
    public function actionPost() {

        $messagesModel = new AChatMessages;

        if(isset($_POST['ajax']) && $_POST['ajax'] == 'achat-form') {
            $_POST['AChatMessages']['text'] = preg_replace('/[^0-9a-zA-Zа-яА-я\!\?\-\., ]/ui',
                                                            '',
                                                            $_POST['AChatMessages']['text']
                                                            );

            $res = CActiveForm::validate($messagesModel);
            if($res == '[]') {
                //request is valid, add some data ...
                $_POST['time'] = time();
                $_POST['user_id'] = Yii::app()->user->getIsGuest()
                                    ? -1
                                    : Yii::app()->user->getId();
                $messagesModel->attributes = $_POST;
                $messagesModel->save();

                //get this row (with user name)
                $msgId = $messagesModel->getPrimaryKey();
                $addedMsg = $messagesModel->with('user')->findByPk($msgId);

                $message = array(
                                'id'        => $addedMsg->id,
                                'datetime'  => date('m-d H:i:s', $addedMsg->time),
                                'text'      => $addedMsg->text,
                                'user_id'   => $addedMsg->user_id,
                                'username'  => (!empty($addedMsg->user) ? $addedMsg->user->username : null),
                            );

                $this->responseJson(1, array('message' => $message));
            } else {
                echo $res;
            }
        }
        Yii::app()->end();
    }


    /**
     * Get last messages from database
     */
    public function actionGet() {

        $msgModel = AChatMessages::model();
        $criteria = new CDbCriteria();

        /*
         * 1.2 Widget should request server asking for new messages once each 5 seconds.
         * 1.10. Widget should show only 15 last messages.
         * This is also the case when new user connects to website.
         */
        $lastId = Yii::app()->request->getParam('lastId');
        if(ctype_digit($lastId) && $lastId > 0) {
            $criteria->addCondition('t.id > ' . (int)$lastId);
        } else {
            $criteria->limit = 15;
        }

        //add ignored message id
        $ignoreId = Yii::app()->request->getParam('ignoreId');
        if(ctype_digit($ignoreId) && $ignoreId > 0) {
            $criteria->addCondition('t.id != ' . (int)$ignoreId);
        }

        $criteria->order = 't.id DESC';

        $messagesList = $msgModel->with('user')->findAll($criteria);

        $response = array('count' => 0, 'messages' => array());

        //add messages into response
        if($messagesList != null) {
            $response['count'] = count($messagesList);
            foreach($messagesList as $msg) {
                $response['messages'][] = array(
                                                'id'        => $msg->id,
                                                'datetime'  => date('m-d H:i:s', $msg->time),
                                                'text'      => $msg->text,
                                                'user_id'   => $msg->user_id,
                                                'username'  => (!empty($msg->user) ? $msg->user->username : null),
                                                );
            }
            $response['messages'] = array_reverse($response['messages']);
        }

        $this->responseJson(1, $response);

        Yii::app()->end();
    }


    /**
     * Show JSON response packet with status and additionally data
     * @param int $status
     * @param array $data
     * @return void
     */
    protected function responseJson($status = 0, $data = array()) {
        $response = array('status' => $status);
        if(!empty($data)) {
            $response = array_merge($response, $data);
        }
        echo json_encode($response);
    }


}