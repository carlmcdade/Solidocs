<h2>Content</h2>

<table class="list">
	
	<thead>
	
		<tr>
			<th>ID</th>
			<th>Title</th>
			<th>URI</th>
			<th>Content type</th>
			<th>Locale</th>
			<th>Status</th>
			<th>Actions</th>
		</tr>
	
	</thead>
	
	<tbody>
		
		<?php foreach($nodes as $node):?>
		<tr>
			<td><?php echo $node['node_id'];?></td>			
			<td><?php echo $node['title'];?></td>
			<td><a href="<?php echo $node['uri'];?>" target="_blank"><?php echo $node['uri'];?></a></td>
			<td><?php echo $node['content_type'];?></td>
			<td><?php echo $node['locale'];?></td>
			<td>
				<?php if($node['published']):?>
				Published
				<?php else:?>
				Not published
				<?php endif;?>
			</td>
			<td>
				<a href="/admin/content/edit/<?php echo $node['node_id'];?>">Edit</a> | 
				<a href="/admin/content/delete/<?php echo $node['node_id'];?>">Delete</a>
			</td>
		</tr>
		<?php endforeach;?>
		
	</tbody>
	
</table>