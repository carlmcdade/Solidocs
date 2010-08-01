<h2>Navigation</h2>

<table class="list">
	
	<thead>
		
		<tr>
			<th>Name</th>
			<th>Locale</th>
			<th>Actions</th>
		</tr>
		
	</thead>
	
	<tbody>
		
		<?php foreach($navigations as $navigation):?>
		<tr>
			<td><?php echo $navigation['name'];?> <span class="discrete">(<?php echo $navigation['navigation'];?>)</span></td>
			<td><?php echo $navigation['locale'];?></td>
			<td>
				<a href="/admin/navigation/edit/<?php echo $navigation['navigation'];?>">Edit</a> | 
				<a href="/admin/navigation/delete/<?php echo $navigation['navigation'];?>">Delete</a>
			</td>
		</tr>
		<?php endforeach;?>
		
	</tbody>
	
</table>