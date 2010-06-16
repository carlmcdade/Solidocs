<table class="list">

	<thead>
		<tr>
			<th>User ID</th>
			<th>E-mail</th>
			<th>Username</th>
			<th>Groups</th>
		</tr>
	</thead>
	
	<tbody>
	<?php foreach($users as $user):?>
		<tr>
			<td><?php echo $user['user_id'];?></td>
			<td><?php echo $user['email'];?></td>
			<td><?php echo $user['username'];?></td>
			<td><?php echo implode(', ', explode(',', $user['group']));?></td>
		</tr>
	<?php endforeach;?>
	</tbody>

</table>

<?php $pager->create_links();?>