<?php
/*
 * Klasse fuer books Table
 * Diese Klasse wird nur beim Upload verwendet
 */
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
			array('updated, title, description, words, booktype_id, language_id, wip, nsfw, age_restriction, cover_artist', 'safe'),
		);
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
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Buchtitel',
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
