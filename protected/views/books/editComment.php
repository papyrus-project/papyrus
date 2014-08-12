<?php
/* @var $this CommentsController */
/* @var $model Comments */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'comments-editComment-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'text'); ?>
		<?php echo $form->textArea($model,'text'); ?>
		<?php echo $form->error($model,'text'); ?>
	</div>

	<div class="row buttons">
				<?php echo
                          CHtml::ajaxSubmitButton(
                      'Submit request',
                      array('books/saveEdit', 'id'=>$model->id),
                      array(
                          'update'=>'#com',
                      ), 
                      array('id' => uniqid())); 
                          ?>
	</div>
    <div id="com"></div>

<?php $this->endWidget(); ?>

</div><!-- form -->