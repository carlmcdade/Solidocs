<h2>Content</h2>

<table class="list">
	
	<thead>
	
		<tr>
			<th>ID</th>
			<th>Title</th>
			<th>URI</th>
			<th>Locale</th>
		</tr>
	
	</thead>
	
	<tbody>
		
		<?php foreach($nodes as $node):?>
		<tr>
			<td><?php echo $node['node_id'];?></td>			
			<td><?php echo $node['title'];?></td>
			<td><a href="<?php echo $node['uri'];?>" target="_blank"><?php echo $node['uri'];?></a></td>
			<td><?php echo $node['locale'];?></td>
		</tr>
		<?php endforeach;?>
		
	</tbody>
	
</table>