<h2>{table} edit <a href="<?php echo $this->router->assemble($this->router->route_key, array('action' => 'list'));?>">Return</a></h2>

<form action="<?php echo $this->router->assemble($this->router_key);?>" method="post">

	<div class="form">
	
	<?php
	foreach($record as $key => $val){
		$this->form_label($key);
		$this->form_input(array(
			'name' => $key,
			'value' => $val
		), true);
	}
	
	$this->form_label('Actions');
	$this->form_button('Save');
	?>
		
	</div>

</form>