<?php

/**
 * This is the model class for table "users_data".
 *
 * The followings are the available columns in table 'users_data':
 * @property string $id
 * @property string $name
 * @property string $birthday
 * @property string $location
 * @property integer $sex
 * @property string $homepage
 * @property string $description
 * @property string $obs
 * @property string $site
 * @property string $facebook_address
 * @property string $twitter_address
 * @property string $activation_code
 * @property string $date_of_update
 * @property integer $invitations_left
 *
 * The followings are the available model relations:
 * @property Messages[] $messages
 * @property Messages[] $messages1
 * @property Subscription[] $subscriptions
 * @property Subscription[] $subscriptions1
 * @property Users $id0
 */
class UserData extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users_data';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, location, sex, homepage', 'required'),
			array('sex, invitations_left', 'numerical', 'integerOnly'=>true),
			array('id', 'length', 'max'=>20),
			array('name, location, homepage', 'length', 'max'=>255),
			array('site', 'length', 'max'=>1500),
			array('facebook_address, twitter_address', 'length', 'max'=>60),
			array('activation_code', 'length', 'max'=>45),
			array('birthday, description, obs, date_of_update', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('name, birthday, location, sex, homepage, description, obs, site, facebook_address, twitter_address, activation_code, date_of_update, invitations_left', 'safe', 'on'=>'search'),
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
			'messages' => array(self::HAS_MANY, 'Messages', 'receiver'),
			'messages1' => array(self::HAS_MANY, 'Messages', 'sender'),
			'subscriber' => array(self::HAS_MANY, 'Subscription', 'subscriber_id'),
			'subscribed' => array(self::HAS_MANY, 'Subscription', 'subscripted_id'),
			'id0' => array(self::BELONGS_TO, 'Users', 'id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'birthday' => 'Birthday',
			'location' => 'Location',
			'sex' => 'Sex',
			'homepage' => 'Homepage',
			'description' => 'Description',
			'obs' => 'Obs',
			'site' => 'Site',
			'facebook_address' => 'Facebook Address',
			'twitter_address' => 'Twitter Address',
			'activation_code' => 'Activation Code',
			'date_of_update' => 'Date Of Update',
			'invitations_left' => 'Invitations Left',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('birthday',$this->birthday,true);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('sex',$this->sex);
		$criteria->compare('homepage',$this->homepage,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('obs',$this->obs,true);
		$criteria->compare('site',$this->site,true);
		$criteria->compare('facebook_address',$this->facebook_address,true);
		$criteria->compare('twitter_address',$this->twitter_address,true);
		$criteria->compare('activation_code',$this->activation_code,true);
		$criteria->compare('date_of_update',$this->date_of_update,true);
		$criteria->compare('invitations_left',$this->invitations_left);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsersData the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
