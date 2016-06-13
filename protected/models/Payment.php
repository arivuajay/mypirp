<?php

/**
 * This is the model class for table "dmv_payment".
 *
 * The followings are the available columns in table 'dmv_payment':
 * @property integer $payment_id
 * @property integer $class_id
 * @property string $payment_date
 * @property double $payment_amount
 * @property string $payment_type
 * @property string $cheque_number
 * @property string $payment_complete
 * @property string $payment_notes
 * @property string $print_certificate
 * @property string $moneyorder_number
 * @property integer $total_students
 */
class Payment extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dmv_payment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('payment_type, cheque_number', 'required'),
			array('class_id, total_students', 'numerical', 'integerOnly'=>true),
			array('payment_amount', 'numerical'),
			array('payment_type', 'length', 'max'=>2),
			array('cheque_number', 'length', 'max'=>15),
			array('payment_complete, print_certificate', 'length', 'max'=>1),
			array('moneyorder_number', 'length', 'max'=>20),
			array('payment_date, payment_notes', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('payment_id, class_id, payment_date, payment_amount, payment_type, cheque_number, payment_complete, payment_notes, print_certificate, moneyorder_number, total_students', 'safe', 'on'=>'search'),
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
			'payment_id' => Myclass::t('Payment'),
			'class_id' => Myclass::t('Class'),
			'payment_date' => Myclass::t('Payment Date'),
			'payment_amount' => Myclass::t('Payment Amount'),
			'payment_type' => Myclass::t('Payment Type'),
			'cheque_number' => Myclass::t('Cheque Number'),
			'payment_complete' => Myclass::t('Payment Complete'),
			'payment_notes' => Myclass::t('Payment Notes'),
			'print_certificate' => Myclass::t('Print Certificate'),
			'moneyorder_number' => Myclass::t('Moneyorder Number'),
			'total_students' => Myclass::t('Total Students'),
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

		$criteria->compare('payment_id',$this->payment_id);
		$criteria->compare('class_id',$this->class_id);
		$criteria->compare('payment_date',$this->payment_date,true);
		$criteria->compare('payment_amount',$this->payment_amount);
		$criteria->compare('payment_type',$this->payment_type,true);
		$criteria->compare('cheque_number',$this->cheque_number,true);
		$criteria->compare('payment_complete',$this->payment_complete,true);
		$criteria->compare('payment_notes',$this->payment_notes,true);
		$criteria->compare('print_certificate',$this->print_certificate,true);
		$criteria->compare('moneyorder_number',$this->moneyorder_number,true);
		$criteria->compare('total_students',$this->total_students);

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
	 * @return Payment the static model class
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
