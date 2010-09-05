<h2>Content</h2>

<table class="list">
	
	<thead>
	
		<tr>
			<th>ID</th>
			<th>Title</th>
			<th>URI</th>
			<th width="100">Content type</th>
			<th>Locale</th>
			<th width="130">Status</th>
			<th width="100">Actions</th>
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
				Published &#8250; <a href="/admin/content/unpublish/<?php echo $node['node_id'];?>">Unpublish</a>
				<?php else:?>
				Not published &#8250; <a href="/admin/content/publish/<?php echo $node['node_id'];?>">Publish</a>
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