<?php

class UserController extends Controller
{
	private $profile_pc = 2; //profile page count
	/**
	 * Declares class-based actions.
	 */
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
	/*
	 * Profil editieren
	 */
	public function actionEdit(){
        Yii::import('application.Components.*');
        require_once('ImageEdit.php');
		if(Yii::app()->user->isGuest)
			$this->redirect(array('bum/users/login'));
		$model = UserData::model()->findByPk(Yii::app()->user->id);
		if(!empty($_POST)){
			$model->attributes = $_POST;
			$model->name = CHtml::encode($_POST['name']);
			$model->location = CHtml::encode($_POST['location']);
			$model->homepage = CHtml::encode($_POST['homepage']);
			$model->description = CHtml::encode($_POST['description']);
            

		    //Cover Datei
		    $uploadCover = CUploadedFile::getInstance($model,'extension');
            $oldExt = $model->extension;
            if($uploadCover){
                $p = $uploadCover;
			    $covername = "{$uploadCover}";
			    $coverInfo = pathinfo($covername);
			    $model->extension = $coverInfo['extension'];
			}
            if($model->save()){
			    //Ueberpruefen ob die Ordner schon vorhanden sind sonst neue erstellen
			    if(!is_dir(Yii::app()->basePath.'/../upload/user/original/'))
				    mkdir(Yii::app()->basePath.'/../upload/user/original/',0777,true);
			
			    //Dateien Speichern
			    if($uploadCover){
                    if(is_file(Yii::getPathOfAlias('webroot').'/upload/user/original/'.$model->id.'.'.$oldExt))
                        unlink(Yii::getPathOfAlias('webroot').'/upload/user/original/'.$model->id.'.'.$oldExt);
				    $uploadCover->saveAs(Yii::app()->basePath.'/../upload/user/original/'.$model->id.'.'.$model->extension);
                    
                    ImageEdit::resize(1, Yii::app()->basePath.'/../upload/user/original/'.$model->id.'.'.$model->extension);

                    if(is_file(Yii::getPathOfAlias('webroot').'/upload/user/comment/'.$model->id.'.'.$oldExt))
                        unlink(Yii::getPathOfAlias('webroot').'/upload/user/comment/'.$model->id.'.'.$oldExt);
                    if(is_file(Yii::getPathOfAlias('webroot').'/upload/user/big/'.$model->id.'.'.$oldExt))
                        unlink(Yii::getPathOfAlias('webroot').'/upload/user/big/'.$model->id.'.'.$oldExt);
		        }
		        $this->redirect(array('user/profile','id'=>YII::app()->user->id));
		    }
        }
		$this->render('edit',array(
			'model'=>$model));
	}
	/*
	 * Profil anzeigen
	 */
	public function actionProfile($id){
		YII::app()->session['page']=1;
		if(!$id)
			if(YII::app()->user->isGuest)
				$this->redirect(YII::app()->createAbsoluteUrl(''));
			else
				$id = Yii::app()->user->id;
		$model = UserData::model()->findByPk($id);
		if(!$model){
			$this->redirect(YII::app()->createAbsoluteUrl(''));
		}
		$own = Books::model()->findAllByAttributes(array('author'=>$model->id));
		$array = array();
		foreach ($own as $key => $value) {
			$array[] = $value->id;
		}
		$var_sum = Books::model()->findBySql('select SUM(`downloads`) as `downloads` from books where author=:id', array(':id'=>$model->id));
		if(!$var_sum->downloads)
			$var_sum->downloads = 0;
		
		YII::app()->session['page'] = 1;
		$books = Books::model()->owns($id)->published()->with('bookgenres')->findAll(array('limit'=>$this->profile_pc,'order'=>'id desc'));
		$booksRender = '';
		foreach($books as $book){
			$rating = Comments::model()->findBySql('select SUM(`rating`) as `rating`, count(id) as `count` from comments WHERE ref_id=:id AND rating != 0', array(':id'=>$book->id));
			$booksRender.=$this->renderPartial('application.views.books._BookPreview',array('data'=>$book,'showOptions'=>true,'rating'=>$rating),true,true);
		}
		
		$this->render('profile',array(
			'model' => $model,
			'sexes'=>array(1=>'Keine Angabe',2=>'M&auml;nnlich',3=>'Weiblich'),
			'subscribtions'=>Subscription::model()->countByAttributes(array('subscripted_id'=>$model->id)),
			'favorits'=>BooksFavorites::model()->countByAttributes(array('books_id'=>$array)),
			'downloads'=>$var_sum->downloads,
			'booksRender'=>$booksRender,
		));
	}
	/*
	 * Anzeigen von Buechern die vom Author $id erstellt wurde
	 */
	public function action_Own($id){
		YII::app()->session['page'] = 1;
		$books = Books::model()->owns($id)->published()->with('bookgenres')->findAll(array('limit'=>$this->profile_pc,'order'=>'id desc'));
		$booksRender = '';
		foreach($books as $book){
			$rating = Comments::model()->findBySql('select SUM(`rating`) as `rating`, count(id) as `count` from comments WHERE ref_id=:id AND rating != 0', array(':id'=>$book->id));
			$booksRender.=$this->renderPartial('application.views.books._BookPreview',array('data'=>$book,'showOptions'=>true,'rating'=>$rating),true,true);
		}
		
		/*if(!$books){
			throw new CHttpException(204,'Keine Buecher vorhanden');
		}*/
		$this->renderPartial('_own',array('books'=>$booksRender,'userId'=>$id),false,true);
	}
	/*
	 * Anzeigen von mehr Buechern die vom Author $id erstellt wurde
	 */
	public function action_MoreOwn(){
		$page = YII::app()->session['page'];
		$books = Books::model()->owns($_POST['id'])->published()->with('bookgenres')->findAll(array('limit'=>$this->profile_pc,'offset'=>$page*$this->profile_pc,'order'=>'id desc'));
		YII::app()->session['page'] = ++$page;
		if(!$books){
			throw new CHttpException(204,'Keine B&uuml;cher mehr vorhanden');
		}
		foreach($books as $book){
			$rating = Comments::model()->findBySql('select SUM(`rating`) as `rating`, count(id) as `count` from comments WHERE ref_id=:id AND rating != 0', array(':id'=>$book->id));
			$this->renderPartial('application.views.books._BookPreview',array('data'=>$book,'userId'=>$_POST['id'],'showOptions'=>true,'rating'=>$rating));
		}
	}
	/*
	 * anzeigen von Buechern die man Favorisiert hat
	 */
	public function action_Favorites($id){
		YII::app()->session['page'] = 1;
		$favs = BooksFavorites::model()->findAll(array('limit'=>$this->profile_pc,'condition'=>'users_id = "'.$id.'"'));
		foreach ($favs as $key => $value) {
			$array[] = $value->books_id;
		}
		if(!$favs){
			throw new CHttpException(204,'Keine B&uuml;cher vorhanden');
		}
		$books = Books::model()->findAllByAttributes(array('id'=>$array));
		$booksRender = '';
		foreach($books as $book){
			$rating = Comments::model()->findBySql('select SUM(`rating`) as `rating`, count(id) as `count` from comments WHERE ref_id=:id AND rating != 0', array(':id'=>$book->id));
			$booksRender.=$this->renderPartial('application.views.books._BookPreview',array('data'=>$book,'showOptions'=>true,'rating'=>$rating),true,true);
		}
		$this->renderPartial('_favorites',array('books'=>$booksRender,'userId'=>$id),false,true);
	}
	
