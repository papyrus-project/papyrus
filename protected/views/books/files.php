<h1>files</h1>
<div>Titel: <?= $model->title ?></div>
<div>von: <?= $model->users[0]['name'] ?></div>
<div>Gattung: <?= $model->booktypes[0]['type'] ?></div>
<div>Genre: <?= $genres ?></div>
<div>Sprachen: <?= $lang ?></div
<div>Umfang: <?= $model->words ?></div>
<div>Alter: <?= $model->age_restriction ?></div>
<?php 
//coverild anzeigen groesse 200x150, seitenverhaeltnis bleibt erhalten
$this->widget('ext.SAImageDisplayer', array(
    'image' => $model->cover_path,
    'title' => $model->cover_path,
    'size' => 'thumb',
    'class' => '',
    'id' => '',
)); ?>
<div>Beschreibung: <?= $model->description ?></div>
<br />Statistik<br />
<div>Datei: <?= $model->file_path ?></div>
<div>Erstellt am: <?= $model->created ?></div>
<div>Favorisiert: <?= $model->favorite_count ?></div>
<div>Downloads: <?= $model->downloads ?></div>
<div>Views: <?= $model->views ?></div>
<div>Cover Artist: <?= $model->cover_artist ?></div>