<h2>Categories</h2>

<table class="list">
	
	<thead>
		
		<tr>
			<th>Category</th>
			<th>Locale</th>
			<th>Actions</th>
		</tr>
		
	</thead>
	
	<tbody>
		
		<?php foreach($categories as $category):?>
		<tr>
			<td><?php echo $category['name'];?> <span class="discrete">(<?php echo $category['category'];?>)</span></td>
			<td><?php echo $category['locale'];?></td>
			<td>
				<a href="/admin/category/edit/<?php echo $category['category'];?>">Edit</a> |
				<a href="/admin/category/delete/<?php echo $category['category'];?>">Delete</a>
			</td>
		</tr>
		<?php endforeach;?>
		
	</tbody>
	
</table>