<h2>Install</h2>

<p>Installs the following packages:</p>

<ul>
	<li>Admin</li>
	<li>Dynamic</li>
	<li>Media</li>
	<li>Node</li>
	<li>Solidocs</li>
</ul>

<form action="/install/?install=true" method="post">
	
	<label>Admin E-mail</label>
	<input type="text" name="email" />
	
	<label>Admin Password</label>
	<input type="text" name="password" />
	
	<button type="submit">Install Solidocs</button>
	
</form>

<br />
<br />

<textarea cols="200" rows="30" style="font: 0.9em monospace;">
<?php print_r($this->db->queries);?>
</textarea>