<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
    <!-- Bootstrap -->
    <link href="<?= Yii::app()->request->baseUrl; ?>/css/bootstrap/bootstrap.css" rel="stylesheet" media="screen">
    <link href="<?= Yii::app()->request->baseUrl; ?>/css/some.css" rel="stylesheet" media="screen">
	<link rel="stylesheet" href="<?= Yii::app()->request->baseUrl; ?>/css/chosen/chosen.css">
	<!-- blueprint CSS framework -->
	
	<!-- <link rel="stylesheet" type="text/css" href="<?= Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?= Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	
	<link rel="stylesheet" type="text/css" href="<?= Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?= Yii::app()->request->baseUrl; ?>/css/form.css" />  -->
	
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?= Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif] -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
	<title><?= CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
	   <script>
      window.fbAsyncInit = function() {
        FB.init({
          appId      : '684989361538190',
          xfbml      : true,
          version    : 'v2.0'
        });
      };

      (function(d, s, id){
         var js, fjs = d.getElementsByTagName(s)[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement(s); js.id = id;
         js.src = "//connect.facebook.net/en_US/sdk.js";
         fjs.parentNode.insertBefore(js, fjs);
       }(document, 'script', 'facebook-jssdk'));
       
       (function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
    </script>
<div id="fb-root"></div>
	<div id="page">
		<div class="header">
			<a class="brand" href="<?= Yii::app()->createAbsoluteUrl('') ?>"><?= CHtml::encode(Yii::app()->name); ?></a>
			<ul>
				<li><a href="<?= Yii::app()->createAbsoluteUrl('site/Impressum">Impressum')?></a></li>
				<li><a href="<?= Yii::app()->createAbsoluteUrl('site/contact">Kontakt')?></a></li>
				<li><a href="<?= Yii::app()->createAbsoluteUrl('site/AGBs">AGBs')?></a></li>
				<li><a href="<?= Yii::app()->createAbsoluteUrl('site/DSA')?>">Datenschutzerklärung</a></li>
			</ul>
		</div><!-- header -->
	
		<div class="navbar">
			<div class="navbar-inner">
				<div class="container">
					<?= CHtml::beginForm($this->createUrl(''), 'get'); ?>
		                <?= CHtml::activeSearchField(Books::model(),'title'); ?>
		                <?= CHtml::submitButton('Suchen'); ?>
                    <?= CHtml::endForm(); ?>
					
					<?php 
						if (Yii::app()->user->isGuest):
					?>
						<a href="<?=Yii::app()->createAbsoluteUrl('users/signUp');?>">Register</a>
						<a href="<?=Yii::app()->createAbsoluteUrl('users/login');?>">login</a>
					<?php
						else :
					?>						
						<a href="<?=Yii::app()->createAbsoluteUrl('books/upload');?>">upload</a>
						<a href="<?=Yii::app()->createAbsoluteUrl('user/profile',array('id'=>'0'));?>"><?=Yii::app()->user->name?></a>
						<a href="<?=Yii::app()->createAbsoluteUrl('site/logout');?>">logout</a>	
						<?= Messages::model()->countByAttributes(array('receiver'=>Yii::app()->user->id,'read'=>0))?>		
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
			<?= $content; ?>
		</div>
	
		<div id="footer">
			<div class="container">
				Copyright &copy; <?= date('Y'); ?> by Team Papyrus.<br/>
				All Rights Reserved.<br/>
				<?= Yii::powered(); ?>
			</div>
		</div><!-- footer -->
	
	</div><!-- page -->
	
	
  	

	<script src="<?= Yii::app()->request->baseUrl; ?>/js/bootstrap/bootstrap.js" type="text/javascript"></script>
	<script src="<?= Yii::app()->request->baseUrl; ?>/js/chosen/chosen.jquery.js" type="text/javascript"></script>
	<script type="text/javascript">
		var config = {
		  '.chosen-select'           : {},
		  '.chosen-select-deselect'  : {allow_single_deselect:true},
		  '.chosen-select-no-single' : {disable_search_threshold:10},
		  '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
		  '.chosen-select-width'     : {width:"95%"}
		    }
		    for (var selector in config) {
		      $(selector).chosen(config[selector]);
		    }
	</script>
	<script src="<?= Yii::app()->request->baseUrl; ?>/js/papyrus.js" type="text/javascript"></script>
</body>
</html>
