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
	
	public function actionFiles($id){
        //zur startseite, wenn id fehlt
        if(!$id)
			$this->redirect(Yii::app()->createAbsoluteUrl(''));
        //tabellen joinen
		$model = Books::model()->findByPk($id);
        if(!$model)
			$this->redirect(Yii::app()->createAbsoluteUrl(''));
        //genres auslesen und als 1 string schreiben
        $genre = $model->bookgenres;
        $genres = '';
        $genreArray = array();
        foreach($genre as $value){
            $genreArray[] = $value->genreName->genre;
        }
        if($genreArray)
            $genres = implode(", ", $genreArray);
        else
            $genres = '';
        //buchtyp auslesen
        $type = Booktype::model()->findByPk($model->booktype_id)->type;
        //languages 
        $lang = Languanges::model()->findByPk($model->language_id)->language;
        //autor auslesen
        $author = UserData::model()->findByPk($model->author)->name;
        
        //pseudo view counter
        $views = $model->views + 1;
        Books::model()->updateByPk($id, array('views'=> $views));

		//Meta daten fuer Facebookshare
        Yii::app()->clientScript->registerMetaTag($model->description, 'og:description');
        Yii::app()->clientScript->registerMetaTag($model->title, 'og:title');

        
        //comments
        $commentForm = new Comments();
        if(isset($_POST['Comments'])) {
            $commentForm->users_id = Yii::app()->user->id;
            $commentForm->text = $_POST['Comments']['text'];
            date_default_timezone_set('Europe/Berlin');
            $commentForm->date = date('m/d/Y h:i:s a', time());
            $commentForm->ref_id = $id;
            $commentForm->belongsTo = 0;
            if($commentForm->validate()) {
                if($commentForm->save()) {
                    //happy dance
                } 
                else {
                    throw new CHttpException(500, 'Something went wrong');
                }
            }
        }
        $comments = array();
        $commentList = Comments::model()->with('users')->findAllByAttributes(array('ref_id'=>$id));
        foreach($commentList as $comment){
            $comments[] = $comment;
        }
        
		$this->render('files',array('model' => $model, 'lang' => $lang, 'genres' => $genres, 'type'=>$type, 'author'=>$author, 'commentForm'=>$commentForm, 'comments'=>$comments));
	}
	
	public function actionEdit($id){
        //zur startseite, wenn id fehlt
        if(!$id)
			$this->redirect(Yii::app()->createAbsoluteUrl(''));
		$model = Books::model()->findByPk($id);
		if(!$model || $model->author != Yii::app()->user->id)
			$this->redirect(Yii::app()->createAbsoluteUrl(''));
        $languages = Languanges::model()->findAll();
        $types = Booktype::model()->findAll();
        if(isset($_POST['Books']))
        {
            // Erfasst die gesendeten Formulardaten
            $model->attributes=$_POST['Books'];
            // Validiert die Daten und kehrt zur vorherigen Seite zur��ck, 
            // wenn die Pr��fung erfolgreich war.
            $genres = '';
            if($model->validate()) {
                //genres speichern
                if(isset($_POST['genres'])) {
                    foreach($_POST['genres'] as $genre_id=>$checked){
                        $genres[] = '('.$id.','.$checked.')';
                    }
                    $genresStr = implode(",", $genres) . ';';
                    $model->addBookGenres($genresStr, $id); //Add Interest
                }
                    
                if($model->save()) {
                  //happy dance
                } 
                else {
                  throw new CHttpException(500, 'Something went wrong');
                }
                $this->redirect(Yii::app()->createUrl('books/files', array('id'=>$model->id)));
            }
        }
		$selectedGenres = array();
		foreach ($model->bookgenres as $foo => $bar) {
			$selectedGenres[] = $bar->bookgenre_id; 
		}
		
		
        $this->render('edit',array('model'=>$model,'selectedGenres' => $selectedGenres));
	}
	
	public function actionUpload(){
		$model = new PdfTable();
		if(isset($_POST['PdfTable'])){
			//Setzen der variablen
			$model->attributes = $_POST['PdfTable'];
			$model->description = $_POST['PdfTable']['description'];
			
			
			//PDF Datei verarbeiten
			$uploadFile = CUploadedFile::getInstance($model,'file_path');
			if($uploadFile){
				$filename = "{$uploadFile}";
				$i = 0;
				$fileInfo = pathinfo($filename);
				do {
					$file_path = '/../upload/pdf/'.$fileInfo['filename'].'-'.$i++.'.'.$fileInfo['extension'];
				} while (is_file(Yii::app()->basePath.$file_path));
				$model->file_path = $file_path;
			}
			//Cover Datei verarbeiten
			$uploadCover = CUploadedFile::getInstance($model,'cover_path');
			if($uploadCover){
				$covername = "{$uploadCover}";
				$i = 0;
				$coverInfo = pathinfo($covername);
				do{
					$cover_path = $coverInfo['filename'].'-'.$i++.'.'.$coverInfo['extension'];
				} while(is_file(Yii::app()->basePath.'/../upload/cover/'.$cover_path));
				$model->cover_path = $cover_path;
			} else {
				$model->cover_path = 'default.jpg';				
			}
            $model->author = Yii::app()->user->id;
			
			//Eintrag in die Datenbank
			if($model->save()){
                ////Eintrag in die BooksAuthor
                //$connection=Yii::app()->db; 
                //$command=$connection->createCommand('
                //    INSERT INTO  `books_author` (
                //        `users_id` ,
                //        `books_id`
                //    )
                //    VALUES (
                //        "'.Yii::app()->user->id.'",
                //        "'.$model->id.'"
                //    )');
                //$rowCount=$command->execute();
				
				//Ueberpruefen ob die Ordner schon vorhanden sind sonst neue erstellen
				if(!is_dir(Yii::app()->basePath.'/../upload/pdf/'))
					mkdir(Yii::app()->basePath.'/../upload/pdf/',0777,true);
				if(!is_dir(Yii::app()->basePath.'/../upload/cover/'))
					mkdir(Yii::app()->basePath.'/../upload/cover/',0777,true);
				
				//Dateien hochladen
				if($uploadFile){
					$uploadFile->saveAs(Yii::app()->basePath.$file_path);
				}
				if($uploadCover){
					$uploadCover->saveAs(Yii::app()->basePath.'/../upload/cover/'.$cover_path);
				}
				$this->redirect(array('books/edit/'.$model->id));
			}
		}
		
		$this->render('upload',array('model'=>$model));
	}

	public function actionBookList($id){
		$model = Books::model()->findAll();
	}
	
}
	