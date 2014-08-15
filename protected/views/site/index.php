<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>

<?php 
if(isset($dataProvider)){
    $this->widget('zii.widgets.CListView', array(
        'dataProvider'=>$dataProvider,
        'itemView'=>'application.views.books.bookPreview',   // refers to the partial view named '_post'
        'sortableAttributes'=>array(
            'title',
            'id'=>'Datum',
        ),
    ));
}else if(!isset($books))
              echo 'Zurzeit konnten keine ver&ouml;ffentlichten B&uuml;cher gefunden werden';
	else
		foreach($books as $book) : 
?>
	<div class="row">
		<a href="<?= Yii::app()->createUrl('books/files',array('id'=>$book->id))?>">
			<?= $book->title ?>
		</a><br />
		<?php foreach($book->bookgenres as $genre): ?>
			<?= $genre->genreName->genre ?>
		<?php endforeach ?>
		<?php
			try{
				$this->widget('ext.SAImageDisplayer', array(
				    'image' => $book->id.'.'.$book->extension,
				    'title' => $book->title,
				    'size' => 'thumb',
				    'class' => '',
				    'id' => '',
			)); 
			} catch(exception $e){
				$this->widget('ext.SAImageDisplayer', array(
				    'image' => 'default.jpg',
				    'title' => 'default Cover',
				    'size' => 'thumb',
				    'class' => '',
				    'id' => '',
				));
			}
?>
	</div>
<?php endforeach ?>