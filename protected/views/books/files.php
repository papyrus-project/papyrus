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
<? if($model->author != Yii::app()->user->id):?>
	<button <?= !Yii::app()->user->isGuest?'onclick="favorise('.$model->id.')"':''?>>
		Favorisieren
	</button>
<? endif; ?>
<? if($model->author == Yii::app()->user->id):?>
	<a href="<?php $url=Yii::app()->createUrl('books/edit', array('id'=>$model->id)); echo ($url);?>">edit</a><br /><br />
<? endif; ?>

<pre><?php print_r($model); ?></pre>