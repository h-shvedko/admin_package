<?php

define('PACKAGES_FLAG_ON', 1);
define("PACKAGES_VISIBILITY_NO", 2);
define('PACKAGES_PER_PAGE', 15);

/**
 * This is the model class for table "pak_packages".
 *
 * The followings are the available columns in table 'pak_packages':
 * @property integer $id
 * @property string $alias
 * @property integer $flag
 * @property integer $visibility
 * @property string $price
 */
class Packages extends UTIActiveRecord
{
	public $my_price__id;
	public $my_price_courses__id;
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
		return 'pak_packages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('price, count', 'length', 'max' => 20, 'on' => 'create, update'),
			array('count', 'required', 'on' => 'create, update'),
			array('count', 'numerical', 'min' => 1, 'on' => 'create, update'),
			array('my_price__id, my_price_courses__id', 'required', 'on' => 'create'),
			array('my_price__id, my_price_courses__id', 'exist', 'attributeName' => 'id', 'className' => 'Prices', 'on' => 'create, update', 'message' => Yii::t('app', 'Цена неверна.')),
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
			'lang' => array(self::HAS_ONE, 'PackagesLang', 'pak_packages__id', 'condition' => 'lang=:lang', 'params' => array(':lang' => Yii::app()->language)),
		);
	}

	public function beforeFind()
	{
		$criteria = new CDbCriteria();
		$criteria->condition = 'visibility <> :visibility';
		$criteria->params = array(':visibility' => PACKAGES_VISIBILITY_NO);
		$this->dbCriteria->mergeWith($criteria);
		parent::beforeFind();
	}

	public function attributeLabels()
	{
		return array(
			'id'			=> Yii::t('app','Ун.№'),
			'alias'			=> 'Alias',
			'price_courses'	=> Yii::t('app','Цена курсов'),
			'flag'			=> Yii::t('app','Активный'),
			'visibility'	=> 'Visibility',
			'count'			=>	Yii::t('app','Количество'),
			'price'			=> Yii::t('app','Стоимость'),
		);
	}

	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;
		$criteria->compare('id', $this->id);
		$criteria->compare('alias', $this->alias, true);
		$criteria->compare('flag', $this->flag);
		$criteria->compare('visibility', $this->visibility);
		$criteria->compare('price', $this->price, true);
		return new CActiveDataProvider($this, array(
					'criteria' => $criteria,
				));
	}

}