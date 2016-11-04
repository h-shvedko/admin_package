<?php

/**
 * This is the model class for table "packages_packages".
 *
 * The followings are the available columns in table 'packages_packages':
 * @property integer $id
 * @property integer $flag
 * @property string $alias
 * @property string $price
 * @property string $points
 */
class PackagesStore extends UTIActiveRecord
{

    const PACKAGES_VISIBILITY_NO = 0;
    const PACKAGES_FLAG_ON = 1;
    const PACKAGES_FLAG_OFF = 0;
    const PACKAGES_PER_PAGE = 15;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Packages the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'pak_store_packages';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('flag', 'required'),
            array('flag, visibility, type__id, created_by, modified_by, count', 'numerical', 'integerOnly' => true),
            array('alias, price, points', 'length', 'max' => 20),
            array('created_ip, modified_ip', 'length', 'max' => 255),
            array('created_at, modified_at', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, flag, alias, price, points, visibility, type__id, gifts, created_at, created_by, created_ip, modified_at, modified_by, modified_ip, count', 'safe', 'on' => 'search'),
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
            'lang' => array(self::HAS_ONE, 'PackagesStoreLang', 'packages__id'),
            'type' => array(self::BELONGS_TO, 'PackagesStoreType', 'type__id'),
            'value' => array(self::HAS_MANY, 'PackagesStoreValue', 'packages__id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'flag' => 'Вкл/Выкл',
            'alias' => 'Alias',
            'price' => 'Цена',
            'points' => 'Баллы',
			'gifts' => 'Гифт',
            'type__id' => 'Тип пакета',
            'count' => 'Count',
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('flag', $this->flag);
        $criteria->compare('alias', $this->alias, true);
        $criteria->compare('price', $this->price, true);
        $criteria->compare('points', $this->points, true);
		$criteria->compare('gifts', $this->gifts, true);
        $criteria->compare('visibility', $this->visibility);
        $criteria->compare('type__id', $this->type__id);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('created_ip', $this->created_ip, true);
        $criteria->compare('modified_at', $this->modified_at, true);
        $criteria->compare('modified_by', $this->modified_by);
        $criteria->compare('modified_ip', $this->modified_ip, true);
        $criteria->compare('count', $this->count);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
