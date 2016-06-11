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
class DmvClasses extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dmv_classes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('clas_name, start_time, end_time, start_time2, end_time2, location, loc_addr, loc_city, zip', 'required'),
			array('affiliate_id, country, instructor_id, pending', 'numerical', 'integerOnly'=>true),
			array('clas_name, location', 'length', 'max'=>50),
			array('start_time, end_time, start_time2, end_time2, loc_state, zip', 'length', 'max'=>10),
			array('loc_addr', 'length', 'max'=>30),
			array('loc_city', 'length', 'max'=>20),
			array('show_admin', 'length', 'max'=>1),
			array('clas_date, date2', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('clas_id, affiliate_id, clas_date, clas_name, start_time, end_time, date2, start_time2, end_time2, location, loc_addr, loc_city, loc_state, zip, country, instructor_id, show_admin, pending', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
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
			'loc_addr' => Myclass::t('Loc Addr'),
			'loc_city' => Myclass::t('City'),
			'loc_state' => Myclass::t('State'),
			'zip' => Myclass::t('Zip'),
			'country' => Myclass::t('Country'),
			'instructor_id' => Myclass::t('Instructor'),
			'show_admin' => Myclass::t('Show Admin'),
			'pending' => Myclass::t('Pending'),
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('clas_id',$this->clas_id);
		$criteria->compare('affiliate_id',$this->affiliate_id);
		$criteria->compare('clas_date',$this->clas_date,true);
		$criteria->compare('clas_name',$this->clas_name,true);
		$criteria->compare('start_time',$this->start_time,true);
		$criteria->compare('end_time',$this->end_time,true);
		$criteria->compare('date2',$this->date2,true);
		$criteria->compare('start_time2',$this->start_time2,true);
		$criteria->compare('end_time2',$this->end_time2,true);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('loc_addr',$this->loc_addr,true);
		$criteria->compare('loc_city',$this->loc_city,true);
		$criteria->compare('loc_state',$this->loc_state,true);
		$criteria->compare('zip',$this->zip,true);
		$criteria->compare('country',$this->country);
		$criteria->compare('instructor_id',$this->instructor_id);
		$criteria->compare('show_admin',$this->show_admin,true);
		$criteria->compare('pending',$this->pending);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination' => array(
                            'pageSize' => PAGE_SIZE,
                        )
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DmvClasses the static model class
	 */
	public static function model($className=__CLASS__)
	{
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
