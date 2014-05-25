<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
    <!-- Bootstrap -->
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/some.css" rel="stylesheet" media="screen">
    
	<!-- blueprint CSS framework -->
	
	<!-- <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />  -->
	
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif] -->
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
	<div id="page">
		<div class="header">
			<a class="brand" href="<? echo Yii::app()->createAbsoluteUrl('') ?>"><?php echo CHtml::encode(Yii::app()->name); ?></a>
			<ul>
				<li><a href="?r=site/Impressum">Impressum</a></li>
				<li><a href="?r=site/contact">Kontakt</a></li>
				<li><a href="?r=site/AGBs">AGBs</a></li>
				<li><a href="?r=site/DSA">Datenschutzerklärung</a></li>
			</ul>
		</div><!-- header -->
	
		<div class="navbar">
			<div class="navbar-inner">
				<div class="container">
					<input placeholder="Search" />
					
					<?php 
						if (Yii::app()->user->isGuest):
					?>
						<a href="<?=Yii::app()->createAbsoluteUrl('users/signUp/bum');?>">Register</a>
						<a href="<?=Yii::app()->createAbsoluteUrl('users/login/bum');?>">login</a>
					<?php
						else :
					?>						
						<a href="<?=Yii::app()->createAbsoluteUrl('books/upload');?>">upload</a>
						<a href="<?=Yii::app()->createAbsoluteUrl('user/profile',array('id'=>'0'));?>"><?=Yii::app()->user->name?></a>
						<a href="<?=Yii::app()->createAbsoluteUrl('site/logout');?>">logout</a>			
					<?php
						endif;
					?>
				</div>
			</div>
		</div><!-- navbar -->
		<?php /*
		if(isset($this->breadcrumbs)):?>
			<?php $this->widget('zii.widgets.CBreadcrumbs', array(
				'links'=>$this->breadcrumbs,
			)); ?><!-- breadcrumbs -->
		<?php endif */ ?>
		
		<div class='container'>
			<?php echo $content; ?>
		</div>
	
		<div id="footer">
			<div class="container">
				Copyright &copy; <?php echo date('Y'); ?> by Team Papyrus.<br/>
				All Rights Reserved.<br/>
				<?php echo Yii::powered(); ?>
			</div>
		</div><!-- footer -->
	
	</div><!-- page -->
	
	<script src="http://code.jquery.com/jquery.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap.min.js"></script>
</body>
</html>
