<?php
/* @var $this PackagesController */
/* @var $model Packages */

$this->breadcrumbs = array(
	'Пакеты' => array('index'),
	$model->lang->name=>array('view','id'=>$model->id),
);
?>

<table>
	<tbody>
		<tr>
			<td style="width: 200px"><?php echo CHtml::encode(Packages::model()->getAttributeLabel('id')); ?></td>
			<td><?php echo CHtml::encode($model->id); ?></td>
		</tr>
		<tr>
			<td><?php echo CHtml::encode(PackagesLang::model()->getAttributeLabel('name')); ?></td>
			<td><?php echo CHtml::encode($model->lang->name); ?></td>
		</tr>
		<tr>
			<td><?php echo CHtml::encode(Packages::model()->getAttributeLabel('count')); ?></td>
			<td><?php echo $model->count; ?></td>
		</tr>			
		<tr>
			<td><?php echo CHtml::encode(Packages::model()->getAttributeLabel('price')); ?></td>
			<td><?php echo CHtml::encode(sprintf('%.2f',$model->price)); ?></td>
		</tr>
		<tr>
			<td><?php echo CHtml::encode(Packages::model()->getAttributeLabel('price_courses')); ?></td>
			<td><?php echo CHtml::encode(sprintf('%.2f',$model->price_courses)); ?></td>
		</tr>		
	</tbody>
</table>

