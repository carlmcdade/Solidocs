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
			
			<h1><a href="#">Solidocs Admin</a></h1>
			
		</div>
			
		<div id="sidebar">
		
			<ul>
				<li><a href="#">Dashboard</a></li>
				<li>
					<a href="#">Packages</a>
					<ul>
						<li><a href="#">Plugins</a></li>
						<li><a href="#">Install</a></li>
					</ul>
				</li>
			</ul>
			
			<b><?php echo $this->session->user->username;?></b>, <a href="/logout">logout?</a>
			
		</div>
		
		<div id="main">