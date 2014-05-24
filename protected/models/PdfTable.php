<?php
class PdfTable extends CActiveRecord{
	
	public $id;
	public $title;
	public $description;
	public $file_path;
	public $cover_path;
	public $base_id;
	public $views;
	public $downloads;
	public $created;
	
	public function tableName(){
		return 'books';
	}
	
	public function rules(){
		return array(
			array('file_path','file','types'=>'pdf'),
			array('cover_path','file','types'=>'jpg,jpeg,png', 'allowEmpty' => true),
			array('title, file_path','required'),
			
		);
	}
	
}
