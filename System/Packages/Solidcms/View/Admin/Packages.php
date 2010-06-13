<h2>Packages</h2>

<table class="list">

<?php foreach($list as $item):?>	
	<tr>
		<td>
			<div class="block"><strong><?php echo $item['name'];?></strong></div>
			<div class="block">
				<?php if($item['install']):?>
				
					<a href="/admin/package/install/?package=<?php echo $item['package'];?>">Install</a> | 
					<a href="/admin/package/uninstall/?package=<?php echo $item['package'];?>">Uninstall</a> | 
					<a href="/admin/package/reinstall/?package=<?php echo $item['package'];?>">Reinstall</a>
				
				<?php endif;?>
			</div>
		</td>
		<td>
			<div class="block"><?php echo $item['description'];?></div>
			<div class="block">Version <?php echo $item['version'];?></div>
		</td>
	</tr>
	
<?php endforeach;?>

</table>