<?php

/**
 * This is the model class for table "dmv_add_instructor".
 *
 * The followings are the available columns in table 'dmv_add_instructor':
 * @property integer $instructor_id
 * @property string $instructor_ss
 * @property string $instructor_last_name
 * @property string $ins_first_name
 * @property string $instructor_initial
 * @property string $instructor_suffix
 * @property string $instructor_code
 * @property string $instructor_client_id
 * @property string $instructor_dob
 * @property string $enabled
 * @property string $gender
 * @property string $addr1
 * @property string $addr2
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property string $phone
 * @property string $created_date
 */
class DmvAddInstructor extends CActiveRecord {

    public $Affiliate, $Instructor;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'dmv_add_instructor';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('instructor_last_name, ins_first_name, instructor_code', 'required'),
            array('instructor_ss, instructor_suffix, instructor_code', 'length', 'max' => 10),
            array('instructor_code', 'unique'),
            array('instructor_last_name, ins_first_name, state', 'length', 'max' => 20),
            array('instructor_initial', 'length', 'max' => 5),
            array('instructor_client_id', 'length', 'max' => 11),
            array('enabled, gender', 'length', 'max' => 1),
            array('addr1, addr2', 'length', 'max' => 50),
            array('city', 'length', 'max' => 30),
            array('zip, phone', 'length', 'max' => 15),
            array('instructor_dob, created_date,Affiliate,Instructor', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('instructor_id, instructor_ss, instructor_last_name, ins_first_name, instructor_initial, instructor_suffix, instructor_code, instructor_client_id, instructor_dob, enabled, gender, addr1, addr2, city, state, zip, phone, created_date', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'affInstructor' => array(self::HAS_MANY, 'DmvAffInstructor', 'instructor_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'instructor_id' => Myclass::t('Instructor'),
            'instructor_ss' => Myclass::t('Instructor SS'),
            'instructor_last_name' => Myclass::t('Last Name'),
            'ins_first_name' => Myclass::t('First Name'),
            'instructor_initial' => Myclass::t('Initial'),
            'instructor_suffix' => Myclass::t('Suffix'),
            'instructor_code' => Myclass::t('Instructor Code'),
            'instructor_client_id' => Myclass::t('Instructor Client ID'),
            'instructor_dob' => Myclass::t('DOB'),
            'enabled' => Myclass::t('Enabled'),
            'gender' => Myclass::t('Gender'),
            'addr1' => Myclass::t('Instructor Address1'),
            'addr2' => Myclass::t('Address2'),
            'city' => Myclass::t('City'),
            'state' => Myclass::t('State'),
            'zip' => Myclass::t('Zip'),
            'phone' => Myclass::t('Phone #'),
            'created_date' => Myclass::t('Created Date'),
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
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->condition = "admin_id = :admin_id";
        $criteria->params = (array(':admin_id' => Yii::app()->user->admin_id));      
        
        if($this->Instructor>0){
            $this->instructor_id = $this->Instructor;
        }
      
        $criteria->compare('t.instructor_id', $this->instructor_id);
        $criteria->compare('instructor_ss', $this->instructor_ss, true);
        $criteria->compare('instructor_last_name', $this->instructor_last_name, true);
        $criteria->compare('ins_first_name', $this->ins_first_name, true);
        $criteria->compare('instructor_initial', $this->instructor_initial, true);
        $criteria->compare('instructor_suffix', $this->instructor_suffix, true);
        $criteria->compare('instructor_code', $this->instructor_code, true);
        $criteria->compare('instructor_client_id', $this->instructor_client_id, true);
        $criteria->compare('instructor_dob', $this->instructor_dob, true);
        $criteria->compare('enabled', $this->enabled, true);
        $criteria->compare('gender', $this->gender, true);
        $criteria->compare('addr1', $this->addr1, true);
        $criteria->compare('addr2', $this->addr2, true);
        $criteria->compare('city', $this->city, true);
        $criteria->compare('state', $this->state, true);
        $criteria->compare('zip', $this->zip, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('created_date', $this->created_date, true);
        
        if($this->Affiliate>0){
            $_findaff = $this->Affiliate;
            $criteria->addCondition("affInstructor.affiliate_id = '".$_findaff."' or affInstructor.affiliate_id='0'");
            $criteria->with = 'affInstructor';
            $criteria->together = true;           
        }
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => PAGE_SIZE,
            )
        ));
    }
    
    public function getConcatened()
    {
        return $this->ins_first_name.' '.$this->instructor_last_name; 
    }

    public static function all_instructors($affid = null) {
        $criteria = new CDbCriteria;
        $criteria->condition = "admin_id = :admin_id";
        $criteria->params = (array(':admin_id' => Yii::app()->user->admin_id));
        
        if($affid>0)
        {           
            $criteria->addCondition("affInstructor.affiliate_id = '".$affid."' or affInstructor.affiliate_id='0'");
            $criteria->with = 'affInstructor';
            $criteria->together = true; 
        }    
        $criteria->order = 't.instructor_id ASC';
        
        $affiliate_list = DmvAddInstructor::model()->findAll($criteria);
        $val = CHtml::listData($affiliate_list, 'instructor_id', 'concatened');
        return $val;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return DmvAddInstructor the static model class
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
