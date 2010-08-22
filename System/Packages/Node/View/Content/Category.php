<h2>{category}</h2>

<ul>
	<?php foreach($nodes as $node):?>
	<li><a href="<?php echo $node->uri;?>"><?php echo $node->title;?></a></li>
	<?php endforeach;?>
</ul>