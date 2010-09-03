<h2>Editing region</h2>

<div class="form horizontal">
	
	<form action="<?php echo $this->router->request_uri;?>" method="post">
	
		<label>Widget</label>
		<?php echo $this->form()->select('new[widget]', '', $widgets);?>
		
		<label>Weight</label>
		<?php echo $this->form()->text('new[weight]', 0);?>
		
		<?php echo $this->form()->button('Add');?>
		
	</form>
	
</div>

<form action="<?php echo $this->router->request_uri;?>" method="post">

<table class="list">
	
	<thead>
		
		<tr>
			<th>Widget</th>
			<th>Weight</th>
			<th>Config</th>
			<th>Actions</th>
		</tr>
		
	</thead>
	
	<tbody>
		
		<?php foreach($items as $item):?>
		<tr>
			<td><?php echo $widgets[$item['widget']];?> <span class="discrete">(<?php echo $item['widget'];?>)</span></td>
			<td><?php echo $this->form()->text('item[' . $item['region_item_id'] . '][weight]', $item['weight']);?></td>
			<td>
				<table>
				
					<?php foreach(unserialize($item['config']) as $key => $val):?>
					<tr>
					
						<td><?php echo $this->form()->label($key);?></td>
						<td><?php echo $this->form()->text('item[' . $item['region_item_id'] . '][' . $key . ']', $val);?></td>
					
					</tr>
					<?php endforeach;?>
				</table>
			</td>
			<td>
				<a href="/admin/region/delete_item/<?php echo $item['region_item_id'];?>">Delete</a>
			</td>
		</tr>
		<?php endforeach;?>
		
	</tbody>

</table>

<?php echo $this->form()->button('Save');?>

</form>