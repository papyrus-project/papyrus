<section id="upload-files">
    <div class="container">
        <div class="row col-md-6">
            <h2><?= $model->title ?> bearbeiten</h2>


            <?= CHtml::beginForm(); ?>
            <div class="form-group">
                <?= CHtml::activeLabel($model,'titel'); ?>
                <?= CHtml::activeTextField($model,'title', array('class'=>'form-control',)); ?>
            </div>
            <div class="form-group">
                <?= CHtml::activeLabel($model,'Klappentext'); ?>
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
                                                                'data-placeholder'=>'Genres eingeben')); ?>
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
                    <label class="checkbox-inline">
                        <?= CHtml::activeCheckBox($model,'nsfw'); ?> Explizites Material (Mature Content) <a href="#">?</a>
                    </label>
                </p>
            </div>

            <div class="form-group">
                <h3>Buchcover ausw&auml;hlen</h3>
                <?=Yii::app()->homeUrl;?>
                <script type="text/javascript">
                    var ImgArray = [
                      "<?=Yii::app()->homeUrl.'/upload/cover/default1.jpg'; ?>",
                      "<?=Yii::app()->homeUrl.'/upload/cover/default2.jpg'; ?>",
                      "<?=Yii::app()->homeUrl.'/upload/cover/default3.jpg'; ?>",
                      "<?=Yii::app()->homeUrl.'/upload/cover/default4.jpg'; ?>",
                      "<?=Yii::app()->homeUrl.'/upload/cover/default5.jpg'; ?>",
                      "<?=Yii::app()->homeUrl.'/upload/cover/default6.jpg'; ?>",
                      "<?=Yii::app()->homeUrl.'/upload/cover/thumb/'.$model->id.'.'.$model->extension; ?>",
                    ];
                    function ChangeImg(imgPtr) {
                        document.getElementById('coverPreview').src = ImgArray[imgPtr];
                    }
                </script>

                <div class="cover-preview">
                    <div class="radio">
                        <label>
                            <input type="radio" name="optionsRadios" id="optionsRadios1" value="default1" onclick="ChangeImg(0)" checked>
                            Tanz der Totenk&ouml;pfe
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="optionsRadios" id="Radio1" value="default2" onclick="ChangeImg(1)">
                            Schmetterlinge im Bauch
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="optionsRadios" id="Radio2" value="default3" onclick="ChangeImg(2)">
                            Abenteuer ahoj!
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="optionsRadios" id="Radio3" value="default4" onclick="ChangeImg(3)">
                            Unendliche Weite
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="optionsRadios" id="Radio4" value="default5" onclick="ChangeImg(4)">
                            Kerker und Eidechsen
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="optionsRadios" id="Radio5" value="default6" onclick="ChangeImg(5)">
                            Blutiger Abgang
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="optionsRadios" id="Radio6" value="custom" onclick="ChangeImg(6)" checked>
                            Eigenes Cover verwenden
                        </label>
                    </div>
                </div>

                <div class="cover-preview">
                    <?php $this->widget('ext.SAImageDisplayer', array(
			                                'image' => $model->id.'.'.$model->extension,
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
                    <input type="file" id="File2">
                </div>
            </div>

            <div class="form-group form-send">
                <p>
                    <?= CHtml::submitButton('Speichern', array('class'=>'btn btn-g')); ?>
                </p>
            </div>
            <?= CHtml::endForm(); ?>
        </div>
    </div>
</section>

