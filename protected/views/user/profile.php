<h1>Profile</h1>
<?= $model->id == Yii::app()->user->id?'<a href=?r=user/edit>Edit</a><br />':'' ?>
Name: <?= $model->name ?> <br />
Bday: <?= $model->birthday ?> <br />
Sex: <?= $sexes[$model->sex] ?> <br />
Location: <?= $model->location ?> <br />
Homepage: <?= $model->homepage ?> <br />
Description: <?= $model->description ?> <br />
