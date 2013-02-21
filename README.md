AChat
========

Simple Ajax-based Chat widget for Yii


###Requirements
* PHP 5.3+ (with following extensions: mod_rewrite, PDO)
* MySql 5.1+
* Yii 1.0 or above
* jQuery 1.7 or above


###Installation
* Extract the release file into protected/modules
* Execute sql instructions from achat/data/install.sql 
* Add the following to your config file 'modules' section:

~~~php
<?php
    //...
    'modules'       => array(
                            'AChat' 
                            ),
~~~

* Add the following to your layout or some view

~~~php
<?php $this->widget('AChat.components.AChat'); ?>
~~~

###Info
* The widget uses the third-party jQuery library [jquery.scrollTo](http://demos.flesler.com/jquery/scrollTo/)
