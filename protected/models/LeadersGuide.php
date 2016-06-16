<?php

/**
 * This is the model class for table "dmv_leaders_guide".
 *
 * The followings are the available columns in table 'dmv_leaders_guide':
 * @property integer $guide_id
 * @property integer $affiliate_id
 * @property integer $instructor_id
 * @property string $client_type
 * @property string $guide_instructor
 * @property string $payment_date
 * @property integer $number_of_guides
 * @property double $payment_amount
 * @property double $guide_fee
 * @property double $shipping_fee
 * @property string $payment_type
 * @property string $cheque_number
 * @property string $payment_complete
 */
class LeadersGuide extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dmv_leaders_guide';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        array('affiliate_id', 'required' , 'on'=>"create"),
			array('guide_fee, payment_type,payment_date,payment_amount', 'required'),
			array('affiliate_id, instructor_id, number_of_guides', 'numerical', 'integerOnly'=>true),
			array('payment_amount, guide_fee, shipping_fee', 'numerical'),
			array('client_type, guide_instructor, payment_complete', 'length', 'max'=>1),
			array('payment_type', 'length', 'max'=>2),
			array('cheque_number', 'length', 'max'=>15),
			array('payment_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('guide_id, affiliate_id, instructor_id, client_type, guide_instructor, payment_date, number_of_guides, payment_amount, guide_fee, shipping_fee, payment_type, cheque_number, payment_complete', 'safe', 'on'=>'search'),
                        array('cheque_number,instructor_id', 'Checknotempty'),
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
                    'affiliateInfo' => array(self::BELONGS_TO, 'DmvAffiliateInfo', 'affiliate_id'),
                    'instructorInfo' => array(self::BELONGS_TO, 'DmvAddInstructor', 'instructor_id'),
		);
	}
        
         public function checknotempty($attribute_name, $params) {

        if ($this->payment_type == "CQ" && $this->cheque_number == '') {
            $this->addError('cheque_number', "Please enter cheque number.");
            return false;
        }
        
        if ($this->guide_instructor == "1" && $this->instructor_id == '') {
            $this->addError('instructor_id', "Please select instructor.");
            return false;
        }
        
        return true;
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'guide_id' => Myclass::t('Guide'),
			'affiliate_id' => Myclass::t('Delivery Agency School'),
			'instructor_id' => Myclass::t('Instructor'),
			'client_type' => Myclass::t('Client Type'),
			'guide_instructor' => Myclass::t('Appiled for instructor'),
			'payment_date' => Myclass::t('Payment Date'),
			'number_of_guides' => Myclass::t('Number Of Guides'),
			'payment_amount' => Myclass::t('Payment Amount'),
			'guide_fee' => Myclass::t('Guide Fee'),
			'shipping_fee' => Myclass::t('Shipping Fee'),
			'payment_type' => Myclass::t('Payment Type'),
			'cheque_number' => Myclass::t('Cheque Number'),
			'payment_complete' => Myclass::t('Mark as payment complete'),
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
                
                $criteria->condition = "affiliateInfo.admin_id = :admin_id";
                $criteria->params=(array(':admin_id'=>Yii::app()->user->admin_id));


		$criteria->compare('guide_id',$this->guide_id);
		$criteria->compare('affiliate_id',$this->affiliate_id);
		$criteria->compare('instructor_id',$this->instructor_id);
		$criteria->compare('client_type',$this->client_type,true);
		$criteria->compare('guide_instructor',$this->guide_instructor,true);
		$criteria->compare('payment_date',$this->payment_date,true);
		$criteria->compare('number_of_guides',$this->number_of_guides);
		$criteria->compare('payment_amount',$this->payment_amount);
		$criteria->compare('guide_fee',$this->guide_fee);
		$criteria->compare('shipping_fee',$this->shipping_fee);
		$criteria->compare('payment_type',$this->payment_type,true);
		$criteria->compare('cheque_number',$this->cheque_number,true);
		$criteria->compare('payment_complete',$this->payment_complete,true);
                
                $criteria->with = array("affiliateInfo","instructorInfo");
                $criteria->together = true;

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
	 * @return LeadersGuide the static model class
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
