<div id='books'>
<?php foreach($books as $book) :?>
	<a><?= $book->title ?></a><br/>
<?php endforeach ?>
</div>
<div id="request">
    <?= CHtml::ajaxLink(
        'moa Books',
        array('books/moreFeed'),
        array(
            'success'=>'js:function(data, status, header){
            	if(header.status == 200)
            		$("#books").append(data);
				else if(header.status == 204){
	            	$("#request").children().detach();
	            	$("#request").append("Es wurden keine weiteren Buecher gefunden");
				}
            }',
        )
    );?>
</div>