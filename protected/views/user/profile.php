<!-- user profile section -->
	<section id="user-profile">
		<div class="container">
			<div class="row">
				
				<div class="col-md-3">
					<?php 
						//coverbild anzeigen groesse 200x150, seitenverhaeltnis bleibt erhalten
						
							$this->widget('ext.SAImageDisplayer', array(
								'image' => $model->id . '.' . $model->extension,
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
							<a href="<?= YII::app()->createAbsoluteUrl('user/edit') ?>"><span class="glyphicon glyphicon-cog"></span>Profil bearbeiten</a>
						</p>
					<?php else: if(!YII::app()->user->isGuest): ?>
						<p>
							<a href="<?= YII::app()->createAbsoluteUrl('user/sendPm/'.$model->id) ?>"><span class="glyphicon glyphicon-envelope"></span>Nachricht senden</a>
						</p>
						<p class="user-profile-edit">
							<?= CHtml::ajaxLink(
								//gucken ob das buch bereits favorisiesrt wurde
							    '<span class="book-profile-option glyphicon glyphicon-star"></span>'.(Subscription::model()->findByAttributes(array('subscriber_id'=>YII::app()->user->id,'subscripted_id'=>$model->id))?'Deabonnieren ':'Abonnieren '),
							    array('ajax/Subscribe'),
							    array(
							    	'type'=>'POST',
							    	'data'=>array('subsripted'=>$model->id),
							    	'success'=>'js:function(data){
								        $("#SubButton").text(data);
										$("#SubButton").prepend(\'<span class="book-profile-option glyphicon glyphicon-star"></span>\');
								    }',
								),
								array(
									'id'=>'SubButton',
									'class'=>'book-profile-option'
								)
							);?>
						</p>
					<?php endif;endif;?>
					<p class="user-profile-name"><?= $model->name ?></p>
					<p class="user-profile-alias text-muted"><?= $model->id0->user_name ?></p>
					<p class="user-profile-description"><?= nl2br($model->description) ?></p>					<ul class="col-xs-6 col-sm-6 col-md-6">

						<li class="text-muted">Letzte Aktivität</li>
						<li class="text-muted">Mitglied seit</li>
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
						<li class="text-meta"><?= date('d.m.Y',$model->id0->date_of_last_access)?></li>
						<li class="text-meta"><?= date('d.m.Y',$model->id0->date_of_creation)?></li>
						<br>
						<li class="text-meta"><?= $subscribtions?></li>
						<li class="text-meta"><?= $favorits?></li>
						<li class="text-meta"><?= $downloads?></li>
						<br>
						<li class="text-meta"><?= isset($sexes[$model->sex])?$sexes[$model->sex]:'error'?></li>
						<li class="text-meta"><?= $model->birthday?$model->birthday:'Keine Angabe' ?></li>
						<li class="text-meta"><?= $model->location?$model->location:'Keine Angabe'?></li>
						<li class="text-meta"><?= $model->homepage ?></li>
					</ul>
				</div>
				
				<div class="col-md-9">
					<ul class="nav nav-tabs" role="tablist">
						<li class="active">
							<?= CHtml::ajaxlink(
								'Meine Werke <span class="badge">'.Books::model()->countByAttributes(array('author'=>$model->id,'status'=>1,'base_id'=>0)).'</span>',
								array('user/_own/'.$model->id),
								array(
									'success'=>'js:function(data, status, header){
										$(".nav-tabs").children("li").removeClass("active");
										$("#tab-own").parent("li").addClass("active");
					            		$("#profile-content").children().detach();
						            	if(header.status == 200)
						            		$("#profile-content").append(data);
									}'
								), 
                                	array('id' => 'tab-own')
							);?>
						</li>
						<?php if($model->id == YII::app()->user->id):?>
						<li>
							<?= CHtml::ajaxlink(
								'Favoriten <span class="badge">'.BooksFavorites::model()->countByAttributes(array('users_id'=>$model->id)).'</span>',
								array('user/_favorites/'.$model->id),
								array(
									'success'=>'js:function(data, status, header){
										$(".nav-tabs").children("li").removeClass("active");
										$("#tab-favorites").parent("li").addClass("active");
					            		$("#profile-content").children().detach();
						            	if(header.status == 200)
						            		$("#profile-content").append(data);										
									}'
								), 
                            	array('id' => 'tab-favorites')
							);?>
						</li>
						<li>
							<?= CHtml::ajaxlink(
								'Abonnements <span class="badge">'.Subscription::model()->countByAttributes(array('subscriber_id'=>$model->id)).'</span>',
								array('user/_subs/'.$model->id),
								array(
									'success'=>'js:function(data, status, header){
										$(".nav-tabs").children("li").removeClass("active");
										$("#tab-subs").parent("li").addClass("active");
					            		$("#profile-content").children().detach();
						            	if(header.status == 200)
						            		$("#profile-content").append(data);										
									}'
								), 
                            	array('id' => 'tab-subs')
							);?>
						</li>
						<?php endif;?>
					</ul>
					<div id='profile-content'>
						<?=$booksRender?>
					</div>
				</div>
			</div>
		</div>
	</section>