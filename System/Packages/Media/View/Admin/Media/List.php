<h2>Media</h2>

<table class="list">
	
	<thead>
		
		<tr>
			<th>ID</th>
			<th>Type</th>
			<th>Height</th>
			<th>Width</th>
			<th>Length</th>
			<th>Date</th>
			<th>Actions</th>
		</tr>
		
	</thead>
	
	<tbody>

		<?php foreach($media_items as $item):?>
		<tr>
			<td><?php echo $item['media_id'];?></td>
			<td><?php echo $item['mime'];?></td>
			<td><?php echo $item['height'];?></td>
			<td><?php echo $item['width'];?></td>
			<td><?php echo $item['length'];?></td>
			<td><?php echo $this->i18n->date_time($item['time']);?></td>
			<td>
				<a href="/admin/media/delete/<?php echo $item['media_id'];?>">Delete</a> | 
				<a href="<?php echo $item['path'];?>" target="_new">View</a>
			</td>
		</tr>
		<?php endforeach;?>
	
	</tbody>
	
</table>