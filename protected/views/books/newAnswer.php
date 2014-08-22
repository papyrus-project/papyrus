<?php
/* @var $this CommentsController */
/* @var $model Comments */
/* @var $form CActiveForm */
?>

<div class="row answerForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'comments-newAnswer-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>
	<div class="col-xs-3 col-sm-3 col-md-3 ">
	</div>
	<div class="col-xs-9 col-sm-9 col-md-9 no-padding comment-frame">
		<div class="form-group">
			<?php echo ''//$form->labelEx($model,'text'); ?>
			<?php echo $form->textArea($model,'text',array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'text'); ?>
		</div>
	
		<div class="form-group">
			<?php echo CHtml::ajaxSubmitButton(
				'Antwort posten',
				array('books/postAnswer', 'id'=>$id, 'belongsTo'=>$belongsTo),
				array(
                    'success'=>'js:function(data){
                    	console.log("#newAnswers'.$belongsTo.'");
                    	$("#newAnswer'.$belongsTo.'").children(".answerForm").detach();
                    	$("#newAnswer'.$belongsTo.'").append(data);
                	}'
				), 
				array(
					'id' => uniqid(),
				  	'class'=>'btn btn-g',
				)); ?>
		</div>
	    <div id="com"></div>
	</div>
<?php $this->endWidget(); ?>

</div><!-- form -->