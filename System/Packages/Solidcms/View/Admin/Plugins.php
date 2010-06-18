<h2>Plugins</h2>

<table class="list">
	
	<thead>
		
		<tr>
			<th>Plugin</th>
			<th>Information</th>
		</tr>
		
	</thead>
	
	<tbody>
	
	<?php foreach($list as $item):?>	
	<tr>
		<td>
			<div class="block"><strong><?php echo $item['name'];?></strong> (<?php echo $item['package'];?>)</div>
			<div class="block">
			<?php if(in_array($item['class'], $config_plugins)):?>
				<span class="discrete">This plugin is loaded from config</span>			
			<?php elseif(in_array($item['class'], $active_plugins)):?>
				<a href="/admin/package/deactivate_plugin/?plugin=<?php echo $item['class'];?>">Deactivate</a>
			<?php else:?>
				<a href="/admin/package/activate_plugin/?plugin=<?php echo $item['class'];?>">Activate</a>
			<?php endif;?>
			</div>
		</td>
		<td>
			<div class="block"><?php echo $item['description'];?></div>
			<div class="block">Version <?php echo $item['version'];?> | <a href="<?php echo $item['url'];?>"><?php echo $item['url'];?></a></div>
		</td>
	</tr>
	<?php endforeach;?>
	
	</tbody>
	
</table>