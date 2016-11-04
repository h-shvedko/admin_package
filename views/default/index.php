<?php
/* @var $this PackagesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    'Пакеты' => array(''),
);
?>
<div>
    <a href="<?= $this->createUrl('packagesstore/index') ?>"><?= Yii::t('app', 'Настройка пакетов для продуктов из списка товаров') ?>
</div><br><br>
<div>
    <a href="<?= $this->createUrl('packagesstoretype/index') ?>"><?= Yii::t('app', 'Настройка типов пакетов') ?>
</div><br><br>
<div>
   <? /* <a href="<?= $this->createUrl('packages/index') ?>"><?= Yii::t('app', 'Настройка курсов') ?> */ ?>
</div>