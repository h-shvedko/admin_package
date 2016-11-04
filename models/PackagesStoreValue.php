<?php

/**
 * This is the model class for table "packages_packages_value".
 *
 * The followings are the available columns in table 'packages_packages_value':
 * @property integer $id
 * @property integer $packages__id
 * @property integer $catalogue__id
 * @property integer $products__id
 */
class PackagesStoreValue extends UTIActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PackagesValue the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'pak_store_packages_value';
    }

    /**
     * @return array validation rules for model attributes.
     */
     public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('packages__id, catalogue__id, products__id', 'required'),
            array('packages__id, catalogue__id, products__id, created_by, modified_by', 'numerical', 'integerOnly'=>true),
            array('created_ip, modified_ip', 'length', 'max'=>255),
            array('created_at, modified_at', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, packages__id, catalogue__id, products__id, created_at, created_by, created_ip, modified_at, modified_by, modified_ip', 'safe', 'on'=>'search'),
        );
    }


    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        Yii::import('application.modules.admin.modules.catalog.models.*');
        return array(
            'packages' => array(self::BELONGS_TO, 'PackagesStore', 'packages__id'),
            'catalogue' => array(self::BELONGS_TO, 'Catalogues', 'catalogue__id'),
            'product' => array(self::BELONGS_TO, 'Products', 'products__id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'packages__id' => 'Packages',
            'catalogue__id' => 'Каталог',
            'products__id' => 'Продукт',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'modified_at' => 'Modified At',
            'modified_by' => 'Modified By',
            'modified_ip' => 'Modified Ip',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('packages__id',$this->packages__id);
        $criteria->compare('catalogue__id',$this->catalogue__id);
        $criteria->compare('products__id',$this->products__id);
        $criteria->compare('created_at',$this->created_at,true);
        $criteria->compare('created_by',$this->created_by);
        $criteria->compare('created_ip',$this->created_ip,true);
        $criteria->compare('modified_at',$this->modified_at,true);
        $criteria->compare('modified_by',$this->modified_by);
        $criteria->compare('modified_ip',$this->modified_ip,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}