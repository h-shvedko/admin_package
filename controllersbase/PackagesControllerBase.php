<?php

class PackagesControllerBase extends UTIController
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
        $model = new Packages();
        $modelLang = new PackagesLang();

        $model->setScenario('create');
        $modelLang->setScenario('create');


        if (array_key_exists('btn1', $_POST))
        {
            $model->attributes = array_key_exists('Packages', $_POST) ? $_POST['Packages'] : $model->attributes;
            $model->flag = $_POST['Packages']['flag'];

            $modelLang->attributes = array_key_exists('PackagesLang', $_POST) ? $_POST['PackagesLang'] : $modelLang->attributes;
            $modelLang->lang = Yii::app()->language;

            $validate = $model->validate();
            if ($validate)
            {
                $modelPrices = Prices::model()->findByPk($model->my_price_courses__id);
                $model->price_courses = $modelPrices->price;

                $modelPrices = Prices::model()->findByPk($model->my_price__id);
                $model->price = $modelPrices->price;
            }


            $validate = $model->validate();
            $validate = $modelLang->validate() && $validate;


            if ((bool) $validate)
            {

                $model->save();
                $modelLang->pak_packages__id = $model->id;
                $modelLang->save();
                $this->redirect(array('view', 'id' => $model->id));
            }
        }
        $model->price = sprintf('%.2f', $model->price);
        $this->render('create', array(
            'model' => $model,
            'modelLang' => $modelLang,
        ));
    }

    public function Update($id)
    {
        //$this->checkAccess();
        $this->pageTitle = 'Редактирование пакета';
        $model = $this->loadModel($id);


        $modelLang = PackagesLang::model()->find('pak_packages__id = :pak_packages__id', array(':pak_packages__id' => $id));

        $model->setScenario('update');
        $modelLang->setScenario('create');

        if (array_key_exists('btn1', $_POST))
        {
            $model->attributes = array_key_exists('Packages', $_POST) ? $_POST['Packages'] : $model->attributes;
            $model->flag = $_POST['Packages']['flag'];

            $modelLang->attributes = array_key_exists('PackagesLang', $_POST) ? $_POST['PackagesLang'] : $modelLang->attributes;
            $modelLang->lang = Yii::app()->language;

            $validate = $model->validate();
            $validate = $modelLang->validate() && $validate;
            if ((bool) $validate)
            {
                $model->save();
                $modelLang->pak_packages__id = $model->id;
                $modelLang->save();
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $model->price = sprintf('%.2f', $model->price);
        $this->render('update', array(
            'model' => $model,
            'modelLang' => $modelLang,
        ));
    }

    public function Flag($id)
    {
        //$this->checkAccess();
        $model = $this->loadModel($id);


        if (isset($model))
        {
            $model->flag = PACKAGES_FLAG_ON;
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

        $errorDelete = false;

        if (!$errorDelete)
        {
            Packages::model()->updateByPk($id, array('visibility' => PACKAGES_VISIBILITY_NO));
        }
        else
        {

            Yii::app()->user->setFlash('error', Yii::t('app', 'Удалить не возможно, пакет используется'));
            $this->redirect('/admin/packagesbase/packages');
        }

        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    public function Index()
    {

        //$this->checkAccess();
        $this->pageTitle = 'Просмотр пакетов';

        $define = new Packages();

        $criteria = new CDbCriteria();
        $criteria->condition = 'visibility <> :visibility';
        $criteria->params = array(':visibility' => PACKAGES_VISIBILITY_NO);

        $count = Packages::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = PACKAGES_PER_PAGE;
        $pages->applyLimit($criteria);

        $model = Packages::model()->findAll($criteria);
        $modelLang = PackagesLang::model()->findAll();


        $this->render('index', array(
            'model' => $model,
            'modelLang' => $modelLang,
            'pages' => $pages
        ));
    }

    public function loadModel($id)
    {
        $model = Packages::model()->findByPk($id);
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
