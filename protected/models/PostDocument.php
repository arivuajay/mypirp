<?php

/**
 * This is the model class for table "dmv_post_document".
 *
 * The followings are the available columns in table 'dmv_post_document':
 * @property integer $id
 * @property string $doc_title
 * @property string $posted_date
 * @property string $file_name
 */
class PostDocument extends CActiveRecord
{
    public $image;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dmv_post_document';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('doc_title, posted_date', 'required'),
			array('doc_title', 'length', 'max'=>50),
			array('file_name', 'length', 'max'=>250),
			array('posted_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, doc_title, posted_date, file_name,image', 'safe', 'on'=>'search'),
                        array('image', 'file','allowEmpty'=>true,  'safe' => false),
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
			'id' => Myclass::t('ID'),
			'doc_title' => Myclass::t('Title'),
			'posted_date' => Myclass::t('Posted Date'),
			'file_name' => Myclass::t('Document'),
                         'image' => Myclass::t('Document'),
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
                
                $criteria->condition = "admin_id = :admin_id";
                $criteria->params=(array(':admin_id'=>Yii::app()->user->admin_id));

		$criteria->compare('id',$this->id);
		$criteria->compare('doc_title',$this->doc_title,true);
		$criteria->compare('posted_date',$this->posted_date,true);
		$criteria->compare('file_name',$this->file_name,true);

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
	 * @return PostDocument the static model class
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
