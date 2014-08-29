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
        
        $rating = Comments::model()->findBySql('select SUM(`rating`) as `rating`, count(id) as `count` from comments WHERE ref_id=:id AND rating != 0', array(':id'=>$id));
        
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

        //comments
        $commentForm = new Comments();
        $commentForm->users_id = Yii::app()->user->id;
        $commentForm->date = Yii::time(time());
        $commentForm->ref_id = $id;
        $commentForm->belongsTo = 0;
        
        $comments = array();
        $commentList = Comments::model()->with('users')->findAllByAttributes(array('ref_id'=>$id),array('order'=>'date desc'));
        foreach($commentList as $comment){
            if($comment->belongsTo == 0)
                $comments[] = $comment;
        }

		//Meta daten fuer Facebookshare
        Yii::app()->clientScript->registerMetaTag($model->description, 'og:description');
        Yii::app()->clientScript->registerMetaTag($model->title, 'og:title');
        Yii::app()->clientScript->registerMetaTag(YII::app()->createAbsoluteUrl('/upload/cover/original/'.((strlen($model->extension)<=5?$model->id.'.':'').$model->extension)), 'og:image');
       
		$this->render('files',array('model' => $model, 'lang' => $lang, 'genres' => $genres, 'type'=>$type, 'author'=>$author, 'commentForm'=>$commentForm, 'comments'=>$comments,'rating'=>$rating));
	}
	
	public function actionEdit($id){
        Yii::import('application.Components.*');
        require_once('ImageEdit.php');
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
            //$model->attributes=$_POST['Books'];
            $model->attributes=$_POST;
            // Validiert die Daten und kehrt zur vorherigen Seite zur��ck, 
            // wenn die Pr��fung erfolgreich war.
            $genres = '';
            if($model->validate()) {
                $model->title=CHtml::encode($_POST['Books']['title']);
                $model->description=CHtml::encode($_POST['Books']['description']);
                $model->wip=$_POST['Books']['wip'];
                $model->nsfw=$_POST['Books']['nsfw'];
                //genres speichern
                if(isset($_POST['genres'])) {
                    foreach($_POST['genres'] as $genre_id=>$checked){
                        $genres[] = '('.$id.','.$checked.')';
                    }
                    $genresStr = implode(",", $genres) . ';';
                    $model->addBookGenres($genresStr, $id); //Add Interest
                }
                $uploadCover = '';
                $oldExt = $model->extension;
                if($_POST['optionsRadios'] == 'custom')
                {
                    //Cover Datei
                    $uploadCover = CUploadedFile::getInstance($model,'extension');
                    if($uploadCover){
                        $covername = "{$uploadCover}";
                        $coverInfo = pathinfo($covername);
                        $model->extension = $coverInfo['extension'];
                    }
                }
                else
                    $model->extension = $_POST['optionsRadios'].'.jpg';
                    
                //$p = $uploadCover;
                if($model->save()) {
                    //happy dance
                    if($_POST['optionsRadios'] == 'custom')
                    {
                        //Ueberpruefen ob die Ordner schon vorhanden sind sonst neue erstellen
                        if(!is_dir(Yii::app()->basePath.'/../upload/cover/original/'))
                            mkdir(Yii::app()->basePath.'/../upload/cover/original/',0777,true);
                        
                        //Dateien Speichern
                        if($uploadCover){
                            if(is_file(Yii::getPathOfAlias('webroot').'/upload/cover/original/'.$model->id.'.'.$oldExt))
                                unlink(Yii::getPathOfAlias('webroot').'/upload/cover/original/'.$model->id.'.'.$oldExt);
                            $uploadCover->saveAs(Yii::app()->basePath.'/../upload/cover/original/'.$model->id.'.'.$model->extension);

                            ImageEdit::resize(0.75, Yii::app()->basePath.'/../upload/cover/original/'.$model->id.'.'.$model->extension);
                            
                            if(is_file(Yii::getPathOfAlias('webroot').'/upload/cover/thumb/'.$model->id.'.'.$oldExt))
                                unlink(Yii::getPathOfAlias('webroot').'/upload/cover/thumb/'.$model->id.'.'.$oldExt);
                            if(is_file(Yii::getPathOfAlias('webroot').'/upload/cover/big/'.$model->id.'.'.$oldExt))
                                unlink(Yii::getPathOfAlias('webroot').'/upload/cover/big/'.$model->id.'.'.$oldExt);
                        }
                    }
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
		
		$model->title = CHtml::decode($model->title);
		$model->description = CHtml::decode($model->description);
        $this->render('edit',array('model'=>$model,'selectedGenres' => $selectedGenres));
	}
	
	public function actionUpload(){
		$model = new PdfTable();
		if(isset($_POST['PdfTable'])){
			//print(nl2br(print_r($_POST)));
            //die();
			//Cover Datei
			$uploadCover = '';
            if($_POST['optionsRadios'] == 'custom')
            {
                //Cover Datei
                $uploadCover = CUploadedFile::getInstance($model,'extension');
                if($uploadCover){
                    $covername = "{$uploadCover}";
                    $coverInfo = pathinfo($covername);
                    $model->extension = $coverInfo['extension'];
                }
            }
            else
                $model->extension = $_POST['optionsRadios'].'.jpg';
			//$uploadCover = CUploadedFile::getInstance($model,'extension');
			
			if($_POST['uploadType']=='multi'){
				$uploadFiles = CUploadedFile::getInstances($model,'file_path');
				$newBookId = $this->uploadFile($uploadFiles[0],$uploadCover);
				foreach ($uploadFiles as $value=>$uploadFile) {
					$_POST['PdfTable']['title'] = $_POST['PdfTable']['name'][$value]?$_POST['PdfTable']['name'][$value]:'Kapitel '.($value+1);
					$this->uploadFile($uploadFile,$uploadCover,$newBookId);
				}
			} else {
				//PDF Datei verarbeiten
				$uploadFile = CUploadedFile::getInstance($model,'file_path');
				$newBookId = $this->uploadFile($uploadFile,$uploadCover);
			}
			//Eintrag in die Datenbank
			$this->redirect(array('user/profile/'.YII::app()->user->id));
		}
		
		$this->render('upload',array('model'=>$model));
	}

	public function actionBookList($id){
		$model = Books::model()->findAll();
	}
	
	private function uploadFile($uploadFile,$uploadCover,$baseId=0){
		$model = new PdfTable();
		$model->attributes = $_POST['PdfTable'];
		$model->attributes = $_POST;
		$model->title = CHtml::encode($_POST['PdfTable']['title']);
		$model->description = CHtml::encode($_POST['PdfTable']['description']);
		$model->base_id = $baseId;
        $model->author = Yii::app()->user->id;
		if(!$uploadFile){
			throw new CException('Kein Buch');
		}
		if($_POST['optionsRadios'] == 'custom')
        {
            //Cover Datei
            $uploadCover = CUploadedFile::getInstance($model,'extension');
            if($uploadCover){
                $covername = "{$uploadCover}";
                $coverInfo = pathinfo($covername);
                $model->extension = $coverInfo['extension'];
            }
        }
        else
            $model->extension = $_POST['optionsRadios'].'.jpg';
		
		
		if($model->save()){
			//Ueberpruefen ob die Ordner schon vorhanden sind sonst neue erstellen
			if(!is_dir(Yii::app()->basePath.'/../upload/pdf/'))
				mkdir(Yii::app()->basePath.'/../upload/pdf/',0777,true);
			if(!is_dir(Yii::app()->basePath.'/../upload/cover/original/'))
				mkdir(Yii::app()->basePath.'/../upload/cover/original/',0777,true);
			
			//Dateien Speichern
			if($uploadFile){
				$uploadFile->saveAs(Yii::app()->basePath.'/../upload/pdf/'.$model->id.'.pdf');
				if(!is_file(Yii::app()->basePath.'/../upload/pdf/'.$model->id.'.pdf')){
					rename(Yii::app()->basePath.'/../upload/pdf/'.$model->base_id.'.pdf',Yii::app()->basePath.'/../upload/pdf/'.$model->id.'.pdf');
				}
			}
			if(isset($_POST['genres'])) {
                foreach($_POST['genres'] as $genre_id=>$checked){
                    $genres[] = '('.$model->id.','.$checked.')';
                }
                $genresStr = implode(",", $genres) . ';';
                $model->addBookGenres($genresStr, $model->id); //Add Interest
            }
			if($uploadCover){
				$uploadCover->saveAs(Yii::app()->basePath.'/../upload/cover/original/'.$model->id.'.'.$model->extension);
                ImageEdit::resize(0.75, Yii::app()->basePath.'/../upload/cover/original/'.$model->id.'.'.$model->extension);
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
            $commentForm->date = Yii::time(time());
            $commentForm->ref_id = $id;
            $commentForm->rating = $_POST['Comments']['rating'];
            $commentForm->belongsTo = 0;
            if($commentForm->validate()) {
                if($commentForm->save()) {
                    //happy dance
                } 
                else {
                    throw new CHttpException(500, 'Something went wrong');
                }
            }
            echo $this->renderPartial('postedComment', array('comment' => $commentForm), true, true);
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
	
	public function actionDel($id){
		$model = Books::model()->findByPk($id);
		if($model && $model->author == YII::app()->user->id){
			$model->status = 2;
			$model->save();
		}
		$this->redirect(YII::app()->createAbsoluteUrl('user/profile/'.YII::app()->user->id));
	}

	public function actionDownload($id,$format){
		$ext = array(
			1=>'.pdf',
			2=>'.epub',
			3=>'.mobi',
		);
		if(!isset($ext[$format]))
			$this->redirect(array('books/files','id'=>$id));
		$model = Books::model()->findByPk($id);
		if(!$model)
			$this->redirect(YII::app()->createAbsoluteUrl(''));
		$model->downloads++;
		$model->save();
		if($model->chapters){
			$zipname = CHtml::decode($model->title).'.zip';
			$zip = new ZipArchive;
			$zip->open($zipname, ZipArchive::CREATE);
			foreach ($model->chapters as $file) {
			  $zip->addFile(YII::app()->basePath.'/../upload/pdf/'.$file->id.$ext[$format],$file->title.$ext[$format]);
			}
			$zip->close();
			header('Content-Type: application/zip');
			header('Content-disposition: attachment; filename="'.$zipname.'"');
			header('Content-Length: ' . filesize($zipname));
			readfile($zipname);
			unlink($zipname);
		} else {
			header('Content-Disposition: attachment; filename="'.CHtml::decode($model->title).$ext[$format]);
			readfile(YII::app()->basePath.'/../upload/pdf/'.$id.$ext[$format]);
		}
	}
    
	public function actionFeed(){
		$subs = Subscription::model()->findAllByAttributes(array('subscriber_id'=>YII::app()->user->id),array('select'=>'subscripted_id'));
		foreach($subs as $sub){
			$subsArray[] = $sub->subscripted_id;
		}
		$books = Books::model()->published()->findAllByAttributes(array('author'=>$subsArray),array('limit'=>2));
		
		$_SESSION['feedPage']=1;
		$this->render('feed',array('books'=>$books));
	}
	
	public function actionMoreFeed(){
		$subs = Subscription::model()->findAllByAttributes(array('subscriber_id'=>YII::app()->user->id),array('select'=>'subscripted_id'));
		foreach($subs as $sub){
			$subsArray[] = $sub->subscripted_id;
		}
		$books = Books::model()->published()->findAllByAttributes(array('author'=>$subsArray),array('limit'=>2,'offset'=>2*$_SESSION['feedPage']++));
		if(!$books)
			throw new CHttpException(204,'Keine B&uuml;cher mehr vorhanden');
		$this->renderPartial('moreFeed',array('books'=>$books));
	}
	
    public function actionShowNewCommentForm($id){
        $commentForm = new Comments();
        echo $this->renderPartial('newComment', array('model' => $commentForm, 'id'=>$id), true, true);
    }
    
    public function actionShowNewAnswerForm($id, $belongsTo=null){
        $commentForm = new Comments();
        echo $this->renderPartial('newAnswer', array('model' => $commentForm, 'id'=>$id, 'belongsTo'=>$belongsTo), true, true);
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
        echo        'var element = document.getElementById("text' . $model->id . '");';
        echo        'element.innerHTML = "<p class=\"comment-text\">' . $model->text . '</p>";';
        echo    '</script>';
    }
    
    public function actionPostAnswer($id, $belongsTo=0){
        if(isset($_POST['Comments'])) {
            $commentForm = new Comments();
            $commentForm->users_id = Yii::app()->user->id;
            $commentForm->text = CHtml::encode(print_r($_POST['Comments']['text'], true));
            $commentForm->date = Yii::time(time());
            $commentForm->ref_id = $id;
            $commentForm->belongsTo = $belongsTo;
            if($commentForm->validate()) {
                if($commentForm->save()) {
                    //happy dance
                    echo $this->renderPartial('postedAnswer', array('comment' => $commentForm), true, true);
                } 
                else {
                    throw new CHttpException(500, 'Something went wrong');
                }
            }
        }
    }
    
    public function actionNewComment($id){
        $model = new Comments();
        $this->renderPartial('newComment',array('model'=>$model, 'id'=>$id),false,true);
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
