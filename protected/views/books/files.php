<?php
	$this->pageTitle=Yii::app()->name.' - '.$model->title;
?>
<h1>files</h1>
<div>Titel: <?= $model->title ?></div>
<div>von: <?= $author ?></div>
<div>Gattung: <?= $type ?></div>
<div>Genre: <?= $genres ?></div>
<div>Sprachen: <?= $lang ?></div>
<div>Umfang: <?= $model->words ?></div>
<div>Alter: <?= $model->age_restriction ?></div>
<?php 
//coverbild anzeigen groesse 200x150, seitenverhaeltnis bleibt erhalten

	$this->widget('ext.SAImageDisplayer', array(
	    'image' => $model->cover_path,
	    'title' => $model->cover_path,
	    'size' => 'thumb',
	    'class' => '',
	    'id' => '',
)); 

?>
<div class="og:description">Beschreibung: <br /><?= $model->description ?></div>
<div class="fb-share-button" data-href="http://papyrus-project.noip.me/books/files/<?=$model->id?>" data-type="icon"></div>
<br />Statistik<br />
<div>Datei: <?= $model->file_path ?></div>
<div>Erstellt am: <?= $model->created ?></div>
<div>Favorisiert: <?= $model->favorite_count ?></div>
<div>Downloads: <?= $model->downloads ?></div>
<div>Views: <?= $model->views ?></div>
<div>Cover Artist: <?= $model->cover_artist ?></div>
<?php if($model->author != Yii::app()->user->id):?>
	<form>
		<?= CHtml::ajaxButton(
			//gucken ob das buch bereits favorisiesrt wurde
		    BooksFavorites::model()->findByAttributes(array('users_id'=>YII::app()->user->id,'books_id'=>$model->id))?'unfavorise':'favorise',
		    array('ajax/favoriseBook'),
		    array(
		    	'type'=>'POST',
		    	'data'=>array('book'=>$model->id),
		    	'success'=>'js:function(data){
					console.log("success");
			        $(".bookFavButton").val(data);
			    }',
			),
			array(
			    'class'=>'bookFavButton',
			)
		);?>
	</form>
<?php endif; ?>
<?php if($model->author == Yii::app()->user->id): ?>
	<a href="<?php $url=Yii::app()->createUrl('books/edit', array('id'=>$model->id)); echo ($url);?>">edit</a><br /><br />
<?php endif; ?>
<div id='comments'>
    <h4>Kommentare</h4>
    
    <?php foreach($comments as $comment):?>
		    <div class="row">
		    <?= $comment->getAuthor($comment->users_id); ?><br/>
            <?= $comment->date; ?><br/>
            <?= $comment->text; ?><br/>
            <div class='edit'>
                <?php 
                if($comment->users_id == Yii::app()->user->id){
                    echo '<a href='. Yii::app()->createUrl('books/files', array('id'=>$model->id)) . '>edit</a> ';
                    echo '<a href='. Yii::app()->createUrl('books/files', array('id'=>$model->id)) . '>delete</a>';
                    }
                ?>
            </div>
	    </div><br/>
    <?php endforeach; ?>
</div>
<div id="newComment">
    <?php if(!Yii::app()->user->isGuest):?>
    <div class="form">
    <?= CHtml::beginForm(); ?>
 
        <?= CHtml::errorSummary($commentForm); ?>

       <div class="row">
            <?= CHtml::activeHiddenField($commentForm, 'ref_id', array('value'=>$model->id)); ?>
		    <?= CHtml::activeLabel($commentForm,'neuer Kommentar'); ?>
		    <?= CHtml::activeTextArea($commentForm,'text'); ?>
	    </div>
    
        <div class="row submit">
            <?php echo CHtml::ajaxSubmitButton(
	            'Submit request',
	            array('books/postComment'),
	            array(
		            'update'=>'#com',
	            )
            );
	        ?>
        </div>
    <?= CHtml::endForm(); ?>
    </div><!-- form -->
    <?php endif; ?>
    
</div>

<div id="com"></div>
<pre><?php //print_r($comments); ?></pre>
