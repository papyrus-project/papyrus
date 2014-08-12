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
<?php if(YII::app()->user->isGuest):?>
	<?= CHtml::link(
		"favorisieren",
		array('users/login'),
		array(
			'class'=>'btn'
		)
	);?>
<?php endif;?>
<?php if($model->author != Yii::app()->user->id && !YII::app()->user->isGuest):?>
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
			    'class'=>'btn bookFavButton',
			)
		);?>
<?php endif; ?>
<?php if($model->author == Yii::app()->user->id): ?>
	<a href="<?php $url=Yii::app()->createUrl('books/edit', array('id'=>$model->id)); echo ($url);?>">edit</a><br /><br />
<?php endif; ?>

<?= CHtml::link(
		'download',
		array('books/download/'.$_GET['id'])
		
	);?>


<div id="newComment">
    <?php if(!Yii::app()->user->isGuest):
    echo CHtml::ajaxLink(
        'neuer Kommentar',
        array('books/showNewCommentForm', 'id'=>$model->id),
        array(
            'update'=>'#newComment',
        ), 
        array('id' => uniqid())
    );
endif; ?>
</div>
<div id='comments'>
    <h4>Kommentare</h4>
    
    <?php foreach($comments as $comment):?>
		    <div id="<?= $comment->id; ?>" class="row">
		    <?= $comment->getAuthor($comment->users_id); ?><br/>
            <?= $comment->date; ?><br/>
            <?= $comment->text; ?><br/>
            <div class='edit'>
                <?php 
              if($comment->users_id == Yii::app()->user->id){
                  echo CHtml::ajaxLink(
                                          'Edit',
                                          array('books/showEditCommentForm', 'id'=>$comment->id),
                                          array(
                                              'update'=>'#'.$comment->id,
                                          ), 
                                          array('id' => 'edit'.uniqid())
                                      ) . ' ';
                  echo CHtml::ajaxLink(
                                          'Delete',
                                          array('books/deleteComment', 'id'=>$comment->id),
                                          array(
                                              'update'=>'#com',
                                          ), 
                                          array('id' => 'delete'.uniqid())
                                      );
              }
                ?>
            </div>

	    </div>
    <?php endforeach; ?>
</div>

<div id="com">...</div>
<pre><?php //print_r($comments); ?></pre>
