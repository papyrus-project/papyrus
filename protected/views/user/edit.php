<section id="upload-files">
    <div class="container">
        <div class="row col-md-6">
            <form role="form" method="post" action="" enctype="multipart/form-data">
                <h2>Profil bearbeiten</h2>
                
	            <div class="form-group row">
                    <div class="col-md-5">
                            <div class="cover-preview">	
                                <?php 
						        $this->widget('ext.SAImageDisplayer', array(
							        'image' => $model->id.'.'.$model->extension,
							        'defaultImage' => 'default.jpg',
							        'title' => 'user',
							        'group' => 'user',
							        'size' => 'big',
							        'class' => 'img-responsive user-portrait',
							        'id' => '',
					                )); 
					            ?>
                                <p class="help-block">Aktuelles Profilbild</p>
                            </div>
                    </div>
                    
                    <div class="col-md-5">
                        <div class="cover-preview">
                            <p><label for="input-file">Neues Bild hochladen</label></p>
                            <?= CHtml::activeFileField($model, 'extension'); ?>
                            <!-- <input type="file" id="input-file" name="extension"> -->
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Name</label>
		            <input class="form-control" type="text" name="name" value="<?php echo $model->name; ?>" />
                </div>
	            <div class="form-group">
		            <label>Wohnort</label>
		            <input class="form-control" type="text" name="location" value="<?php echo $model->location; ?>" />
	            </div>
	            <div class="form-group">
		            <label>Geschlecht</label>
		            <select class="form-control" name='sex'>
			            <option value='1' <?php echo $model->sex==1?'selected="selected"':'' ?>>Keine Angabe</option>
			            <option value='2' <?php echo $model->sex==2?'selected="selected"':'' ?>>M&auml;nnlich</option>
			            <option value='3' <?php echo $model->sex==3?'selected="selected"':'' ?>>Weiblich</option>
		            </select>
	            </div>
	            <div class="form-group">
		            <label>Homepage</label>
		            <input class="form-control" type="text" name="homepage" value="<?php echo $model->homepage; ?>" />
	            </div>
	            <div class="form-group">
		            <label>Beschreibung</label>
		            <textarea class="form-control" rows="5" name="description"><?php echo $model->description; ?></textarea>
	            </div>

	            <div class="form-group">
		            <button class="btn btn-g" type="submit">Speichern<span class="glyphicon glyphicon-ok"></span></button>
		            <button class="btn btn-r pull-right" onclick="window.location.href='<?=YII::app()->createAbsoluteUrl('user/profile/'.$model->id)?>'">Abbrechen<span class="glyphicon glyphicon-remove"></span></button>
	            </div>
            </form>
        </div>
    </div>
</section>

