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
						        'size' => 'big',
						        'class' => '',
						        'id' => '',
						        'group' => 'cover',
						        'defaultImage' => 'default.jpg',
							));
						?>
						</p>
					<?php if($model->author0->id == YII::app()->user->id):?>
						<p class="user-profile-edit">
							<a href="<?= YII::app()->createAbsoluteUrl('books/edit/'.$model->id) ?>"><span class="glyphicon glyphicon-cog"></span> Buch bearbeiten</a>
						</p>
                        <?php endif;?>
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
                    <a href="<?= Yii::app()->createAbsoluteUrl('user/profile/'.$model->author0->id)?>"><h3 class="text-muted">von <?=$model->author0->name?></h3></a>

                    <p>
                        <input type="hidden" readonly class="rating" data-start="1" data-stop="6" value="<?=$rating->count?round($rating->rating/$rating->count):''?>" />
                        (<?=$rating->count?>) Bewertungen
                    </p>

                    <ul class="col-xs-6 col-sm-6 col-md-6 book-profile-meta-big">
                        <li class="text-muted">Literarische Gattung</li>
                        <?= $model->Genres?'<li class="text-muted">Genre</li>':''?>
                        <li class="text-muted">Sprachen</li>
                        <li class="text-muted">Altersempfehlung</li>
                    </ul>
                    <ul class="col-xs-6 col-sm-6 col-md-6 book-profile-meta-big">
                        <li class="text-muted">
                            <span class="label label-meta"><?=$model->booktype->type?></span>
                        </li>
                         <?php if($model->Genres):?>
                        <li class="text-muted">
                        	<?php foreach($model->Genres as $genre):?>
                            <span class="label label-meta"><?=$genre->genreName->genre?></span>
                            <?php endforeach;?>
                        </li>
                        <?php endif ?>
                        <li class="text-muted">
                            <span class="label label-meta"><?=$model->language->language?></span>
                        </li>
                        <li class="text-muted">
                            <span class="label label-meta"><?=$model->age_restriction?'Ab '.$model->age_restriction.' Jahren':'Keine Alters Beschrenkung'?></span>
                            <?php if($model->nsfw == 1) :?><span class="label label-meta">Expliziter Inhalt</span><?php endif;?>
                        </li>
                    </ul>
                </div>
                
                <!-- chapter -->
                <?php if($model->chapters):?>
                <div class="row">
                    <h2 id="book-profile-sub-heading">Verfügbare Kapitel</h2>
                    <ul id="book-series">
                    	<?php foreach($model->chapters as $value => $chapter): ?>
	                        <li class="text-muted"><span class="glyphicon glyphicon-tag"></span> Kapitel <?=$value+1?>: <a href="<?=YII::app()->createAbsoluteUrl('books/files/'.$chapter->id)?>"><?=$chapter->title?></a></li>
                        <?php endforeach;?>
                    </ul>
                </div>
                <?php endif;?>
                
                <?php if($model->parentBook):?>
            	<div class="row">
                    <h2 id="book-profile-sub-heading">Aus dem Buch</h2>
                    <ul id="book-series">
            			<li class="text-muted"><span class="glyphicon glyphicon-tag"></span><a href="<?=YII::app()->createAbsoluteUrl('books/files/'.$model->base_id)?>"><?=$model->parentBook->title?></a></li>
        			</ul>
            	</div>
            	<?php endif;?>
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
                	<p>
                		<?=CHtml::ajaxLink(
							'Kommentar schreiben <span class="glyphicon glyphicon-pencil"></span>',
							array('books/newComment','id'=>$model->id),
							array('success'=>'js:function(data){
								$("#newComment").children().detach();
								$("#newComment").append(data);
								$("#newComment input.rating").rating();
							}'
							),
							array('class'=>'btn btn-b')
						)?>
                	</p>
                </div>
			    <?php if(!Yii::app()->user->isGuest):?>
                <div class="row" id="newComment">
			    	
		    	</div>
				<?php endif; ?>
                
				<div id="com"></div>
                <?php foreach($comments as $comment):?>
                <!-- comment example -->
                <div id="<?= $comment->id; ?>" class="row">
                    <div class="comment-wrapper">
                        <div class="row">
                            <div class="col-xs-2 col-sm-2 col-md-2 hidden-xs">
                                 <!--<img class="commentary-portrait" src="../../upload/cover/thumb/default.jpg" alt="user-portrait" />-->
                                <?php 
						    $user = UserData::model()->findByPk($comment->users_id);
					        $this->widget('ext.SAImageDisplayer', array(
						        'image' => $user->id.'.'.$user->extension,
						        'title' => $model->title,
						        'size' => 'comment',
						        'class' => 'commentary-portrait',
						        'id' => '',
						        'group' => 'user',
						        'defaultImage' => 'default.jpg',
							));
						?>
                            </div>
                            <div class="col-xs-9 col-sm-9 col-md-9 no-padding comment-frame">
                                <div class="row">
                    				<h3><?= $comment->getAuthor($comment->users_id); ?></h3>
                                    <p class="comment-date text-muted">
                        				geschrieben am <?= Yii::time($comment->date); ?>
                                    </p>
                                </div>
                                <div id="text<?= $comment->id; ?>" class="row">
                                    <p class="comment-text">
                                        <?= $comment->text; ?>
                                    </p>
                                </div>
                                <div class="row">
                                    <p>
                                        <h4 class="comment-rating">Bewertung</h4> 
	                					<input type="hidden" data-start="1" data-end="6" class="rating" value="<?=$comment->rating?>" readonly />
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
				                                              'update'=>'#text'.$comment->id,
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
                <div class="row">
                    <div class="col-xs-3 col-sm-3 col-md-3 hidden-xs text-align-right">
                        <?= CHtml::ajaxLink(
                                    '<span class="text-muted glyphicon glyphicon-chevron-down"></span>Antworten anzeigen',
                                    array('books/showAnswers', 'id'=>$comment->ref_id, 'belongsTo'=>$comment->id),
                                    array(
                                        'update'=>'#answers'.$comment->id,
                                    ), 
                                    array('id' => 'show'.uniqid())
                                ) . ' ';
                        ?>
                    </div>
				</div>
	                <div id="answers<?= $comment->id ?>"></div>
	                <div id="newAnswer<?= $comment->id ?>"></div>
	                
	                <?php 
	                    if(!Yii::app()->user->isGuest){
	                        echo CHtml::ajaxLink(
                                  'Antwort schreiben',
                                  array('books/showNewAnswerForm','id'=>$model->id, 'belongsTo'=>$comment->id),
                                  array(
	                                    'success'=>'js:function(data){
                    						$("#newAnswer'.$comment->id.'").children(".answerForm").detach();
	                                    	$("#newAnswer'.$comment->id.'").append(data);
										}'
                                  ), 
                                  array('id' => 'answer'.uniqid())
                              );
	                    }
	                ?>
                </div> 
    <?php endforeach; ?>

                <!-- content pull block -->
                <div class="row">
                    <p class="content-pull col-xs-12 col-sm-12 col-md-12">
                        <a href="#">Weitere Kommentare laden <span class="glyphicon glyphicon-chevron-down"></span></a>
                    </p>
                </div>
            </div>
            
            <!-- options -->
            <div class="col-md-2 dropdown-meta text-align-right">
            	<?php if($model->author != Yii::app()->user->id && !YII::app()->user->isGuest):?>
 					<p>
					<?php if($model->author!=YII::app()->user->id) : ?>
					<?= CHtml::ajaxLink(
						//gucken ob das buch bereits favorisiesrt wurde
                        '<span class="book-profile-option glyphicon glyphicon-bookmark"></span>'.(BooksFavorites::model()->findByAttributes(array('users_id'=>YII::app()->user->id,'books_id'=>$model->id))?'Entfavorisieren ':'Favorisieren '),
					    array('ajax/favoriseBook'),
					    array(
					    	'type'=>'POST',
					    	'data'=>array('book'=>$model->id),
					    	'success'=>'js:function(data){
						        $("#bookFavButton").text(data);
						        $("#bookFavButton").prepend(\'<span class="book-profile-option glyphicon glyphicon-bookmark"></span>\');
						    }',
						),
						array(
							'id'=>'bookFavButton'
						)
					); endif; ?>
					</p>
 					<p>
					<?= CHtml::ajaxLink(
						//gucken ob das buch bereits favorisiesrt wurde
					    '<span class="book-profile-option glyphicon glyphicon-star"></span>'.(Subscription::model()->findByAttributes(array('subscriber_id'=>YII::app()->user->id,'subscripted_id'=>$model->author))?'Deabonnieren ':'Abonnieren '),
					    array('ajax/Subscribe'),
					    array(
					    	'type'=>'POST',
					    	'data'=>array('subsripted'=>$model->author),
					    	'success'=>'js:function(data){
						        $("#SubButton").text(data);
								$("#SubButton").prepend(\'<span class="book-profile-option glyphicon glyphicon-star"></span>\');
						    }',
						),
						array(
							'id'=>'SubButton'
						)
					);?>
					</p>
				<?php endif;?>
                <p><a class="pluginShareButtonLink" href="/sharer.php?app_id=684989361538190&amp;sdk=joey&amp;u=http%3A%2F%2Fpapyrus-project.noip.me%2Fbooks%2Ffiles%2F<?=$model->id?>&amp;display=popup&amp;ref=plugin" target="_blank" id="u_0_1"><span style="padding-left: 19px;" class="uiIconText"><img class="img" src="https://fbstatic-a.akamaihd.net/rsrc.php/v2/yQ/r/7GFXgco-uzw.png" alt="" style="top: 0px;" width="14" height="14">Share</span></a></p>
            </div>    
        </div>
    </div>
</section>