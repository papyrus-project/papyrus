<?php
	$this->pageTitle=Yii::app()->name.' - '.$model->title;
?>
<h1>files</h1>
<div>Titel: <?= $model->title ?></div>
<div>von: <a href="<?= YII::app()->createAbsoluteUrl('user/profile/'.$model->author0->id) ?>"><?= $author ?></a></div>
<div>Gattung: <?= $type ?></div>
<div>Genre: <?= $genres ?></div>
<div>Sprachen: <?= $lang ?></div>
<div>Umfang: <?= $model->words ?></div>
<div>Alter: <?= $model->age_restriction ?></div>
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
<div>Beschreibung: <br /><?= $model->description ?></div>
<div class="fb-share-button" data-href="http://papyrus-project.noip.me/books/files/<?=$model->id?>" data-type="icon"></div>
<br />Statistik<br />
<div>Erstellt am: <?= YII::time($model->created) ?></div>
<div>Favorisiert: <?= $model->favorite_count ?></div>
<div>Downloads: <?= $model->downloads ?></div>
<div>Views: <?= $model->views ?></div>
<div>Cover Artist: <?= $model->cover_artist ?></div>
<?php if(YII::app()->user->isGuest):?>
	<?= CHtml::link(
		"favorisieren",
		array('users/login'),
		array(
			'class'=>'btn'
		)
	);?>
<?php endif;?>
<?php if($model->author != Yii::app()->user->id && !YII::app()->user->isGuest):?>
	<?= CHtml::ajaxButton(
		//gucken ob das buch bereits favorisiesrt wurde
	    BooksFavorites::model()->findByAttributes(array('users_id'=>YII::app()->user->id,'books_id'=>$model->id))?'unfavorise':'favorise',
	    array('ajax/favoriseBook'),
	    array(
	    	'type'=>'POST',
	    	'data'=>array('book'=>$model->id),
	    	'success'=>'js:function(data){
				console.log("success");
		        $(".bookFavButton").val(data);
		    }',
		),
		array(
		    'class'=>'btn bookFavButton',
		)
	);?>
<?php endif; ?>
<?php if($model->author == Yii::app()->user->id): ?>
	<a href="<?php $url=Yii::app()->createUrl('books/edit', array('id'=>$model->id)); echo ($url);?>">edit</a><br /><br />
<?php endif; ?>
<br />
<?= CHtml::link(
	'download pdf',
	array('books/download/'.$_GET['id'].'.1'),
	array('class'=>'btn')
	
);?><br />
<?= CHtml::link(
	'download epub',
	array('books/download/'.$_GET['id'].'.2'),
	array('class'=>'btn')
	
);?>
<br />
<?= CHtml::link(
	'download mobi',
	array('books/download/'.$_GET['id'].'.3'),
	array('class'=>'btn')
	
);?><br />

<div id="newComment">
    <?php if(!Yii::app()->user->isGuest):
    //echo CHtml::ajaxLink(
    //    'neuer Kommentar',
    //    array('books/showNewCommentForm', 'id'=>$model->id),
    //    array(
    //        'update'=>'#newComment',
    //    ), 
    //    array('id' => uniqid())
    //);
              echo $form;
endif; ?>
</div>
<div id='comments'>
    <h4>Kommentare</h4>
    
    <?php foreach($comments as $comment):?>
    <div id="Div1" class="row">
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
                        <ul class="dropdown-menu" role="menu" aria-labelledby="dropdown-share" style="text-align: left;">
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
                        <ul class="dropdown-menu" role="menu" aria-labelledby="dropdown-config" style="text-align: left;">
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
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Verst??e Melden</a></li>
                        </ul>
                    </div>
                </p>
            </div>
        </div>
    </div>
</div>


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
    <?php endforeach; ?>
</div>

<div id="com"></div>
