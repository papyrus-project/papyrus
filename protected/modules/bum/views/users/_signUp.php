<?php
/**
 * Sign Up form; partial view.
 *
 * @copyright	Copyright &copy; 2012 Hardalau Claudiu 
 * @package		bum
 * @license		New BSD License 
 */

/* @var $this UsersController */
/* @var $model Users */
/* @var $form CActiveForm */
?>

<section>
<div class="container">
<div class='row col-md-6'>
<h1>Sign Up</h1>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'users-singUp-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php 
    // if site is not invitation based, then do not display invitation code errors... :)
    if(Yii::app()->getModule('bum')->invitationBasedSignUp):
        echo $form->errorSummary(array($model, $model->invitations)); 
    else:
        echo $form->errorSummary(array($model)); 
    endif;
    
    ?><fieldset>
        <legend>Username and password:</legend>
        <div class="form-group">
            <?php echo $form->labelEx($model,'user_name'); ?>
            <?php if($model->isNewRecord): ?>
                <?php echo $form->textField($model,'user_name',array('size'=>45,'maxlength'=>45,'class'=>'form-control')); ?>
            <?php else: ?>
                <?php echo $form->textField($model,'user_name',array('size'=>45,'maxlength'=>45,'class'=>'form-control', 'readonly'=>'readonly', 'disabled'=>true)); ?>
            <?php endif; ?>
            <?php echo $form->error($model,'user_name'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model,'password'); ?>
            <?php echo $form->passwordField($model,'password',array('size'=>45,'maxlength'=>150,'class'=>'form-control')); ?>
            <?php echo $form->error($model,'password'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model,'password_repeat'); ?>
            <?php echo $form->passwordField($model,'password_repeat',array('size'=>45,'maxlength'=>150,'class'=>'form-control')); ?>
            <?php echo $form->error($model,'password_repeat'); ?>
        </div>
        
        <div class="form-group">
            <?php echo $form->labelEx($model,'email'); ?>
            <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>60,'class'=>'form-control')); ?>
            <?php echo $form->error($model,'email'); ?>
        </div>
    </fieldset>
    <fieldset>
    	<legend>Pers&ouml;nliche Angaben</legend>
    	
    	<div class="form-group">
    		<label>Name</label>
			<input class='form-control' type="text" value="<?=isset($_POST['userdata'])?$_POST['userdata']['name']:''?>" name="userdata[name]"/>
		</div>
		
		<div class="form-group">
			<label>Geburtstag</label>
			<select name="userdata[day]" class="chosen-select-small">
				<?php for ($i=1; $i <= 31; $i++) : ?>
					<option <?= isset($_POST['userdata'])&&$_POST['userdata']['day']==$i?'selected':''?> value="<?=str_pad($i,2,'0',STR_PAD_LEFT);?>"><?=$i;?></option>
				<?php endfor; ?>
			</select>
			<select name="userdata[month]" class="chosen-select-small">
				<?php for ($i=1; $i <= 12; $i++) : ?>
					<option <?= isset($_POST['userdata'])&&$_POST['userdata']['month']==$i?'selected':''?> value="<?=str_pad($i,2,'0',STR_PAD_LEFT);?>"><?=$i;?></option>
				<?php endfor; ?>
			</select>
			<select name="userdata[year]" class="chosen-select-small">
				<?php for ($i=1900; $i <= date('Y'); $i++) : ?>
					<option <?= isset($_POST['userdata'])&&$_POST['userdata']['year']==$i?'selected':''?> value="<?=$i;?>"><?=$i;?></option>
				<?php endfor; ?>
			</select>
		</div>
		<div class="form-group">
			<label>Geschlecht</label>
			<select class="form-control" name='userdata[sex]'>
				<option <?= isset($_POST['userdata'])&&$_POST['userdata']['sex']==1?'selected':''?> value='1'>Keine Angabe</option>
				<option <?= isset($_POST['userdata'])&&$_POST['userdata']['sex']==2?'selected':''?> value='2'>M&auml;nnlich</option>
				<option <?= isset($_POST['userdata'])&&$_POST['userdata']['sex']==3?'selected':''?> value='3'>Weiblich</option>
			</select>
		</div>
    </fieldset>
    <fieldset>
        <legend>Are you human?</legend>
        <?php if(CCaptcha::checkRequirements()): ?>
        <div class="form-group">
            <?php echo $form->labelEx($model,'verifyCode'); ?>
            <div>
            <?php $this->widget('CCaptcha'); ?>
            <?php echo $form->textField($model,'verifyCode',array('type'=>'text')); ?>
            </div>
            <div class="hint">Please enter the letters as they are shown in the image above.
            <br/>Letters are not case-sensitive.</div>
            <?php echo $form->error($model,'verifyCode'); ?>
        </div>
        <?php endif; ?>
    </fieldset>
    
    <?php if(Yii::app()->getModule('bum')->invitationBasedSignUp): ?>
        <fieldset>
            <legend>Invitation code?</legend>
            <?php echo $form->labelEx($model->invitations,'invitation_code'); ?>
            <?php echo $form->textField($model->invitations,'invitation_code',array('size'=>10,'maxlength'=>10)); ?>
            <?php echo $form->error($model->invitations,'invitation_code'); ?>
        </fieldset>
    <?php else:
            // if site is not invitation based, then do not display invitation_code field... :)
            echo $form->hiddenField($model->invitations,'invitation_code');
    endif; ?>
    
	<div class="form-group buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'btn btn-g')); ?>
	</div>

<?php $this->endWidget(); ?>
</div>
</div>
</section>