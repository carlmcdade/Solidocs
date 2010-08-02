<h2>Editing content type</h2>

<form action="<?php echo $this->router->request_uri;?>" method="post">

<table class="list">

	<thead>
		
		<tr>
			<th>Field</th>
			<th>Name (Label)</th>
			<th>Helper</th>
			<th>Type</th>
			<th>Filters</th>
			<th>Validators</th>
			<th>Actions</th>
		</tr>
		
	</thead>
	
	<tbody>
		
		<?php foreach($fields as $field):?>
		<tr>
			<td><?php echo $field['field'];?></td>
			<td><?php echo $this->form_text($field['field'] . '[name]', $field['name']);?></td>
			<td><?php echo $this->form_select($field['field'] . '[helper]', $field['helper'], $helpers);?></td>
			<td><?php echo $this->form_select($field['field'] . '[type]', $field['type'], $types);?></td>
			<td><?php echo $field['filters'];?></td>
			<td><?php echo $field['validators'];?></td>
			<td><a href="/admin/type/delete_field/<?php echo $this->input->uri_segment('id') . ':' . $field['field'];?>">Delete</a></td>
		</tr>
		<?php endforeach;?>
		
		<tr>
			<td><?php echo $this->form_text('new_field[field]');?></td>
			<td><?php echo $this->form_text('new_field[name]');?></td>
			<td><?php echo $this->form_select('new_field[helper]', '', $helpers);?></td>
			<td><?php echo $this->form_select('new_field[type]', '', $types);?></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		
	</tbody>

</table>

<p>
	<button type="submit">Save</button>
</p>

</form>