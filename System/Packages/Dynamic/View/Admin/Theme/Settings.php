<h2>Theme settings</h2>

<form action="/admin/theme/settings" method="post">

	<div class="form vertical">
		
		<?php
		echo $this->form()->label('Title base');
		echo $this->form()->text('title_base', $title_base);
		
		echo $this->form()->label('Title separator');
		echo $this->form()->text('title_separator', $title_separator);
		
		echo $this->form()->label('Default meta description');
		echo $this->form()->text('default_description', $default_description);
		
		echo $this->form()->label('Default meta keywords');
		echo $this->form()->text('default_keywords', $default_keywords);
		
		echo $this->form()->label('Save');
		echo $this->form()->button('Save');
		?>
		
	</div>

</form>