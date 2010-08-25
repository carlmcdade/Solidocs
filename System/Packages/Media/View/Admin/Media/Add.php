<h2>Add media</h2>

<?php echo $this->form()->starttag($this->router->uri, 'post', 'form', true);?>
	
	<div class="form vertical">
		
		<label>File</label>
		<?php echo $this->form()->file('file');?>
		
		<label>Height (px)</label>
		<?php echo $this->form()->text('height');?>
		
		<label>Width (px)</label>
		<?php echo $this->form()->text('width');?>
		
		<label>Length (s)</label>
		<?php echo $this->form()->text('length');?>
		
		<label>Caption</label>
		<?php echo $this->form()->text('caption');?>
		
		<label>Save</label>
		<?php echo $this->form()->button('Save');?>
		
	</div>

</form>