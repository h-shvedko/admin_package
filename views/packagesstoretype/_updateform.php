<?php
/* @var $this PackagesController */
/* @var $model Packages */
/* @var $form CActiveForm */
?>
<style>
    #block_products, #block_result
    {
        text-align: left;
    }
</style>

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
                <td  style="width:150px"><?php echo $form->labelEx($model, 'name'); ?></td>
                <td><?= $form->textField($model, 'name', array('size' => 50, 'maxlength' => 255)); ?></td>
                <td><?= $form->error($model, 'name'); ?></td>
            </tr>
            <tr>
                <td  style="width:150px"><?php echo $form->labelEx($model, 'alias'); ?></td>
                <td><?= $form->textField($model, 'alias', array('size' => 50, 'maxlength' => 255)); ?></td>
                <td><?= $form->error($model, 'alias'); ?></td>
            </tr>
        </tbody>
    </table>
<?php echo CHtml::submitButton('Сохранить', array('name' => 'btn1')); ?>
<?php $this->endWidget(); ?>

</div><!-- form -->