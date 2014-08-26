<tr class="msg" id="message-<?=$message->id?>" value="<?=$message->id?>">
	<td><?= $got?$message->sender0->name:$message->receiver0->name?> <?= $got?'('.$message->sender0->id0->user_name.')':''?></td>
	<td><?= $got&&!$message->read?'<span class="label label-msg">Neu</span> ':''?><?=$message->subject?></td>
	<td class="text-muted"><?=date('d.m.Y',$message->created)?></td>
	<td class="text-align-right">
	    <?php if($got):?>
	    	<a href="<?=YII::app()->createAbsoluteUrl('user/sendPm/'.$message->sender)?>">Antwort senden</a>
	    	<a id="message-del-<?=$message->id?>" value="<?=$message->id?>" href="javaScript:void(0);"><span class="glyphicon glyphicon-trash"></span></a>
	    	
    	<?php endif;?>
		<script>
			$("#message-del-<?=$message->id?>").click(clickMessageDel);
			$("#message-<?=$message->id?>").click(clickMessage);
		</script>
	</td>  
</tr>
		
