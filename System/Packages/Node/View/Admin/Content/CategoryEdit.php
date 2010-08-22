<h2>Editing category</h2>

<div class="form vertical">

<form action="<?php echo $this->router->request_uri;?>" method="post">
	
	<?php
	echo $this->form()->label('Name');
	echo $this->form()->text('name', $category['name']);
	echo $this->form()->label('Locale');
	echo $this->form()->select('locale', $category['locale'], $this->i18n->get_locales());
	echo $this->form()->label('Save');
	echo $this->form()->button('Save');
	?>
	
</form>

</div>