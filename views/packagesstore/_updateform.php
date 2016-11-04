<?php
/* @var $this PackagesController */
/* @var $model Packages */
/* @var $form CActiveForm */
?>
<style>
    #block_products, #block_result
    {
        text-align: left;
    }
</style>
<script>
    $(document).ready(function() {
        $('#count').text(<?= CHtml::encode($cntProducts); ?>);
       // $('.catalog').attr('name', 'catalog[1]');
       // $('.product').attr('name', 'product[1]');
        $('#Packages_price').attr('name', 'products_price[1]');
        $('#Packages_points').attr('name', 'products_points[1]');
        $('#changePrice').click(function() {
            $('.total_price').removeAttr('readonly');
        });

        $('#changePoints').click(function() {
            $('.total_points').removeAttr('readonly');
        });

        $('#productAdd').click(function() {
            var divContent = $('#product').html();
            var countProducts = parseInt($('#count').text());

            countProducts = countProducts + 1;
            $('#block_products').append('<div id="product" class="i' + countProducts + '">' + divContent + '</div>');
            $('.i' + countProducts + ' .catalog').attr('name', 'catalog[' + countProducts + ']');
            $('.i' + countProducts + ' .product').attr('name', 'product[' + countProducts + ']');
            $('.i' + countProducts + ' .products_price').attr('name', 'products_price[' + countProducts + ']');
            $('.i' + countProducts + ' .products_points').attr('name', 'products_points[' + countProducts + ']');
            $('#count').text(countProducts);
            $('.i' + countProducts + ' table tbody').append('<tr><td colspan="3"><?php echo CHtml::Button('Удалить товар из пакета', array('name' => 'delete', 'class' => 'delete_product', 'onclick' => 'delete_product(this)')); ?></td></tr>');
        });

    });

    function delete_product(object) {
        $(object).parents('#product').remove();

        var cnt = $('#count').text();
        cnt--;
        var sum = sum_total();
        var points = points_total();
        var packagesPriceTotal = $(' .total_price');
        var packagesPointsTotal = $(' .total_points');
        packagesPriceTotal.val(sum);
        packagesPointsTotal.val(points);
        $('#count').text(cnt);

    }

    function sum_total() {
        var sum = 0;
        $('.products_price').each(function(i) {
            if ($(this).val())
            {
                sum += parseFloat($(this).val());
            }
        });
        return sum;
    }

    function points_total() {
        var sum = 0;
        $('.products_points').each(function(i) {
            if ($(this).val())
            {
                sum += parseFloat($(this).val());
            }
        });
        return sum;
    }

    function call(object) {
        var num = $(object).parents('#product').attr('class');
        var catalog = $('.' + num + ' .catalog').val();
        var productSelect = $('.' + num + ' .product');

        $.ajax({
            url: app.createAbsoluteUrl('admin/packagesbase/ajaxpackages/form_product'),
            error: function()
            {
                alert('Ошибка запроса');
            },
            success: function(data)
            {
                productSelect.html('');

                $.each(data, function(i) {
                    productSelect.append('<option value="' + i + '">' + data[i] + '</option>');
                });
            },
            data:
                    {
                        YII_CSRF_TOKEN: app.csrfToken,
                        PackagesValue: catalog
                    },
            async: false,
            cache: false
        });
    }

    function callproduct(object) {
        var num = $(object).parents('#product').attr('class');
        var packagesPrice = $('.' + num + ' .products_price');
        var packagesPoints = $('.' + num + ' .products_points');
        var packagesPriceTotal = $(' .total_price');
        var packagesPointsTotal = $(' .total_points');
        var valueOfObject = $(object).attr('value');

        $.ajax({
            url: app.createAbsoluteUrl('admin/packagesbase/ajaxpackages/form_price'),
            error: function()
            {
                alert('Ошибка запроса');
            },
            success: function(data)
            {
                packagesPrice.html('');
                packagesPoints.html('');
                packagesPrice.val(data['price']);
                packagesPoints.val(data['points']);
            },
            data:
                    {
                        YII_CSRF_TOKEN: app.csrfToken,
                        ProductValue: valueOfObject
                    },
            async: false,
            cache: false
        });

        var sum = sum_total();
        var points = points_total();
        packagesPriceTotal.val(sum);
        packagesPointsTotal.val(points);
    }
