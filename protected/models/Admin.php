<?php

/**
 * This is the model class for table "{{admin}}".
 *
 * The followings are the available columns in table '{{admin}}':
 * @property integer $admin_id
 * @property string $admin_name
 * @property string $admin_password
 * @property string $admin_status
 * @property string $admin_email
 * @property string $created_date
 * @property string $admin_last_login
 * @property integer $admin_login_ip
 */
class Admin extends CActiveRecord {

    public $current_password, $re_password;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{dmv_admin}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('username, password, email,domain_url , client_name', 'required'),
            array('username, email,domain_url', 'unique'),
            array('domain_url', 'url', 'defaultScheme' => 'http'),
            array('email', 'email'),
            array('email', 'required', 'on' => 'forgotpassword'),
            array('password,current_password,re_password', 'required', 'on' => 'changepassword'),
            array('current_password', 'compare', 'compareAttribute' => 're_password', 'on' => 'changepassword'),
            array('password', 'equalPasswords', 'on' => 'changepassword'),
            array('username, password, email', 'length', 'max' => 255),
            array('status', 'length', 'max' => 1),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('username, password, email,modified_at,domain_url,client_name', 'safe', 'on' => 'search'),
        );
    }

    public function equalPasswords($attribute, $params) {
        $admin = Admin::model()->findByPk(Yii::app()->user->id);
        if ($this->$attribute != "" && $admin->password != Myclass::refencryption($this->$attribute)) {
            $this->addError($attribute, Myclass::t('APP12'));
        }
    }

    public function behaviors() {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created_at',
                'updateAttribute' => 'modified_at',
            )
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'dmvAdminResources' => array(self::HAS_MANY, 'DmvAdminResources', 'admin_id'),  
            'dmvAffiliateInfo' => array(self::HAS_MANY, 'DmvAffiliateInfo', 'admin_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Myclass::t('APP1'),
            'username' => Myclass::t('APP3'),
            'password' => Myclass::t('APP4'),
            'status' => Myclass::t('APP5'),
            'email' => Myclass::t('APP6'),
            'current_password' => Myclass::t('APP7'),
            're_password' => Myclass::t('APP8'),
            'modified_at' => "Last modified",
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

        $criteria->compare('id', $this->admin_id);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('email', $this->email, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Admin the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
