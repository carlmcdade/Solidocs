<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $this->title('Solidocs', 'PHP Framework', ' | ', true);?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo THEME_WWW;?>/style.css" />
	
</head>
<body>

	<div id="wrapper">
		
		<div id="header">
			
			<h1><?php echo $this->config->get('Site.name', 'Solidocs Admin');?> <a href="/"><span class="discrete label">visit site</span></a></h1>
			
			<div class="userbar">
				
				Welcome <?php echo $this->session->user->username;?>, <a href="/logout">logout?</a>
				
			</div>
			
		</div>
			
		<div id="sidebar">
		
			<ul>
				<?php
				$this->list_channel('admin_navigation', array(
					'children' => true
				));
				?>
			</ul>
			
		</div>
		
		<div id="main">
