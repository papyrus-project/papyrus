<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>

<h2>Landingpage</h2>

<?php //foreach($books as $book) : ?>
	<div class="row">
		<a href="<?= Yii::app()->createUrl('books/files',array('id'=>$book->id))?>">
			<?= $book->title ?>
		</a><br />
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
		)); ?>
	</div>
<?php //endforeach ?>