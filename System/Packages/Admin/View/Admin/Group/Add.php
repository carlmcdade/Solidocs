<h2>Add group</h2>

<form action="/admin/group/add/" method="post">

	<div class="form vertical">
	
		<?php
		echo $this->form()->label('Name');
		echo $this->form()->text('name');
		
		echo $this->form()->label('Description');
		echo $this->form()->text('description');
		
		echo $this->form()->label('Save');
		echo $this->form()->button('Save');
		?>
	
	</div>
</form>