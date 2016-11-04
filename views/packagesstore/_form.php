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
        $('#count').text('1');
        $('#PackagesStoreValue_catalogue__id').attr('name', 'Catalog[1]');
        $('#PackagesStoreValue_products__id').attr('name', 'Product[1]');
        $('#PackagesStore_price').attr('name', 'ProductsStore_price[1]');
        $('#PackagesStore_points').attr('name', 'ProductsStore_points[1]');
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
            $('.i' + countProducts + ' .catalog').attr('name', 'Catalog[' + countProducts + ']');
            $('.i' + countProducts + ' .product').attr('name', 'Product[' + countProducts + ']');
            $('.i' + countProducts + ' .products_price').attr('name', 'ProductsStore_price[' + countProducts + ']');
            $('.i' + countProducts + ' .products_points').attr('name', 'ProductsStore_points[' + countProducts + ']');
            $('#count').text(countProducts);
            $('.i' + countProducts + ' table tbody').append('<tr><td colspan="3"><?php echo CHtml::Button('Удалить товар из пакета', array('name' => 'delete', 'class' => 'delete_product', 'onclick' => 'delete_product(this)')); ?></td></tr>');
        });

    });

    function delete_product(object) {
        $(object).parents('#product').remove();

        var cnt = $('#count').text();
        cnt --;
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
        var catalog = $('.' + num + ' #PackagesStoreValue_catalogue__id').val();
        var productSelect = $('.' + num + ' #PackagesStoreValue_products__id');

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
        var product = $('.' + num + ' #PackagesStoreValue_products__id').val();
        var productSelect = $('.' + num + ' #PackagesStoreValue_products__id').val();
        var packagesPrice = $('.' + num + ' #PackagesStore_price');
        var packagesPoints = $('.' + num + ' #PackagesStore_points');
        var packagesPriceTotal = $(' .total_price');
        var packagesPointsTotal = $(' .total_points');

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
                        ProductValue: product
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
        <div id="product" class="i1">
            <table >
                <tbody>
                    <tr>
                        <td style="width:150px"><?= $form->labelEx($modelValue, 'catalogue__id'); ?></td>
                        <td><?= $form->dropDownList($modelValue, 'catalogue__id', $catalog, array('onchange' => 'call(this)', 'class' => 'catalog')); ?></td>
                        <td><?= $form->error($modelValue, 'catalogue__id'); ?></td>
                    </tr>
                    <tr>
                        <td><?= $form->labelEx($modelValue, 'products__id'); ?></td>
                        <td><?= $form->dropDownList($modelValue, 'products__id', $product, array('onchange' => 'callproduct(this)', 'class' => 'product')); ?></td>
                        <td><?= $form->error($modelValue, 'products__id'); ?></td>
                    </tr>
                    <tr>
                        <td><?= $form->labelEx($model, 'price'); ?></td>
                        <td><?= $form->textField($model, 'price', array('readonly' => 'readonly', 'class' => 'products_price')); ?></td>
                        <td><?= $form->error($model, 'price'); ?></td>
                    </tr>
                    <tr>
                        <td><?= $form->labelEx($model, 'points'); ?></td>
                        <td><?= $form->textField($model, 'points', array('readonly' => 'readonly', 'class' => 'products_points')); ?></td>
                        <td><?= $form->error($model, 'points'); ?></td>
                    </tr>
                </tbody>
            </table>
            <hr>
        </div>
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