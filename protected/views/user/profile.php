<h1>Profile</h1>
<?= $model->id == Yii::app()->user->id?'<a href='.YII::app()->createAbsoluteUrl('user/edit').'>edit</a><br />':'' ?>
Name: <?= $model->name ?> <br />
Bday: <?= $model->birthday ?> <br />
<?php if($model->sex) : ?>
	Sex: <?= $sexes[$model->sex] ?> <br />
<?php endif; ?>
Location: <?= $model->location ?> <br />
Homepage: <?= $model->homepage ?> <br />
Description: <?= $model->description ?> <br />
<?php if($model->id != Yii::app()->user->id && !YII::app()->user->isGuest):?>
	<?= CHtml::ajaxButton(
		//gucken ob das buch bereits favorisiesrt wurde
	    Subscription::model()->findByAttributes(array('subscriber_id'=>YII::app()->user->id,'subscripted_id'=>$model->id))?'nicht mehr folgen':'folgen',
	    array('ajax/subscribe'),
	    array(
	    	'type'=>'POST',
	    	'data'=>array('subsripted'=>$model->id),
	    	'success'=>'js:function(data){
				console.log("success");
		        $(".mi-btn-subscribe").val(data);
		    }',
		),
		array(
		    'class'=>'btn mi-btn-subscribe',
		)
	);?>
<?php endif; ?>
B&uuml;cher<br />
<?php foreach($books as $book):?>
		<div class="row">
		<a href="<?= Yii::app()->createUrl('books/files',array('id'=>$book->id))?>">
			<?= $book->title ?>
		</a><br />
		<?= $book->status?'':'Nicht erschienen';?>
		<?php foreach($book->bookgenres as $genre): ?>
			<?= $genre->genreName->genre ?>
		<?php endforeach ?>
		<?php
			$this->widget('ext.SAImageDisplayer', array(
			    'image' => $book->id.'.'.$book->extension,
			    'title' => $book->title,
			    'size' => 'thumb',
			    'class' => '',
			    'id' => '',
		)); 
?>
	</div>
<?php endforeach; ?>
