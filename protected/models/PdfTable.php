<?php
class PdfTable extends CActiveRecord{
	
	public $id;
	public $title;
	public $description;
	public $file_path;
	public $extension;
	public $base_id;
	public $views;
	public $downloads;
	public $created;
	
	public function tableName(){
		return 'books';
	}
	
	public function rules(){
		return array(
			array('extension','file','types'=>'jpg,jpeg,png', 'allowEmpty' => true),
			array('title','required'),
			array('title, description, age_restriction, base_id','safe'),
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'description' => 'Klappentext',
			'age_restriction' => 'Age Restriction',
			'extension' => 'File extension',
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
            'status' => 'Status',
		);
	}
}
