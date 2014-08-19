<div id="books">
	<?= $books ?>
</div>
<!-- content pull block -->
<p class="content-pull">
    <?= CHtml::ajaxLink(
        'moa Books <span class="glyphicon glyphicon-chevron-down"></span>',
        array('user/_moreSubs'),
        array(
        	'data'=>array(
        		'id'=>$userId
			),
			'type'=>'post',
            'success'=>'js:function(data, status, header){
            	if(header.status == 200)
            		$("#books").append(data);
				else if(header.status == 204){
	            	$(".content-pull").children().detach();
	            	$(".content-pull").append("Es wurden keine weiteren Buecher gefunden");
				}
            }',
        ), 
    	array('id' => 'moreSubs'.uniqid())
    );?>
</p>