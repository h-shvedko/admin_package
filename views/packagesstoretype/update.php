<?php
/* @var $this PackagesController */
/* @var $model Packages */

$this->breadcrumbs=array(
	'Типы пакетов'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Редактирование'=>array('update','id'=>$model->id),
);

?>

<?php echo $this->renderPartial('_updateform', array('model'=>$model)); ?>