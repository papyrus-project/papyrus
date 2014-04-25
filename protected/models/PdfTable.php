<?php
class PdfTable extends CActiveRecord{
	
	public $id;
	public $path;
	public $titel;
	public $created;
	
	public function tableName(){
		return 'books_pdf';
	}
	
	public function rules(){
		return array(
			array('path','file','types'=>'pdf'),
			array('titel, path','required'),
			
		);
	}
	
}
