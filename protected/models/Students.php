<?php

/**
 * This is the model class for table "dmv_students".
 *
 * The followings are the available columns in table 'dmv_students':
 * @property integer $student_id
 * @property integer $affiliate_id
 * @property integer $clas_id
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $stud_suffix
 * @property string $address1
 * @property string $address2
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property string $phone
 * @property string $email
 * @property string $gender
 * @property string $dob
 * @property string $licence_number
 * @property string $notes
 * @property string $course_completion_date
 */
class Students extends MyActiveRecord  {

    public $instructorid, $startdate, $enddate, $certificatenumber, $label_flag, $start_date, $end_date, $completion_date_all;
    public $agencycode, $agencyname, $clasdate;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'dmv_students';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('affiliate_id, clas_id,first_name,last_name,gender,dob,licence_number,address1,city', 'required', 'on' => 'create'),
            array('affiliate_id, clas_id', 'numerical', 'integerOnly' => true),
            array('first_name, last_name, city, zip, phone, licence_number', 'length', 'max' => 20),
            array('middle_name, stud_suffix, state', 'length', 'max' => 10),
            array('address1, address2, email', 'length', 'max' => 50),
            array('gender', 'length', 'max' => 1),
            array('dob, course_completion_date,notes,instructorid,certificatenumber,startdate,enddate,label_flag,completion_date_all', 'safe'),
            array('agencycode, agencyname,clasdate', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('student_id, affiliate_id, clas_id, first_name, middle_name, last_name, stud_suffix, address1, address2, city, state, zip, phone, email, gender, dob, licence_number, notes, course_completion_date', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'dmvClasses' => array(self::BELONGS_TO, 'DmvClasses', 'clas_id'),
            'dmvAffiliateInfo' => array(self::BELONGS_TO, 'DmvAffiliateInfo', 'affiliate_id'),
            'StudentCertificate' => array(self::HAS_MANY, 'PrintCertificate', 'student_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'student_id' => Myclass::t('Student'),
            'affiliate_id' => Myclass::t('Affiliate'),
            'clas_id' => Myclass::t('Class Date'),
            'first_name' => Myclass::t('First Name'),
            'middle_name' => Myclass::t('Middle Name'),
            'last_name' => Myclass::t('Last Name'),
            'stud_suffix' => Myclass::t('Stud Suffix'),
            'address1' => Myclass::t('Address1'),
            'address2' => Myclass::t('Address2'),
            'city' => Myclass::t('City'),
            'state' => Myclass::t('State'),
            'zip' => Myclass::t('Zip'),
            'phone' => Myclass::t('Phone'),
            'email' => Myclass::t('Email'),
            'gender' => Myclass::t('Gender'),
            'dob' => Myclass::t('Dob'),
            'licence_number' => Myclass::t('Driver License Number'),
            'notes' => Myclass::t('Notes'),
            'course_completion_date' => Myclass::t('Course Completion Date'),
            'affiliateid' => "Delivery Agency School",
            'instructorid' => 'Instructor Name',
            'startdate' => "Start Date",
            'enddate' => "End Date",
            'agencycode' => "Agency Code",
            'agencyname' => "Agency Name"
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
        $_action = Yii::app()->controller->action->id;

        $criteria = new CDbCriteria;

        if (isset(Yii::app()->user->admin_id) && Yii::app()->user->admin_id != "") {
            $criteria->condition = "dmvAffiliateInfo.admin_id = :admin_id";
            $criteria->params = (array(':admin_id' => Yii::app()->user->admin_id));
        }

        if ($this->affiliate_id != "" && $this->clas_id != "") {

            $criteria->condition = "t.affiliate_id = :affiliate_id and t.clas_id = :clas_id";
            $criteria->params = (array(':affiliate_id' => $this->affiliate_id, ':clas_id' => $this->clas_id));
        } elseif (isset(Yii::app()->user->affiliate_id) && Yii::app()->user->affiliate_id != "") {

            $criteria->condition = "t.affiliate_id = :affiliate_id";
            $criteria->params = (array(':affiliate_id' => Yii::app()->user->affiliate_id));
        }

        if ($this->licence_number != "")
            $criteria->addCondition("licence_number=" . $this->licence_number);
        
        if ($this->agencycode != "")
            $criteria->addCondition("dmvAffiliateInfo.agency_code = '".$this->agencycode."'");  
        
        if ($this->course_completion_date != "")
        {    
            $this->course_completion_date = Myclass::dateformat($this->course_completion_date);
            $criteria->addCondition("course_completion_date = '" . $this->course_completion_date . "'");
            $datamod['Students']['course_completion_date'] = $this->course_completion_date;
        }  
        
        if ($this->clasdate != "")
        {    
            $this->clasdate = Myclass::dateformat($this->clasdate);
            $criteria->addCondition("dmvClasses.clas_date = '" . $this->clasdate . "'");
            $datamod['Students']['clasdate'] = $this->clasdate;
        } 
        
        if ($this->startdate != "" && $this->enddate != "") {

            $this->startdate = Myclass::dateformat($this->startdate);
            $this->enddate = Myclass::dateformat($this->enddate);

            $datamod['Students']['startdate'] = $this->startdate;
            $datamod['Students']['enddate'] = $this->enddate;

            if ($this->label_flag)
                $criteria->addCondition("course_completion_date >= '" . $this->startdate . "' AND course_completion_date <= '" . $this->enddate . "'");
            else
                $criteria->addCondition("dmvClasses.clas_date >= '" . $this->startdate . "' AND dmvClasses.clas_date <= '" . $this->enddate . "'");

            if ($this->affiliate_id > 0) {
                $criteria->addCondition('t.affiliate_id = ' . $this->affiliate_id);
            } elseif (isset(Yii::app()->user->affiliate_id) && Yii::app()->user->affiliate_id != "") {
                $criteria->addCondition('t.affiliate_id = ' . Yii::app()->user->affiliate_id);
            }

            if ($this->instructorid > 0) {
                $criteria->addCondition('dmvClasses.instructor_id = ' . $this->instructorid);
            }
        }


        $criteria->compare('t.first_name', $this->first_name, true);
        $criteria->compare('middle_name', $this->middle_name, true);
        $criteria->compare('t.last_name', $this->last_name, true);
        $criteria->compare('stud_suffix', $this->stud_suffix, true);
        $criteria->compare('t.address1', $this->address1, true);
        $criteria->compare('t.city', $this->city, true);
        $criteria->compare('t.state', $this->state, true);
        $criteria->compare('t.zip', $this->zip, true);
        $criteria->compare('t.phone', $this->phone, true);
        $criteria->compare('t.email', $this->email, true);
        $criteria->compare('t.gender', $this->gender, true);
        //$criteria->compare('course_completion_date', $this->course_completion_date, true);

        $criteria->with = array("dmvAffiliateInfo", 'dmvClasses');
        $criteria->together = true;

        if ($_action == "printstudents")
            $pagesize = 100;
        else
            $pagesize = PAGE_SIZE;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => $pagesize,
                'params' => $datamod
            )
        ));
    }

    public function getConcatened() {
        return $this->first_name . " " . $this->last_name;
    }
    
    public function getConcatenedAddress() {
        $address =  $this->address1 . " " . $this->address2.", ". $this->city.", ".$this->state." ".$this->zip;
        return array('data-subtext' => $address);
    }

    public static function get_student_list($classid = NULL) {
        $get_stdlist = Students::model()->byfirstname()->findAll("clas_id=" . $classid);
        $students = CHtml::listData($get_stdlist, 'student_id', 'concatened');
        return $students;
    }
    
    public static function get_student_address_list($classid = NULL) {
        $get_stdlist = Students::model()->byfirstname()->findAll("clas_id=" . $classid);
        $students_adds = CHtml::listData($get_stdlist, 'student_id', 'concatenedAddress');     
        return $students_adds;
    }
    
    public function scopes() {
        return array(
            'byfirstname' => array('order' => 'first_name'),
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Students the static model class
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
