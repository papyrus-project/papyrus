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
<div>Beschreibung: <br /><?= $model->description ?></div>
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
<?php endif; ?>
<?php if($model->author == Yii::app()->user->id): ?>
	<a href="<?php $url=Yii::app()->createUrl('books/edit', array('id'=>$model->id)); echo ($url);?>">edit</a><br /><br />
<?php endif; ?>
<div>
    <h4>Kommentare</h4>
    
    <?php foreach($comments as $comment):?>
		    <div class="row">
		    <?= $comment->getAuthor($comment->users_id); ?><br/>
            <?= $comment->date; ?><br/>
            <?= $comment->text; ?><br/><br/>
	    </div>
    <?php endforeach; ?>

    <?php if(!Yii::app()->user->isGuest):?>
    <div class="form">
    <?= CHtml::beginForm(); ?>
 
        <?= CHtml::errorSummary($commentForm); ?>

       <div class="row">
		    <?= CHtml::activeLabel($commentForm,'neuer Kommentar'); ?>
		    <?= CHtml::activeTextArea($commentForm,'text'); ?>
	    </div>
    
        <div class="row submit">
            <?= CHtml::submitButton('Posten'); ?>
        </div>
    <?= CHtml::endForm(); ?>
    </div><!-- form -->
    <?php endif; ?>
    
</div>
<pre><?php //print_r($comments); ?></pre>