<?php
$this->pageTitle = Yii::app()->name;
$form = $this->beginWidget(
    'CActiveForm',
    array(
        'id' => 'upload-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array(
            'enctype' => 'multipart/form-data',
        ),
    ))
?>
<h1>Upload your pdf</h1>
	<div class="row">
		<?php echo $form->labelEx($model,'file_path');?><br />
		<?php echo $form->fileField($model,'file_path');?>
	 	<?php echo $form->error($model,'file_path'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'cover_path');?><br />
		<?php echo $form->fileField($model,'cover_path');?>
	 	<?php echo $form->error($model,'cover_path'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'description');?><br />
		<?php echo $form->textArea($model,'description');?>
	 	<?php echo $form->error($model,'description'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'title');?><br />
		<?php echo $form->textField($model,'title');?>
	 	<?php echo $form->error($model,'title'); ?>
	</div>
	
	
	<div class="row-buttons">
		<?php echo CHtml::SubmitButton('senden');?>
	</div>

<?php
	$this->endWidget();
?>
