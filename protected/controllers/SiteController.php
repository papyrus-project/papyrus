<?php

class SiteController extends Controller
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
	 * Index Seite anzeigen
	 */
    public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
        if(!YII::app()->user->isGuest)
		    $this->redirect(Yii::app()->createUrl('site/bob'));
        
        $books = Books::model()->published()->recently()->with('bookgenres')->findAll();
        $this->render('index', array('books' => $books));
    }
	/*
	 * Such Seite anzeigen & erneuern
	 */ 
	public function actionBob( $q = '', array $type = array(), array $lang = array(), array $age = array(), array $genre = array(), $wip = 0, $nsfw = 0)
	{
        //if(isset($_POST['q']))
        //    $q = $_POST['q'];
        //if(isset($_POST['type']))
        //    $type = $_POST['type'];
        //if(isset($_POST['lang']))
        //    $lang = $_POST['lang'];
        //if(isset($_POST['age']))
        //    $age = $_POST['age'];
        //if(isset($_POST['genre']))
        //    $genre = $_POST['genre'];
        //if(isset($_POST['wip']))
        //    $wip = $_POST['wip'];
        //if(isset($_POST['nsfw']))
        //    $nsfw = $_POST['nsfw'];

        $criteria = new CDbCriteria();
        if( count( $age ) > 0  && $age) {
            $ageCrit = new CDbCriteria();
            foreach($age as $value)
                $ageCrit->/*addColumnCondition( array('age_restriction'=>$value), 'OR');*/addSearchCondition( 'age_restriction', $value, true, 'OR' );
            $criteria->mergeWith($ageCrit, 'AND');
        }
        if( count( $type ) > 0 ) {
            $typeCrit = new CDbCriteria();
            
            foreach($type as $value)
                $typeCrit->/*addColumnCondition( array('booktype_id'=>$value), 'OR');*/addSearchCondition( 'booktype_id', $value, true, 'OR' );
            $criteria->mergeWith($typeCrit, 'AND');
        }
        if( count( $lang ) > 0 ) {
            $langCrit = new CDbCriteria();
            
            foreach($lang as $value)
                $langCrit->/*addColumnCondition( array('language_id'=>$value), 'OR');*/addSearchCondition( 'language_id', $value, true, 'OR' );
            $criteria->mergeWith($langCrit, 'AND');
        }
        
        if( $wip != '1' ) {
            $wipCrit = new CDbCriteria();
            $wipCrit->addColumnCondition( array('wip'=>0), 'AND');
            $criteria->mergeWith($wipCrit, 'AND');
        }
        
        if( $nsfw != '1' ) {
            $nsfwCrit = new CDbCriteria();
            $nsfwCrit->addColumnCondition( array('nsfw'=>0), 'AND');
            $criteria->mergeWith($nsfwCrit, 'AND');
        }
        if( count( $genre ) > 0 ) {
            $genreCrit = new CDbCriteria();
            $genreCrit->with = array('bookgenres');
            $genreCrit->group = 't.id';
            $genreCrit->together = true;
            
            foreach($genre as $value)
                if($value >=0)
                    $genreCrit->/*addColumnCondition( array('bookgenres.bookgenre_id'=>$value), 'OR');*/addSearchCondition( 'bookgenres.bookgenre_id', $value, true, 'OR' );
            $criteria->mergeWith($genreCrit, 'AND');
        }
        if( strlen( $q ) > 0 ) {
            $text = new CDbCriteria();
            $text->addSearchCondition( 'title', $q, true, 'OR' );
            $text->addSearchCondition( 'description', $q, true, 'OR' );
            $criteria->mergeWith($text, 'AND');
        }
        
        $criteria->addColumnCondition( array('status'=>1), 'AND');
        $criteria->addColumnCondition( array('base_id'=>0), 'AND');
        $dataProvider = new CActiveDataProvider( 'Books', array( 'criteria' => $criteria, 'pagination'=>array('pageSize'=>5,) ) );
        
        $this->render('bob',array('dataProvider' => $dataProvider));
        if(isset($_GET)) {
            unset($_GET);
        }
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm('Front');

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	
	public function actionImpressum(){
		$this->render('impressment');
	}
	public function actionUsabilty(){
		header('Content-Disposition: attachment; filename="Bookwork-Usability-Test.pdf"');
		readfile(YII::app()->basePath.'/../upload/Useabilty.pdf');
	}
}