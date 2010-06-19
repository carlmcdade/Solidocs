<h2>Content <a href="/admin/content/create">Create Content</a></h2>

<table class="list">
	
	<thead>
		
		<tr>
			<th></th>
			<th>ID</th>
			<th>URI</th>
			<th>Type</th>
			<th>Title</th>
			<th>Created</th>
			<th></th>
		</tr>
		
	</thead>
	
	<tbody>
	
	<?php foreach($content as $item):?>	
		<tr>
			<td><input type="checkbox" name="content_ids[]" value="<?php echo $item['content_id'];?>" /></td>
			<td><?php echo $item['content_id'];?></td>
			<td><?php echo $item['uri'];?></td>
			<td><?php echo $item['content_type'];?></td>
			<td><?php echo $item['title'];?></td>
			<td><?php echo $this->i18n->date_time($item['time']);?></td>
			<td>
				<span class="discrete">Action:</span>
				<select name="url">
					<option>--</option>
					<option value="/admin/content/edit/<?php echo $item['content_id'];?>">Edit</option>
					<option value="/admin/content/delete/<?php echo $item['content_id'];?>">Delete</option>
				</select>
			</td>
		</tr>
	<?php endforeach;?>
	
	</tbody>
	
	<tfoot>
		
		<tr>
			<td colspan="2">
				
				<span class="discrete">Bulk action:</span>
				<select name="action">
					<option>--</option>
					<option value="delete">Delete</option>
				</select>
			
			</td>
			<td colspan="5"></td>
		</tr>
		
	</tfoot>
	
</table>