<h2>Packages</h2>

<table class="list">
	
	<thead>
		
		<tr>
			<th width="100">Name</th>
			<th>Description</th>
			<th>Version</th>
			<th>URL</th>
			<th width="160">Actions</th>
		</tr>
		
	</thead>
	
	<tbody>
		
		<?php foreach($packages as $folder => $package):?>
		<tr>
			<td><?php echo $package['name'];?></td>
			<td><?php echo $package['description'];?></td>
			<td><?php echo $package['version'];?></td>
			<td><a href="<?php echo $package['url'];?>"><?php echo $package['url'];?></a></td>
			<td>
				<?php if($package['package_model']):?>
				<a href="/admin/packages/install/<?php echo $folder;?>">Install</a> | 
				<a href="/admin/packages/uninstall/<?php echo $folder;?>">Uninstall</a> |
				<a href="/admin/packages/reinstall/<?php echo $folder;?>">Reinstall</a>
				<?php endif;?>
			</td>
		</tr>
		<?php endforeach;?>
		
	</tbody>
	
</table>