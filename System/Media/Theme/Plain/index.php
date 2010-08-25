<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<?php
	$this->head();
	?>
	<style type="text/css">
	body
	{background: #eee; font: 62.5% Helvetica; padding: 5px;}
	
	h2
	{font-size: 2em;}
	
	#wrapper
	{padding: 20px; border: 1px solid #999;}
	
	p,li
	{font-size: 1.2em;}
	
	.message
	{padding: 10px; margin: 10px; border: 1px solid; font-size: 10px;}
	
	.message span
	{font-size: 1.2em; font-weight: bold;}
	
	.message p
	{font-size: 1.1em; padding-top: 5px;}
	
	.message.success
	{border-color: #fffb1b; background: #feffde;}
	
	.message.error
	{border-color: #ea110e; background: #ffe2e5;}
	
	.message.info
	{border-color: #34a1ff; background: #dbe8ff;}
	</style>
	
</head>
<body>
	
	<div id="wrapper">

		<?php $this->render_content();?>
	
	</div>

</body>
</html>