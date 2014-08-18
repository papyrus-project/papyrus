<table>
<tablebody>
<?php foreach ($messages as $message) :?>
	<tr>
		<td> <?= $message->sender0->name?></td>
		<td> <a href="<?= YII::app()->createAbsoluteUrl('user/Message/'.$message->id)?>"><?= $message->subject?></a></td>
		<td> <?= YII::time($message->created) ?> </td>
	</tr>
<?php endforeach ?>
</tablebody>
</table>