<?php

/**
 * This is the model class for table "dmv_affiliate_commission".
 *
 * The followings are the available columns in table 'dmv_affiliate_commission':
 * @property integer $commission_id
 * @property integer $affiliate_id
 * @property double $student_fee
 * @property double $aff_book_fee
 * @property string $referral_code
 * @property double $referral_amt
 */
class DmvAffiliateCommission extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dmv_affiliate_commission';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('student_fee, aff_book_fee, referral_code, referral_amt', 'required'),
			array('affiliate_id', 'numerical', 'integerOnly'=>true),
			array('student_fee, aff_book_fee, referral_amt', 'numerical'),
			array('referral_code', 'length', 'max'=>30),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('commission_id, affiliate_id, student_fee, aff_book_fee, referral_code, referral_amt', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'commission_id' => Myclass::t('Commission'),
			'affiliate_id' => Myclass::t('Affiliate'),
			'student_fee' => Myclass::t('Student Processing Fee'),
			'aff_book_fee' => Myclass::t('Book Fee'),
			'referral_code' => Myclass::t('Referral Code'),
			'referral_amt' => Myclass::t('Referral Amt'),
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

		$criteria->compare('commission_id',$this->commission_id);
		$criteria->compare('affiliate_id',$this->affiliate_id);
		$criteria->compare('student_fee',$this->student_fee);
		$criteria->compare('aff_book_fee',$this->aff_book_fee);
		$criteria->compare('referral_code',$this->referral_code,true);
		$criteria->compare('referral_amt',$this->referral_amt);

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
	 * @return DmvAffiliateCommission the static model class
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
