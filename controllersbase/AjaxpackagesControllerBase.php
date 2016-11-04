<?php

class AjaxPackagesControllerBase extends UTIAjaxController
{

    private $_request;

    public function beforeAction($action)
    {
        $this->_request = Yii::app()->getRequest();
        return TRUE;
    }

    public function Form_Product()
    {
        $presetData = $this->_request->getPost('PackagesValue');
        
        Yii::import('application.modules.store.models.*');

        $productModel = Catalogues::model()->findByPk($presetData);
        $productModelPrice = $productModel->products;
        $products = array();
        foreach ($productModelPrice as $key => $value)
        {
            $products[$value->id] = $value->lang->name;
        }
        
        echo CJSON::encode($products);
    }
    
    public function Form_Price()
    {
        $productData = $this->_request->getPost('ProductValue');
        Yii::import('application.modules.store.models.*');
        $productModel = Products::model()->findByPk($productData);
        if(!empty($productModel))
        {
            $price = sprintf('%.2f', $productModel->price);
            $points = sprintf('%.2f', $productModel->points);
        }
        else
        {
            throw new CHttpException(404, 'Продукт не найден');
        }
        
        echo CJSON::encode(array('price'=>$price, 'points'=>$points));
    }

}
