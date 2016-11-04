<?php
/* @var $this PackagesController */
/* @var $model Packages */

$this->breadcrumbs=array(
	'Пакеты'=>array('index'),
	$model->lang->name=>array('view','id'=>$model->id),
	'Редактирование'=>array('update','id'=>$model->id),
);

?>

<?php echo $this->renderPartial('_updateform', array('model'=>$model,'modelLang'=>$modelLang,'modelValue'=>$modelValue)); ?>