<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<?php
	$this->add_css(THEME_WWW . '/style.css');
	echo $this->head();
	?>

</head>
<body>

<div id="header">

	<h1><?php echo $this->config->get('Site.name');?> <a href="/">Visit</a></h1>

</div>

<div id="main">
	
	<div id="sidebar">
		
		<ul>
			<?php $this->navigation->menu('admin_menu');?>
		</ul>
		
	</div>