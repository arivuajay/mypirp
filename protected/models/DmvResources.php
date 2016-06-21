<?php

/**
 * This is the model class for table "dmv_resources".
 *
 * The followings are the available columns in table 'dmv_resources':
 * @property integer $resource_id
 * @property integer $parent_id
 * @property string $resource_name
 * @property string $resource_url
 * @property string $resource_key
 * @property string $created_at
 * @property string $updated_at
 *
 * The followings are the available model relations:
 * @property DmvAdminResources[] $dmvAdminResources
 */
class DmvResources extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dmv_resources';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('parent_id, resource_name, resource_url, resource_key, created_at, updated_at', 'required'),
			array('parent_id', 'numerical', 'integerOnly'=>true),
			array('resource_name, resource_url, resource_key', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('resource_id, parent_id, resource_name, resource_url, resource_key, created_at, updated_at', 'safe', 'on'=>'search'),
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
                        'Childs' => array(self::HAS_MANY, 'DmvResources', 'parent_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'resource_id' => Myclass::t('Resource'),
			'parent_id' => Myclass::t('Parent'),
			'resource_name' => Myclass::t('Resource Name'),
			'resource_url' => Myclass::t('Resource Url'),
			'resource_key' => Myclass::t('Resource Key'),
			'created_at' => Myclass::t('Created At'),
			'updated_at' => Myclass::t('Updated At'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('resource_id',$this->resource_id);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('resource_name',$this->resource_name,true);
		$criteria->compare('resource_url',$this->resource_url,true);
		$criteria->compare('resource_key',$this->resource_key,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination' => array(
                            'pageSize' => PAGE_SIZE,
                        )
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DmvResources the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

        public function dataProvider() {
            return new CActiveDataProvider($this, array(
                'pagination' => array(
                    'pageSize' => PAGE_SIZE,
                )
            ));
        }
}
