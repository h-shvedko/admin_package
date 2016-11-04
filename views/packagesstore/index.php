<?php
/* @var $this PackagesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    'Пакеты' => array(''),
);
?>
<div>
    <a href="<?= $this->createUrl('create') ?>"><?= Yii::t('app', 'Создать пакет') ?></a>
</div>
<table>
    <thead>
        <tr>
            <td><?php echo CHtml::encode(PackagesStore::model()->getAttributeLabel('id')); ?></td>
            <td><?php echo CHtml::encode(PackagesStoreLang::model()->getAttributeLabel('Название')); ?></td>
            <td><?php echo CHtml::encode(PackagesStore::model()->getAttributeLabel('price')); ?></td>
            <td><?php echo CHtml::encode(PackagesStore::model()->getAttributeLabel('points')); ?></td>
            <td><?php echo CHtml::encode(PackagesStore::model()->getAttributeLabel('Состояние')); ?></td>
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
            <td style="width: 100px"><?php echo CHtml::encode(sprintf('%.2f', $value->price)); ?></td>
            <td style="width: 100px"><?php echo CHtml::encode(sprintf('%.2f', $value->points)); ?></td>
            <? if ($value->flag == (int)TRUE) : ?>
            <td style="width: 100px"><?=Yii::t('app','Активен'); ?></td>
            <? else : ?>
            <td style="width: 100px"><?=Yii::t('app','Не активен'); ?></td>
            <? endif; ?>
            <td>
                <?php echo CHtml::link('Просмотреть', '/admin/packagesbase/packagesstore/view/id/' . $value->id); ?>
                <?php echo CHtml::link('Редактирование', '/admin/packagesbase/packagesstore/update/id/' . $value->id); ?>
                <?= CHtml::form('', 'post', array('style' => 'display:inline-block')) ?>
                <?=
                CHtml::linkButton('Удаление пакета', array(
                    'submit' => array(
                        '/admin/packagesbase/packagesstore/delete/',
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
                    echo CHtml::link('Сделать активным', '/admin/packagesbase/packagesstore/flag/id/' . $value->id);
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
