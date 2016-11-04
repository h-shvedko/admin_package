<?php
/* @var $this PackagesController */
/* @var $model Packages */

$this->breadcrumbs = array(
    'Пакеты' => array('index'),
    $model->lang->name => array('view', 'id' => $model->id),
);
?>

<table>
    <tbody>
        <tr>
            <td style="width: 200px"><?php echo CHtml::encode(PackagesStore::model()->getAttributeLabel('id')); ?></td>
            <td><?php echo CHtml::encode($model->id); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::encode(PackagesStoreLang::model()->getAttributeLabel('name')); ?></td>
            <td><?php echo CHtml::encode($model->lang->name); ?></td>
        </tr>
        <tr>
            <td><?= Yii::t('app', 'Тип пакета '); ?></td>
            <td><?php echo CHtml::encode($model->type->name); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::encode(PackagesStore::model()->getAttributeLabel('price')); ?></td>
            <td><?php echo CHtml::encode(sprintf('%.2f', $model->price)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::encode(PackagesStore::model()->getAttributeLabel('points')); ?></td>
            <td><?php echo CHtml::encode(sprintf('%.2f', $model->points)); ?></td>
        </tr>		
    </tbody>
</table>
<table style="width: 100%;">
    <tbody>
        <? $id=0; ?>
    <th style="text-align: left;"><?= Yii::t('app', 'Название Каталога: '); ?></th>
        <? foreach ($model->value as $values) : ?>
        <? if ($values->catalogue__id != $id) : ?>
        <tr>
            <td><?php echo CHtml::encode($values->catalogue->lang->name); ?></td>
            <td>
                <table>
                    <tbody>
                        <th style="text-align: left;"><?= Yii::t('app', 'Название продукта: '); ?></th>
                        <? foreach ($model->value as $val) : ?>
                        <? if ($val->catalogue__id == $values->catalogue__id) : ?>
                        <tr>
                            <td><?php echo CHtml::encode($val->product->lang->name); ?></td>
                        </tr>
                        <? endif; ?>
                        <? endforeach; ?>
                    </tbody>
                </table>
            </td>
        </tr>		
        <? endif; ?>
        <? $id = $values->catalogue__id; ?>
        <? endforeach; ?>
    </tbody>
</table>

