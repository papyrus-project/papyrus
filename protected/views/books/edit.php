<section id="upload-files">
    <div class="container">
        <div class="row col-md-6">
            <h2><?= CHtml::encode($model->title); ?> bearbeiten</h2>


            <?= CHtml::beginForm('','post',array('enctype'=>'multipart/form-data')); ?>
            <div class="form-group">
                <?= CHtml::activeLabel($model,'titel'); ?>
                <?= CHtml::activeTextField($model,'title', array('class'=>'form-control',)); ?><p>
                <label class="checkbox-inline" style="margin-top: 10px">
                    <?= CHtml::activeCheckBox($model,'wip'); ?> Titel befindet sich noch in der Bearbeitung <span class="label book-thumb-label" style="margin-left: 5px;font-size:14px">WIP</span>
                </label>
                </p>
            </div>
            <div class="form-group">
                <?= CHtml::activeLabel($model,'description'); ?>
                <?= CHtml::activeTextArea($model,'description', array('class'=>'form-control', 'rows'=>5)); ?>
            </div>
            <div class="form-group">
                <?= CHtml::activeLabel($model,'Literarische Gattung'); ?>
                <?= CHtml::dropDownList('booktype_id',
                                                        $model->booktype_id,CHtml::listData(Booktype::model()->findAll(), 'id', 'type'), 
                                                        array('class'=>'form-control')); ?>
            </div>
            <div class="form-group">
                <?= CHtml::activeLabel($model,'genre'); ?>
                <?= CHtml::dropDownList('genres', 
                                                        $selectedGenres, 
                                                        CHtml::listData(Genres::model()->findAll(), 'id', 'genre'), 
                                                        array(  'multiple' => 'multiple', 
                                                                'class'=>'chosen-select form-control', 
                                                                'data-placeholder'=>' ')); ?>
                <span class="help-block">Mehrere Angaben m&ouml;glich</span>
            </div>
            <div class="form-group">
                <?= CHtml::activeLabel($model,'language_id'); ?>
                <?= CHtml::dropDownList('language_id',
                                                        $model->language_id,CHtml::listData(Languanges::model()->findAll(), 'id', 'language'), 
                                                        array('class'=>'form-control')); ?>
            </div>
            <div class="form-group">
                <?= CHtml::activeLabel($model,'Altersempfehlung'); ?>
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
                        <?= CHtml::activeFileField($model, 'extension'); ?>
                </div>
            </div>

            <div class="form-group form-send">
                <p>
                	<button type="submit" class="btn btn-g">Speichern<span class="glyphicon glyphicon-ok"></span></button>				
                	<button type="button" class="btn btn-r pull-right" style="margin-left: 5px" onclick="window.location.href='<?=YII::app()->createAbsoluteUrl('user/profile/'.YII::app()->user->id)?>'">Abbrechen <span class="glyphicon glyphicon-remove"></span></button>
                </p>
            </div>
            <?= CHtml::endForm(); ?>
        </div>
    </div>
</section>

