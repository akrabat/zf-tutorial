<form action="/zf-tutorial/index/<?php echo $this->action; ?>" method="post">
<div>
	<label for="artist">Artist</label>
	<input type="text" class="input-large" name="artist" value="<?php echo $this->escape(trim($this->album->artist));?>"/>
</div>
<div>
	<label for="title">Title</label>
	<input type="text" class="input-large" name="title" value="<?php echo $this->escape($this->album->title);?>"/>
</div>

<div id="formbutton">
<input type="hidden" name="id" value="<?php echo $this->album->id; ?>" />
<input type="submit" name="add" value="<?php echo $this->escape($this->buttonText); ?>" />
</div>
</form>

