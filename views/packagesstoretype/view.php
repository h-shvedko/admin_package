<?php
/* @var $this PackagesController */
/* @var $model Packages */

$this->breadcrumbs = array(
    'Типы пакетов' => array('index'),
    $model->name => array('view', 'id' => $model->id),
);
?>

<table>
    <tbody>
        <tr>
            <td style="width: 200px"><?php echo CHtml::encode('id'); ?></td>
            <td><?php echo CHtml::encode($model->id); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::encode('Название пакета'); ?></td>
            <td><?php echo CHtml::encode($model->name); ?></td>
        </tr>

        <tr>
            <td><?php echo CHtml::encode('Алиас пакета'); ?></td>
            <td><?php echo CHtml::encode($model->alias); ?></td>
        </tr>	
    </tbody>
</table>
