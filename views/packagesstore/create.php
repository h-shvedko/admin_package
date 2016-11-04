<?php
/* @var $this PackagesController */
/* @var $model Packages */

$this->breadcrumbs=array(
	'Пакеты'=>array('index'),
	'Создание'=>array(''),
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model,'modelLang'=>$modelLang, 'modelValue'=>$modelValue)); ?>