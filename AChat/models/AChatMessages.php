<?php

/**
 * Simple Ajax-based Chat
 *
 * @author Anthony
 * @link https://github.com/KabulNazret/AChat
 * @version 0.1
 */


class AChatMessages extends CActiveRecord {


    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{achat_messages}}';
    }

    public function relations() {
        return array(
            'user'          => array(parent::BELONGS_TO, 'User', 'user_id'),
        );
    }

    public function rules() {
        return array(
                        array('text', 'safe'),
                        array('text', 'required'),
                        array('text', 'length', 'max' => 100, 'min' => 1, 'allowEmpty' => false),
                        array('user_id', 'numerical', 'min' => -1, 'allowEmpty' => true),
                        array('time', 'numerical', 'allowEmpty' => true),
                    );
    }

}