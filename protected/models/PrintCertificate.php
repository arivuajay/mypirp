<?php

/**
 * This is the model class for table "dmv_print_certificate".
 *
 * The followings are the available columns in table 'dmv_print_certificate':
 * @property integer $certificate_number
 * @property integer $class_id
 * @property integer $student_id
 * @property string $issue_date
 * @property string $notes
 */
class PrintCertificate extends CActiveRecord {
    public $startdate,$enddate;
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'dmv_print_certificate';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('student_id', 'required'),
            array('notes', 'required', "on"=>"update"),
            array('class_id, student_id', 'numerical', 'integerOnly' => true),
            array('issue_date, notes,startdate,enddate', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('certificate_number, class_id, student_id, issue_date, notes', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'dmvStudents' => array(self::BELONGS_TO, 'Students', 'student_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'certificate_number' => Myclass::t('Certificate Number'),
            'class_id' => Myclass::t('Class'),
            'student_id' => Myclass::t('Student'),
            'issue_date' => Myclass::t('Issue Date'),
            'notes' => Myclass::t('Notes'),
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
    public function search($class_id = null) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        if ($class_id != "") {
            $this->class_id = $class_id;
            $criteria->addCondition("class_id='" . $this->class_id . "'");
        }
        
        return new CActiveDataProvider($this, array(
            'sort' => array(
                'defaultOrder' => 'certificate_number ASC',
            ),
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => PAGE_SIZE,
            )
        ));
    }
    public function printCertificatesReport($startdate,$enddate){
            $this->startdate = $startdate;
            $this->enddate = $enddate;
            $criteria = new CDbCriteria;
            
            $criteria->with = array("dmvStudents","dmvStudents.dmvAffiliateInfo","dmvStudents.dmvAffiliateInfo.affInstructor","dmvStudents.dmvAffiliateInfo.affiliate_instructor.Instructor");
            $criteria->together = true;
            
            $criteria->addCondition("issue_date BETWEEN '" . $this->startdate . "' AND '" . $this->enddate . "'");
            
//            $criteria->join = 'inner join dmv_students  t1 on t1.student_id=t.student_id';
//            $criteria->join = 'inner join dmv_affiliate_info  t2 on t1.affiliate_id =t2.affiliate_id';
//            $criteria->join = 'inner join dmv_aff_instructor  t3 on t1.affiliate_id =t3.affiliate_id';
//            $criteria->join = 'inner join dmv_add_instructor  t4 on t3.instructor_id =t4.instructor_id';
            $criteria->group='dmvStudents.student_id';
//            $criteria->addCondition("issue_date >= '" . $this->startdate . "' AND issue_date <= '" . $this->enddate . "'");
            return new CActiveDataProvider($this, array(
                    
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => PAGE_SIZE,
                    )
                ));
    }
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return PrintCertificate the static model class
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
