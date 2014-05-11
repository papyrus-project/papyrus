<?php

/**
 * This is the model class for table "books".
 *
 * The followings are the available columns in table 'books':
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $age_restriction
 * @property string $file_path
 * @property string $cover_path
 * @property string $cover_artist
 * @property integer $base_id
 * @property string $created
 * @property integer $downloads
 * @property integer $favorite_count
 * @property integer $words
 * @property string $updated
 * @property integer $views
 *
 * The followings are the available model relations:
 * @property Users[] $users
 * @property Bookgenre[] $bookgenres
 * @property Booktype[] $booktypes
 * @property Languanges[] $languanges
 * @property Users[] $users1
 */
class Books extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'books';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, description, age_restriction, file_path, cover_path, cover_artist, base_id, created, downloads, favorite_count, words, views', 'required'),
			array('age_restriction, base_id, downloads, favorite_count, words, views', 'numerical', 'integerOnly'=>true),
			array('title, file_path, cover_path, cover_artist', 'length', 'max'=>255),
			array('updated', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, description, age_restriction, file_path, cover_path, cover_artist, base_id, created, downloads, favorite_count, words, updated, views', 'safe', 'on'=>'search'),
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
			'users' => array(self::MANY_MANY, 'UserData', 'books_author(books_id, users_id)'),
			'bookgenres' => array(self::MANY_MANY, 'Bookgenre', 'books_bookgenre(books_id, bookgenre_id)'),
			'booktypes' => array(self::MANY_MANY, 'Booktype', 'books_booktype(books_id, booktype_id)'),
			'languanges' => array(self::MANY_MANY, 'Languanges', 'books_language(books_id, languages_id)'),
			'users1' => array(self::MANY_MANY, 'Users', 'favorites(books_id, users_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'description' => 'Description',
			'age_restriction' => 'Age Restriction',
			'file_path' => 'File Path',
			'cover_path' => 'Cover Path',
			'cover_artist' => 'Cover Artist',
			'base_id' => 'Base',
			'created' => 'Created',
			'downloads' => 'Downloads',
			'favorite_count' => 'Favorite Count',
			'words' => 'Words',
			'updated' => 'Updated',
			'views' => 'Views',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('age_restriction',$this->age_restriction);
		$criteria->compare('file_path',$this->file_path,true);
		$criteria->compare('cover_path',$this->cover_path,true);
		$criteria->compare('cover_artist',$this->cover_artist,true);
		$criteria->compare('base_id',$this->base_id);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('downloads',$this->downloads);
		$criteria->compare('favorite_count',$this->favorite_count);
		$criteria->compare('words',$this->words);
		$criteria->compare('updated',$this->updated,true);
		$criteria->compare('views',$this->views);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Books the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
