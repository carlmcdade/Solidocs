<h2>Regions</h2>

<ul>
	<?php foreach($regions as $region => $name):?>
	<li><a href="/admin/region/edit/<?php echo $region;?>"><?php echo $name;?></a></li>
	<?php endforeach;?>
</ul>