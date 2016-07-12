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
class PrintCertificate extends MyActiveRecord {
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
           // array('notes', 'required', "on"=>"update"),
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
                'pageSize' => 100,
            )
        ));
    }
    
    public function printCertificatesReport($startdate,$enddate){
            
            $datamod = array();
            $datamod = $_GET;
        
            $this->startdate = Myclass::dateformat($startdate);
            $this->enddate = Myclass::dateformat($enddate);
            
            $datamod['PrintCertificate']['startdate'] = $this->startdate;
            $datamod['PrintCertificate']['enddate'] = $this->enddate;
            
            $criteria = new CDbCriteria;
            $criteria->with = array("dmvStudents","dmvStudents.dmvAffiliateInfo","dmvStudents.dmvAffiliateInfo.affiliate_instructor","dmvStudents.dmvAffiliateInfo.affiliate_instructor.Instructor");
            $criteria->together = true;
            $criteria->join = ' INNER JOIN dmv_students  t1 ON t1.student_id=t.student_id';
            $criteria->join .= '  INNER JOIN dmv_affiliate_info  t2 ON t1.affiliate_id = t2.affiliate_id';
            $criteria->join .= '  INNER JOIN dmv_aff_instructor  t3 ON t1.affiliate_id = t3.affiliate_id';
            $criteria->join .= '  INNER JOIN dmv_add_instructor  t4 ON t3.instructor_id = t4.instructor_id';
            $criteria->addCondition("t2.admin_id ='".Yii::app()->user->admin_id."' AND t.issue_date BETWEEN '" . $this->startdate . "' AND '" . $this->enddate . "'");
            $criteria->group='dmvStudents.student_id';
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
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
    public function getInstructorName($id){
        $classes = DmvClasses::model()->findByPk($id);
        return $classes->Instructor->ins_first_name.' '.$classes->Instructor->instructor_last_name;
        
    }

}
