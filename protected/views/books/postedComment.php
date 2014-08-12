
<br />
<div id="<?= $comment->id; ?>" class="row">
	<?= $comment->getAuthor($comment->users_id); ?><br/>
    <?= Yii::time(time()); ?><br/>
    <?= $comment->text; ?><br/>
    <div class='edit'>
        <?php 
        if($comment->users_id == Yii::app()->user->id){
        echo CHtml::ajaxLink(
                                'Edit',
                                array('books/showEditCommentForm', 'id'=>$comment->id),
                                array(
                                    'update'=>'#'.$comment->id,
                                ), 
                                array('id' => 'edit'.uniqid())
                            ) . ' ';
        echo CHtml::ajaxLink(
                                'Delete',
                                array('books/deleteComment', 'id'=>$comment->id),
                                array(
                                    'update'=>'#com',
                                ), 
                                array('id' => 'delete'.uniqid())
                                      );
        }
        ?>
    </div>

</div>
