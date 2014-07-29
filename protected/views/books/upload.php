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
<!--<?= CHtml::fileField('PdfTable[blubb]','',array('class'=>'TestKlasse')); ?>-->
<h1>Upload your pdf</h1>
	<div class="row">
		Komplettes Buch <input type="radio" name="uploadType" class="uploadType" checked value="single">
		Einzelne Kapitel<input type="radio" name="uploadType" class="uploadType" value="multi">
	</div>
	<div class="row uploadPdf">
		<?php echo $form->labelEx($model,'Pdf Datei');?><br />
		<?php echo $form->fileField($model,'file_path');?>
	 	<?php echo $form->error($model,'file_path'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'Cover');?><br />
		<?php echo $form->fileField($model,'cover_path');?>
	 	<?php echo $form->error($model,'cover_path'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'title');?><br />
		<?php echo $form->textField($model,'title');?>
	 	<?php echo $form->error($model,'title'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'description');?><br />
		<?php echo $form->textArea($model,'description');?>
	 	<?php echo $form->error($model,'description'); ?>
	</div>
	
    <div class="row">
		<?= CHtml::activeLabel($model,'Altersbeschrenkung'); ?>
		<?= CHtml::dropDownList('PdfTable[age_restriction]','',array(0=>'Keine Altersbeschrenkung',6=>'Ab 6',12=>'Ab 12',16=>'Ab 16',18=>'Ab 18',)); ?>
	</div>
	
	<div class="row">
		<input type="checkbox" name="agb" required /> Hiermit stimme ich der 
		<a href="<?= Yii::app()->createAbsoluteUrl('site/agbs') ?>">AGB</a> zu
	</div>
	
	<div class="row-buttons">
		<?php echo CHtml::SubmitButton('senden');?>
	</div>
	
	<script> 
		$('.uploadType').change(function(){
			console.log($(this).val());
		});
	    var intputElements = document.getElementsByTagName("INPUT");
	    for (var i = 0; i < intputElements.length; i++) {
	        intputElements[i].oninvalid = function (e) {
	            e.target.setCustomValidity("");
	            if (!e.target.validity.valid) {
	                if (e.target.name == "agb") {
	                    e.target.setCustomValidity("Akzeptiere die AGB!");
	                }
	            }
	        };
	    
	}
	</script>
<?php
	$this->endWidget();
?>
