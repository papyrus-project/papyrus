<h1>Edit</h1>

<form method="post" action="">
	<div class="row">
		<label>name</label>
		<input type="text" name="name" value="<?php echo $model->name; ?>" />
	</div>
	<div class="row">
		<label>location</label>
		<input type="text" name="location" value="<?php echo $model->location; ?>" />
	</div>
	<div class="row">
		<label>sex</label>
		<select name='sex'>
			<option value='0' <?php echo $model->sex==0?'selected="selected"':'' ?>>Keine Angabe</option>
			<option value='1' <?php echo $model->sex==1?'selected="selected"':'' ?>>M&auml;nnlich</option>
			<option value='2' <?php echo $model->sex==2?'selected="selected"':'' ?>>Weiblich</option>
		</select>
	</div>
	<div class="row">
		<label>homepage</label>
		<input type="text" name="homepage" value="<?php echo $model->homepage; ?>" />
	</div>
	<div class="row">
		<label>description</label>
		<textarea name="description"><?php echo $model->description; ?></textarea>
	</div>
	<div class="row">
		<button type="submit">save</button>
	</div>
</form>

