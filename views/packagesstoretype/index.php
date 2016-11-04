<?php
/* @var $this PackagesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    'Пакеты' => array(''),
);
?>
<div>
    <a href="<?= $this->createUrl('create') ?>"><?= Yii::t('app', 'Создать тип для пакетов') ?></a>
</div>
<table>
    <thead>
        <tr>
            <td style="width: 200px"><?php echo CHtml::encode('id'); ?></td>
            <td><?php echo CHtml::encode('Название пакета'); ?></td>
            <td><?php echo CHtml::encode('Алиас пакета'); ?></td>
        </tr>
        <tr>
        </tr>
    </thead>
    <tbody>
        <? if (isset($model)): ?>
        <? foreach ($model as $key => $value): ?>
        <tr>
            <td style="width: 60px"><?php echo CHtml::link(CHtml::encode($value->id), array('view', 'id' => $value->id)); ?></td>
            <td style="width: 300px"><?php echo CHtml::encode($value->name); ?></td>
            <td style="width: 300px"><?php echo CHtml::encode($value->alias); ?></td>
            <td>
                <?php echo CHtml::link('Просмотреть', '/admin/packagesbase/packagesstoretype/view/id/' . $value->id); ?>
                <?php echo CHtml::link('Редактирование', '/admin/packagesbase/packagesstoretype/update/id/' . $value->id); ?>
                <?= CHtml::form('', 'post', array('style' => 'display:inline-block')) ?>
                <?=
                CHtml::linkButton('Удаление типа пакета', array(
                    'submit' => array(
                        '/admin/packagesbase/packagesstoretype/delete/',
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
                    echo CHtml::link('Сделать активным', '/admin/packagesbase/packagesstoretype/flag/id/' . $value->id);
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
