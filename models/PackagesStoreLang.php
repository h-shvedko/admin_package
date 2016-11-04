<?php

/**
 * This is the model class for table "packages_packages_lang".
 *
 * The followings are the available columns in table 'packages_packages_lang':
 * @property integer $id
 * @property integer $packages__id
 * @property string $lang
 * @property string $name
 * @property string $short_name
 */
class PackagesStoreLang extends UTIActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PackagesLang the static model class
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
        return 'pak_store_packages_lang';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('packages__id', 'required'),
            array('packages__id, created_by, modified_by', 'numerical', 'integerOnly'=>true),
            array('lang', 'length', 'max'=>20),
            array('name, short_name', 'length', 'max'=>50),
            array('created_ip, modified_ip', 'length', 'max'=>255),
            array('created_at, modified_at', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, packages__id, lang, name, short_name, created_at, created_by, created_ip, modified_at, modified_by, modified_ip', 'safe', 'on'=>'search'),
        );
    }
    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'packages' => array(self::BELONGS_TO, 'PackagesStore', 'packages__id'),
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
            'lang' => 'Язык',
            'name' => 'Название',
            'short_name' => 'Короткое название',
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
        $criteria->compare('lang',$this->lang,true);
        $criteria->compare('name',$this->name,true);
        $criteria->compare('short_name',$this->short_name,true);
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