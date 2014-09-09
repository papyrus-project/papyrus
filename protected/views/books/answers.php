<?php
foreach($comments as $comment):?>

<div id="<?= $comment->id; ?>">
    <div class="comment-commentary-wrapper">
        <div class="row">
            <div class="col-xs-3 col-sm-3 col-md-3 hidden-xs text-align-right">
                <span class="text-muted glyphicon glyphicon-chevron-up"></span>
            </div>
            <div class="col-xs-8 col-sm-8 col-md-8 no-padding comment-frame">
                <div class="row">
                    <h3><a href="<?=YII::app()->createAbsoluteUrl('user/profile/'.$comment->users_id)?>"><?= $comment->getAuthor($comment->users_id); ?></a></h3>
                    <p class="comment-date text-muted">
                        geschrieben am <?= Yii::time($comment->date); ?>
                    </p>
                </div>
                <div id="text<?= $comment->id; ?>" class="row">
                    <p class="comment-text">
                        <?= $comment->text; ?>
                    </p>
                </div>
            </div>
            <!-- meta dropdown menu -->
            <div class="col-xs-1 col-sm-1 col-md-1 dropdown-meta text-align-right">
                <!-- dropdown menus -->
                
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
                                    'update'=>'#text'.$comment->id,
                                ), 
                                array('id' => 'edit'.uniqid(), 'role'=>'menuitem', 'tabindex'=>'-1')
                            );?>
                            </li>
                            <li role="presentation">
                                <?= CHtml::ajaxLink(
                                'Entfernen',
                                array('books/deleteComment', 'id'=>$comment->id),
                                array(
                                    'update'=>'#com',
                                ), 
                                array('id' => 'delete'.uniqid())
                            );?>
                            </li>
                            <?php endif; ?>
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="mailto:info@bookworks.noip.me">Verst&ouml;&szlig;e Melden</a></li>
                        </ul>
                    </div>
                </p>
            </div>
        </div>
    </div>
</div>

<?php endforeach; ?>
