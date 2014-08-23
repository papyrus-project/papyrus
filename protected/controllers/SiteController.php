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
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
    public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
        $books = Books::model()->published()->recently()->with('bookgenres')->findAll();
        $this->render('index', array('books' => $books));
    }
	public function actionBob( $q = '', array $type = array(), array $lang = array(), array $age = array(), array $genre = array(), $wip = '', $nsfw = '')
	{
        if(isset($_POST['q']))
            $q = $_POST['q'];
        if(isset($_POST['type']))
            $type = $_POST['type'];
        if(isset($_POST['lang']))
            $lang = $_POST['lang'];
        if(isset($_POST['age']))
            $age = $_POST['age'];
        if(isset($_POST['genre']))
            $genre = $_POST['genre'];
        if(isset($_POST['wip']))
            $wip = $_POST['wip'];
        if(isset($_POST['nsfw']))
            $nsfw = $_POST['nsfw'];
        
        $criteria = new CDbCriteria();
        if( count( $genre ) > 0 ) {
            $genreCrit = new CDbCriteria();
            $genreCrit->together = true;
            $genreCrit->with = array('bookgenres');
            $genreCrit->addInCondition( 'bookgenres.bookgenre_id', $genre, 'OR' );
            $criteria->mergeWith($genreCrit, 'AND');
        }
        if( count( $age ) > 0 ) {
            $ageCrit = new CDbCriteria();
            $ageCrit->addInCondition( 'age_restriction', $age, 'OR' );
            $criteria->mergeWith($ageCrit, 'AND');
        }
        if( count( $type ) > 0 ) {
            $typeCrit = new CDbCriteria();
            $typeCrit->addInCondition( 'booktype_id', $type, 'OR' );
            $criteria->mergeWith($typeCrit, 'AND');
        } 
        else {
            $typeCrit = new CDbCriteria();
            $types = array();
            foreach(Booktype::model()->findAll() as $type)
                $types[] = $type->id;
            $typeCrit->addInCondition( 'booktype_id', $types, 'OR' );
            $criteria->mergeWith($typeCrit, 'AND');
        }
        if( count( $lang ) > 0 ) {
            $langCrit = new CDbCriteria();
            $langCrit->addInCondition( 'language_id', $lang, 'OR' );
            $criteria->mergeWith($langCrit, 'AND');
        }
        if( $wip != '1' ) {
            $wipCrit = new CDbCriteria();
            $wipCrit->addSearchCondition( 'wip', "0", true, 'AND' );
            $criteria->mergeWith($wipCrit, 'AND');
        }
        if( $nsfw != '1' ) {
            $nsfwCrit = new CDbCriteria();
            $nsfwCrit->addSearchCondition( 'nsfw', "0", true, 'AND' );
            $criteria->mergeWith($nsfwCrit, 'AND');
        }
        if( strlen( $q ) > 0 ) {
            $text = new CDbCriteria();
            $text->addSearchCondition( 'title', $q, true, 'OR' );
            $text->addSearchCondition( 'description', $q, true, 'OR' );
            $criteria->mergeWith($text, 'AND');
        }
        $criteria->addSearchCondition( 'status', 1, true, 'AND' );

        $dataProvider = new CActiveDataProvider( 'Books', array( 'criteria' => $criteria, 'pagination'=>array('pageSize'=>5,) ) );
        
        $q = '';
        $type = array();
        $lang = array();
        $age = array();
        $genre = array();
        $wip = '';
        
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
	
	public function actionBookList(){
		$model = new PdfTable();
		$posts = $model->findAll();
		$this->render('bookList',array('posts'=>$posts));
	}
	
	public function actionBookRead($id){
		$model = new PdfTable();
		$post = $model->findByPk($id);
		
		$this->render('bookRead',array('post'=>$post));		
	}
	
	public function actionImpressum(){
		$this->render('impressum');
	}
	
	public function actionDSE(){
		$this->render('DSE');
	}
	
	public function actionAgbs(){
		$this->render('agbs');
	}













	public function actionCreate(){
        $model=new Banner;  // this is my model related to table
        if(isset($_POST['Banner']))
        {
            $rnd = rand(0,9999);  // generate random number between 0-9999
            $model->attributes=$_POST['Banner'];
 
            $uploadedFile=CUploadedFile::getInstance($model,'image');
            $fileName = "{$rnd}-{$uploadedFile}";  // random number + file name
            $model->image = $fileName;
 
            if($model->save())
            {
                $uploadedFile->saveAs(Yii::app()->basePath.'/../banner/'.$fileName);  // image will uplode to rootDirectory/banner/
                $this->redirect(array('Create'));
            }
        }
        $this->render('create',array(
            'model'=>$model,
        ));
    }

    public function actionUpdate($id){
        $model=$this->loadModel($id);
 
        if(isset($_POST['Banner']))
        {
            $_POST['Banner']['image'] = $model->image;
            $model->attributes=$_POST['Banner'];
 
            $uploadedFile=CUploadedFile::getInstance($model,'image');
 
            if($model->save())
            {
                if(!empty($uploadedFile))  // check if uploaded file is set or not
                {
                    $uploadedFile->saveAs(Yii::app()->basePath.'/../banner/'.$model->image);
                }
                $this->redirect(array('admin'));
            }
 
        }
 
        $this->render('update',array(
            'model'=>$model,
        ));
    }

}