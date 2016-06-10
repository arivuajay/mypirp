<?php

/**
 * This is the model class for table "dmv_affiliate_info".
 *
 * The followings are the available columns in table 'dmv_affiliate_info':
 * @property integer $affiliate_id
 * @property string $agency_code
 * @property string $agency_name
 * @property string $user_id
 * @property string $password
 * @property string $enabled
 * @property string $aff_created_date
 * @property integer $sponsor_code
 * @property string $file_type
 * @property string $email_addr
 * @property string $record_type
 * @property string $trans_type
 * @property string $ssn
 * @property string $fedid
 * @property string $addr1
 * @property string $addr2
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property string $country_code
 * @property string $last_name
 * @property string $first_name
 * @property string $initial
 * @property string $contact_suffix
 * @property string $con_title
 * @property string $phone
 * @property string $phone_ext
 * @property string $fax
 * @property string $owner_last_name
 * @property string $owner_first_name
 * @property string $owner_initial
 * @property string $owner_suffix
 * @property string $agency_approved_date
 * @property string $aff_notes
 */
class DmvAffiliateInfo extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'dmv_affiliate_info';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('agency_code,agency_name, user_id, password', 'required'),
            array('agency_code, user_id', 'unique'),
            array('sponsor_code', 'numerical', 'integerOnly' => true),
            array('agency_code', 'length', 'max' => 3),
            array('agency_name, user_id', 'length', 'max' => 150),
            array('password, state, last_name, first_name', 'length', 'max' => 20),
            array('enabled, record_type, trans_type', 'length', 'max' => 1),
            array('file_type', 'length', 'max' => 100),
            array('email_addr, addr1, addr2', 'length', 'max' => 50),
            array('ssn, fedid, city', 'length', 'max' => 25),
            array('zip, country_code, contact_suffix, con_title, owner_last_name, owner_first_name, owner_initial, owner_suffix', 'length', 'max' => 10),
            array('initial', 'length', 'max' => 5),
            array('phone, phone_ext, fax', 'length', 'max' => 15),
            array('aff_created_date, agency_approved_date, aff_notes', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('affiliate_id, agency_code, agency_name, user_id, password, enabled, aff_created_date, sponsor_code, file_type, email_addr, record_type, trans_type, ssn, fedid, addr1, addr2, city, state, zip, country_code, last_name, first_name, initial, contact_suffix, con_title, phone, phone_ext, fax, owner_last_name, owner_first_name, owner_initial, owner_suffix, agency_approved_date, aff_notes', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
             'affiliateCommission' => array(self::HAS_ONE, 'DmvAffiliateCommission', 'affiliate_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'affiliate_id' => Myclass::t('Affiliate'),
            'agency_code' => Myclass::t('Agency Code'),
            'agency_name' => Myclass::t('Agency Name'),
            'user_id' => Myclass::t('User ID'),
            'password' => Myclass::t('Password'),
            'enabled' => Myclass::t('Enabled'),
            'aff_created_date' => Myclass::t('Aff Created Date'),
            'sponsor_code' => Myclass::t('Sponsor Code'),
            'file_type' => Myclass::t('File Type'),
            'email_addr' => Myclass::t('Email Addr'),
            'record_type' => Myclass::t('Record Type'),
            'trans_type' => Myclass::t('Transaction Type'),
            'ssn' => Myclass::t('SSN'),
            'fedid' => Myclass::t('Fed id#'),
            'addr1' => Myclass::t('Agency Address1'),
            'addr2' => Myclass::t('Address2'),
            'city' => Myclass::t('City'),
            'state' => Myclass::t('State'),
            'zip' => Myclass::t('Zip'),
            'country_code' => Myclass::t('Country Code'),
            'last_name' => Myclass::t('Contact Last Name'),
            'first_name' => Myclass::t('Contact First Name'),
            'initial' => Myclass::t('Contact Middle Initial'),
            'contact_suffix' => Myclass::t('Contact Suffix'),
            'con_title' => Myclass::t('Contact Title'),
            'phone' => Myclass::t('Contact Phone'),
            'phone_ext' => Myclass::t('Phone Ext'),
            'fax' => Myclass::t('Fax'),
            'owner_last_name' => Myclass::t('Owner Last Name'),
            'owner_first_name' => Myclass::t('Owner First Name'),
            'owner_initial' => Myclass::t('Owner Middle Initial'),
            'owner_suffix' => Myclass::t('Owner Suffix'),
            'agency_approved_date' => Myclass::t('Agency Approved Date'),
            'aff_notes' => Myclass::t('Notes'),
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
        $criteria->params=(array(':admin_id'=>Yii::app()->user->admin_id));
        
        $criteria->compare('affiliate_id', $this->affiliate_id);
        $criteria->compare('agency_code', $this->agency_code, true);
        $criteria->compare('agency_name', $this->agency_name, true);
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('enabled', $this->enabled, true);
        $criteria->compare('aff_created_date', $this->aff_created_date, true);
        $criteria->compare('sponsor_code', $this->sponsor_code);
        $criteria->compare('file_type', $this->file_type, true);
        $criteria->compare('email_addr', $this->email_addr, true);
        $criteria->compare('record_type', $this->record_type, true);
        $criteria->compare('trans_type', $this->trans_type, true);
        $criteria->compare('ssn', $this->ssn, true);
        $criteria->compare('fedid', $this->fedid, true);
        $criteria->compare('addr1', $this->addr1, true);
        $criteria->compare('addr2', $this->addr2, true);
        $criteria->compare('city', $this->city, true);
        $criteria->compare('state', $this->state, true);
        $criteria->compare('zip', $this->zip, true);
        $criteria->compare('country_code', $this->country_code, true);
        $criteria->compare('last_name', $this->last_name, true);
        $criteria->compare('first_name', $this->first_name, true);
        $criteria->compare('initial', $this->initial, true);
        $criteria->compare('contact_suffix', $this->contact_suffix, true);
        $criteria->compare('con_title', $this->con_title, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('phone_ext', $this->phone_ext, true);
        $criteria->compare('fax', $this->fax, true);
        $criteria->compare('owner_last_name', $this->owner_last_name, true);
        $criteria->compare('owner_first_name', $this->owner_first_name, true);
        $criteria->compare('owner_initial', $this->owner_initial, true);
        $criteria->compare('owner_suffix', $this->owner_suffix, true);
        $criteria->compare('agency_approved_date', $this->agency_approved_date, true);
        $criteria->compare('aff_notes', $this->aff_notes, true);
        
      
        return new CActiveDataProvider($this, array(
            'sort' => array(
                'defaultOrder' => 'agency_name ASC',
            ),
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
     * @return DmvAffiliateInfo the static model class
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
