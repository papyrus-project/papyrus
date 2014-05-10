<?php

class BooksController extends Controller
{
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
	
	public function actionFiles(){
		$this->render('files');
	}
	
	public function actionEdit(){
		$this->render('edit');
	}
	
	public function actionUpload(){
		$model = new PdfTable();
		if(isset($_POST['PdfTable'])){
			$model->attributes = $_POST['PdfTable'];
			$model->description = $_POST['PdfTable']['description'];
			$uploadFile = CUploadedFile::getInstance($model,'file_path');
			$filename = "{$uploadFile}";
			$model->file_path = '/../upload/pdf/'.substr($filename,0,-4);
			$uploadCover = CUploadedFile::getInstance($model,'cover_path');
			$covername = "{$uploadCover}";
			$model->cover_path = '/../upload/cover/'.$filename;
			$model->created = time();
			if($model->save()){
				$connection=Yii::app()->db; 
				$command=$connection->createCommand('
					INSERT INTO  `books_author` (
						`users_id` ,
						`books_id`
					)
					VALUES (
						"'.Yii::app()->user->id.'",
						"'.$model->id.'"
					)');
				$rowCount=$command->execute();
				
				if(!is_dir(Yii::app()->basePath.'/../upload/pdf/'))
					mkdir(Yii::app()->basePath.'/../upload/pdf/',0777,true);
				if(!is_dir(Yii::app()->basePath.'/../upload/cover/'))
					mkdir(Yii::app()->basePath.'/../upload/cover/',0777,true);
				$uploadFile->saveAs(Yii::app()->basePath.'/../upload/pdf/'.$uploadFile);
				$uploadCover->saveAs(Yii::app()->basePath.'/../upload/cover/'.$uploadCover);
				$this->redirect(array('books/upload'));
			}
		}
		
		$this->render('Upload',array('model'=>$model));
	}
	
}
	