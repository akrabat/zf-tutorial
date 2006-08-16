<h1><?php echo $this->escape($this->title); ?></h1>
<p><a href="/zf-tutorial/index/add">Add new album</a></p>
<table>
<tr>
	<th>Title</th>
	<th>Artist</th>
	<th>&nbsp;</th>
</tr>

<?php foreach($this->albums as $album) : ?>
<tr>
	<td><?php echo $this->escape($album->title);?></td>
	<td><?php echo $this->escape($album->artist);?></td>
	<td>
		<a href="/zf-tutorial/index/edit/id/<?php echo $album->id;?>">Edit</a>
		<a href="/zf-tutorial/index/delete/id/<?php echo $album->id;?>">Delete</a>
	</td>
</tr>
<?php endforeach; ?>
</table>
