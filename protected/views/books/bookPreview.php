<div class="row">
</div>

<div class="row book-thumb">
    <div class="col-md-2">
    <a href="<?= Yii::app()->createUrl('books/files',array('id'=>$data->id)) ?>"> 
        <?php $this->widget('ext.SAImageDisplayer', array(
                'image' => $data->id.'.'.$data->extension,
                'title' => $data->title,
                'size' => 'thumb',
                'class' => 'book-thumb-cover',
                'id' => '',
                'group' => 'cover',
                'defaultImage' => 'default.jpg',
        )); ?>
    </a>
    </div>
    <div class="col-md-9">
        <h3 class="text-muted"><?= UserData::model()->findByPk($data->author)->name; ?></h3>
        <h2><a href="<?= Yii::app()->createUrl('books/files',array('id'=>$data->id)) ?>"><?= $data->title ?></a> <?php if($data->wip == 1) echo '<span class="label book-thumb-label">WIP</span>'?></h2>
        <p>
            <span class="label label-default"><?= Booktype::model()->findByPk($data->booktype_id)->type; ?></span>
            <?php $genre = $data->bookgenres;
                  foreach($genre as $value){
                      echo '<span class="label label-default">'.$value->genreName->genre.'</span> ';
                  } ?>
            <span class="label label-default"><?php if($data->age_restriction != 0){echo 'Ab '.$data->age_restriction.' Jahren';}else{echo 'Keine Altersangabe';} ?></span>
            <span class="label label-default"><?= Languanges::model()->findByPk($data->language_id)->language; ?></span>
            <span class="label label-default"><?= $data->words ?> W&oumlrter</span>
        </p>
                                
        <p>
            <span class="glyphicon glyphicon-star"></span>
            <span class="glyphicon glyphicon-star"></span>
            <span class="glyphicon glyphicon-star"></span>
            <span class="glyphicon glyphicon-star-empty"></span>
            <span class="glyphicon glyphicon-star-empty"></span>
        </p>
                                
        <p class="book-thumb-txt">
            <?= $data->description ?>
        </p>
                                
        <ul class="book-thumb-meta">
            <li class="text-meta"><span class="glyphicon glyphicon-eye-open"></span> <?= $data->views; ?></li>
            <li class="text-meta"><span class="glyphicon glyphicon-bookmark"></span> <?= $data->favorite_count; ?></li>
            <li class="text-meta"><span class="glyphicon glyphicon-comment"></span> 100.000</li>
            <li class="text-meta"><span class="glyphicon glyphicon-save"></span> <?= $data->downloads; ?></li>
        </ul>
                                
    </div>
    <!-- dropdown menus -->
    <div class="col-md-1 dropdown-meta" style="text-align:right;">
        <p>
            <div class="dropdown">
                <a href="#" class="dropdown-toggle" type="button" data-toggle="dropdown"><span class="glyphicon glyphicon-share"></span></a>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdown-share" style="text-align:left;">
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Auf Facebook teilen</a></li>
                </ul>
            </div>
        </p>
        <p>
            <div class="dropdown">
                <a href="#" class="dropdown-toggle" type="button" data-toggle="dropdown"><span class="glyphicon glyphicon-cog"></span></a>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdown-config" style="text-align:left;">
                    <?php if($data->author == Yii::app()->user->id): ?>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Bearbeiten</a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Entfernen</a></li>
                    <?php endif; ?>
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Verst??e Melden</a></li>
                </ul>
            </div>
        </p>
    </div>    
</div>