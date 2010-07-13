<h2>Please sign in to access this page</h2>

<div id="login_form">
	
	<form action="/login" method="post">
		
		<?php
		$this->form_label('Username');
		$this->form_input('username', true);
		
		$this->form_label('Password');
		$this->form_input('password', false, 'password');
		
		$this->form_button('Sign in');
		?>
		
	</form>

</div>