<h2>Plugins</h2>

<table class="list">

<?php foreach($list as $item):?>	
	<tr>
		<td>
			<div class="block"><strong><?php echo $item['name'];?></strong> (<?php echo $item['package'];?>)</div>
			<div class="block">
			
				<a href="/admin/package/install_plugin/?plugin=<?php echo $item['class'];?>">Install</a> | 
				<a href="/admin/package/uninstall_plugin/?plugin=<?php echo $item['class'];?>">Uninstall</a> | 
				<a href="/admin/package/reinstall_plugin/?plugin=<?php echo $item['class'];?>">Reinstall</a>
				
			</div>
		</td>
		<td>
			<div class="block"><?php echo $item['description'];?></div>
			<div class="block">Version <?php echo $item['version'];?> | <a href="<?php echo $item['url'];?>"><?php echo $item['url'];?></a></div>
		</td>
	</tr>
	
<?php endforeach;?>

</table>