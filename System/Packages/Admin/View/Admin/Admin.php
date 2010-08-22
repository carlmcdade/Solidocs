<h2>Admin items</h2>

<div class="form horizontal">
	{form}
</div>

<table class="list">
	
	<thead>
		
		<tr>
			<th>Item</th>
			<th>Controller</th>
			<th>Actions</th>
		</tr>
		
	</thead>
	
	<tbody>
		
		<?php foreach($items as $item):?>
		<tr>
			<td><?php echo $item['item'];?></td>
			<td><?php echo $item['controller'];?></td>
			<td><a href="/admin/admin/delete/<?php echo $item['item'];?>">Delete</a></td>
		</tr>
		<?php endforeach;?>
		
	</tbody>
	
</table>