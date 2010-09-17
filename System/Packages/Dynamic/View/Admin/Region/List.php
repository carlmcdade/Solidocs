<h2>Regions</h2>

<table class="list">
	
	<thead>
		
		<tr>
			<th>Region</th>
			<th>Locale</th>
			<th>Actions</th>
		</tr>
		
	</thead>
	
	<tbody>
	
	<?php
	foreach($this->i18n->accepted_locales as $locale):
		
		foreach($regions as $region => $name):?>
		<tr>
			<td><?php echo $name;?></td>
			<td><?php echo $locale;?></td>
			<td><a href="/admin/region/edit/<?php echo $region;?>?locale=<?php echo $locale;?>">Edit</a></td>
		</tr>
		<?php endforeach;
		
	endforeach;
	?>
	
	</tbody>
	
</table>