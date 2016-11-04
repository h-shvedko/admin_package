<?php
/* @var $this PackagesController */
/* @var $model Packages */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'packages-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note">Поля, <span class="required">*</span> обязательны для заполнения.</p>

    <table>
        <tbody>
            <tr>
                <td  style="width:150px"><?php echo $form->labelEx($modelLang, 'name'); ?></td>
                <td><?php echo $form->textField($modelLang, 'name', array('size' => 50, 'maxlength' => 255)); ?></td>
                <td><?php echo $form->error($modelLang, 'name'); ?></td>
            </tr>
            <?/*
            <tr>
            <td><?php echo $form->labelEx($modelLang, 'short_name'); ?></td>
            <td><?= FSmarty::ckeditor(array('name' => 'PackagesLang[short_name]', 'type' => 'content', 'ckfinder' => true, 'value' => $modelLang->short_name ? $modelLang->short_name : NULL)) ?></td>
            <td><?php echo $form->error($modelLang, 'short_name'); ?></td>
            </tr>

            <tr>
            <td><?php echo $form->labelEx($modelLang, 'detailed_name'); ?></td>
            <td><?= FSmarty::ckeditor(array('name' => 'PackagesLang[detailed_name]', 'type' => 'content', 'ckfinder' => true, 'value' => $modelLang->detailed_name ? $modelLang->detailed_name : NULL)) ?></td>
            <td><?php echo $form->error($modelLang, 'detailed_name'); ?></td>
            </tr> */?>
            <? if ($model->isNewRecord): ?>
            <tr>
                <td><?php echo $form->labelEx($model, 'count'); ?></td>
                <td><?php echo $form->textField($model, 'count', array('size' => 20, 'maxlength' => 20)); ?></td>
                <td><?php echo $form->error($model, 'count'); ?></td>
            </tr>
            <? else:?>		
            <tr>
                <td><?php echo $form->labelEx($model, 'count'); ?></td>
                <td><?php echo $model->count ?></td>
                <td></td>
            </tr>			
            <? endif;?>
            <? if (!$model->isNewRecord): ?>
            <tr>
                <td><?php echo $form->labelEx($model, 'price'); ?></td>
                <td><?php echo CHtml::encode(sprintf('%.2f', $model->price)); ?></td>
            </tr>
            <? else:?>		
            <tr>
                <td><?php echo Yii::t('app', 'Стоимость пакета') ?> <span class="required">*</span></td>
                <td><?php echo $form->dropDownList($model, 'my_price__id', Courses::allUpdateCoursesprice(false, false), array('options' => array($model->my_price__id => array('selected' => true)), 'style' => 'width:356px')); ?></td>
                <td><?php echo $form->error($model, 'my_price__id'); ?></td>
            </tr>
            <? endif;?>

            <tr>
                <td><?php echo $form->labelEx($model, 'flag'); ?></td>
                <td><?php echo $form->checkBox($model, 'flag'); ?></td>
                <td><?php echo $form->error($model, 'flag'); ?></td>
            </tr>

            <? if (!$model->isNewRecord): ?>
            <tr>
                <td><?php echo Yii::t('app', 'Текущая цена курсов') ?></td>
                <td><?php echo CHtml::encode(sprintf('%.2f', $model->price_courses)); ?></td>
            </tr>
            <? else:?>
            <tr>
                <td><?php echo Yii::t('app', 'Цена курсов') ?> <span class="required">*</span></td>
                <td><?php echo $form->dropDownList($model, 'my_price_courses__id', Courses::allUpdateCoursesprice(false, false), array('options' => array($model->my_price_courses__id => array('selected' => true)), 'style' => 'width:356px')); ?></td>
                <td><?php echo $form->error($model, 'my_price_courses__id'); ?></td>
            </tr>
            <? endif; ?>

        </tbody>
    </table>

    <?php echo CHtml::submitButton('Сохранить', array('name' => 'btn1')); ?>


<?php $this->endWidget(); ?>

</div><!-- form -->