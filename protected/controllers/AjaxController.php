<?
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
			print('nein nein nein mr author nicht sein eigenes Buch favorisieren');
		else{
			$model = BooksFavorites::model()->findByAttributes(array('users_id'=>$user,'books_id'=>$book));
			if(!$model){
				$model = new BooksFavorites();
				$model->users_id=$user;
				$model->books_id=$book;
				$model->save();
			} else{
				$model->delete();
			}
		}
		/*
		$connection=Yii::app()->db; 
		
        $command=$connection->createCommand('
			INSERT INTO alex.books_favorites
			SET 
				books_id = "' . $_POST['book'] . '",
				users_id = "' . Yii::app()->user->id .'"
			ON duplicate key update
				books_id = "' . $book . '"
			');
        $rowCount=$command->execute();*/
	}
}