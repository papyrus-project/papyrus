<?php
$this->beginContent('//layouts/column1');

foreach(Yii::app()->user->getFlashes() as $key => $message) {
    echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
} 

echo $content;

$this->endContent(); ?>

