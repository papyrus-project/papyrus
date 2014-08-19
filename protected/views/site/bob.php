
<?php 
Yii::app()->clientScript->registerScript('search',
    "var ajaxUpdateTimeout;
    var ajaxRequest;
    $('input#q').keyup(function(){
        ajaxRequest = $(this).serialize();
        clearTimeout(ajaxUpdateTimeout);
        ajaxUpdateTimeout = setTimeout(function () {
            $.fn.yiiListView.update(
// this is the id of the CListView
                'ajaxListView',
                {data: ajaxRequest}
            )
        },
// this is the delay
        300);
    });"
);
Yii::app()->clientScript->registerScript('filter',
        "$('.filterItem').change(function(){
    category = $('.filterItem').serialize();
    $.fn.yiiListView.update(
        'ajaxListView',
        {data: category}
    );
    //alert(category);
});"
);
?>
<div class="row">
<form>
    <div class="col-md-3">
        <h3 class="meta-list-heading-big text-muted">Zeige</h3>
                        
        <ul>
            <li class="meta-list-item"><input type="checkbox" class="filterItem" id="r18" value="1" name="mature"> Mature Content*</li>
            <li class="meta-list-item"><input type="checkbox" class="filterItem" id="wip" value="1" name="wip"> WIP Inhalte</li>
        </ul>
                        
        <h3 class="meta-list-heading-big text-muted">Filtern nach</h3>
        <p class="meta-list-heading">Genre</p>
        <ul>
		    <?php foreach(Genres::model()->findAll() as $genre): ?>
                <li class="meta-list-item"><input type="checkbox" class="filterItem" id="genre<?= $genre->id ?>" value="<?= $genre->id ?>" name="genre"> <?= $genre->genre ?></li>
            <?php endforeach ?>
        </ul>
        <p class="meta-list-heading">Literarische Gattung</p>
        <ul>
	        <?php foreach(Booktype::model()->findAll() as $type): ?>
            <li class="meta-list-item"><input type="checkbox" class="filterItem" id="type<?= $type->id ?>" value="<?= $type->id ?>" name="type"> <?= $type->type ?></li>
	        <?php endforeach ?>
        </ul>
        <p class="meta-list-heading">Altersempfehlung</p>
        <ul>
            <li class="meta-list-item"><input type="checkbox" class="filterItem" id="age0"  value="0"  name="age"> Keine</li>
            <li class="meta-list-item"><input type="checkbox" class="filterItem" id="age6"  value="6"  name="age"> Ab 6</li>
            <li class="meta-list-item"><input type="checkbox" class="filterItem" id="age12" value="12" name="age"> Ab 12</li>
            <li class="meta-list-item"><input type="checkbox" class="filterItem" id="age16" value="16" name="age"> Ab 16</li>
            <li class="meta-list-item"><input type="checkbox" class="filterItem" id="age18" value="18" name="age"> Ab 18+</li>
        </ul>
        <p class="meta-list-heading">Sprachen</p>
        <ul>
	        <?php foreach(Languanges::model()->findAll() as $language): ?>
            <li class="meta-list-item"><input type="checkbox" class="filterItem" id="language<?= $language->id ?>" value="<?= $language->id ?>" name="lang"> <?= $language->language ?></li>
	        <?php endforeach ?>
        </ul>                        
    </div>
</form>
                    
                    <div class="col-md-9">
                        <?php if(isset($dataProvider)){
    //yii::app()->language = 'de';
    $this->widget('zii.widgets.CListView', array(
        'dataProvider'=>$dataProvider,
        'itemView'=>'application.views.books.bookPreview',   // refers to the partial view named '_post'
        'sortableAttributes'=>array(
            'title'=>'Titel',
            'id'=>'Datum',
        ),
        'id'=>'ajaxListView',
    ));
} ?>
                    </div>
</div>