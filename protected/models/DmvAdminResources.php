<?php

/**
 * This is the model class for table "dmv_admin_resources".
 *
 * The followings are the available columns in table 'dmv_admin_resources':
 * @property integer $adres_id
 * @property integer $admin_id
 * @property integer $resource_key
 * @property string $created_at
 * @property string $modified_at
 *
 * The followings are the available model relations:
 * @property DmvResources $resource
 * @property DmvAdmin $admin
 */
class DmvAdminResources extends MyActiveRecord  {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'dmv_admin_resources';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            //array('admin_id, resource_key, created_at, modified_at', 'required'),
            array('admin_id', 'numerical', 'integerOnly' => true),
            array('resource_key', 'length', 'max'=>255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('adres_id, admin_id, resource_key, created_at, modified_at', 'safe', 'on' => 'search'),
        );
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
            'admin' => array(self::BELONGS_TO, 'DmvAdmin', 'admin_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'adres_id' => Myclass::t('Adres'),
            'admin_id' => Myclass::t('Admin'),
            'resource_key' => Myclass::t('Resource'),
            'created_at' => Myclass::t('Created At'),
            'modified_at' => Myclass::t('Modified At'),
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

        $criteria->compare('adres_id', $this->adres_id);
        $criteria->compare('admin_id', $this->admin_id);
        $criteria->compare('resource_key', $this->resource_key, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('modified_at', $this->modified_at, true);

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
     * @return DmvAdminResources the static model class
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
