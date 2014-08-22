<script>
	var page=1;
	function clickMessage () {
	    var id = $(this).attr('value');
	    $.ajax({
	    	url:"<?=YII::app()->createAbsoluteUrl('user/message')?>/"+id
	    }).done(function(data){
	    	$('#message').children().detach();
	    	$('#message').append(data);
	    })
	};
</script>
<section id="messaging">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="row">
                    
                    <h2 class="messaging-heading">Postfach</h2>
                    
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="active">
                        	<?= 
	                        	CHtml::ajaxLink('<span class="glyphicon glyphicon-import"></span> Posteingang <span class="badge">'.$countIn.'</span>',
	                        		YII::app()->createAbsoluteUrl('user/listPmR/'.YII::app()->user->id),
	                        		array(
										'update'=>'#messageTable',
										'success'=>'js:function(data){
											$(".nav-tabs").children("li").removeClass("active");
											$("#getReceived").parent("li").addClass("active");
											$("#messageTable").children().detach();
											$("#messageTable").append(data);
											page = 1;
											count = $("#messageTable").children().size();
											if(count == 1)
												append = "<div>"+1+"-"+count+"</div>";
											else {
												append = "<div>"+0+"</div>";
											}
											$("#messageCounter").children().detach();
											$("#messageCounter").append(append);
										}'
									),
									array(
										'id'=>'getReceived',
									)
							)?> 
                    	</li>
                        <li>
                        	<?= 
	                        	CHtml::ajaxLink('<span class="glyphicon glyphicon-import"></span> Postausgang <span class="badge">'.$countOut.'</span>',
	                        		YII::app()->createAbsoluteUrl('user/listPmS/'.YII::app()->user->id),
	                        		array(
										'update'=>'#messageTable',
										'success'=>'js:function(data){
											$(".nav-tabs").children("li").removeClass("active");
											$("#getSend").parent("li").addClass("active");
											$("#messageTable").children().detach();
											$("#messageTable").append(data);
											page = 1;
											count = $("#messageTable").children().size();
											if(count == 1)
												append = "<div>"+1+"-"+count+"</div>";
											else {
												append = "<div>"+0+"</div>";
											}
											$("#messageCounter").children().detach();
											$("#messageCounter").append(append);
										}',
									),
									array(
										'id'=>'getSend'
									)
							)?> 
                    	</li>
                    </ul>

                    <table class="table table" id="table-mailbox">
                        <tr>
                            <th>Benutzer</th>
                            <th>Betreff</th>
                            <th>Datum</th>
                            <th></th>
                        </tr>
                        <tbody id="messageTable">
	                       <?=$messages?>
                        </tbody>
                        <!-- colspan -->
                        <tr>
                            <td colspan="4"></td>
                        </tr>    
                    </table> 
                    
                </div>
            </div>
            <?=
            CHtml::ajaxLink('
            	<span class="glyphicon glyphicon-chevron-left"></span>',
            	YII::app()->createAbsoluteUrl('user/listPmM/'.YII::app()->user->id.'/0'),
            	array(
					'update'=>'#messageTable',
					'success'=>'js:function(data,status,header){
						if(header.status==200){
							--page;
							$("#messageTable").children().detach();
							$("#messageTable").append(data);
							$("#messageCounter").children().detach();
							$("#messageCounter").append("<div>"+
								((page-1)*5+1)+"-"+((page-1)*5+$("#messageTable").children().size())+
								"</div>");
						}
					}'
				),
				array(
					'class'=>'btn btn-b pull-left'
				)

			)?>
            <?=
            CHtml::ajaxLink('
            	<span class="glyphicon glyphicon-chevron-right"></span>',
            	YII::app()->createAbsoluteUrl('user/listPmM/'.YII::app()->user->id.'/1'),
            	array(
					'update'=>'#messageTable',
					'success'=>'js:function(data,status,header){
						if(header.status==200){
							++page;
							$("#messageTable").children().detach();
							$("#messageTable").append(data);
							$("#messageCounter").children().detach();
							$("#messageCounter").append("<div>"+
								((page-1)*5+1)+"-"+((page-1)*5+$("#messageTable").children().size())+
								"</div>");
						}
					}'
				),
				array(
					'class'=>'btn btn-b pull-right'
				)

			)?>
            <div id="messageCounter" class="text-align-center"><div>1-<?=$countIn>5?'5':$countIn?></div></div>
            <!-- message (reload with AJAX)-->
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div id="message" class="row">
                    
                </div>
            </div>
        </div>
    </div>
</section>