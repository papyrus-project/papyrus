<?php
class AjaxController extends Controller
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
	
	public function actionFavoriseBook(){
		$book=$_POST['book'];
		$user=Yii::app()->user->id;
		if($book == Books::model()->findByAttributes(array('author'=>$user,'id'=>$book)))
			throw new CHttpException(401,'Own Books not favorisable');
		else if(YII::app()->user->isGuest)
			throw new CHttpException(401,'Login required');
		else{
			$model = BooksFavorites::model()->findByAttributes(array('users_id'=>$user,'books_id'=>$book));
			if(!$model){
				$model = new BooksFavorites();
				$model->users_id=$user;
				$model->books_id=$book;
				$model->save();
				print('unfavorise');
			} else{
				$model->delete();
				print('favorise');
			}
		}
	}
	
	public function actionSubscribe(){
		$sub=$_POST['subsripted'];
		$user=Yii::app()->user->id;
		if($sub == $user)
			throw new CHttpException(401,'u no sub urself');
		else if(YII::app()->user->isGuest)
			throw new CHttpException(401,'Login required');
		else{
			$model = Subscription::model()->findByAttributes(array('subscriber_id'=>$user,'subscripted_id'=>$sub));
			if(!$model){
				$model = new Subscription();
				$model->subscriber_id=$user;
				$model->subscripted_id=$sub;
				$model->save();
				print('nicht mehr folgen');
			} else{
				$model->delete();
				print('folgen');
			}
		}
	}
	
	public function actionTest(){
		$blub = Subscription::model()->findAllByAttributes(array('subscriber_id'=>array(1,6),),array('limit'=>2,'offset'=>2));
		foreach ($blub as $key => $value) {
			print_r($value->subscriber_id);
		}
	}
}