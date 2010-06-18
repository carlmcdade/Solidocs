<h2>Packages</h2>

<table class="list">
	
	<thead>
		
		<tr>
			<th>Package</th>
			<th>Information</th>
		</tr>
		
	</thead>
	
	<tbody>
	
	<?php foreach($list as $item):?>	
		<tr>
			<td>
				<div class="block"><strong><?php echo $item['name'];?></strong></div>
				<div class="block">
				<?php if($item['install']):?>
				
					<a href="/admin/package/install_package/?package=<?php echo $item['package'];?>">Install</a> | 
					<a href="/admin/package/uninstall_package/?package=<?php echo $item['package'];?>">Uninstall</a> | 
					<a href="/admin/package/reinstall_package/?package=<?php echo $item['package'];?>">Reinstall</a>
					
					<span class="discrete"><i><?php echo count($item['install_tables']);?></i> tables</span>
				
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