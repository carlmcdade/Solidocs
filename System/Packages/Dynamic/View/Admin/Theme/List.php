<h2>Themes</h2>

<div class="theme_list">
	<?php foreach($themes as $folder => $theme):?>
		<div style="background: #eee url(/System/Media/Theme/<?php echo $folder;?>/preview.png) no-repeat;"<?php if($this->config->config['Theme']['theme'] == $folder):?> class="active"<?php endif;?>>
			<h3><?php echo $theme['name'];?> <span class="discrete"><?php echo $theme['version'];?></span></h3>
			<p><?php echo $theme['description'];?></p>
			<a href="/admin/theme/select/<?php echo $folder;?>">Select theme</a>
		</div>
	<?php endforeach;?>
</div>