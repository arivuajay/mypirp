<?php

/**
 * This is the model class for table "dmv_post_message".
 *
 * The followings are the available columns in table 'dmv_post_message':
 * @property integer $message_id
 * @property string $message_title
 * @property string $descr
 * @property string $posted_date
 * @property integer $admin_id
 */
class DmvPostMessage extends MyActiveRecord 
{

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'dmv_post_message';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('affiliate_id,message_title, descr,posted_date', 'required'),
            array('affiliate_id', 'numerical', 'integerOnly' => true),
            array('message_title', 'length', 'max' => 20),
            array('posted_date,view_status', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('message_id, message_title, descr, posted_date, affiliate_id', 'safe', 'on' => 'search'),
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'message_id' => Myclass::t('Id'),
            'message_title' => Myclass::t('Title'),
            'descr' => Myclass::t('Description'),
            'posted_date' => Myclass::t('Posted Date'),
            'affiliate_id' => Myclass::t('Affiliate'),
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


         if(isset(Yii::app()->user->admin_id) && Yii::app()->user->admin_id!="")
        {  
            $criteria->condition = "Affliate.admin_id = :admin_id";
            $criteria->params = (array(':admin_id' => Yii::app()->user->admin_id));
        }    
        
        if(isset(Yii::app()->user->affiliate_id) && Yii::app()->user->affiliate_id!="")
        {    
            $criteria->addCondition("t.affiliate_id = ".Yii::app()->user->affiliate_id);  
        }  

        $criteria->with = array("Affliate");
        $criteria->together = true;

        return new CActiveDataProvider($this, array(
            'sort' => array(
                'defaultOrder' => 'posted_date DESC',
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
     * @return DmvPostMessage the static model class
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
