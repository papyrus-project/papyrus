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
<section>
    <div class="container">
        <div class="row col-md-6">
		<!--<?= CHtml::fileField('PdfTable[blubb]','',array('class'=>'TestKlasse')); ?>-->
		<h2 id="publishNow">Jetzt veröffentlichen</h2>
			<label class="radio-inline">
				<input type="radio" name="uploadType" id="inlineRadio1" class="uploadType" checked value="single"> Gesamtwerk veröffentlichen
			</label>
			<label class="radio-inline">
				<input type="radio" name="uploadType" id="inlineRadio1"  class="uploadType" value="multi"> Kapitelweise veröffentlichen
			</label>
            <h3 id="uploadABook">Ein Buch hochladen</h3>
			<div class="form-group">
				<?php echo $form->labelEx($model,'PDF-Datei/en');?>
				<div class="uploadPdf">
					<input type="text" placeholder="Kapitelname (Ohne Nummerierung o.&Auml;.)" class="form-control input-chapter" name="PdfTable[name][]" style="display:none">
					<?php echo $form->fileField($model,'file_path',array('required'=>'required','accepted'=>'.pdf'));?>
			 	</div>
				<button class="uploadAdd btn btn-b" type="button" >Kapitel Hinzuf&uuml;gen <span class="glyphicon glyphicon-plus-sign"></span></button>
			 	<?php echo $form->error($model,'file_path'); ?>
			</div>
			<div class="form-group">
				<?php echo $form->labelEx($model,'title');?>
				<?php echo $form->textField($model,'title',array('class'=>'form-control'));?>
			 	<?php echo $form->error($model,'title'); ?>
                <label class="checkbox-inline" style="margin-top: 10px">
                    <?= CHtml::activeCheckBox($model,'wip'); ?> Titel befindet sich noch in der Bearbeitung <span class="label book-thumb-label" style="margin-left: 5px;font-size:14px">WIP</span>
                </label>
			</div>
			<div class="form-group">
				<?php echo $form->labelEx($model,'description');?>
				<?php echo $form->textArea($model,'description',array('class'=>'form-control', 'rows'=>5));?>
			 	<?php echo $form->error($model,'description'); ?>
			</div>
			<div class="form-group">
                <?= CHtml::activeLabel($model,'Literarische Gattung'); ?>
                <?= CHtml::dropDownList('booktype_id',
                                                        '',CHtml::listData(Booktype::model()->findAll(), 'id', 'type'), 
                                                        array('class'=>'form-control')); ?>
            </div>
            <div class="form-group">
                <?= CHtml::activeLabel($model,'genre'); ?>
                <?= CHtml::dropDownList('genres', 
                                                        '', 
                                                        CHtml::listData(Genres::model()->findAll(), 'id', 'genre'), 
                                                        array(  'multiple' => 'multiple', 
                                                                'class'=>'chosen-select form-control', 
                                                                'data-placeholder'=>' ')); ?>
                <span class="help-block hint">Mehrere Angaben m&ouml;glich</span>
            </div>
            <div class="form-group">
                <?= CHtml::activeLabel($model,'language_id'); ?>
                <?= CHtml::dropDownList('language_id',
                                                        $model->language_id,CHtml::listData(Languanges::model()->findAll(), 'id', 'language'), 
                                                        array('class'=>'form-control')); ?>
            </div>
		    <div class="form-group">
				<?= CHtml::activeLabel($model,'Empfohlene Altersfreigabe'); ?>
				<?= CHtml::dropDownList('age_restriction',
                    $model->age_restriction,array(  0=>'Keine Altersempfehlung', 
                                                    6=>'Ab 6 Jahren', 
                                                    12=>'Ab 12 Jahren', 
                                                    16=>'Ab 16 Jahren',
                                                    18=>'Ab 18 Jahren'), 
                    array('class'=>'form-control')); ?>
                <p>
                    <label class="checkbox-inline" style="margin-top: 10px">
                        <?= CHtml::activeCheckBox($model,'nsfw'); ?> Der Titel enth&auml;lt <span class="label book-thumb-gore" style="margin-left: 5px;font-size:14px">Explizites Material</span>
                    </label>
                </p>
			</div>
			
			<div class="form-group">
                <h3>Buchcover ausw&auml;hlen</h3>
                <script type="text/javascript">
                    var ImgArray = [
                      "<?=Yii::app()->createAbsoluteUrl('/upload/cover/original/default1.jpg'); ?>",
                      "<?=Yii::app()->createAbsoluteUrl('/upload/cover/original/default2.jpg'); ?>",
                      "<?=Yii::app()->createAbsoluteUrl('/upload/cover/original/default3.jpg'); ?>",
                      "<?=Yii::app()->createAbsoluteUrl('/upload/cover/original/default4.jpg'); ?>",
                      "<?=Yii::app()->createAbsoluteUrl('/upload/cover/original/default5.jpg'); ?>",
                       <?php   $img = '';
                                if(strlen($model->extension) < 6)
                                    $img = $model->id.'.'.$model->extension;
                                else
                                    $img = $model->extension;?>
                      "<?=Yii::app()->homeUrl.'/upload/cover/thumb/'.$img; ?>",
                    ];
                    function ChangeImg(imgPtr) {
                        document.getElementById('coverPreview').src = ImgArray[imgPtr];
                    }
                </script>

                <div class="cover-preview">
                    <div class="radio">
                        <label>
                            <input type="radio" name="optionsRadios" id="Radio0" value="default1" onclick="ChangeImg(0)" <?php if($model->extension == 'default1.jpg') echo 'checked';?>>
                            Tanz der Totenk&ouml;pfe
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="optionsRadios" id="Radio1" value="default2" onclick="ChangeImg(1)" <?php if($model->extension == 'default2.jpg') echo 'checked';?>>
                            Schmetterlinge im Bauch
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="optionsRadios" id="Radio2" value="default3" onclick="ChangeImg(2)" <?php if($model->extension == 'default3.jpg') echo 'checked';?>>
                            Mord im Blumenbeet
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="optionsRadios" id="Radio3" value="default4" onclick="ChangeImg(3)" <?php if($model->extension == 'default4.jpg') echo 'checked';?>>
                            Kerker und Eidechsen
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="optionsRadios" id="Radio4" value="default5" onclick="ChangeImg(4)" <?php if($model->extension == 'default5.jpg') echo 'checked'; ?>>
                            Unendliche Weite
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="optionsRadios" id="Radio6" value="custom" onclick="ChangeImg(6)" <?php if(strlen($model->extension)<5) echo 'checked'; ?> />
                            Eigenes Cover verwenden
                        </label>
                    </div>
                </div>

                <div class="cover-preview">
                    <?php   $img = '';
                            if(strlen($model->extension) < 6)
                                $img = $model->id.'.'.$model->extension;
                            else
                                $img = $model->extension;
                            $this->widget('ext.SAImageDisplayer', array(
			                                'image' => $img,
			                                'title' => $model->title,
			                                'size' => 'thumb',
			                                'class' => '',
			                                'id' => 'coverPreview',
                                            'group' => 'cover',
                                            'defaultImage' => 'default.jpg',
		                            )); ?>
                    <p class="help-block">Buchcover Vorschau</p>
                </div>

                <div class="cover-preview">
                    <p>
                        <label for="input-file">Eigenes Buchcover hinzuf&uuml;gen</label></p>
                        <?= CHtml::activeFileField($model, 'extension',array('accepted'=>'.jpg, .png, .jpeg')); ?>
                </div>
            </div>
            
			<div class="row-buttons" style="margin-top:35px">
				<button type="submit" class="btn btn-g">Hochladen und Ver&ouml;ffentlichen <span class="glyphicon glyphicon-ok"></span></button>
				<button type="button" class="btn btn-r pull-right" style="margin-left: 5px" onclick="window.location.href='<?=YII::app()->createAbsoluteUrl('user/profile/'.YII::app()->user->id)?>'">Abbrechen <span class="glyphicon glyphicon-remove"></span></button>
			</div>
			
			<div class="form-group" id="acceptAGBGroup">
				<input type="checkbox" name="agb" required /> <span id="acceptAGB">Hiermit stimme ich der</span> 
				<a href="<?= Yii::app()->createAbsoluteUrl('site/impressum#agb') ?>" target="agb">AGB</a> zu
			</div>
			
			<script> 
				$('.uploadAdd').hide(0).click(function(){
					console.log('stg');
					$('.uploadPdf').append("<input type='text' class='form-control input-chapter' name='PdfTable[name][]'><input name='PdfTable[file_path][]' required type='file' style='display:block'>");
				});
				$('.uploadType').change(function(){
					if($(this).val()=='single'){
						$('.uploadPdf').children().slice(3).detach();
						$('.uploadPdf').children('input[type=file]').attr('name','PdfTable[file_path]');
						$('.uploadPdf').children('input[type=text]').hide(0);
						$('.uploadAdd').hide(0);
					} else {
						$('.uploadAdd').show(0);
						$('.uploadPdf').children('input[type=file]').attr('name','PdfTable[file_path][]');
						$('.uploadPdf').children('input[type=text]').show(0);
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
		</div>
	</div>
</section>
<?php
	$this->endWidget();
?>