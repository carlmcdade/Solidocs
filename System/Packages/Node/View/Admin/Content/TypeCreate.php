<h2>Create content type (node type)</h2>

<form action="<?php echo $this->router->request_uri;?>" method="post">

	<div class="form vertical">
		
		<label>Content Type</label>
		<input type="text" name="content_type" />
		
		<label>Name</label>
		<input type="text" name="name" />
		
		<label>Description</label>
		<input type="text" name="description" />
		
		<label>Save</label>
		<button type="submit">Save</button>
		
	</div>

</form>