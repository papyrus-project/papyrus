<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;

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

<div class="row">
        <?php echo $form->labelEx($model,'image'); ?>
        <?php echo CHtml::activeFileField($model, 'image'); ?>  // by this we can upload image
        <?php echo $form->error($model,'image'); ?>
</div>
<div class="row buttons">
    <?php echo CHtml::submitButton('Submit'); ?>
</div>
<?php if($model->isNewRecord!='1'): ?>
<div class="row">
     <?php echo CHtml::image(Yii::app()->request->baseUrl.'/banner/'.$model->image,"image",array("width"=>200)); ?>  // Image shown here if page is update page
</div>
<?php endif; 
   $this->endWidget();
?>