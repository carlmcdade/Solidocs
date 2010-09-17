<h2>Add user</h2>

<form action="/admin/user/add/" method="post">

	<div class="form vertical">
	
		<?php
		echo $this->form()->label('Email');
		echo $this->form()->text('email');
		
		echo $this->form()->label('Password');
		echo $this->form()->password('password');
		
		echo $this->form()->label('Group');
		echo $this->form()->select('group', false, $groups, false, true);
		
		echo $this->form()->label('Save');
		echo $this->form()->button('Save');
		?>
	
	</div>
</form>