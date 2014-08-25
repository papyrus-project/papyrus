<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-xs-10 col-sm-10 col-md-10">
                <b><span class="glyphicon glyphicon-envelope padding-right-5 text-muted"></span> <?=$message->subject?></b>
                <?php if(YII::app()->user->id==$message->receiver):?>
                	<p id="msg-from">von <a href="<?=YII::app()->createAbsoluteUrl('user/profile/'.$message->sender)?>"><?=$message->sender0->name?></a></p>
            	<?php else:?>
                	<p id="msg-from">an <a href="<?=YII::app()->createAbsoluteUrl('user/profile/'.$message->receiver)?>"><?=$message->receiver0->name?></a></p>
        		<?php endif;?>
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2 text-align-right">
                <?=date('d.m.Y',$message->created)?>
            </div>
        </div>
    </div>
    <div class="panel-body">
    	<?=nl2br($message->message)?>
    </div>
</div>
<div class="row">
    <div class="col-md-12 text-align-right">
    	<?php if(YII::app()->user->id==$message->receiver):?>
        	<p><a href="<?=YII::app()->createAbsoluteUrl('user/sendPm/'.$message->sender)?>" class="btn btn-b">Antwort schreiben <span class="glyphicon glyphicon-pencil"></span></a></p>
    	<?php endif;?>
    </div>
</div>