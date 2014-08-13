<?php

/**
 * This is the model class for table "messages".
 *
 * The followings are the available columns in table 'messages':
 * @property string $message
 * @property string $sender
 * @property string $receiver
 * @property integer $read
 * @property string $created
 * @property string $subject
 *
 * The followings are the available model relations:
 * @property Users $sender0
 * @property Users $receiver0
 */
class Messages extends CActiveRecord
{
	public $verifyCode;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'messages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('message, sender, receiver, subject', 'required'),
			array('read', 'numerical', 'integerOnly'=>true),
			array('sender, receiver', 'length', 'max'=>20),
			array('subject', 'length', 'max'=>255),
			array('created', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('message, sender, receiver, read, created, subject', 'safe', 'on'=>'search'),
			array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
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
			'sender0' => array(self::BELONGS_TO, 'UserData', 'sender'),
			'receiver0' => array(self::BELONGS_TO, 'UsersData', 'receiver'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'message' => 'Nachricht',
			'sender' => 'sender',
			'receiver' => 'To',
			'read' => 'Read',
			'created' => 'Created',
			'subject' => 'Betreff',
			'verifyCode'=>'Verification Code',
		);
	}
	
	public function scopes()
    {
		return array(
			'got'=>array(
				'condition'=>'receiver='.YII::app()->user->id,
			),
			'send'=>array(
				'condition'=>'sender='.YII::app()->user->id,
			),
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

		$criteria->compare('message',$this->message,true);
		$criteria->compare('sender',$this->sender,true);
		$criteria->compare('to',$this->to,true);
		$criteria->compare('read',$this->read);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('subject',$this->subject,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Messages the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
