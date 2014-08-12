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
	<div class="row">
		<?php echo $form->labelEx($model,'Pdf Datei');?>
		<div class="uploadPdf">
			<?php echo $form->fileField($model,'file_path',array('required'=>'required'));?><br/ >
			<button class="uploadAdd" type="button" >Add</button>
	 	</div>
	 	<?php echo $form->error($model,'file_path'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'Cover');?>
		<?php echo $form->fileField($model,'extension');?>
	 	<?php echo $form->error($model,'extension'); ?>
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
		$('.uploadAdd').hide(0).click(function(){
			console.log('stg');
			$('.uploadPdf').append("<input name='PdfTable[file_path][]' type='file' style='display:block'>");
		});
		$('.uploadType').change(function(){
			if($(this).val()=='single'){
				$('.uploadPdf').children(':not(button)').slice(2).detach();
				console.log($('.uploadPdf').children(':not(:first-child)').attr('name','PdfTable[file_path]'));
				$('.uploadAdd').hide(0);
			} else {
				$('.uploadAdd').show(0);
				console.log($('.uploadPdf').children(':not(:first-child)').attr('name','PdfTable[file_path][]'));
			}
		});
		
		//Warnung bei nicht akzeptieren der AGB setzen
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
