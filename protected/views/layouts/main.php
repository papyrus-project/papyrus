<!DOCTYPE html>

<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	    <!-- Chosen -->
		<link rel="stylesheet" href="<?= Yii::app()->request->baseUrl; ?>/css/chosen/chosen.css">
		<link rel="stylesheet" href="<?= Yii::app()->request->baseUrl; ?>/css/bootstrap-rating.css">
	    <!-- Bootstrap -->
	    <link href="<?= Yii::app()->request->baseUrl; ?>/frameworks/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
	    <!-- Internal -->
	    <!-- <link href="<?= Yii::app()->request->baseUrl; ?>/css/some.css" rel="stylesheet" media="screen"> -->
		<link rel="stylesheet" href="<?= Yii::app()->request->baseUrl; ?>/css/style_master.css">
		<link href='http://fonts.googleapis.com/css?family=Lato:400,100,100italic,300,300italic,400italic,700,700italic,900italic,900' rel='stylesheet' type='text/css'>
		
		<script src="<?=Yii::app()->request->baseUrl?>/frameworks/jquery/jquery-2.1.0.min.js" type="text/javascript"></script>
		<script src="<?=YII::app()->request->baseUrl?>/js/fb.js"></script>
		<title><?= CHtml::encode($this->pageTitle); ?></title>
	</head>
<?php
if(!YII::app()->user->isGuest)
	$newMessages = Messages::model()->countByAttributes(array('receiver'=>Yii::app()->user->id,'read'=>0));
?>
<body>
	 <!-- Navigation -->
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header page-scroll">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#toggle-navigation">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand page-scroll" href="<?=YII::app()->createAbsoluteUrl('')?>"><?=YII::app()->name?></a>
                </div>
                

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="toggle-navigation">
                    
                    <!-- <form role="search" method="get" action="<?=YII::app()->createAbsoluteUrl('')?>" class="navbar-form navbar-left"> -->
                    <?= CHtml::beginForm(YII::app()->createAbsoluteUrl('site/bob'), 'get', array('id'=>'filter-form','class'=>'navbar-form navbar-left'))?>
                        <?= CHtml::textField('q', (isset($_GET['q'])) ? $_GET['q'] : '', array('class'=>'form-control', 'placeholder'=>'Bücher finden ...', 'name'=>'q', 'id'=>'srch-term'))?>
                           <!-- <input type="text" class="form-control" placeholder="Bücher finden ..." name="q" id="srch-term">-->

                    <?= CHtml::endForm();?>
                    <!-- </form> -->
                        <ul class="nav navbar-nav navbar-right">
                        <li class="hidden">
                            <a href="#page-top"></a>
                        </li>
                        <?php if(YII::app()->user->isGuest): ?>
                        <li>
                            <a href="<?=YII::app()->createAbsoluteUrl('users/login')?>">Anmelden</a>
                        </li>
                        <li>
                        	<button onclick="window.location.href='<?=YII::app()->createAbsoluteUrl('users/login')?>'" class="btn navbar-btn btn-b">Hochladen</button>
                        </li>
                    	<?php else: ?>
                        <li>
                            <a href="<?=YII::app()->createAbsoluteUrl('user/profile/'.YII::app()->user->id)?>"><span class="glyphicon glyphicon-user"></span> Profil</a>
                        </li>
                        <li>
                            <a href="<?=YII::app()->createAbsoluteUrl('user/messages')?>"><span class="glyphicon glyphicon-envelope"></span> Postfach <?php if($newMessages>0):?><span class="badge badge-pn"><?= $newMessages ?></span><?php endif;?></a>
                        </li>
                        <li>
                            <a href="<?=YII::app()->createAbsoluteUrl('site/logout')?>">Abmelden</a>
                        </li>
                        <li>
                            <button class="btn navbar-btn btn-b" onclick="window.location.href='<?=YII::app()->createAbsoluteUrl('books/upload')?>'">Hochladen</button>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container-fluid -->
        </nav>
        

	<?= $content; ?>

	
	
	<footer>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <ul class="pull-left">
                        <li><a href="<?=YII::app()->createAbsoluteUrl('site/impressum')?>">Impressum</a></li>
                        <li><a href="<?=YII::app()->createAbsoluteUrl('site/contact')?>">Kontakt</a></li>
                        <li><a href="<?=YII::app()->createAbsoluteUrl('site/agbs')?>">AGBs</a></li>
                        <li><a href="<?=YII::app()->createAbsoluteUrl('site/dse')?>">Datenschutzerklärung</a></li>
                    </ul>
                </div> 
                <div class="col-md-4">
                    <ul class="pull-right">
                        <li><a href="#"><img src="<?=YII::app()->request->baseUrl?>/img/social/github.png" alt="github" /></a></li>
                        <li><a href="#"><img src="<?=YII::app()->request->baseUrl?>/img/social/facebook.png" alt="facebook" /></a></li>
                        <li><a href="#"><img src="<?=YII::app()->request->baseUrl?>/img/social/google+.png" alt="google+" /></a></li>
                        <li><a href="#"><img src="<?=YII::app()->request->baseUrl?>/img/social/twitter.png" alt="twitter" /></a></li>
                    </ul>
                </div> 
            </div>
            <div class="row">
                <p>© <?=date('Y')?> Florian Jacobsen, Team "Bookwork"</p>
            </div>
        </div>
    </footer>
	
	
  	

	<script src="<?= Yii::app()->request->baseUrl; ?>/frameworks/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="<?= Yii::app()->request->baseUrl; ?>/js/chosen/chosen.jquery.js" type="text/javascript"></script>
	<script src="<?= Yii::app()->request->baseUrl; ?>/js/bootstrap-rating.js" type="text/javascript"></script>
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
