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
        $id=14; //buch id
        if(!$id)
			$id = Yii::app()->books->id;
        //tabellen joinen
		$model = Books::model()->with('users', 'bookgenres', 'booktypes', 'languanges', 'users1')->findByPk($id);
        
        //languages auslesen und als 1 string schreiben
        $lang1 = Books::model()->findByPk($id)->languanges;
        $lang = '';
        foreach($lang1 as $value){
            $lang = $lang . $value['language'] . ', ';   
            
        }//genres auslesen und als 1 string schreiben
        $genre = Books::model()->findByPk($id)->bookgenres;
        $genres = '';
        foreach($genre as $value){
            $genres = $genres . $value['genre'] . ', ';
        }
        //booktype sollte ueberarbeitet werden!
		$this->render('files',array('model' => $model, 'lang' => $lang, 'genres' => $genres,));
	}
	
	public function actionEdit(){
		$this->render('edit');
	}
	
	public function actionUpload(){
		$model = new PdfTable();
		if(isset($_POST['PdfTable'])){
			//Setzen der variablen
			$model->attributes = $_POST['PdfTable'];
			$model->description = $_POST['PdfTable']['description'];
			$model->created = time();
			
			//PDF Datei verarbeiten
			$uploadFile = CUploadedFile::getInstance($model,'file_path');
			$filename = "{$uploadFile}";
			$i = 0;
			$fileInfo = pathinfo($filename);
			do {
				$file_path = '/../upload/pdf/'.$fileInfo['filename'].'-'.$i++.'.'.$fileInfo['extension'];
			} while (is_file(Yii::app()->basePath.$file_path));
			$model->file_path = $file_path;
			
			//Cover Datei verarbeiten
			$uploadCover = CUploadedFile::getInstance($model,'cover_path');
			$covername = "{$uploadCover}";
			$i = 0;
			$coverInfo = pathinfo($covername);
			do{
				$cover_path = $coverInfo['filename'].'-'.$i++.'.'.$coverInfo['extension'];
			} while(is_file(Yii::app()->basePath.'/../upload/cover/'.$cover_path));
			$model->cover_path = $cover_path;
			
			//Eintrag in die Datenbank
			if($model->save()){
				//Eintrag in die BooksAuthor
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
				
				//Ueberpruefen ob die Ordner schon vorhanden sind sonst neue erstellen
				if(!is_dir(Yii::app()->basePath.'/../upload/pdf/'))
					mkdir(Yii::app()->basePath.'/../upload/pdf/',0777,true);
				if(!is_dir(Yii::app()->basePath.'/../upload/cover/'))
					mkdir(Yii::app()->basePath.'/../upload/cover/',0777,true);
				
				//Dateien hochladen
				$uploadFile->saveAs(Yii::app()->basePath.$file_path);
				$uploadCover->saveAs(Yii::app()->basePath.$cover_path);
				$this->redirect(array('books/upload'));
			}
		}
		
		$this->render('Upload',array('model'=>$model));
	}
	
}
	