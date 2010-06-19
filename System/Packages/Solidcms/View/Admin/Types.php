<h2>Content Types <a href="/admin/content/type_create">Create Content Type</a></h2>

<table class="list">
	
	<thead>
		
		<tr>
			<th>Name</th>
			<th>Description</th>
		</tr>
		
	</thead>
	
	<tbody>
	
	<?php foreach($content_types as $content_type):?>	
		<tr>
			<td><?php echo $content_type['name'];?> <span class="discrete"><?php echo $content_type['content_type'];?></span></td>
			<td><?php echo $content_type['description'];?></td>
		</tr>
	<?php endforeach;?>
	
	</tbody>
	
</table>