<?php

/**
 * This is the model class for table "dmv_classes".
 *
 * The followings are the available columns in table 'dmv_classes':
 * @property integer $clas_id
 * @property integer $affiliate_id
 * @property string $clas_date
 * @property string $clas_name
 * @property string $start_time
 * @property string $end_time
 * @property string $date2
 * @property string $start_time2
 * @property string $end_time2
 * @property string $location
 * @property string $loc_addr
 * @property string $loc_city
 * @property string $loc_state
 * @property string $zip
 * @property integer $country
 * @property integer $instructor_id
 * @property string $show_admin
 * @property integer $pending
 */
class DmvClasses extends CActiveRecord {
    
    public $agencycode,$agencyname,$start_date,$end_date,$composite_error,$affiliateid,$startdate,$enddate,$clasdate,$pnewclassid;
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'dmv_classes';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('affiliate_id, instructor_id, start_time, end_time, location, loc_city, country,clas_date', 'required'),
            array('affiliate_id, country, instructor_id, pending', 'numerical', 'integerOnly' => true),
            array('clas_name, location', 'length', 'max' => 50),
            array('start_time, end_time, start_time2, end_time2, loc_state, zip', 'length', 'max' => 10),
            array('loc_addr', 'length', 'max' => 30),
            array('loc_city', 'length', 'max' => 20),
            array('show_admin', 'length', 'max' => 1),
            array('clas_date, date2,agencycode,start_date,end_date,composite_error,affiliateid,agencyname,clasdate', 'safe'),
            array('pnewclassid', 'safe'),
            //array('affiliate_id, instructor_id, start_time, end_time,clas_date','unique',),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('clas_id, affiliate_id, clas_date, clas_name, start_time, end_time, date2, start_time2, end_time2, location, loc_addr, loc_city, loc_state, zip, country, instructor_id, show_admin, pending', 'safe', 'on' => 'search'),
            array('*', 'compositeUniqueKeysValidator'),
         );
    }
    
    /**
     * Validates composite unique keys
     *
     * Validates composite unique keys declared in the
     * ECompositeUniqueKeyValidatable bahavior
     */
    public function compositeUniqueKeysValidator() {
        $this->validateCompositeUniqueKeys();
    }
    
    public function behaviors() {
        return array(
            'ECompositeUniqueKeyValidatable' => array(
                'class' => 'ext.ECompositeUniqueKeyValidatable',
                'uniqueKeys' => array(
                    'attributes' => 'affiliate_id, instructor_id, clas_date, start_time, end_time',
                    'errorAttributes' => 'composite_error',                  
                    'errorMessage' => 'Schedule already exist!!'
                )
            ),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'Affliate' => array(self::BELONGS_TO, 'DmvAffiliateInfo', 'affiliate_id'),
            'Instructor' => array(self::BELONGS_TO, 'DmvAddInstructor', 'instructor_id'),
            'Payment' => array(self::HAS_MANY, 'Payment', 'class_id'),
            'studentsCount' => array(self::STAT, 'Students', 'clas_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'clas_id' => Myclass::t('Clas'),
            'affiliate_id' => Myclass::t('Affiliate'),
            'clas_date' => Myclass::t('Date'),
            'clas_name' => Myclass::t('Clas Name'),
            'start_time' => Myclass::t('Start Time'),
            'end_time' => Myclass::t('End Time'),
            'date2' => Myclass::t('Date2'),
            'start_time2' => Myclass::t('Start Time2'),
            'end_time2' => Myclass::t('End Time2'),
            'location' => Myclass::t('Location'),
            'loc_addr' => Myclass::t('Location Address'),
            'loc_city' => Myclass::t('City'),
            'loc_state' => Myclass::t('State'),
            'zip' => Myclass::t('Zip'),
            'country' => Myclass::t('Country'),
            'instructor_id' => Myclass::t('Instructor'),
            'show_admin' => Myclass::t('Show Admin'),
            'pending' => Myclass::t('Pending'),
            'affiliateid' => "Affiliate",
            'clasdate' => "Class Date",
            "pnewclassid" => "Print Certificates For New Class"
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
        
        if(isset(Yii::app()->user->affiliate_id) && Yii::app()->user->affiliate_id!="")
        $this->affiliateid = Yii::app()->user->affiliate_id;
                
        if($this->affiliateid!="")
        $criteria->addCondition("t.affiliate_id = ".$this->affiliateid);  
        
        if($this->agencycode!="")
        $criteria->addCondition("Affliate.agency_code = '".$this->agencycode."'");    
        
        if($this->agencyname!="")
        $criteria->compare('Affliate.agency_name', $this->agencyname, true);
        
        $criteria->addCondition("show_admin = 'Y'");
        
        if(isset(Yii::app()->user->admin_id) && Yii::app()->user->admin_id!="")
        $criteria->addCondition("Affliate.admin_id = ".Yii::app()->user->admin_id);
        
        if($this->start_date!="" && $this->end_date!="")
        {    
            $criteria->addCondition('clas_date >= :startDate AND clas_date <= :endDate');
            $criteria->params = array(':startDate' => $this->start_date, ':endDate' => $this->end_date);
        }    
        
        $criteria->with = array("Affliate",'Instructor');
        $criteria->together = true;

        return new CActiveDataProvider($this, array(
            'sort' => array(
                'defaultOrder' => 'clas_id DESC',
            ),
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => PAGE_SIZE,
            )
        ));
    }
    
     public function getConcatened()
    {
        return date("F d,Y", strtotime($this->clas_date)) . " " . $this->start_time . " to " . $this->end_time; 
    }
    
    public static function all_classes($affid = null){
        $criteria = new CDbCriteria;
        $criteria->condition = "affiliate_id = :affiliate_id";
        $criteria->params = (array(':affiliate_id' => $affid));    
      
        $classed_list = DmvClasses::model()->findAll($criteria);
        $val = CHtml::listData($classed_list, 'clas_id', 'concatened');
        return $val;  
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return DmvClasses the static model class
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
