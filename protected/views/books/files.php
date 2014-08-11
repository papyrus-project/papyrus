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
<div class="fb-share-button" data-href="http://papyrus-project.noip.me/books/files/27" data-type="icon"></div>
<br />Statistik<br />
<div>Datei: <?= $model->file_path ?></div>
<div>Erstellt am: <?= $model->created ?></div>
<div>Favorisiert: <?= $model->favorite_count ?></div>
<div>Downloads: <?= $model->downloads ?></div>
<div>Views: <?= $model->views ?></div>
<div>Cover Artist: <?= $model->cover_artist ?></div>
<?php if($model->author != Yii::app()->user->id):?>
	<button <?= !Yii::app()->user->isGuest?'onclick="favorise('.$model->id.')"':''?>>
		Favorisieren
	</button>
	<?= CHtml::ajaxSubmitButton(
	    'Submit request',
	    array('ajax/favoriseBook'),
	    array(
		)
	);?>
<?php endif; ?>
<?php if($model->author == Yii::app()->user->id): ?>
	<a href="<?php $url=Yii::app()->createUrl('books/edit', array('id'=>$model->id)); echo ($url);?>">edit</a><br /><br />
<?php endif; ?>

<div id="newComment">
    <?php if(!Yii::app()->user->isGuest):?>
    <div class="form">
    <?= CHtml::beginForm(); ?>
 
        <?= CHtml::errorSummary($commentForm); ?>

       <div class="row">            
            <?= CHtml::activeHiddenField($commentForm, 'type', array('value'=>'new')); ?>
		    <?= CHtml::activeLabel($commentForm,'neuer Kommentar'); ?>
		    <?= CHtml::activeTextArea($commentForm,'text'); ?>
	    </div>
    
        <div class="row submit">
            <?php echo CHtml::ajaxSubmitButton(
	            'Submit request',
	            array('books/postComment', 'id'=>$model->id),
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
	                                        array('books/editComment', 'id'=>$comment->id),
	                                        array(
		                                        'update'=>'#newComment',// . $comment->id,
	                                        )
                                        ) . ' ';
                    echo CHtml::ajaxLink(
	                                        'Delete',
	                                        array('books/deleteComment', 'id'=>$comment->id),
	                                        array(
		                                        'update'=>'#com',
	                                        )
                                        );
                    }
                ?>
            </div>
	    </div>
    <?php endforeach; ?>
</div>

<div id="com">...</div>
<pre><?php //print_r($comments); ?></pre>