</script>
<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'packages-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note">Поля, <span class="required">*</span> обязательны для заполнения.</p>

    <table>
        <tbody>
            <tr>
                <td  style="width:150px"><?php echo $form->labelEx($modelLang, 'name'); ?></td>
                <td><?= $form->textField($modelLang, 'name', array('size' => 50, 'maxlength' => 255)); ?></td>
                <td><?= $form->error($modelLang, 'name'); ?></td>
            </tr>
            <tr>
                <td><?= $form->labelEx($model, 'type__id'); ?></td>
                <td><?= $form->dropDownList($model, 'type__id', $type); ?></td>
                <td><?= $form->error($model, 'type__id'); ?></td>
            </tr>
        </tbody>
    </table>
    <hr>
    <div id="block_products">
        <? $i=1; ?>
        <? foreach ($modelValue as $value) : ?>
        <div id="product" class="<?php echo"i" . $i; ?>">
            <table >
                <tbody>
                    <tr>
                        <td style="width:150px"><?= $form->labelEx($value, 'catalogue__id'); ?></td>
                        <td><?= $form->dropDownList($value, 'catalogue__id', $catalog, array('onchange' => 'call(this)', 'class' => 'catalog', 'name'=>'catalog['.$i.']')); ?></td>
                        <td><?= $form->error($value, 'catalogue__id'); ?></td>
                    </tr>
                    <tr>
                        <td><?= $form->labelEx($value, 'products__id'); ?></td>
                        <td><?= $form->dropDownList($value, 'products__id', $product, array('onchange' => 'callproduct(this)', 'class' => 'product', 'name'=>'product['.$i.']')); ?></td>
                        <td><?= $form->error($value, 'products__id'); ?></td>
                    </tr>
                    <tr>
                        <td><?= $form->labelEx($value, 'price'); ?></td>
                        <td><?= $form->textField($value, 'price', array('readonly' => 'readonly', 'class' => 'products_price', 'name'=>'products_price['.$i.']')); ?></td>
                        <td><?= $form->error($value, 'price'); ?></td>
                    </tr>
                    <tr>
                        <td><?= $form->labelEx($value, 'points'); ?></td>
                        <td><?= $form->textField($value, 'points', array('readonly' => 'readonly', 'class' => 'products_points', 'name'=>'products_points['.$i.']')); ?></td>
                        <td><?= $form->error($value, 'points'); ?></td>
                    </tr>
                    <? if ($i>1) : ?>
                    <tr>
                        <td colspan="3">
                            <?php echo CHtml::Button('Удалить товар из пакета', array('name' => 'delete', 'class' => 'delete_product', 'onclick' => 'delete_product(this)')); ?>
                        </td>
                    </tr>
                    <? endif; ?>
                </tbody>
            </table>
            <hr>
            <? $i++; ?>
        </div>
        <? endforeach; ?>
    </div>
    <span style=" font-weight: bold;"><?= Yii::t('app', 'Итоговые данные:'); ?></span>
    <table id="block_result">
        <tbody>
            <tr>
                <td style="width:150px"><?= $form->labelEx($model, 'price'); ?></td>
                <td><?= $form->textField($model, 'price', array('readonly' => 'readonly', 'class' => 'total_price', 'name' => 'total_price')); ?>
                    <?php echo CHtml::Button('Редактировать', array('id' => 'changePrice')); ?></td>
                <td><?= $form->error($model, 'price'); ?></td>
            </tr>
            <tr>
                <td><?= $form->labelEx($model, 'points'); ?></td>
                <td><?= $form->textField($model, 'points', array('readonly' => 'readonly', 'class' => 'total_points', 'name' => 'total_points')); ?>
                    <?php echo CHtml::Button('Редактировать', array('id' => 'changePoints')); ?></td>
                <td><?= $form->error($model, 'points'); ?></td>
            </tr>

            <tr>
                <td><?= $form->labelEx($model, 'flag'); ?></td>
                <td><?= $form->checkBox($model, 'flag'); ?></td>
                <td><?= $form->error($model, 'flag'); ?></td>
            </tr>
        </tbody>
    </table>
    <div id="count_products" style=" font-weight: bold;">
        <p><?= Yii::t('app', 'Всего выбрано товаров: '); ?></p>
        <p id="count"></p>
    </div>
    <?php echo CHtml::Button('Добавить товар', array('name' => 'btn_store', 'id' => 'productAdd')); ?>
    <?php echo CHtml::submitButton('Сохранить', array('name' => 'btn1')); ?>


    <?php $this->endWidget(); ?>

</div><!-- form -->