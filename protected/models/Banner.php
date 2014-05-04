<?php
class Banner extends CActiveRecord{

	public $image;
	public $isNewRecord;

	public function rules(){
		return array(
			array('image', 'file','types'=>'jpg, gif, png', 'allowEmpty'=>true, 'on'=>'update')
			);
	}

	public function attributeLabels()
	{
		return array(
			'rememberMe'=>'Remember me next time',
		);
	}
}