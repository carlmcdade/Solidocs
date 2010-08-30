<h2>User Groups</h2>

<table class="list">
	
	<thead>
		
		<tr>
			<th>Group</th>
			<th>Description</th>
			<th>Actions</th>
		</tr>
		
	</thead>
	
	<tbody>
		
		<?php foreach($groups as $group):?>
		<tr>
			<td><?php echo $group['name'];?> <span class="discrete">(<?php echo $group['group'];?>)</span></td>
			<td><?php echo $group['description'];?></td>
			<td>
				<a href="/admin/group/delete/<?php echo $group['group'];?>">Delete</a>
			</td>
		</tr>
		<?php endforeach;?>
		
	</tbody>
	
</table>