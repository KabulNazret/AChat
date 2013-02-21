<?php

/**
 * Simple Ajax-based Chat
 *
 * @author Anthony
 * @link https://github.com/KabulNazret/AChat
 * @version 0.1
 */



class AChatModule extends CWebModule {


    public $defaultController = 'json';


    public function init() {

        $this->setImport(array(
            'AChat.models.*',
            'AChat.components.*',
        ));

        parent::init();


    }


}