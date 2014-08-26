<?php
/**
 * Log in file.
 *
 * @copyright	Copyright &copy; 2013 Hardalau Claudiu 
 * @package		bum
 * @license		New BSD License 
 * 
 * The log in form file.
 */

/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);

$cs = Yii::app()->clientScript;

$cs->registerScript('focus_on_username', "
    $('#LoginForm_username').focus();
", CClientScript::POS_READY);



?>

<?php /*
if (!Yii::app()->getModule('bum')->demoMode) : ?> 
    <DIV class="login-box">
        <?php $this->widget('facebook_app', array(
                'appId'=>Yii::app()->getModule('bum')->fb_appId,
                'secret'=>Yii::app()->getModule('bum')->fb_secret,
                'text'=>'Sign in with <b>Facebook</b>',
                'target'=>'_self',
            )); ?>
        
        <?php $this->widget('twitter_app', array(
                'text'=>'Sign in with <b>Twitter</b>',
                'target'=>'_self',
            )); ?>
    </DIV>
<?php endif; */ ?>
<section>
	<div class="container">
        <div class="row col-md-6">
			<h1>Login</h1>
		    <div class="form login-form">
		    <?php $form=$this->beginWidget('CActiveForm', array(
		        'id'=>'login-form',
		        'enableClientValidation'=>true,
		        'clientOptions'=>array(
		            'validateOnSubmit'=>true,
		        ),
		    )); ?>
		
		        <div class="form-group">
		            <?php echo $form->labelEx($model,'username'); ?>
		            <?php echo $form->textField($model,'username',array('class'=>'form-control')); ?>
		            <?php echo $form->error($model,'username'); ?>
		        </div>
		
		        <div class="form-group">
		            <?php echo $form->labelEx($model,'password'); ?>
		            <?php echo $form->passwordField($model,'password',array('class'=>'form-control')); ?>
		            <?php echo $form->error($model,'password'); ?>
		        </div>
		
		        <div class="form-group rememberMe">
		            <?php echo $form->checkBox($model,'rememberMe'); ?>
		            <?php echo $form->label($model,'rememberMe'); ?>
		            <?php echo $form->error($model,'rememberMe'); ?>
		        </div>
		
		        <div class="form-group buttons">
		            <?php echo CHtml::submitButton('Login',array('class'=>'btn btn-g')); ?>
					<a class='btn btn-b' href="<?=YII::app()->createAbsoluteUrl('users/signUp')?>">Noch kein Mitglied?</a>
		        </div>
		
		    <?php $this->endWidget(); ?>
		    </div><!-- form -->
	    </div>
	</div>
</section>
<?php /*<DIV class="message note">Forgot your password? Click <?php echo CHtml::link('here',array('users/passwordRecoveryWhatUser')); ?> to reset your password.</DIV>
*/?>
<?php 
if (Yii::app()->getModule("bum")->install) :
    ?><DIV class="message note">Or go to the install page; click <?php echo CHtml::link('here',array('install/index')); ?>.</DIV><?php
endif;
