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
class Payment extends CActiveRecord {

    public $affcode, $start_date, $end_date,$affiliatesid,$print_certificate,$refcode;
    public $startdate, $enddate;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'dmv_payment';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
             array('affiliatesid,class_id', 'required',"on"=>"create"),
            array('payment_type,payment_date,payment_amount', 'required'),
            array('class_id, total_students', 'numerical', 'integerOnly' => true),
            array('payment_amount', 'numerical'),
            array('payment_type', 'length', 'max' => 2),
            array('cheque_number', 'length', 'max' => 15),
            array('payment_complete, print_certificate', 'length', 'max' => 1),
            array('moneyorder_number', 'length', 'max' => 20),
            array('payment_date, payment_notes,affcode,start_date,end_date,affiliatesid,print_certificate,refcode', 'safe'),
            array('startdate,enddate', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('payment_id, class_id, payment_date, payment_amount, payment_type, cheque_number, payment_complete, payment_notes, print_certificate, moneyorder_number, total_students', 'safe', 'on' => 'search'),
            array('cheque_number,moneyorder_number', 'Checknotempty'),
        );
    }
    
     public function checknotempty($attribute_name, $params) {

        if ($this->payment_type == "CQ" && $this->cheque_number == '') {
            $this->addError('cheque_number', "Please enter cheque number.");
            return false;
        }
        
        if ($this->payment_type == "MO" && $this->moneyorder_number == '') {
            $this->addError('moneyorder_number', "Please enter moneyorder number.");
            return false;
        }
        
        return true;
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'dmvClasses' => array(self::BELONGS_TO, 'DmvClasses', 'class_id'),
           // 'studentsCount' => array(self::STAT, 'Students', 'clas_id'),
        );
    }
    
    public static function totalstudents($class_id)
    {
        $condition = "clas_id=".$class_id;
        $totalstudents = Students::model()->count($condition);
        return $totalstudents;
    }  
    
    public static function totaldue($totstuds,$refamt)
    { 
        $totaldue = $totstuds*$refamt;
        return $totaldue;
    }  

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'payment_id' => Myclass::t('Payment'),
            'class_id' => Myclass::t('Class Name'),
            'payment_date' => Myclass::t('Payment Date'),
            'payment_amount' => Myclass::t('Payment Amount'),
            'payment_type' => Myclass::t('Payment Type'),
            'cheque_number' => Myclass::t('Cheque Number'),
            'payment_complete' => Myclass::t('Mark as payment complete'),
            'payment_notes' => Myclass::t('Payment Notes'),
            'print_certificate' => Myclass::t('Print Certificate'),
            'moneyorder_number' => Myclass::t('Moneyorder Number'),
            'total_students' => Myclass::t('Total Students'),
            'affcode' => 'Agency Code',
            'affiliatesid' => 'Agency'
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
    public function search() {
        $datamod = array();
        $datamod = $_GET;
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->addCondition("Affliate.admin_id='" . Yii::app()->user->admin_id . "'");
        
        if ($this->start_date != "" && $this->end_date != "") {
            $datamod['Payment']['start_date'] = Myclass::dateformat($this->start_date);
            $datamod['Payment']['end_date'] = Myclass::dateformat($this->end_date);
            
            $criteria->addCondition("dmvClasses.clas_date >= '" . Myclass::dateformat($this->start_date) . "' AND dmvClasses.clas_date <= '" . Myclass::dateformat($this->end_date) . "'");
        }
        
        if ($this->affcode != "") {
            $criteria->addCondition("Affliate.agency_code='" . $this->affcode . "'");
        }
        
        /* For payment report */
        if ($this->startdate != "" && $this->enddate != "") {
            
            $datamod['Payment']['startdate'] = Myclass::dateformat($this->startdate);
            $datamod['Payment']['enddate'] = Myclass::dateformat($this->enddate);
            
            $criteria->addCondition("payment_date >= '" . Myclass::dateformat($this->startdate) . "' AND payment_date <= '" . Myclass::dateformat($this->enddate) . "'");
        }
        
        if($this->affiliatesid!=""){
            $criteria->addCondition("Affliate.affiliate_id='" . $this->affiliatesid . "'");
        }

        $criteria->with = array("dmvClasses", "dmvClasses.Affliate");
        $criteria->together = true;

        return new CActiveDataProvider($this, array(
            'sort' => array(
                'defaultOrder' => 'payment_date ASC',
            ),
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => PAGE_SIZE,
                'params' => $datamod
            )
        ));
    }
    
     public function print_certificate_search() {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $datamod = array();
        $datamod = $_GET;
        
        $criteria = new CDbCriteria;
        $criteria->addCondition("Affliate.admin_id='" . Yii::app()->user->admin_id . "'");
        
        $criteria->addCondition("payment_complete='Y' and print_certificate='Y'");
        
        if ($this->start_date != "" && $this->end_date != "") {
            $datamod['Payment']['start_date'] = Myclass::dateformat($this->start_date);
            $datamod['Payment']['end_date'] = Myclass::dateformat($this->end_date);
            
            $criteria->addCondition("dmvClasses.clas_date >= '" .  Myclass::dateformat($this->start_date) . "' AND dmvClasses.clas_date <= '" . Myclass::dateformat($this->end_date) . "'");
        }
        
        if ($this->affcode != "") {
            $criteria->addCondition("Affliate.agency_code='" . $this->affcode . "'");
        }
        
        $criteria->with = array("dmvClasses", "dmvClasses.Affliate");
        $criteria->together = true;

        return new CActiveDataProvider($this, array(
            'sort' => array(
                'defaultOrder' => 'Affliate.agency_code ASC',
            ),
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => PAGE_SIZE,
                 'params' => $datamod
            )
        ));
    }
    
    public function referal_report_search() {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $datamod = array();
        $datamod = $_GET;

        $criteria = new CDbCriteria;
        $criteria->addCondition("Affliate.admin_id='" . Yii::app()->user->admin_id . "'");
    
         $criteria->addCondition("payment_amount > 0");
         
        if ($this->startdate != "" && $this->enddate != "") {
            $datamod['Payment']['startdate'] = Myclass::dateformat($this->startdate);
            $datamod['Payment']['enddate'] = Myclass::dateformat($this->enddate);
            
            $criteria->addCondition("payment_date >= '" . Myclass::dateformat($this->startdate) . "' AND payment_date <= '" . Myclass::dateformat($this->enddate) . "'");
        }  
        
        if ($this->refcode != "" ) {
             $criteria->addCondition("affiliateCommission.referral_code = '" . $this->refcode . "'");
        }

        $criteria->with = array("dmvClasses", "dmvClasses.Affliate", "dmvClasses.Affliate.affiliateCommission");
        $criteria->together = true;

        return new CActiveDataProvider($this, array(
            'sort' => array(
                'defaultOrder' => 'payment_date ASC',
            ),
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => PAGE_SIZE,
                 'params' => $datamod
            )
        ));
    }
    

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Payment the static model class
     */
    public static function model($className = __CLASS__) {
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
