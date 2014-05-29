<h1>Profile</h1>
<?= $model->id == Yii::app()->user->id?'<a href=?r=user/edit>Edit</a><br />':'' ?>
Name: <?= $model->name ?> <br />
Bday: <?= $model->birthday ?> <br />
<?php if($model->sex) : ?>
	Sex: <?= $sexes[$model->sex] ?> <br />
<?php endif; ?>
Location: <?= $model->location ?> <br />
Homepage: <?= $model->homepage ?> <br />
Description: <?= $model->description ?> <br />

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
			    'image' => $book->cover_path,
			    'title' => $book->cover_path,
			    'size' => 'thumb',
			    'class' => '',
			    'id' => '',
		)); 
?>
	</div>
<?php endforeach; ?>
