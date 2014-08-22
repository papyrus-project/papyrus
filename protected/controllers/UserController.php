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
	
	public function actionEdit(){
		if(Yii::app()->user->isGuest)
			$this->redirect(array('bum/users/login'));
		$model = UserData::model()->findByPk(Yii::app()->user->id);
        $p='qqqq';
		if(!empty($_POST)){
			$model->attributes = $_POST;
			$model->name = CHtml::encode($_POST['name']);
			$model->location = CHtml::encode($_POST['location']);
			$model->homepage = CHtml::encode($_POST['homepage']);
			$model->description = CHtml::encode($_POST['description']);
			$model->invitations_left = CHtml::encode($_POST['invitations_left']);
            
		    //Cover Datei
		    $uploadCover = CUploadedFile::getInstance($model,'extension');
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
				    $uploadCover->saveAs(Yii::app()->basePath.'/../upload/user/original/'.$model->id.'.'.$model->extension);
                    if(is_file(Yii::getPathOfAlias('webroot').'/upload/user/comment/'.$model->id.'.'.$model->extension))
                        unlink(Yii::getPathOfAlias('webroot').'/upload/user/comment/'.$model->id.'.'.$model->extension);
                    if(is_file(Yii::getPathOfAlias('webroot').'/upload/user/big/'.$model->id.'.'.$model->extension))
                        unlink(Yii::getPathOfAlias('webroot').'/upload/user/big/'.$model->id.'.'.$model->extension);
		        }
		        $this->redirect(array('user/profile','id'=>YII::app()->user->id));
		    }
        }
		$date = explode('.', $model->birthday);
		$this->render('edit',array(
			'model'=>$model,
			'birthday'=>$date));
            echo '<pre>';
        print_r($p);
        echo '</pre>';
	}
	
	public function actionProfile($id){
		YII::app()->session['page']=1;
		if(!$id)
			if(YII::app()->user->isGuest)
				$this->redirect(YII::app()->createAbsoluteUrl(''));
			else
				$id = Yii::app()->user->id;
		$model = UserData::model()->findByPk($id);
		
		$own = Books::model()->findAllByAttributes(array('author'=>$model->id));
		$array = array();
		foreach ($own as $key => $value) {
			$array[] = $value->id;
		}
		$var_sum = Books::model()->findBySql('select SUM(`downloads`) as `downloads` from books where author=:id', array(':id'=>$model->id));
		if(!$var_sum->downloads)
			$var_sum->downloads = 0;
		
		
		
		$this->render('profile',array(
			'model' => $model,
			'sexes'=>array(0=>'Keine Angabe',1=>'M&auml;nnlich',2=>'Weiblich'),
			'subscribtions'=>Subscription::model()->countByAttributes(array('subscripted_id'=>$model->id)),
			'favorits'=>BooksFavorites::model()->countByAttributes(array('books_id'=>$array)),
			'downloads'=>$var_sum->downloads,
		));
	}

	public function action_Own($id){
		YII::app()->session['page'] = 1;
		$books = Books::model()->owns($id)->published()->with('bookgenres')->findAll(array('limit'=>$this->profile_pc,'order'=>'id desc'));
		$booksRender = '';
		foreach($books as $book)
			$booksRender.=$this->renderPartial('application.views.books._BookPreview',array('data'=>$book,'showOptions'=>true),true,true);
		
		if(!$books){
			throw new CHttpException(204,'Keine Buecher vorhanden');
		}
		$this->renderPartial('_own',array('books'=>$booksRender,'userId'=>$id),false,true);
	}

	public function action_MoreOwn(){
		$page = YII::app()->session['page'];
		$books = Books::model()->owns($_POST['id'])->published()->with('bookgenres')->findAll(array('limit'=>$this->profile_pc,'offset'=>$page*$this->profile_pc,'order'=>'id desc'));
		YII::app()->session['page'] = ++$page;
		if(!$books){
			throw new CHttpException(204,'Keine Buecher mehr vorhanden');
		}
		foreach($books as $book)
			$this->renderPartial('application.views.books._BookPreview',array('data'=>$book,'userId'=>$_POST['id'],'showOptions'=>true));
	}

	public function action_Favorites($id){
		YII::app()->session['page'] = 1;
		$favs = BooksFavorites::model()->findAll(array('limit'=>$this->profile_pc,'condition'=>'users_id = "'.$id.'"'));
		foreach ($favs as $key => $value) {
			$array[] = $value->books_id;
		}
		if(!$favs){
			throw new CHttpException(204,'Keine Buecher vorhanden');
		}
		$books = Books::model()->findAllByAttributes(array('id'=>$array));
		$booksRender = '';
		foreach($books as $book)
			$booksRender.=$this->renderPartial('application.views.books._BookPreview',array('data'=>$book,'showOptions'=>true),true,true);
		$this->renderPartial('_favorites',array('books'=>$booksRender,'userId'=>$id),false,true);
	}
	
	public function action_moreFavorites($id){
		$page = YII::app()->session['page'];
		$favs = BooksFavorites::model()->findAll(array('limit'=>$this->profile_pc,'offset'=>$page*$this->profile_pc,'condition'=>'users_id = "'.$id.'"'));
		
		if(!$favs){
			throw new CHttpException(204,'Keine Buecher mehr vorhanden');
		}
		foreach ($favs as $key => $value) {
			$array[] = $value->books_id;
		}
		$books = Books::model()->findAllByAttributes(array('id'=>$array));
		YII::app()->session['page'] = ++$page;
		foreach($books as $book)
			$this->renderPartial('application.views.books._BookPreview',array('data'=>$book,'userId'=>$_POST['id'],'showOptions'=>true));
	}
	
	public function action_subs($id){
		YII::app()->session['page'] = 1;
		$subs = Subscription::model()->findAll(array('condition'=>'subscriber_id = "'.$id.'"'));
		foreach ($subs as $key => $value) {
			$array[] = $value->subscripted_id;
		}
		if(!$subs){
			throw new CHttpException(204,'Keine Buecher vorhanden');
		}
		$books = Books::model()->findAllByAttributes(array('author'=>$array),array('limit'=>$this->profile_pc,'order'=>'id desc'));
		if(!$books){
			throw new CHttpException(204,'Keine Buecher vorhanden');
		}
		$booksRender = '';
		foreach($books as $book)
			$booksRender.=$this->renderPartial('application.views.books._BookPreview',array('data'=>$book,'showOptions'=>true),true,true);
		$this->renderPartial('_subs',array('books'=>$booksRender,'userId'=>$id),false,true);
	}
	
	public function action_moreSubs(){
		$page = YII::app()->session['page'];
		$subs = Subscription::model()->findAll(array('condition'=>'subscriber_id = "'.$_POST['id'].'"'));
		foreach ($subs as $key => $value) {
			$array[] = $value->subscripted_id;
		}
		if(!$subs){
			throw new CHttpException(204,'Keine Buecher vorhanden');
		}
		$books = Books::model()->findAllByAttributes(array('author'=>$array),array('limit'=>$this->profile_pc,'offset'=>$page*$this->profile_pc,'order'=>'id desc'));
		if(!$books){
			throw new CHttpException(204,'Keine Buecher vorhanden');
		}
		YII::app()->session['page'] = ++$page;
		foreach($books as $book)
			$this->renderPartial('application.views.books._BookPreview',array('data'=>$book,'userId'=>$_POST['id'],'showOptions'=>true));
	}
	
	public function actionSubscriptions(){
		
		$this->render('Subscriptions');
	}

	public function actionSendPm($id){
		if($id == YII::app()->user->id || YII::app()->user->isGuest){
			$this->redirect(YII::app()->createUrl(''));
		}
		if(!UserData::model()->findByPk($id)){
			$this->redirect(YII::app()->createUrl(''));
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
	
	public function actionMessage($id){
		$model = Messages::model()->findByPk($id);
		if(YII::app()->user->id != $model->sender && YII::app()->user->id != $model->receiver){
			die();
		}
		$model->read = 1;
		if($model->save()){
			$this->renderPartial('pmView',array('message'=>$model));
		}
	}
	
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
	
	public function actionlistPmR($id){
		YII::app()->session['page']=1;
		YII::app()->session['type']=1;
		$model = Messages::model()->findAllByAttributes(array('receiver'=>YII::app()->user->id),array('limit'=>'5'));
		
		foreach($model as $message){
			$this->renderPartial('_pmList',array('message'=>$message,'got'=>true),false,true);
		}
	}
	
	public function actionlistPmS($id){
		YII::app()->session['page']=1;
		YII::app()->session['type']=2;
		$model = Messages::model()->findAllByAttributes(array('sender'=>YII::app()->user->id),array('limit'=>'5'));
		
		foreach($model as $message){
			$this->renderPartial('_pmList',array('message'=>$message,'got'=>false),false,true);
		}
	}
	
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