<?php
/* @var $this CommentsController */
/* @var $model Comments */
/* @var $form CActiveForm */
?>

<div class="answerForm row">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'comments-newAnswer-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>
	<div class="col-xs-2 col-sm-2 col-md-2 ">
	</div>
	<div class="col-xs-9 col-sm-9 col-md-9 no-padding comment-frame">
		<div class="form-group">
			<?php echo ''//$form->labelEx($model,'text'); ?>
			<?php echo $form->textArea($model,'text',array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'text'); ?>
		</div>
	
		<div class="form-group">
			<?php echo CHtml::ajaxSubmitButton(
				'Antwort senden',
				array('books/postAnswer', 'id'=>$id, 'belongsTo'=>$belongsTo),
				array(
                    'success'=>'js:function(data){
                    	console.log("#newAnswers'.$belongsTo.'");
                    	$("#newAnswerForm'.$belongsTo.'").children(".answerForm").detach();
                    	$("#newAnswer'.$belongsTo.'").append(data);
                	}'
				), 
				array(
					'id' => uniqid(),
				  	'class'=>'btn btn-g btn-new-answer pull-right',
				)); ?>
		</div>
	    <div id="com"></div>
	</div>
	<div class="col-xs-1 col-sm-1 col-md-1">
<?php $this->endWidget(); ?>

</div><!-- form -->