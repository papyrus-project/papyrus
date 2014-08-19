<!-- user profile section -->
	<section id="user-profile">
		<div class="container">
			<div class="row">
				
				<div class="col-md-3">
					<?php 
						//coverbild anzeigen groesse 200x150, seitenverhaeltnis bleibt erhalten
						
							$this->widget('ext.SAImageDisplayer', array(
								'image' => 'l',
								'defaultImage' => 'default.jpg',
								'title' => 'user',
								'group' => 'user',
								'size' => 'big',
								'class' => 'img-responsive user-portrait',
								'id' => '',
						)); 
						?>
					<?php if($model->id == YII::app()->user->id):?>
						<p class="user-profile-edit">
							<a href="<?= YII::app()->createAbsoluteUrl('user/edit') ?>"><span class="glyphicon glyphicon-cog"></span> Profil bearbeiten</a>
						</p>
					<?php endif;?>
					<p class="user-profile-name"><?= $model->name ?></p>
					<p class="user-profile-alias text-muted"><?= $model->id0->user_name ?></p>
					<ul class="col-xs-6 col-sm-6 col-md-6">
						<li class="text-muted">Letzte Aktivität</li>
						<li class="text-muted">Mitlied Seit</li>
						<br>
						<li class="text-muted"><span class="glyphicon glyphicon-star"></span> Abonnements</li>
						<li class="text-muted"><span class="glyphicon glyphicon-bookmark"></span> Favorisiert</li>
						<li class="text-muted"><span class="glyphicon glyphicon-save"></span> Heruntergeladen</li>
						<br>
						<li class="text-muted">Geschlecht</li>
						<li class="text-muted">Geburtstag</li>
						<li class="text-muted">Wohnort</li>
						<?= $model->homepage?'<li class="text-muted">Homepage</li>':''?>
					</ul>
					<ul class="col-xs-6 col-sm-6 col-md-6">
						<li class="text-meta"><?= date('d,m,Y',$model->id0->date_of_last_access)?></li>
						<li class="text-meta"><?= date('d,m,Y',$model->id0->date_of_creation)?></li>
						<br>
						<li class="text-meta"><?= $subscribtions?></li>
						<li class="text-meta"><?= $favorits?></li>
						<li class="text-meta"><?= $downloads?></li>
						<br>
						<li class="text-meta"><?= $sexes[$model->sex]?></li>
						<li class="text-meta"><?= $model->birthday?$model->birthday:'Keine Angabe' ?></li>
						<li class="text-meta"><?= $model->location?$model->location:'Keine Angabe'?></li>
						<li class="text-meta"><a class="link-domain" href="#"><?= $model->homepage ?></a></li>
					</ul>
				</div>
				
				<div class="col-md-9">
					<ul class="nav nav-tabs" role="tablist">
						<li class="active"><a href="#">Meine Werke <span class="badge"><?= Books::model()->countByAttributes(array('author'=>$model->id))?></span></a></li>
						<?php if($model->id == YII::app()->user->id):?>
						<li><a href="#">Favoriten <span class="badge"><?= BooksFavorites::model()->countByAttributes(array('users_id'=>$model->id))?></span></a></li>
						<li><a href="#">Abonnements <span class="badge"><?= Subscription::model()->countByAttributes(array('subscriber_id'=>$model->id))?></span></a></li>
						<?php endif;?>
					</ul>
					
					
					<div id="books">
						<?php foreach($books as $book):?>
						<!-- book thumb -->
						<div class="row book-thumb">
							<div class="col-md-2">
								<a href="<?=YII::app()->createAbsoluteUrl('books/files/'.$book->id)?>">
							    <?php
			                		$this->widget('ext.SAImageDisplayer', array(
									'image' => $book->id.'.'.$book->extension,	
									'defaultImage'=> 'default.jpg',
									'title' => $book->title,
									'size' => 'thumb',
									'group'=> 'cover',
									'class' => 'book-thumb-cover',
									'id' => '',
								));?>
								</a>
							</div>
							<div class="col-md-9">
								<h3 class="text-muted"><?= $book->author0->name?></h3>
								<h2><a href="<?=YII::app()->createAbsoluteUrl('books/files/'.$book->id)?>"><?=$book->title?></a> 
									<?php if($book->wip):?>
										<span class="label book-thumb-label">WIP</span>
									<?php endif;?>
									<?php if($book->status == 0):?>
										<span class="label book-thumb-label" style="background:#8e5655">In Bearbeitung</span>
									<?php endif;?>
								</h2>
								<p>
									<span class="label label-default"><?=$book->booktype->type?></span>
									<?php foreach($book->genres as $genre):?>
										<span class="label label-default"><?=$genre->genreName->genre?></span>
									<?php endforeach;?>
									<span class="label label-default"><?= $book->age_restriction?'Ab 12 Jahren':'Ohne Alters begrenzung'?></span>
									<span class="label label-default"><?= $book->language->language?></span>
									
								</p>
								
								<p>
									<span class="glyphicon glyphicon-star"></span>
									<span class="glyphicon glyphicon-star"></span>
									<span class="glyphicon glyphicon-star"></span>
									<span class="glyphicon glyphicon-star-empty"></span>
									<span class="glyphicon glyphicon-star-empty"></span>
								</p>
								
								<p class="book-thumb-txt">
									<?= substr($book->description,0,300)?> <a href="<?=YII::app()->createAbsoluteUrl('books/files/'.$book->id)?>"> ... weiterlesen</a>
								</p>
								
								<ul class="book-thumb-meta">
									<li class="text-meta"><span class="glyphicon glyphicon-eye-open"></span> <?=$book->views?></li>
									<li class="text-meta"><span class="glyphicon glyphicon-bookmark"></span> <?=BooksFavorites::model()->countByAttributes(array('books_id'=>$book->id))?></li>
									<li class="text-meta"><span class="glyphicon glyphicon-comment"></span> <?=Comments::model()->countByAttributes(array('ref_id'=>$book->id))?></li>
									<li class="text-meta"><span class="glyphicon glyphicon-save"></span> <?=$book->downloads?></li>
								</ul>
	
							</div>
							<!-- dropdown menus -->
							<div class="col-md-1 dropdown-meta" style="text-align:right;">
								<p>
									<div class="dropdown">
										<a href="#" class="dropdown-toggle" type="button" data-toggle="dropdown"><span class="glyphicon glyphicon-share"></span></a>
										<ul class="dropdown-menu" role="menu" aria-labelledby="dropdown-share" style="text-align:right;">
											<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Auf Facebook teilen</a></li>
										</ul>
									</div>
								</p>
								<p>
									<div class="dropdown">
										<a href="#" class="dropdown-toggle" type="button" data-toggle="dropdown"><span class="glyphicon glyphicon-cog"></span></a>
										<ul class="dropdown-menu" role="menu" aria-labelledby="dropdown-config" style="text-align:left;">
											<?php if($model->id == YII::app()->user->id):?>
											<li role="presentation"><a role="menuitem" tabindex="-1" href="<?=YII::app()->createAbsoluteUrl('books/edit/'.$book->id)?>">Bearbeiten</a></li>
											<li role="presentation"><a role="menuitem" tabindex="-1" href="<?=YII::app()->createAbsoluteUrl('books/del/'.$book->id)?>">Entfernen</a></li>
											<?php endif;?>
											<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Verstöße Melden</a></li>
									</ul>
									</div>
								</p>
							</div>    
						</div><!-- /.book-thumb -->
						<?php endforeach; ?>
					</div>
					<!-- content pull block -->
					<p class="content-pull">
					    <?= CHtml::ajaxLink(
					        'moa Books <span class="glyphicon glyphicon-chevron-down"></span>',
					        array('books/moreFeed'),
					        array(
					            'success'=>'js:function(data, status, header){
					            	if(header.status == 200)
					            		$("#books").append(data);
									else if(header.status == 204){
						            	$(".content-pull").children().detach();
						            	$(".content-pull").append("Es wurden keine weiteren Buecher gefunden");
									}
					            }',
					        )
					    );?>
					</p>

				</div>
			</div>
		</div>
	</section>