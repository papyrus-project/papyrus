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
 * @property integer $booktype_id
 * @property integer $language_id
 * @property string $author
 *
 * The followings are the available model relations:
 * @property UsersData $author0
 * @property Booktype $booktype
 * @property Languanges $language
 * @property Bookgenre[] $bookgenres
 * @property Users[] $users
 */
class Books extends CActiveRecord
{
    //public $id;
    public $title;
    public $description;
    public $age_restriction;
    //public $file_path;
    public $cover_path;
    public $cover_artist;
    //public $base_id;
    //public $created;
    //public $downloads;
    //public $favorite_count;
    public $words;
    //public $updated;
    //public $views;
    public $booktype_id;
    public $language_id;
    public $author;

    //The followings are the available model relations:
    //public $author0;
    //public $bookgenres;
    //public $booktype;
    //public $language;
    //public $users1;
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
			array('title, age_restriction, cover_path, words', 'required'),
			array('age_restriction, base_id, downloads, favorite_count, words, views, booktype_id, language_id', 'numerical', 'integerOnly'=>true),
			array('title, file_path, cover_path, cover_artist', 'length', 'max'=>255),
			array('author', 'length', 'max'=>20),
			array('updated, title, description, words, booktype_id, language_id, age_restriction, cover_artist', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, description, age_restriction, file_path, cover_path, cover_artist, base_id, created, downloads, favorite_count, words, updated, views, booktype_id, language_id, author', 'safe', 'on'=>'search'),
		);
	} 
	
	public function scopes()
    {
        return array(
            'published'=>array(
                'condition'=>'status=1',
            ),
            'recently'=>array(
                'order'=>'id DESC',
                'limit'=>5,
            ),
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
			'author0' => array(self::BELONGS_TO, 'UsersData', 'author'),
			'booktype' => array(self::BELONGS_TO, 'Booktype', 'booktype_id'),
			'language' => array(self::BELONGS_TO, 'Languanges', 'language_id'),
			'bookgenres' => array(self::HAS_MANY, 'Bookgenre', 'books_id'),
			'users' => array(self::MANY_MANY, 'Users', 'favorites(books_id, users_id)'),
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
			'booktype_id' => 'Booktype',
			'language_id' => 'Language',
			'author' => 'Author',
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
		$criteria->compare('booktype_id',$this->booktype_id);
		$criteria->compare('language_id',$this->language_id);
		$criteria->compare('author',$this->author,true);

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
    
    public function getGenres()
    {
        $bookgenres = $this->bookgenres;
        return($bookgenres);
    }
    public function addBookGenres($genres, $id) {
        $connection=Yii::app()->db; 
        $command=$connection->createCommand('
			DELETE
			FROM alex.books_bookgenre
			where books_id = ' . $id . ';
			
			INSERT INTO alex.books_bookgenre (books_id,bookgenre_id) VALUES
			' . $genres . '
			');
        $rowCount=$command->execute();
    }
}
