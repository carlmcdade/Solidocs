<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<?php
	$this->add_css(THEME . '/style.css');
	
	echo $this->head();
	?>
	
</head>
<body<?php $this->body_class();?>>
	
	<div id="header">
	
		<div>
		
			<h1><a href="/">Solidocs</a></h1>
			
			<div id="navigation">
				
				<ul>
					<?php $this->navigation->menu('main_menu');?>
				</ul>
				
			</div>
			
		</div>
		
	</div>
	
	<div id="wrapper">