<?php

/**
 * This is the model class for table "comments".
 *
 * The followings are the available columns in table 'comments':
 * @property string $id
 * @property string $users_id
 * @property string $text
 * @property string $date
 * @property integer $belongsTo
 * @property integer $ref_id
 * @property integer $rating
 *
 * The followings are the available model relations:
 * @property Books $ref
 * @property Users $users
 */
class Comments extends CActiveRecord
{
    public $users_id;
    public $text;
    public $date;
    public $users;
    public $count;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'comments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('users_id, text, date, ref_id', 'required'),
			array('belongsTo, ref_id, rating', 'numerical', 'integerOnly'=>true),
			array('users_id', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('text, date, rating', 'safe'),
			array('id, users_id, text, date, belongsTo, ref_id, rating', 'safe', 'on'=>'search'),
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
			'ref' => array(self::BELONGS_TO, 'Books', 'ref_id'),
			'users' => array(self::BELONGS_TO, 'UserData', 'users_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'users_id' => 'Users',
			'text' => 'Text',
			'date' => 'Date',
			'belongsTo' => 'Belongs To',
			'ref_id' => 'Ref',
			'rating' => 'Rating',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('users_id',$this->users_id,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('belongsTo',$this->belongsTo);
		$criteria->compare('ref_id',$this->ref_id);
		$criteria->compare('rating',$this->rating);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Comments the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    public function getAuthor($users_id)
    {
        return UserData::model()->findByPk($users_id)->name;
    }
}
