<?php

/**
 * This is the model class for table "pak_packages_lang".
 *
 * The followings are the available columns in table 'pak_packages_lang':
 * @property integer $id
 * @property integer $pak_packages__id
 * @property string $lang
 * @property string $name
 * @property string $short_name
 * @property string $detailed_name
 */
class PackagesLang extends UTIActiveRecord
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
		return 'pak_packages_lang';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('name', 'required','on'=>'create'),
			array('name', 'length', 'max'=>255,'on'=>'create'),	
			
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'pak_packages__id' => 'Pak Packages',
			'lang' => 'Lang',
			'name' => 'Название пакета',
			'short_name' => 'Краткое описание',
			'detailed_name' => 'Подробное описание',
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
		$criteria->compare('pak_packages__id',$this->pak_packages__id);
		$criteria->compare('lang',$this->lang,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('short_name',$this->short_name,true);
		$criteria->compare('detailed_name',$this->detailed_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}