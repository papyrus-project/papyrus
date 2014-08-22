
	<!-- book thumb -->
	<div class="row book-thumb">
		<div class="col-md-2">
			<a href="<?=YII::app()->createAbsoluteUrl('books/files/'.$data->id)?>">
		    <?php
        		$this->widget('ext.SAImageDisplayer', array(
				'image' => $data->id.'.'.$data->extension,	
				'defaultImage'=> 'default.jpg',
				'title' => $data->title,
				'size' => 'thumb',
				'group'=> 'cover',
				'class' => 'book-thumb-cover',
				'id' => '',
			));?>
			</a>
		</div>
		<div class="col-md-9">
			<h3 class="text-muted"><?= $data->author0->name?></h3>
			<h2><a href="<?=YII::app()->createAbsoluteUrl('books/files/'.$data->id)?>"><?=$data->title?></a> 
				<?php if($data->wip):?>
					<span class="label book-thumb-label">WIP</span>
				<?php endif;?>
				<?php if($data->status == 0):?>
					<span class="label book-thumb-label" style="background:#8e5655">In Bearbeitung</span>
				<?php endif;?>
			</h2>
			<p>
				<span class="label label-default"><?=$data->booktype->type?></span>
				<?php foreach($data->genres as $genre):?>
					<span class="label label-default"><?=$genre->genreName->genre?></span>
				<?php endforeach;?>
				<span class="label label-default"><?= $data->age_restriction?'Ab 12 Jahren':'Ohne Alters begrenzung'?></span>
                <?php if($data->nsfw == 1) :?><span class="label label-default">Expliziter Inhalt</span><?php endif;?>
				<span class="label label-default"><?= $data->language->language?></span>
				
			</p>
			
			<p>
				<input type="hidden" class="rating" data-start="1" data-stop="6" readonly value="<?= $rating->count?round($rating->rating/$rating->count):''?>" />
			</p>
			
			<p class="book-thumb-txt">
				<?= substr($data->description,0,300)?> <a href="<?=YII::app()->createAbsoluteUrl('books/files/'.$data->id)?>"> ... weiterlesen</a>
			</p>
			
			<ul class="book-thumb-meta">
				<li class="text-meta"><span class="glyphicon glyphicon-eye-open"></span> <?=$data->views?></li>
				<li class="text-meta"><span class="glyphicon glyphicon-bookmark"></span> <?=BooksFavorites::model()->countByAttributes(array('books_id'=>$data->id))?></li>
				<li class="text-meta"><span class="glyphicon glyphicon-comment"></span> <?=Comments::model()->countByAttributes(array('ref_id'=>$data->id))?></li>
				<li class="text-meta"><span class="glyphicon glyphicon-save"></span> <?=$data->downloads?></li>
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
				<?php if(isset($showOptions)&&$showOptions==true):?>
				<div class="dropdown">
					<a href="#" class="dropdown-toggle" type="button" data-toggle="dropdown"><span class="glyphicon glyphicon-cog"></span></a>
					<ul class="dropdown-menu" role="menu" aria-labelledby="dropdown-config" style="text-align:left;">
						<?php if($data->author == YII::app()->user->id):?>
						<li role="presentation"><a role="menuitem" tabindex="-1" href="<?=YII::app()->createAbsoluteUrl('books/edit/'.$data->id)?>">Bearbeiten</a></li>
						<li role="presentation"><a role="menuitem" tabindex="-1" href="<?=YII::app()->createAbsoluteUrl('books/del/'.$data->id)?>">Entfernen</a></li>
						<?php endif;?>
						<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Verstöße Melden</a></li>
				</ul>
				</div>
				<?php endif; ?>
			</p>
		</div>    
	</div><!-- /.book-thumb -->
