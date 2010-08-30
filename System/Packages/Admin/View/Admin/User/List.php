<h2>Users</h2>

<table class="list">
	
	<thead>
		
		<tr>
			<th>ID</th>
			<th>Email</th>
			<th>Groups</th>
			<th>Actions</th>
		</tr>
		
	</thead>
	
	<tbody>
		
		<?php foreach($users as $user):?>
		<tr>
			<td><?php echo $user['user_id'];?></td>
			<td><?php echo $user['email'];?></td>
			<td><?php echo $user['group'];?></td>
			<td>
				<a href="/admin/user/edit/<?php echo $user['user_id'];?>">Edit</a> |
				<a href="/admin/user/delete/<?php echo $user['user_id'];?>">Delete</a>
			</td>
		</tr>
		<?php endforeach;?>
		
	</tbody>
	
</table>