<?php

/**
 * This is the model class for table "bookgenre".
 *
 * The followings are the available columns in table 'bookgenre':
 * @property integer $bookgenre_id
 * @property string $genre
 *
 * The followings are the available model relations:
 * @property Books[] $books
 */
class Bookgenre extends CActiveRecord
{
    public $bookgenre_id;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'books_bookgenre';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
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
			'books' => array(self::HAS_ONE, 'Books', 'id'),
			'genreName' => array(self::BELONGS_TO, 'Genres', 'bookgenre_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'genre' => 'Genre',
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
		$criteria->compare('genre',$this->genre,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Bookgenre the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}