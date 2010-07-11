<h2>Channels <a href="/admin/content/create_channel">Create Channel</a></h2>

<table class="list">
	
	<thead>
		<tr>
			<th>Name</th>
			<th>Description</th>
			<th>Items</th>
			<th></th>
		</tr>
	</thead>
	
	<tbody>
	<?php foreach($channels as $channel):?>
		
		<tr>
			<td><?php echo $channel['name'];?> <span class="discrete"><?php echo $channel['channel'];?></span></td>
			<td><?php echo $channel['description'];?></td>
			<td><?php echo $channel['items'];?></td>
			<td>
				<span class="discrete">Action:</span>
				<select name="url">
					<option>--</option>
					<option value="/admin/channel/edit/<?php echo $channel['channel'];?>">Edit</option>
					<option value="/admin/channel/delete/<?php echo $channel['channel'];?>">Delete</option>
				</select>
			</td>
		</tr>
		
	<?php endforeach;?>
	</tbody>
	
</table>