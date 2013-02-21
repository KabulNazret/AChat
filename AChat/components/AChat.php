<?php

/**
 * Simple Ajax-based Chat
 *
 * @author Anthony
 * @link https://github.com/KabulNazret/AChat
 * @version 0.1
 */

Yii::import('AChat.models.AChatMessages');

class AChat extends CWidget {

    /**
     * Publish scripts
     * @return void
     */
    public function init() {
        parent::init();

        $this->publishAssets();
    }


    /**
     * Get last 15 messages on module init and render the output
     * @return void
     */
    public function run() {

        $AChatModel = new AChatMessages;
        $criteria = new CDbCriteria();
        $criteria->order = 't.id DESC';
        $criteria->limit = 15;
        $lastMessages = AChatMessages::model()
                                        ->with('user')
                                        ->findAll($criteria);

        $this->render('window',
                            array('lastMessages'    => $lastMessages,
                                    'AChatModel'    => $AChatModel,
                                 )
                    );
    }


    /**
     * Register required css and javasript
     * @return void
     */
    public function publishAssets() {
        $assets = dirname(__FILE__) . '/../assets';
        //$baseUrl = Yii::app()->assetManager->publish($assets, false, -1, YII_DEBUG);
        $baseUrl = Yii::app()->assetManager->publish($assets);

        Yii::app()->clientScript ->registerCssFile($baseUrl . '/css/achat.css');

        Yii::app()->clientScript
            ->registerScriptFile($baseUrl . '/js/jquery.scrollTo.js', CClientScript::POS_HEAD);
        Yii::app()->clientScript
            ->registerScriptFile($baseUrl . '/js/jquery.achat.js', CClientScript::POS_HEAD);
        Yii::app()->clientScript
                    ->registerScriptFile($baseUrl . '/js/jquery.achat-window.js', CClientScript::POS_HEAD);


    }
}