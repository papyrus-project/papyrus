<h1>Edit File</h1>
<div class="form">
<?= CHtml::beginForm(); ?>
 
    <?= CHtml::errorSummary($model); ?>

   <div class="row">
		<?= CHtml::activeLabel($model,'titel'); ?>
		<?= CHtml::activeTextField($model,'title'); ?>
	</div>

	<div class="row">
		<?= CHtml::activeLabel($model,'beschreibung'); ?>
		<?= CHtml::activeTextArea($model,'description'); ?>
	</div>

	<div class="row">
		<?= CHtml::activeLabel($model,'altersangabe'); ?>
		<?= CHtml::activeTextField($model,'age_restriction'); ?>
	</div>

	<div class="row">
		<?= CHtml::activeLabel($model,'cover'); ?>
		<?= CHtml::activeTextField($model,'cover_path'); ?>
	</div>
	<?php
		try{
			$this->widget('ext.SAImageDisplayer', array(
			    'image' => $model->cover_path,
			    'title' => $model->cover_path,
			    'size' => 'thumb',
			    'class' => '',
			    'id' => '',
		)); 
		} catch(exception $e){
			// $this->widget('ext.SAImageDisplayer', array(
			    // 'image' => 'default',
			    // 'title' => 'default Cover',
			    // 'size' => 'thumb',
			    // 'class' => '',
			    // 'id' => '',
			// ));
		}
	?>
	<div class="row">
		<?= CHtml::activeLabel($model,'cover_artist'); ?>
		<?= CHtml::activeTextField($model,'cover_artist'); ?>
	</div>

	<div class="row">
		<?= CHtml::activeLabel($model,'anzahl der Worte'); ?>
		<?= CHtml::activeTextField($model,'words'); ?>
	</div>
    
    <div class="row">
		<?= CHtml::activeLabel($model,'language_id'); ?>
		<?= CHtml::dropDownList('language_id',$model->language_id,CHtml::listData(Languanges::model()->findAll(), 'id', 'language')); ?>
	</div>

    <div class="row">
		<?= CHtml::activeLabel($model,'type'); ?>
		<?= CHtml::dropDownList('booktype_id',$model->booktype_id,CHtml::listData(Booktype::model()->findAll(), 'id', 'type')); ?>
	</div>
	
    <div class="row">
		<?= CHtml::activeLabel($model,'genre'); ?> 
		<?= CHtml::dropDownList('genres', $selectedGenres, CHtml::listData(Genres::model()->findAll(), 'id', 'genre'), array('multiple' => 'multiple', 'class'=>'chosen-select', 'data-placeholder'=>'GIib genres')); ?>
	</div>

    <div class="row submit">
        <?= CHtml::submitButton('Speichern'); ?>
    </div>
    <pre><?php print_r($model->bookgenres); ?></pre>
 
<?= CHtml::endForm(); ?>
</div><!-- form -->