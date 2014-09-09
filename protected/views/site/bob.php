<?php 
Yii::app()->clientScript->registerScript('search',
    "var ajaxUpdateTimeout;
    var ajaxRequest;
    $('input#srch-term').keyup(function(){
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
        var genre=[];
        var lang=[];
        var type=[];
        var age=[];
        var wip=0;
        var nsfw=0;
    category = $('.filterItem').map(function() {
        if(this.checked)
            switch(this.name) {
                case 'genre[]':
                    genre.push(this.value);
                    break;
                case 'type[]':
                    type.push(this.value);
                    break;
                case 'age[]':
                    age.push(this.value);
                    break;
                case 'lang[]':
                    lang.push(this.value);
                    break;
                case 'wip':
                    wip = this.value;
                    break;
                case 'nsfw':
                    nsfw = this.value;
                    break;
                default:
                    console.log('meep');
            }
            return '&'+this.name+'='+this.value;  
        
    }).get();
    
    var getParam = '&wip=' + wip + '&nsfw=' + nsfw;
    
    if(genre.length > 0)
        for (index = 0; index < genre.length; ++index) {
            getParam = getParam + '&genre[]=' + genre[index];
        }    
    else
            getParam = getParam + '&genre[]=';
    if(type.length > 0)
        for (index = 0; index < type.length; ++index) {
            getParam = getParam + '&type[]=' + type[index];
        }
    else
            getParam = getParam + '&type[]=';
    if(lang.length > 0)
        for (index = 0; index < lang.length; ++index) {
            getParam = getParam + '&lang[]=' + lang[index];
        }
    else
            getParam = getParam + '&lang[]=';
    if(age.length > 0)
        for (index = 0; index < age.length; ++index) {
            getParam = getParam + '&age[]=' + age[index];
        }
    else
            getParam = getParam + '&age[]=';
        
    console.log(getParam);
    $.fn.yiiListView.update(
        'ajaxListView',
        {data: getParam}
    ); 
});"
);
?>
<section id="user-profile">
    <div class="container">
        <div class="row">
            <form>
                <div class="col-md-3">
                    <h3 class="meta-list-heading-big text-muted">Zeige</h3>

                    <ul>
                        <li class="meta-list-item">
                            <input type="checkbox" class="filterItem" id="nsfw" value="1" name="nsfw">
                            Expliziter Inhalt*</li>
                        <li class="meta-list-item">
                            <input type="checkbox" class="filterItem" id="wip" value="1" name="wip">
                            WIP Inhalte</li>
                    </ul>

                    <h3 class="meta-list-heading-big text-muted">Filtern nach</h3>
                     <p class="meta-list-heading">Genre</p>
                    <ul>
                        <?php foreach(Genres::model()->findAll() as $genre): ?>
                        <li class="meta-list-item">
                            <input type="checkbox" class="filterItem" id="genre<?= $genre->id ?>" value="<?= $genre->id ?>" name="genre[]">
                            <?= $genre->genre ?></li>
                        <?php endforeach ?>
                    </ul> 
                    <p class="meta-list-heading">Literarische Gattung</p>
                    <ul>
                        <?php foreach(Booktype::model()->findAll() as $type): ?>
                        <li class="meta-list-item">
                            <input type="checkbox" class="filterItem" id="type<?= $type->id ?>" value="<?= $type->id ?>" name="type[]">
                            <?= $type->type ?></li>
                        <?php endforeach ?>
                    </ul>
                    <p class="meta-list-heading">Altersempfehlung</p>
                    <ul>
                        <li class="meta-list-item">
                            <input type="checkbox" class="filterItem" id="age0" value="0" name="age[]">
                            Keine</li>
                        <li class="meta-list-item">
                            <input type="checkbox" class="filterItem" id="age6" value="6" name="age[]">
                            Ab 6</li>
                        <li class="meta-list-item">
                            <input type="checkbox" class="filterItem" id="age12" value="12" name="age[]">
                            Ab 12</li>
                        <li class="meta-list-item">
                            <input type="checkbox" class="filterItem" id="age16" value="16" name="age[]">
                            Ab 16</li>
                        <li class="meta-list-item">
                            <input type="checkbox" class="filterItem" id="age18" value="18" name="age[]">
                            Ab 18+</li>
                    </ul>
                    <p class="meta-list-heading">Sprachen</p>
                    <ul>
                        <?php foreach(Languanges::model()->findAll() as $language): ?>
                        <li class="meta-list-item">
                            <input type="checkbox" class="filterItem" id="language<?= $language->id ?>" value="<?= $language->id ?>" name="lang[]">
                            <?= $language->language ?></li>
                        <?php endforeach ?>
                    </ul>
                </div>
            </form>

            <div class="col-md-9">
                <?php if(isset($dataProvider)){
                          $this->widget('zii.widgets.CListView', array(
                              'dataProvider'=>$dataProvider,
                              'itemView'=>'application.views.books._BookPreview',
                              'sortableAttributes'=>array(
                                  'title'=>'Titel',
                                  'id'=>'Datum',
                              ),
                              'id'=>'ajaxListView',
                              'pagerCssClass' => 'pagination',
                              'pager'=> array(  'cssFile'=>Yii::app()->request->baseUrl.'/css/pager.css', 
                                                'header'=>'',
                                                'prevPageLabel' => '<span class=" glyphicon glyphicon-chevron-left" />',
                                                'nextPageLabel' => '<span class=" glyphicon glyphicon-chevron-right" />',
                                                'hiddenPageCssClass'=>'',
                                                ),
                              'summaryCssClass' => 'col-md-6 pull-left positionL',
                              'sorterCssClass' => 'col-md-6 pull-right positionR',
                              'itemsCssClass' => 'row',
                          ));
                      } ?>
            </div>
        </div>
    </div>
</section>
