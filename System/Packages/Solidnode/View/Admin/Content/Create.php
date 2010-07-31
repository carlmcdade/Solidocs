<h2>Create content</h2>

<div class="form horizontal">
	
	<form action="/admin/content/edit/" method="get">
	
		<label>Content type:</label>
		
		<select name="content_type">
			
			<?php foreach($content_types as $key => $content_type):?>
			<option value="<?php echo $key;?>"><?php echo $content_type['name'];?> - <?php echo $content_type['description'];?></option>
			<?php endforeach;?>
			
		</select>
		
		<button type="submit">Create!</button>
	
	</form>
	
</div>