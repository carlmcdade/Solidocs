<h2>Content types (node types)</h2>

<table class="list">
	
	<thead>
		
		<tr>
			<th>Name</th>
			<th>Description</th>
			<th>Actions</th>
		</tr>
		
	</thead>
	
	<tbody>
		
		<?php foreach($content_types as $content_type):?>
		<tr>
			<td><?php echo $content_type['name'];?> <span class="discrete">(<?php echo $content_type['content_type'];?>)</span></td>
			<td><?php echo $content_type['description'];?></td>
			<td>
				<a href="/admin/type/edit/<?php echo $content_type['content_type'];?>">Edit</a> | 
				<a href="/admin/type/delete/<?php echo $content_type['content_type'];?>">Delete</a>
			</td>
		</tr>
		<?php endforeach;?>
		
	</tbody>
	
</table>