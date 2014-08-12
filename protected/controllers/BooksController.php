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
        $commentForm->users_id = Yii::app()->user->id;
        $commentForm->date = date('m/d/Y h:i:s a', time());
        $commentForm->ref_id = $id;
        $commentForm->belongsTo = 0;
        
        $comments = array();
        $commentList = Comments::model()->with('users')->findAllByAttributes(array('ref_id'=>$id));
        foreach($commentList as $comment){
            if($comment->belongsTo == 0)
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
			
						
			//Cover Datei
			$uploadCover = CUploadedFile::getInstance($model,'extension');
			if($_POST['uploadType']=='multi'){
				$uploadFiles = CUploadedFile::getInstances($model,'file_path');
				$newBookId = $this->uploadFile($uploadFiles[0],$uploadCover);
				unset($uploadFiles[0]);
				foreach ($uploadFiles as $uploadFile) {
					$this->uploadFile($uploadFile,$uploadCover,$newBookId);
				}
			} else {
				//PDF Datei verarbeiten
				$uploadFile = CUploadedFile::getInstance($model,'file_path');
				$newBookId = $this->uploadFile($uploadFile,$uploadCover);
			}
			//Eintrag in die Datenbank
			$this->redirect(array('books/edit/'.$newBookId));
		}
		
		$this->render('upload',array('model'=>$model));
	}

	public function actionBookList($id){
		$model = Books::model()->findAll();
	}
	
	private function uploadFile($uploadFile,$uploadCover,$baseId=0){
		$model = new PdfTable();
		$model->attributes = $_POST['PdfTable'];
		$model->base_id = $baseId;
        $model->author = Yii::app()->user->id;
		if(!$uploadFile){
			throw new CException('Kein Buch');
		}

		if($uploadCover){
			$covername = "{$uploadCover}";
			$coverInfo = pathinfo($covername);
			$model->extension = $coverInfo['extension'];
		} else {
			$model->extension = '';				
		}
		
		if($model->save()){
			//Ueberpruefen ob die Ordner schon vorhanden sind sonst neue erstellen
			if(!is_dir(Yii::app()->basePath.'/../upload/pdf/'))
				mkdir(Yii::app()->basePath.'/../upload/pdf/',0777,true);
			if(!is_dir(Yii::app()->basePath.'/../upload/cover/'))
				mkdir(Yii::app()->basePath.'/../upload/cover/',0777,true);
			
			//Dateien Speichern
			if($uploadFile){
				$uploadFile->saveAs(Yii::app()->basePath.'/../upload/pdf/'.$model->id.'.pdf');
			}
			if($uploadCover){
				$uploadCover->saveAs(Yii::app()->basePath.'/../upload/cover/'.$model->id.'.'.$model->extension);
			}
			return $model->id;
		}
		print_r($model->getErrors());die();
		//throw new Exception("Error Processing Request", 1);
		
	}

    public function actionPostComment($id){
        
        //comments
        if(isset($_POST['Comments'])) {
            $commentForm = new Comments();
            $commentForm->users_id = Yii::app()->user->id;
            $commentForm->text = CHtml::encode(print_r($_POST['Comments']['text'], true));
            $commentForm->date = date('Y/m/d h:i:s a', time());
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
            
            echo    '<script type="text/javascript">';
            echo        'document.getElementById("comments").innerHTML = document.getElementById("comments").innerHTML + ';
            echo        '"<div class=\"row\">';
            echo                userData::model()->findByPk(Yii::app()->user->id)->name . '<br/>';
            echo                date('m/d/Y h:i:s a', time()) . '<br/>';
            echo                CHtml::encode(print_r($_POST['Comments']['text'], true)) . '<br/>';
            echo                '<div class=\"edit\">';
            echo                        '<a href=' . Yii::app()->createUrl('books/files', array('id'=>$id)) . '>edit</a> ';
            echo                        '<a href='. Yii::app()->createUrl('books/files', array('id'=>$id)) . '>delete</a>';
            
            //echo                    CHtml::ajaxLink('Edit', array('books/editComment', 'id'=>$commentForm->id), array('update'=>'#newComment',)) . ' ';
            //echo                    CHtml::ajaxLink('Delete', array('books/deleteComment', 'id'=>$comment->id), array('update'=>'#com',));
            
            echo                '</div>';
            echo            '</div>";</script>';
        }
    }
    
    public function actionDeleteComment($id){
		$model = Comments::model()->findByPk($id)->delete();
        echo    '<script type="text/javascript">';
        echo        'var element = document.getElementById("' . $id . '");';
        echo        'element.outerHTML = "";';
        echo        'delete element;';
        echo    '</script>';
    }
    
    public function actionShowEditCommentForm($id){
		$model = Comments::model()->findByPk($id);
        $model->text = CHtml::decode($model->text);
        echo $this->renderPartial('editComment', array('model' => $model, 'id'=>$model->id), true, true);
    }

	public function actionDownload($id){
		$model = Books::model()->findByPk($id);
		header('Content-Disposition: attachment; filename="'.$model->title.'.pdf"');
		readfile(YII::app()->basePath.$model->file_path);
	}
    
    public function actionShowNewCommentForm($id){
        $commentForm = new Comments();
        echo $this->renderPartial('newComment', array('model' => $commentForm, 'id'=>$id), true, true);
    }
    
    public function actionShowNewAnswerForm($id, $belongsTo=null){
        $commentForm = new Comments();
        //$commentForm->belongsTo = 0;
        echo $this->renderPartial('newAnswer', array('model' => $commentForm, 'id'=>$id, 'belongsTo'=>$belongsTo), true, true);
        //echo $this->renderPartial('newAnswer', array('model' => $commentForm, 'id'=>$id), true, true);
    }
    
    public function actionSaveEdit($id){
            $model = Comments::model()->findByPk($id);
            $model->text = CHtml::encode(print_r($_POST['Comments']['text'], true));
            
            if($model->save()) {
                //happy dance
            } 
            else {
                throw new CHttpException(500, 'Something went wrong');
            }
        
            echo    '<script type="text/javascript">';
            echo        'var element = document.getElementById("' . $model->id . '");';
            echo        'element.innerHTML = "</br>' . $model->date . '</br>' . $model->text . '</br>";';
            echo        'element.innerHTML = element.innerHTML  + "<a href=' . Yii::app()->createUrl('books/files', array('id'=>$id)) . '>edit</a> <a href='. Yii::app()->createUrl('books/files', array('id'=>$id)) . '>delete</a>";';
            echo    '</script>';
    }
    
    public function actionPostAnswer($id, $belongsTo=0){
        echo print_r($_POST);
        if(isset($_POST['Comments'])) {
            $commentForm = new Comments();
            $commentForm->users_id = Yii::app()->user->id;
            $commentForm->text = CHtml::encode(print_r($_POST['Comments']['text'], true));
            $commentForm->date = date('Y/m/d h:i:s a', time());
            $commentForm->ref_id = $id;
            $commentForm->belongsTo = $belongsTo;
            if($commentForm->validate()) {
                if($commentForm->save()) {
                    //happy dance
                } 
                else {
                    throw new CHttpException(500, 'Something went wrong');
                }
            }
        }
    }
    public function actionShowAnswers($id, $belongsTo){
        $comments = array();
        $commentList = Comments::model()->with('users')->findAllByAttributes(array('ref_id'=>$id));
        foreach($commentList as $comment){
            if($comment->belongsTo == $belongsTo)
                $comments[] = $comment;
        }
        echo $this->renderPartial('answers', array('comments' => $comments), true, true);
    }
    
    public function actionNewComment($id){
        $model = new Comments();
        $this->render('newComment',array('model'=>$model, 'id'=>$id));
	}
    public function actionEditComment($id){
        $model = new Comments();
        $this->render('editComment',array('model'=>$model, 'id'=>$id));
	}
    public function actionNewAnswer($id, $belongsTo=0){
        $model = new Comments();
        $this->render('newAnswer',array('model'=>$model, 'id'=>$id, 'belongsTo'=>$belongsTo));
	}
    public function actionAnswer(){
        $comments = array();
        $this->render('answer',array('comment'=>$comments));
    }
}
	