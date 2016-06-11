<?php

/**
 * This is the model class for table "dmv_aff_instructor".
 *
 * The followings are the available columns in table 'dmv_aff_instructor':
 * @property integer $affiliate_instructor_id
 * @property integer $affiliate_id
 * @property integer $instructor_id
 */
class DmvAffInstructor extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dmv_aff_instructor';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('affiliate_id, instructor_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('affiliate_instructor_id, affiliate_id, instructor_id', 'safe', 'on'=>'search'),
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
                    'Affliate' => array(self::BELONGS_TO, 'DmvAffiliateInfo', 'affiliate_id'),
                    'Instructor' => array(self::BELONGS_TO, 'DmvAddInstructor', 'instructor_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'affiliate_instructor_id' => Myclass::t('Affiliate Instructor'),
			'affiliate_id' => Myclass::t('Affiliate'),
			'instructor_id' => Myclass::t('Instructor'),
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

		$criteria->compare('affiliate_instructor_id',$this->affiliate_instructor_id);
		$criteria->compare('affiliate_id',$this->affiliate_id);
		$criteria->compare('instructor_id',$this->instructor_id);

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
	 * @return DmvAffInstructor the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public static function get_ins_affliates($id = null)
	{
            $criteria = new CDbCriteria; 
            $criteria->condition = "instructor_id = :instructor_id";
            $criteria->params=(array(':instructor_id'=>$id));

            $affiliate_list = DmvAffInstructor::model()->findAll($criteria);
            $val = CHtml::listData($affiliate_list, 'affiliate_id', 'affiliate_id'); 
            return $val;
        }
        
        public function dataProvider() {
            return new CActiveDataProvider($this, array(
                'pagination' => array(
                    'pageSize' => PAGE_SIZE,
                )
            ));
        }
}
