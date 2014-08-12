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
			$model->setAttributes($_POST);
			$model->save();
			$this->redirect(array('user/profile','id'=>''));
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
			$_POST['Messages']['from'] = YII::app()->user->id;
			$_POST['Messages']['to'] = $id;
			$_POST['Messages']['created'] = time();
			$model->attributes=$_POST['Messages'];
			print_r('dumm');
			if($model->validate()){
				if($model->save()){
					print_r('gogo gadget save');
					$this->redirect(YII::app()->createUrl('user/profile/'.$id));
				}
			}
		}
		$this->render('sendPm',array('model'=>$model));
	}
}