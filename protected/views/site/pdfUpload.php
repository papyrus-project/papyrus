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
		<?php echo $form->labelEx($model,'path');?><br />
		<?php echo $form->fileField($model,'path');?>
	 	<?php echo $form->error($model,'path'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'titel');?><br />
		<?php echo $form->textField($model,'titel');?>
	 	<?php echo $form->error($model,'titel'); ?>
	</div>
	
	
	<div class="row-buttons">
		<?php echo CHtml::SubmitButton('senden');?>
	</div>

<?php
	$this->endWidget();
?>
