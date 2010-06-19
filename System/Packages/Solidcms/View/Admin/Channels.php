<h2>Channels <a href="/admin/content/create_channel">Create Channel</a></h2>

<table class="list">
	
	<thead>
		<tr>
			<th>Name</th>
			<th>Description</th>
			<th>Items</th>
		</tr>
	</thead>
	
	<tbody>
	<?php foreach($channels as $channel):?>
		
		<tr>
			<td><?php echo $channel['name'];?> <span class="discrete"><?php echo $channel['channel'];?></span></td>
			<td><?php echo $channel['description'];?></td>
			<td><?php echo $channel['items'];?></td>
		</tr>
		
	<?php endforeach;?>
	</tbody>
	
</table>