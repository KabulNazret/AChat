AChat
========

Простой ajax виджет чата для Yii


###Требования
* PHP 5.3+ (с модулями: mod_rewrite, PDO)
* MySql 5.1+
* Yii 1.0 или выше
* jQuery 1.7 или выше


###Установка
* Распакуйте содержимое в папку protected/modules
* Выполните sql-запросы из файла achat/data/install.sql
* В файл конфигурации Yii в секцию 'modules' добавьте:

~~~php
<?php
    //...
    'modules'       => array(
                            'AChat'
                            ),
~~~

* Добавьте следующий код в ваш layout или какой-либо view

~~~php
<?php $this->widget('AChat.components.AChat'); ?>
~~~

###Инфо
* Виджет использует стороннюю библиотеку [jquery.scrollTo](http://demos.flesler.com/jquery/scrollTo/)