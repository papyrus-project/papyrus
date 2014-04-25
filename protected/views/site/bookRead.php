<?php 
	$this->pageTitle = Yii::app()->name;
	print_r('upload/pdf/'.$post['path']);
?>

<div style="height:600px;">
<?php

Yii::app()->clientScript->registerCoreScript('jquery');

$this->widget('ext.pdfJs.QPdfJs',array(
	'url'=>'upload/pdf/'.$post['path']
	)
	);
  
?>
</div>

