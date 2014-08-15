<?php

class UserController extends Controller
{
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

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	 
	public function actionEdit(){
		if(Yii::app()->user->isGuest)
			$this->redirect(array('bum/users/login'));
		$model = UserData::model()->findByPk(Yii::app()->user->id);
		if(!empty($_POST)){
			$model->attributes = $_POST;
			$model->name = CHtml::encode($_POST['name']);
			$model->location = CHtml::encode($_POST['location']);
			$model->homepage = CHtml::encode($_POST['homepage']);
			$model->description = CHtml::encode($_POST['description']);
			$model->save();
			$this->redirect(array('user/profile','id'=>YII::app()->user->id));
		}
		$date = explode('-', $model->birthday);
		$this->render('edit',array(
			'model'=>$model,
			'birthday'=>$date));
	}
	
	public function actionProfile($id){
		if(!$id)
			$id = Yii::app()->user->id;
		$model = UserData::model()->findByPk($id);
		if($id == Yii::app()->user->id)
			$books = Books::model()->owns($id)->recently()->with('bookgenres')->findAll();
		else
			$books = Books::model()->owns($id)->published()->recently()->with('bookgenres')->findAll();
		$this->render('profile',array(
			'model' => $model,
			'sexes'=>array(1=>'male',2=>'female'),
			'books'=>$books,
		));
	}
	
	public function actionFavorits(){
		$this->render('favorits');
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
	
	public function actionViewMessage($id){
		$model = Messages::model()->findByPk($id);
		if(YII::app()->user->id != $model->sender && YII::app()->user->id != $model->receiver){
			YII::app()->clientScript->registerScript('javascript','alert("BITCH")');
			print_r('boese');
			$this->redirect(YII::app()->createAbsoluteUrl('site/index'));
		}
		$model->read = 1;
		if($model->save()){
			$this->render('pmView',array('message'=>$model));
		}
		print_r($model->getErrors());
	}
	
	public function actionViewMessages(){
		$model = Messages::model()->got()->with('sender0')->findAll();
		$this->render('pmList',array('messages'=>$model));
	}
}