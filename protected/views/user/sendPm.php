<?php
/* @var $this MessagesController */
/* @var $model Messages */
/* @var $form CActiveForm */
?>

<section>
<div class="container">
<div class="row col-md-6">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'messages-sendPm-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="form-group">
		<label>An:</label>
		<input type="text" readonly class="form-control" value="<?=UserData::model()->findByAttributes(array('id'=>$_GET['id']))->name?>" />
	</div>
	
	<div class="form-group">
		<label>Betreff:</label>
		<?php echo $form->textField($model,'subject',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'subject'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->textArea($model,'message',array('class'=>'form-control','rows'=>5)); ?>
		<?php echo $form->error($model,'message'); ?>
	</div>

	<?php if(CCaptcha::checkRequirements()): ?>
	<div class="form-group">
		<?php echo $form->labelEx($model,'verifyCode'); ?>
		<div>
		<?php $this->widget('CCaptcha'); ?>
		<?php echo $form->textField($model,'verifyCode',array('class'=>'form-control')); ?>
		</div>
		<div class="hint">Please enter the letters as they are shown in the image above.
		<br/>Letters are not case-sensitive.</div>
		<?php echo $form->error($model,'verifyCode'); ?>
	</div>
	<?php endif; ?>

	<div class="form-group buttons">
		<?php echo CHtml::submitButton('Abschicken',array('class'=>'btn btn-g')); ?>
	</div>
<?php $this->endWidget(); ?>

</div>
</div>
</section>