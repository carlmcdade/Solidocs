<h2>Editing navigation</h2>

<div class="form horizontal">
	
	<form action="<?php echo $this->router->uri;?>" method="post">
		
		<label>Title</label>
		<?php echo $this->form()->text('new_item[title]');?>
		<label>URL</label>
		<?php echo $this->form()->text('new_item[url]');?>
		<label>Parent</label>
		<?php echo $this->form()->select('new_item[parent_id]', 0, $parents);?>
		<label>Order</label>
		<?php echo $this->form()->text('new_item[order]', 999);?>
		<?php echo $this->form()->button('Save');?>
		
	</form>
	
</div>

<form action="<?php echo $this->router->uri;?>" method="post">

<ul id="navigation_list">
	<?php foreach($navigation as $item):?>
	<li>
		<strong><?php echo $item['navigation_item_id'];?></strong>
		<?php
		echo $this->form()->text('item[' . $item['navigation_item_id'] . '][title]', $item['title']);
		echo $this->form()->text('item[' . $item['navigation_item_id'] . '][url]', $item['url']);
		echo $this->form()->select('item[' . $item['navigation_item_id'] . '][parent_id]', $item['parent_id'], $parents, false);
		echo $this->form()->text('item[' . $item['navigation_item_id'] . '][order]', $item['order']);
		?>
		<a href="/admin/navigation/delete_item/<?php echo $item['navigation_item_id'];?>/?redirect=<?php echo $this->router->uri;?>">Delete item</a>
		<?php if(isset($item['children'])){
			echo '<ul>';
			
			foreach($item['children'] as $child_item){
				echo '<li><strong>' . $child_item['navigation_item_id'] . '</strong>';
				echo $this->form()->text('item[' . $child_item['navigation_item_id'] . '][title]', $child_item['title']);
				echo $this->form()->text('item[' . $child_item['navigation_item_id'] . '][url]', $child_item['url']);
				echo $this->form()->select('item[' . $child_item['navigation_item_id'] . '][parent_id]', $child_item['parent_id'], $parents, false);
				echo $this->form()->text('item[' . $child_item['navigation_item_id'] . '][order]', $child_item['order']);
				echo '<a href="/admin/navigation/delete_item/' . $item['navigation_item_id'] . '/?redirect=' . $this->router->uri . '">Delete</a></li>';
			}
			
			echo '</ul>';
		}
		?>
	</li>
	<?php endforeach;?>
</ul>

<p>
	<button type="submit">Save</button>
</p>

</form>