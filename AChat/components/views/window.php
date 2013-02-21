<div class="achat-window">

    <div class="left">

    </div>

    <div class="main">

        <div class="messages">
            <?php $form = $this->beginWidget('CActiveForm', array(
            'id'						=> 'achat-form',
            'enableAjaxValidation' 		=> true,
            'enableClientValidation'    => true,
            'clientOptions'             => array(
                                                'validationUrl'     => Yii::app()->createUrl('AChat/json/post'),
                                                'validateOnSubmit' => true,
                                                'afterValidate' => 'js: function(form, data, hasError) {
                                                    //i think there should be a more elegant solution ...
                                                    if(!hasError) {
                                                        $("#AChatMessages_text").val("");
                                                        $.achatAddMessage({msg: data.message, last: false, ignore: true});
                                                    }
                                                    $("#messages-div").scrollTo("ul > li.last", 200, {axis:"y"});
                                                return false; }'
            ),
            'action'                    => Yii::app()->createUrl('AChat/json/post')
        )); ?>

            <!-- messages area -->
            <div style="height: 200px;overflow-y: scroll;" id="messages-div">
                <ul id="messages-list">
                <?php if(!empty($lastMessages)):
                        $lastMessages = array_reverse($lastMessages);
                ?>

                <?php
                    $i = 1;
                    $count = count($lastMessages);
                    foreach($lastMessages as $msg):
                ?>
                    <li <?= ($i == $count ? 'class="last" name="' . $msg->id . '"' : ''); ?>>
                        <?php if($msg->user_id == -1): ?>
                            <i>Guest</i>
                        <?php else: ?>
                            <b><?= $msg->user->username; ?></b>
                        <?php endif; ?>, <?= date('m-d H:i:s', $msg->time); ?> : <?= $msg->text; ?>
                    </li>
                <?php
                    $i++;
                    endforeach;
                ?>
                <?php endif; ?>
                </ul>

                <?php $form->errorSummary($AChatModel); ?>

                <?= $form->error($AChatModel,'text'); ?>

            </div>

            <!-- new message area -->
            <div style="height: 40px; clear: both;">
                <?= $form->textArea($AChatModel,
                'text',
                array(
                        'class'     => 'textarea-msg',
                        'maxlength' => 100
                )
                ); ?>

                <?= CHtml::submitButton('Send', array('class' => 'submit-msg')); ?>
            </div>

            <? $this->endWidget(); ?>
        </div>



    </div>

    <br style="clear: both;" />
</div>