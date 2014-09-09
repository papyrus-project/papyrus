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
	/*
	 * Togglet ob ein Buch favorisiert ist
	 * Gibt zurueck was beim naechsten aufruf passier (ent/-favorisieren)
	 */
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
				print('Entfavorisieren ');
			} else{
				$model->delete();
				print('Favorisieren ');
			}
		}
	}
	
	/*
	 * Togglet ob ein Author favorisiert ist
	 * Gibt zurueck was beim naechsten aufruf passier (de/-abonnieren)
	 */
	public function actionSubscribe(){
		$sub=$_POST['subsripted'];
		$user=Yii::app()->user->id;
		if($sub == $user)
			throw new CHttpException(401,'Can not subscribe yourself');
		else if(YII::app()->user->isGuest)
			throw new CHttpException(401,'Login required');
		else{
			$model = Subscription::model()->findByAttributes(array('subscriber_id'=>$user,'subscripted_id'=>$sub));
			if(!$model){
				$model = new Subscription();
				$model->subscriber_id=$user;
				$model->subscripted_id=$sub;
				$model->save();
				print CHtml::decode('Deabonnieren ');
			} else{
				$model->delete();
				echo ('Abonnieren ');
			}
		}
	}
}