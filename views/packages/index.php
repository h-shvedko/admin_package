<?php
/* @var $this PackagesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Пакеты' => array(''),
);
?>

<table>
    <thead>
		<tr>
			<td><?php echo CHtml::encode(Packages::model()->getAttributeLabel('id')); ?></td>
			<td><?php echo CHtml::encode(PackagesLang::model()->getAttributeLabel('name')); ?></td>
			<td><?php echo CHtml::encode(Packages::model()->getAttributeLabel('count')); ?></td>
			<td><?php echo CHtml::encode(Packages::model()->getAttributeLabel('price')); ?></td>
			<td><?php echo CHtml::encode(Packages::model()->getAttributeLabel('price_courses')); ?></td>
			<td>Действие</td>
		</tr>
		<tr>

		</tr>
    </thead>
    <tbody>
		<? if (isset($model)): ?>
			<? foreach ($model as $key => $value): ?>
		        <tr>
		            <td style="width: 60px"><?php echo CHtml::link(CHtml::encode($value->id), array('view', 'id' => $value->id)); ?></td>
		            <td style="width: 300px"><?php echo CHtml::encode($value->lang->name); ?></td>
					<td style="width: 100px"><?php echo CHtml::encode($value->count); ?></td>
		            <td style="width: 100px"><?php echo CHtml::encode(sprintf('%.2f', $value->price)); ?></td>
					<td style="width: 100px"><?php echo CHtml::encode(sprintf('%.2f', $value->price_courses)); ?></td>
		            <td>
						<?php echo CHtml::link('Просмотреть', '/admin/packages/packages/view/id/' . $value->id); ?>
						<?php echo CHtml::link('Редактирование', '/admin/packages/packages/update/id/' . $value->id); ?>
						<?= CHtml::form('', 'post', array('style' => 'display:inline-block')) ?>
						<?=
						CHtml::linkButton('Удаление пакета', array(
							'submit' => array(
								'/admin/packages/packages/delete/',
								'id' => $value['id']
							),
							'params' => array(
								Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
							),
							'confirm' => "Удалить пункт?"
						))
						?>
						<?= CHtml::endForm() ?>				
						<?php
						if (empty($value->flag))
						{
							echo CHtml::link('Сделать активным', '/admin/packages/packages/flag/id/' . $value->id);
						}
						else
						{
							echo '';
						}
						?>
		            </td>
		        </tr>
			<? endforeach; ?>
<? endif; ?>
    </tbody>
</table>
<br />
<? $this->widget('CLinkPager', array('pages' => $pages))?>