	/*
	 * anzeigen von mehr Buechern die man Favorisiert hat
	 */
	public function action_moreFavorites($id){
		$page = YII::app()->session['page'];
		$favs = BooksFavorites::model()->findAll(array('limit'=>$this->profile_pc,'offset'=>$page*$this->profile_pc,'condition'=>'users_id = "'.$id.'"'));
		
		if(!$favs){
			throw new CHttpException(204,'Keine B&uuml;cher mehr vorhanden');
		}
		foreach ($favs as $key => $value) {
			$array[] = $value->books_id;
		}
		$books = Books::model()->findAllByAttributes(array('id'=>$array));
		YII::app()->session['page'] = ++$page;
		foreach($books as $book){
			$rating = Comments::model()->findBySql('select SUM(`rating`) as `rating`, count(id) as `count` from comments WHERE ref_id=:id AND rating != 0', array(':id'=>$book->id));
			$this->renderPartial('application.views.books._BookPreview',array('data'=>$book,'userId'=>$_POST['id'],'showOptions'=>true,'rating'=>$rating));
		}
	}
	/*
	 * Anzeigen von Buechern der favorisierten Authoren
	 */
	public function action_subs($id){
		YII::app()->session['page'] = 1;
		$subs = Subscription::model()->findAll(array('condition'=>'subscriber_id = "'.$id.'"'));
		foreach ($subs as $key => $value) {
			$array[] = $value->subscripted_id;
		}
		if(!$subs){
			throw new CHttpException(204,'Keine B&uuml;cher vorhanden');
		}
		$books = Books::model()->findAllByAttributes(array('author'=>$array),array('limit'=>$this->profile_pc,'order'=>'id desc'));
		if(!$books){
			throw new CHttpException(204,'Keine B&uuml;cher vorhanden');
		}
		$booksRender = '';
		foreach($books as $book){
			$rating = Comments::model()->findBySql('select SUM(`rating`) as `rating`, count(id) as `count` from comments WHERE ref_id=:id AND rating != 0', array(':id'=>$book->id));
			$booksRender.=$this->renderPartial('application.views.books._BookPreview',array('data'=>$book,'showOptions'=>true,'rating'=>$rating),true,true);
		}
		$this->renderPartial('_subs',array('books'=>$booksRender,'userId'=>$id),false,true);
	}
	/*
	 * Anzeigen von mehr Buechern der favorisierten Authoren
	 */
	public function action_moreSubs(){
		$page = YII::app()->session['page'];
		$subs = Subscription::model()->findAll(array('condition'=>'subscriber_id = "'.$_POST['id'].'"'));
		foreach ($subs as $key => $value) {
			$array[] = $value->subscripted_id;
		}
		if(!$subs){
			throw new CHttpException(204,'Keine B&uuml;cher vorhanden');
		}
		$books = Books::model()->findAllByAttributes(array('author'=>$array),array('limit'=>$this->profile_pc,'offset'=>$page*$this->profile_pc,'order'=>'id desc'));
		if(!$books){
			throw new CHttpException(204,'Keine B&uuml;cher vorhanden');
		}
		YII::app()->session['page'] = ++$page;
		foreach($books as $book){
			$rating = Comments::model()->findBySql('select SUM(`rating`) as `rating`, count(id) as `count` from comments WHERE ref_id=:id AND rating != 0', array(':id'=>$book->id));
        	$this->renderPartial('application.views.books._BookPreview',array('data'=>$book,'userId'=>$_POST['id'],'showOptions'=>true,'rating'=>$rating));
		}
	}
	/*
	 * Anzeigen der Nachrichten Form / speichern der Nachricht
	 */
	public function actionSendPm($id){
		if($id == YII::app()->user->id || YII::app()->user->isGuest){
			$this->redirect(YII::app()->createAbsoluteUrl(''));
		}
		if(!UserData::model()->findByPk($id)){
			$this->redirect(YII::app()->createAbsoluteUrl(''));
		}
		$model=new Messages();
		if(isset($_POST['Messages'])){
			$model->setScenario('needCaptcha');
			$model->sender = YII::app()->user->id;
			$model->receiver = $id;
			$model->subject = CHtml::encode(print_r($_POST['Messages']['subject'],true));
			$model->message = CHtml::encode(print_r($_POST['Messages']['message'],true));
			$model->verifyCode = $_POST['Messages']['verifyCode'];
			if($model->validate()){
				if($model->save()){
					$this->redirect(YII::app()->createUrl('user/profile/'.$id));
				}
			}
		}
		$this->render('sendPm',array('model'=>$model));
	}
	/*
	 * Nachricht loeschen
	 */
	public function actionPmDel($id){
		$model = Messages::model()->findByPk($id);
		if($model->receiver != YII::app()->user->id)
			throw new CHttpException(402,'');
		$model->delete();
	}
	/*
	 * Nachricht anzeigen
	 */
	public function actionMessage($id){
		$model = Messages::model()->findByPk($id);
		if(YII::app()->user->id != $model->sender && YII::app()->user->id != $model->receiver){
			die();
		}
		if(YII::app()->user->id==$model->receiver)
			$model->read = 1;
		if($model->save()){
			$this->renderPartial('pmView',array('message'=>$model));
		}
	}
	/*
	 * Nachrichtenliste anzeigen
	 */
	public function actionMessages(){
		YII::app()->session['page']=1;
		YII::app()->session['type']=1;
		$model = Messages::model()->got()->findAll(array('limit'=>'5'));
		$countIn = Messages::model()->got()->count();
		$countOut = Messages::model()->send()->count();
		$messages='';
		foreach($model as $message){
			$messages.=$this->renderPartial('_pmList',array('message'=>$message,'got'=>true),true,true);
		}
		$this->render('pmList',array('messages'=>$messages,'countIn'=>$countIn,'countOut'=>$countOut));
	}
	/*
	 * Anzeigen der ersten Seite erhaltener Nachrichten
	 */
	public function actionlistPmR($id){
		YII::app()->session['page']=1;
		YII::app()->session['type']=1;
		$model = Messages::model()->findAllByAttributes(array('receiver'=>YII::app()->user->id),array('limit'=>'5'));
		
		foreach($model as $message){
			$this->renderPartial('_pmList',array('message'=>$message,'got'=>true),false,true);
		}
	}
	
