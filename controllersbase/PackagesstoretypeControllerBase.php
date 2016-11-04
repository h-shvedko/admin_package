<?php

class PackagesstoretypeControllerBase extends UTIController
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
        $this->pageTitle = 'Просмотр типов пакетов';
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function Create()
    {
        //$this->checkAccess();
        $this->pageTitle = 'Создание типа пакетов';
        $model = new PackagesStoreType();
        if (array_key_exists('btn1', $_POST))
        {
            $model->flag = (int)TRUE;
            $model->name = $_POST['PackagesStoreType']['name'];
            $model->alias = $_POST['PackagesStoreType']['alias'];

            $validate = $model->validate();
            if (!(bool) $validate)
            {
                throw new CException('Не верный запрос', E_USER_ERROR);
            }
            if (!$model->save())
            {
                throw new CException('Не верный запрос при сохранении данных', E_USER_ERROR);
            }

            $this->redirect($this->createUrl('/admin/packagesbase/packagesstoretype'));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function Update($id)
    {
        //$this->checkAccess();
        $this->pageTitle = 'Редактирование пакета';
        $model = $this->loadModel($id);

        if (array_key_exists('btn1', $_POST))
        {
            $model->name = $_POST['PackagesStoreType']['name'];
            $model->alias = $_POST['PackagesStoreType']['alias'];

            $validate = $model->validate();
            if (!(bool) $validate)
            {
                throw new CException('Не верный запрос', E_USER_ERROR);
            }
            if (!$model->save())
            {
                throw new CException('Не верный запрос при сохранении данных', E_USER_ERROR);
            }
            $this->redirect($this->createUrl('/admin/packagesbase/packagesstoretype'));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function Flag($id)
    {
        //$this->checkAccess();
        $model = $this->loadModel($id);


        if (!empty($model))
        {
            $model->flag = PackagesStore::PACKAGES_FLAG_ON;
            if (!$model->save())
            {
                throw new CException('Не верный запрос при сохранении данных', E_USER_ERROR);
            }
            $this->redirect(array('view', 'id' => $model->id));
        }


        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function Delete($id)
    {
        //$this->checkAccess();
        $model = $this->loadModel($id);

        if (!empty($model))
        {
            $model->flag = PackagesStore::PACKAGES_FLAG_OFF;
            if (!$model->save())
            {
                throw new CException('Не верный запрос при сохранении данных', E_USER_ERROR);
            }
        }

        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    public function Index()
    {

        //$this->checkAccess();
        $this->pageTitle = 'Просмотр типов пакетов';

        $define = new PackagesStoreType();

        $criteria = new CDbCriteria();
        $criteria->condition = 'flag = :flag';
        $criteria->params = array(':flag' => (int) TRUE);

        $count = PackagesStore::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = PackagesStore::PACKAGES_PER_PAGE;
        $pages->applyLimit($criteria);

        $model = PackagesStoreType::model()->findAll($criteria);

        $this->render('index', array(
            'model' => $model,
            'pages' => $pages
        ));
    }

    public function loadModel($id)
    {
        $model = PackagesStoreType::model()->findByPk($id);
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
