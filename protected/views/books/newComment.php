<?php
/* @var $this CommentsController */
/* @var $model Comments */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'comments-newComment-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<p>
		<?php echo $form->textArea($model,'text',array('class'=>'form-control','rows'=>5)); ?>
		<?php echo $form->error($model,'text'); ?>
	</p>
	<p class="rating">
        <span>Jetzt bewerten: </span>
        <span class="glyphicon glyphicon-star"></span>
        <span class="glyphicon glyphicon-star"></span>
        <span class="glyphicon glyphicon-star"></span>
        <span class="glyphicon glyphicon-star-empty"></span>
        <span class="glyphicon glyphicon-star-empty"></span>
    
		<?=CHtml::ajaxSubmitButton(
	          'Abschicken',
	          array('books/postComment', 'id'=>$id),
	          array(
	              'update'=>'#com',
	          ), 
	          array(
	          	'id' => 'post'.uniqid(),
	          	'class'=>'btn btn-g pull-right'
		  )); ?>
    </p>

<?php $this->endWidget(); ?>

</div><!-- form -->