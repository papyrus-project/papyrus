<?php
	$this->pageTitle = Yii::app()->name;
?>

<table>

	<?php foreach($posts as $post): ?>
		<tr>
			<td><a href="index.php?r=site/bookRead&id=<?php echo $post->id ;?>"><?php echo $post->titel; ?></a></td>
		</tr>
	<?php endforeach; ?>
</table>
