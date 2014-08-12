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
	
}
