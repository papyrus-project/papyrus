<div id="<?= $comment->id; ?>" class="row">
    <div class="comment-wrapper">
        <div class="row">
            <div class="col-xs-2 col-sm-2 col-md-2 hidden-xs">
                <!--<img class="commentary-portrait" src="../../upload/cover/thumb/default.jpg" alt="user-portrait" />-->
                <?php 
                    $user = UserData::model()->findByPk($model->user_id);
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
                        geschrieben am <?= Yii::time(time()); ?>
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

