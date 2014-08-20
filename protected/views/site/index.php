<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name.' - landingpage';
?>

<!-- header -->
<header>
    <div class="container">
        <div class="intro-text">
            <div class="intro-lead-in">Jede Geschichte hat einen Anfang</div>
            <div class="intro-heading"><?=YII::app()->name?></div>
            <ul class="intro-list">
                <li><span class="glyphicon glyphicon-ok-sign"></span> Hunderte EBooks als <b>kostenloser</b> Download in alle gängigen Formate</li>
                <li><span class="glyphicon glyphicon-ok-sign"></span> Werke von freien Autoren lesen, kommentieren und bewerten</li>
                <li><span class="glyphicon glyphicon-ok-sign"></span> Lade deine Werke kostenlos entweder als Gesamtwerk oder kapitelweise hoch</li>
            </ul>
            <p class="intro-teaser">Jetzt kostenlos registrieren!</p>
            <button onclick="window.location.href='<?=YII::app()->createAbsoluteUrl('users/signup')?>'" class="btn btn-g">Benutzerkonto anlegen</button>
        </div>
    </div>
</header>
<!-- services section -->
<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Das bieten wir</h2>
                <h3 class="section-subheading text-muted">Verlagsfreie Werke von Hobbyautoren</h3>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-md-4">
                <img class="services-pictograph" src="img/pictograph_book_512.png" alt="pictograph" />
                <h4 class="service-heading">Schreibe, Lese, Erlebe!</h4>
                <p class="text-muted">
                    <b>Bookwork</b> bietet dir die Möglichkeit eigene werke in einer <b>aktiven Community</b> zu veröffentlichen.</br> 
                    Oder stöbere einfach durch andere Autoren und entdecke die Bücher von morgen.
                </p>
            </div>
            <div class="col-md-4">
                <img class="services-pictograph" src="img/pictograph_community_512.png" alt="pictograph" />
                <h4 class="service-heading">Werde Teil der Community!</h4>
                <p class="text-muted">
                    Werde Mitglied in unserer Community um die Werke anderer Mitglieder zu lesen, bewerten und erhalte Feedback zu eigenen Werken von anderen Hobbyautoren. 
                </p>
            </div>
            <div class="col-md-4">
                <img class="services-pictograph" src="img/pictograph_badge_512.png" alt="pictograph" />
                <h4 class="service-heading">Ausgezeichnet!</h4>
                <p class="text-muted">
                    Veröffentlicht und dann Vergessen? Nicht bei Uns!<br>
                    Unser <b>Badge System</b> macht uns einzigartig, indem es Spaß mit Nützlichem verbindet. Erhalte Auszeichnungen für deine Werke und verfolge so deren
                    Fortschritt innerhalb der Community. 
                </p>
            </div>
        </div>
    </div>
</section>
    
<!-- thumbnail section -->
<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Unsere Highlights</h2>
                <h3 class="section-subheading text-muted">Beliebte Werke unserer Hobbyautoren</h3>
            </div>
            <?php foreach($books as $book):?>
            <div class="col-xs-12 col-md-3">
                <div class="thumbnail thumbnail-centered">
                	<a href="<?= YII::app()->createAbsoluteUrl('books/files/'.$book->id)?>">
	                	<?php
	                		$this->widget('ext.SAImageDisplayer', array(
							'image' => $book->id.'.'.$book->extension,	
							'defaultImage'=> 'default.jpg',
							'title' => $book->title,
							'size' => 'thumb',
							'group'=> 'cover',
							'class' => '',
							'id' => '',
						));?>
					</a>
                    <div class="caption">
                        <a href="<?=YII::app()->createAbsoluteUrl('user/profile/'.$book->author)?>"><?=$book->author0->name?></a>
                        <h3><?=$book->title?></h3>
                        <p>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star-empty"></span>
                            <span class="glyphicon glyphicon-star-empty"></span>
                        </p>
                        <button class="btn btn-g">Herunterladen</button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- teaser section -->
<!-- for testing purpose only! -->
<section>
    <hr>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2>Lesen ist Macht</h2>
                <h3 class="section-subheading text-muted">Lass dich inspirieren und durchstöbere unzählige Werke von freien Autoren</h3>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-md-12">
                <img class="teaser-logo" src="img/logo.png" alt="bookwork logo"/>
                <hr>
                <p class="text-muted text-quote">"Es gibt einen Ort im Universum, an dem sich alle großen künstlerischen Ideen bündeln, sich aneinander reiben und neue erzeugen..."</p>
                <p class="text-muted text-quote-author"> - Walter Moers, "die Stadt der Träumenden Bücher"</p>
            </div>
        </div>
    </div>
</section>
