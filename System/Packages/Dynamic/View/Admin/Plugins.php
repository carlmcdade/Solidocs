<h2>Plugins</h2>

<table class="list">
	
	<thead>
		
		<tr>
			<th width="200">Plugin</th>
			<th>Description</th>
			<th width="120">Actions</th>
		</tr>
		
	</thead>
	
	<tbody>
		
		<?php foreach($plugins as $class => $plugin):?>
		<tr>
			<td><?php echo $plugin['name'];?> <span class="discrete">(<?php echo $plugin['package'] . ' ' . $plugin['version'];?>)</span></td>
			<td><?php echo $plugin['description'];?></td>
			<td>
			<?php if($plugin['from_config']):?>
				<span class="discrete">Loaded from config</span>
			<?php elseif($plugin['autoload']):?>
				<a href="/admin/plugins/deactivate/<?php echo $class;?>">Deactivate</a>
			<?php else:?>
				<a href="/admin/plugins/activate/<?php echo $class;?>">Activate</a>
			<?php endif;?>
			</td>
		</tr>
		<?php endforeach;?>
		
	</tbody>
	
</table>