	/*
	 * Anzeigen der ersten Seite gesendeter Nachrichten
	 */
	public function actionlistPmS($id){
		YII::app()->session['page']=1;
		YII::app()->session['type']=2;
		$model = Messages::model()->findAllByAttributes(array('sender'=>YII::app()->user->id),array('limit'=>'5'));
		
		foreach($model as $message){
			$this->renderPartial('_pmList',array('message'=>$message,'got'=>false),false,true);
		}
	}
	
	/*
	 * Liste aktuallisieren der erhaltenen/gesendeten Nachrichten
	 */
	public function actionlistPmM($id,$format){
		$page = YII::app()->session['page'];
		
		if($format)
			$page++;
		else {
			$page--;
		}
		print($page);
		if($page<1){
			throw new CHttpException(204,'');
		}
		/*
		$countIn = Messages::model()->got()->with('sender0')->count();
		$countOut = Messages::model()->send()->with('sender0')->count();*/
		if(YII::app()->session['type']==1)
			$type = 'receiver';
		else 
			$type = 'sender';
		$model = Messages::model()->with('sender0')->findAllByAttributes(array($type=>YII::app()->user->id),array('limit'=>'5','offset'=>($page-1)*5));
		if(!$model){
			throw new CHttpException(204,'');
		}
		foreach($model as $message){
			$this->renderPartial('_pmList',array('message'=>$message,'got'=>YII::app()->session['type']));
		}
		YII::app()->session['page']=$page;
	}
}