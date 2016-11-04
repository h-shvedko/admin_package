<?php

class PackagesstoreControllerBase extends UTIController
{

    public $breadcrumbs = '';
    public $layout = '';

    public function init()
    {
        parent::init();
    }

    public function View($id)
    {
        //$this->checkAccess();
        $this->pageTitle = 'Просмотр пакета';
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function Create()
    {
        //$this->checkAccess();
        $this->pageTitle = 'Создание пакета';
        $model = new PackagesStore();
        $modelLang = new PackagesStoreLang();
        $modelValue = new PackagesStoreValue();
        if (array_key_exists('btn1', $_POST))
        { 
            $model->flag = $_POST['PackagesStore']['flag'];
            $model->type__id = $_POST['PackagesStore']['type__id'];
            $model->price = $_POST['total_price'];
            $model->points = $_POST['total_points'];
            $model->visibility = (int) TRUE;

            $validate = $model->validate();
            if (!(bool) $validate)
            {
                throw new CException('Не верный запрос', E_USER_ERROR);
            }
            if (!$model->save())
            {
                throw new CException('Не верный запрос при сохранении данных', E_USER_ERROR);
            }

            $modelLang->lang = Yii::app()->language;
            $modelLang->name = $_POST['PackagesStoreLang']['name'];
            $modelLang->packages__id = $model->id;
            if (!(bool) $modelLang->validate())
            {
                throw new CException('Не верный запрос', E_USER_ERROR);
            }
            if (!$modelLang->save())
            {
                throw new CException('Не верный запрос при сохранении данных', E_USER_ERROR);
            }
            foreach ($_POST['Product'] as $key => $value)
            {
                $modelValue = new PackagesStoreValue();
                $modelValue->packages__id = $model->id;
                $modelValue->products__id = $value;
                $modelValue->catalogue__id = $_POST['Catalog'][$key];
                $modelValue->price = $_POST['ProductsStore_price'][$key];
                $modelValue->points = $_POST['ProductsStore_points'][$key];

                if (!(bool) $modelValue->validate())
                {
                    throw new CException('Не верный запрос', E_USER_ERROR);
                }
                if (!$modelValue->save())
                {
                    throw new CException('Не верный запрос при сохранении данных', E_USER_ERROR);
                }
            }
            $this->redirect($this->createUrl('/admin/packagesbase/packagesstore'));
        }

        $typeModel = PackagesStoreType::model()->findAll('flag = :flag', array(':flag'=>(int)TRUE));
        if(empty($typeModel))
        {
            throw new CException('Создайте типы пакетов', E_USER_ERROR);
        }
        foreach ($typeModel as $key => $value)
        {
            $type[$value->id] = $value->name;
        }

        Yii::import('application.modules.admin.modules.catalog.models.*');
        $catalogModel = CataloguesLang::model()->findAll();
        foreach ($catalogModel as $key => $value)
        {
            $catalog[$value->catalogues__id] = $value->name;
        }

        $productModel = ProductsLang::model()->findAll();
        foreach ($productModel as $key => $value)
        {
            $product[$value->product__id] = $value->name;
        }
        
        $this->render('create', array(
            'model' => $model,
            'modelLang' => $modelLang,
            'type' => $type,
            'catalog' => $catalog,
            'modelValue' => $modelValue,
            'product' => $product,
        ));
    }

    public function Update($id)
    {
        //$this->checkAccess();
        $this->pageTitle = 'Редактирование пакета';
        $model = $this->loadModel($id);

        $modelLang = PackagesStoreLang::model()->find('packages__id = :packages__id', array(':packages__id' => $id));
        $modelValue = PackagesStoreValue::model()->findAll('packages__id = :packages__id', array(':packages__id' => $id));
        
        if (array_key_exists('btn1', $_POST))
        {
            $model->flag = $_POST['PackagesStore']['flag'];
            $model->type__id = $_POST['PackagesStore']['type__id'];
            $model->price = $_POST['total_price'];
            $model->points = $_POST['total_points'];

            $validate = $model->validate();
            if (!(bool) $validate)
            {
                throw new CException('Не верный запрос', E_USER_ERROR);
            }
            if (!$model->save())
            {
                throw new CException('Не верный запрос при сохранении данных', E_USER_ERROR);
            }

            $modelLang->lang = Yii::app()->language;
            $modelLang->name = $_POST['PackagesStoreLang']['name'];

            if (!(bool) $modelLang->validate())
            {
                throw new CException('Не верный запрос', E_USER_ERROR);
            }
            if (!$modelLang->save())
            {
                throw new CException('Не верный запрос при сохранении данных', E_USER_ERROR);
            }
            
            $delPackagesValue = PackagesStoreValue::model()->deleteAll('packages__id = :packages__id', array(':packages__id'=>$model->id));
            if(!$delPackagesValue)
            {
                throw new CException('Не верный запрос при сохранении данных', E_USER_ERROR);
            }

            foreach ($_POST['product'] as $key => $value)
            {
                $modelValueNew = new PackagesStoreValue();
                $modelValueNew->packages__id = $model->id;
                $modelValueNew->products__id = $value;
                $modelValueNew->catalogue__id = $_POST['catalog'][$key];
                $modelValueNew->price = $_POST['products_price'][$key];
                $modelValueNew->points = $_POST['products_points'][$key];

                if (!(bool) $modelValueNew->validate())
                {
                    throw new CException('Не верный запрос', E_USER_ERROR);
                }
                if (!$modelValueNew->save())
                {
                    throw new CException('Не верный запрос при сохранении данных', E_USER_ERROR);
                }
            }
            $this->redirect($this->createUrl('/admin/packagesbase/packagesstore'));
        }
        $typeModel = PackagesStoreType::model()->findAll('flag = :flag', array(':flag'=>(int)TRUE));
        foreach ($typeModel as $key => $value)
        {
            $type[$value->id] = $value->name;
        }
        Yii::import('application.modules.admin.modules.catalog.models.*');
        $catalogModel = CataloguesLang::model()->findAll();
        foreach ($catalogModel as $key => $value)
        {
            $catalog[$value->catalogues__id] = $value->name;
        }

        $productModel = ProductsLang::model()->findAll();
        foreach ($productModel as $key => $value)
        {
            $product[$value->product__id] = $value->name;
        }

        $cntProducts = count($modelValue);
        $this->render('update', array(
            'model' => $model,
            'modelLang' => $modelLang,
            'modelValue' => $modelValue,
            'cntProducts' => $cntProducts,
            'type' => $type,
            'catalog' => $catalog,
            'product' => $product,
        ));
    }

    public function Flag($id)
    {
        //$this->checkAccess();
        $model = $this->loadModel($id);


        if (isset($model))
        {
            $model->flag = PackagesStore::PACKAGES_FLAG_ON;
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function Delete($id)
    {
        //$this->checkAccess();

        $this->pageTitle = 'Удаление пакета';
        $model = $this->loadModel($id);

        PackagesStore::model()->updateByPk($id, array('visibility' => PackagesStore::PACKAGES_VISIBILITY_NO));

        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    public function Index()
    {

        ////$this->checkAccess();
        $this->pageTitle = 'Просмотр пакетов';

        $define = new PackagesStore();

        $criteria = new CDbCriteria();
        $criteria->condition = 'visibility = :visibility';
        $criteria->params = array(':visibility' => (int) TRUE);

        $count = PackagesStore::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = PackagesStore::PACKAGES_PER_PAGE;
        $pages->applyLimit($criteria);

        $model = PackagesStore::model()->findAll($criteria);
        $modelLang = PackagesStoreLang::model()->findAll();


        $this->render('index', array(
            'model' => $model,
            'modelLang' => $modelLang,
            'pages' => $pages
        ));
    }

    public function loadModel($id)
    {
        $model = PackagesStore::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Packages $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'packages-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
