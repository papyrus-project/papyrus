<section id="book-profile">
    <div class="container">
        <div class="row">
            
            <!-- profile meta -->
            <div class="col-md-3">
                <div class="row">
                    <div class="col-md-12 hidden-xs hidden-sm no-padding">
                        <p>
						<?php 
							//coverbild anzeigen groesse 200x150, seitenverhaeltnis bleibt erhalten
						    $this->widget('ext.SAImageDisplayer', array(
						        'image' => $model->id.'.'.$model->extension,
						        'title' => $model->title,
						        'size' => 'thumb',
						        'class' => '',
						        'id' => '',
						        'group' => 'cover',
						        'defaultImage' => 'default.jpg',
							));
						?>
						</p>
                    </div>
                </div>
                <div class="row">
                    <p>
                    	<div class="dropdown">
						  <button class="btn btn-g dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
						    Download
						    <span class="glyphicon glyphicon-download"></span>
						  </button>
						  <ul class="dropdown-menu download" role="menu" aria-labelledby="dropdownMenu1">
						    <li role="presentation"><a href="<?=YII::app()->createAbsoluteUrl('books/download/'.$model->id.'.1')?>" role="menuitem" tabindex="-1" href="#">PDF</a></li>
						    <li role="presentation"><a href="<?=YII::app()->createAbsoluteUrl('books/download/'.$model->id.'.2')?>" role="menuitem" tabindex="-1" href="#">EPUB</a></li>
						    <li role="presentation"><a href="<?=YII::app()->createAbsoluteUrl('books/download/'.$model->id.'.3')?>" role="menuitem" tabindex="-1" href="#">MOBI</a></li>
						  </ul>
						</div>
                    </p>
                    <p class="text-muted text-meta">Verfügbare Formate: PDF, EPUB, MOBI</p>
                </div>
                
                <div class="row">
                    <div class="book-statistics col-xs-12 col-sm-12 col-md-12">
                        <h3 class="book-profilepage-statistics-heading">Statistik <span class="glyphicon glyphicon-signal"></span></h3>
                        <ul class="col-xs-8 col-sm-8 col-md-8">
                            <li class="text-muted">Erscheinungsdatum</li>
                            <br>
                            <li class="text-muted"><span class="book-badge glyphicon glyphicon-eye-open"></span> Angesehen</li>
                            <li class="text-muted"><span class="book-badge glyphicon glyphicon-bookmark"></span> Favorisiert</li>
                            <li class="text-muted"><span class="book-badge glyphicon glyphicon-save"></span> Heruntergeladen</li>
                            <li class="text-muted"><span class="book-badge glyphicon glyphicon-comment"></span> Kommentare</li>
                        </ul>
                        <ul class="col-xs-4 col-sm-4 col-md-4">
                            <li class="text-meta"><?=date('d.m.Y',$model->created)?></li>
                            <br>
                            <li class="text-meta"><?=$model->views?></li>
                            <li class="text-meta"><?=BooksFavorites::model()->countByAttributes(array('books_id'=>$model->id))?></li>
                            <li class="text-meta"><?=$model->downloads?></li>
                            <li class="text-meta"><?=Comments::model()->countByAttributes(array('ref_id'=>$model->id))?></li>                                    
                        </ul>
                    </div>
                        
                    <div class="book-badges-history col-xs-12 col-sm-12 col-md-12">

                        <h3>Abzeichen Verlauf</h3>

                        <ul class="col-xs-8 col-sm-8 col-md-8">
                            <li class="text-muted"><span class="book-badge glyphicon glyphicon-bookmark"></span> Meiste Downloads heute</li>
                            <li class="text-muted"><span class="book-badge glyphicon glyphicon-fire"></span> Heiß diskutiert</li> 
                            <li class="text-muted"><span class="book-badge glyphicon glyphicon-flag"></span> Veröffentlichung</li>                               
                        </ul>
                        <ul class="col-xs-4 col-sm-4 col-md-4">
                            <li>06.06.2014</li>
                            <li>02.01.2014</li>
                            <li>01.01.2014</li>
                        </ul>
                    </div>
                    
                </div>
            </div>
            
            <!-- profile -->
            <div class="col-md-7 no-padding">
                <div class="row">
                    <h2><?=$model->title?> <?= $model->wip?'<span class="label book-thumb-label">WIP</span>':''?></h2>
                    <h3 class="text-muted">von <?=$model->author0->name?></h3>

                    <p class="rating">
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star-empty"></span>
                        <span class="glyphicon glyphicon-star-empty"></span>
                        (1000) Bewertungen
                    </p>

                    <ul class="col-xs-6 col-sm-6 col-md-6 book-profile-meta-big">
                        <li class="text-muted">Literarische Gattung</li>
                        <?= $model->Genres?'<li class="text-muted">Genre</li>':''?>
                        <li class="text-muted">Sprachen</li>
                        <li class="text-muted">Altersempfehlung</li>
                    </ul>
                    <ul class="col-xs-6 col-sm-6 col-md-6 book-profile-meta-big">
                        <li class="text-muted">
                            <span class="label label-default"><?=$model->booktype->type?></span>
                        </li>
                         <?php if($model->Genres):?>
                        <li class="text-muted">
                        	<?php foreach($model->Genres as $genre):?>
                            <span class="label label-default"><?=$genre->genreName->genre?></span>
                            <?php endforeach;?>
                        </li>
                        <?php endif ?>
                        <li class="text-muted">
                            <span class="label label-default"><?=$model->language->language?></span>
                        </li>
                        <li class="text-muted">
                            <span class="label label-default"><?=$model->age_restriction?'Ab '.$model->age_restriction.' Jahren':'Keine Alters Beschrenkung'?></span>
                        </li>
                    </ul>
                </div>
                
                <!-- chapter -->
                <div class="row">
                    <h2 id="book-profile-sub-heading">Verfügbare Kapitel</h2>
                    <ul id="book-series">
                        <li class="text-muted"><span class="glyphicon glyphicon-tag"></span> Kapitel 1: <a href="#">Der Anfang</a></li>
                        <li class="text-muted"><span class="glyphicon glyphicon-tag"></span> Kapitel 2: <a href="#">Der Mittelteil</a></li>
                        <li class="text-muted"><span class="glyphicon glyphicon-tag"></span> Kapitel 3: <a href="#">Das Ende</a></li>
                    </ul>
                </div>
                
                <div class="row">
                    <h2 id="book-profile-blurb-heading">Klappentext</h2>
                    <p id="book-profile-blurb">
                        <?=$model->description?>
                    </p>
                </div>
                
                <div class="row">                            
                     <h2 id="H1">Kommentare <span class="badge"> <?=Comments::model()->countByAttributes(array('ref_id'=>$model->id))?></span></h2>
                </div>
                <div class="row">
                	<p><button class="btn btn-b" id="toggle-newComment">Kommentar schreiben <span class="glyphicon glyphicon-pencil"></span></button></p>
                </div>
			    <?php if(!Yii::app()->user->isGuest):?>
                <div class="row" id="newComment">
			    	<?=$form;?>
		    	</div>
				<?php endif; ?>
                
                <?php foreach($comments as $comment):?>
                <!-- comment example -->
                <div id="<?= $comment->id; ?>" class="row">
                    <div class="comment-wrapper">
                        <div class="row">
                            <div class="col-xs-2 col-sm-2 col-md-2 hidden-xs">
                                <img class="commentary-portrait" src="../../upload/cover/thumb/default.jpg" alt="user-portrait" />
                            </div>
                            <div class="col-xs-9 col-sm-9 col-md-9 no-padding comment-frame">
                                <div class="row">
                    <h3><?= $comment->getAuthor($comment->users_id); ?></h3>
                                    <p class="comment-date text-muted">
                        geschrieben am <?= Yii::time($comment->date); ?>
                                    </p>
                                </div>
                                <div class="row">
                                    <p class="comment-text">
                        <?= $comment->text; ?>
                                    </p>
                                </div>
                                <div class="row">
                                    <p>
                                        <h4 class="comment-rating">Bewertung</h4> 
                                        <span class="glyphicon glyphicon-star"></span>
                                        <span class="glyphicon glyphicon-star"></span>
                                        <span class="glyphicon glyphicon-star"></span>
                                        <span class="glyphicon glyphicon-star-empty"></span>
                                        <span class="glyphicon glyphicon-star-empty"></span>
                                    </p>
                                </div>
                            </div>
                            <!-- meta dropdown menu -->
                            <div class="col-xs-1 col-sm-1 col-md-1 dropdown-meta text-align-right">
                                <!-- dropdown menus -->
                                <p>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle" type="button" data-toggle="dropdown"><span class="glyphicon glyphicon-share"></span></a>
                                        <ul class="dropdown-menu" role="menu" aria-labelledby="dropdown-share" style="text-align:left;">
                                            <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Auf Facebook teilen</a></li>
                                        </ul>
                                    </div>
                                </p>
                                <p>
                                    <a href="#" class="dropdown-toggle" type="button" data-toggle="dropdown"><span class="glyphicon glyphicon-envelope"></span></a>
                                </p>                                
                                <p>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle" type="button" data-toggle="dropdown"><span class="glyphicon glyphicon-cog"></span></a>
                                        <ul class="dropdown-menu" role="menu" aria-labelledby="dropdown-config" style="text-align:left;">
                                        <?php if($comment->users_id == Yii::app()->user->id) : ?>
                            <li role="presentation"><?= CHtml::ajaxLink(
                                'Bearbeiten',
                                array('books/showEditCommentForm', 'id'=>$comment->id),
                                          array(
                                              'update'=>'#'.$comment->id,
                                          ), 
                                          array('id' => 'edit'.uniqid(), 'role'=>'menuitem', 'tabindex'=>'-1')
                            ); ?>

                            </li>
                            <li role="presentation">
                                <?= CHtml::ajaxLink(
                                'Entfernen',
                                array('books/deleteComment', 'id'=>$comment->id),
                                          array(
                                              'update'=>'#com',
                                          ), 
                                          array('id' => 'delete'.uniqid(), 'role'=>'menuitem', 'tabindex'=>'-1')
                                      );
                                ?>
                            </li>
                            <?php endif; ?>
                                            <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Verstöße Melden</a></li>
                                        </ul>
                                    </div>
                                </p>
                            </div>
                        </div>
                    </div>
                <!-- comment commentary -->
                <div>
                <div id="answers<?= $comment->id ?>">
                    <?= CHtml::ajaxLink(
                                      'Antworten anzeigen',
                                      array('books/showAnswers', 'id'=>$comment->ref_id, 'belongsTo'=>$comment->id),
                                      array(
                                          'update'=>'#answers'.$comment->id,
                                      ), 
                                      array('id' => 'show'.uniqid())
                                  ) . ' ';
                ?>
                </div>
                <div id="newAnswer<?= $comment->id ?>"></div>
                <?php 
                    if(!Yii::app()->user->isGuest){
                        echo CHtml::ajaxLink(
                                              'Antwort schreiben',
                                              array('books/showNewAnswerForm','id'=>$model->id, 'belongsTo'=>$comment->id),
                                              array(
                                                  'update'=>'#newAnswer'.$comment->id,
                                              ), 
                                              array('id' => 'answer'.uniqid())
                                          );
                    }
                ?>
</div>
                </div> 
    <?php endforeach; ?>
<div id="com"></div>

                <!-- content pull block -->
                <div class="row">
                    <p class="content-pull col-xs-12 col-sm-12 col-md-12">
                        <a href="#">Weitere Kommentare laden <span class="glyphicon glyphicon-chevron-down"></span></a>
                    </p>
                </div>
            </div>
            
            <!-- options -->
            <div class="col-md-2 dropdown-meta text-align-right">
                <p><a href="#">Favorisieren <span class="book-profile-option glyphicon glyphicon-bookmark"></span></a></p>
                <p><a href="#">Abonnieren <span class="book-profile-option glyphicon glyphicon-star"></span></a></p>
                <p><a href="#">Teilen <span class="book-profile-option glyphicon glyphicon-share"></span></a></p>
            </div>    
        </div>
    </div>
</section>