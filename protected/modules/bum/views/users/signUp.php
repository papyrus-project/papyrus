<?php
/**
 * Sign Up form.
 *
 * @copyright	Copyright &copy; 2012 Hardalau Claudiu 
 * @package		bum
 * @license		New BSD License 
 */

/* @var $this UsersController */
/* @var $model Users */

$this->pageTitle=Yii::app()->name . ' - Registrieren';
?>

<?php echo $this->renderPartial('_signUp', array('model'=>$model,)); ?>