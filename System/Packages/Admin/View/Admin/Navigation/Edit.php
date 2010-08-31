<h2>Editing navigation</h2>

<div class="form horizontal">
	
	<form action="<?php echo $this->router->uri;?>" method="post">
		
		<label>Title</label>
		<?php echo $this->form()->text('new_item[title]');?>
		<label>URL</label>
		<?php echo $this->form()->text('new_item[url]');?>
		<label>Parent</label>
		<?php echo $this->form()->select('new_item[parent_id]', 0, $parents);?>
		<label>Weight</label>
		<?php echo $this->form()->text('new_item[weight]', 0);?>
		<?php echo $this->form()->button('Save');?>
		
	</form>
	
</div>

<form action="<?php echo $this->router->uri;?>" method="post">

<ul id="navigation_list">
	<?php foreach($navigation as $item):?>
	<li>
		
		<?php
		echo $this->load->get_view('Admin_Navigation_EditPart', array(
			'item' => $item
		));
		?>
		
	</li>
	<?php endforeach;?>
</ul>

<p>
	<button type="submit">Save</button>
</p>

</form>