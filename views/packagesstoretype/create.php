<?php
/* @var $this PackagesController */
/* @var $model Packages */

$this->breadcrumbs=array(
	'Типы пакетов'=>array('index'),
	'Создание'=>array(''),
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>