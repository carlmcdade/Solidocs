<strong><?php echo $item['navigation_item_id'];?></strong>

<?php
echo $this->form()->text('item[' . $item['navigation_item_id'] . '][title]', $item['title']);
echo $this->form()->text('item[' . $item['navigation_item_id'] . '][url]', $item['url']);
echo $this->form()->select('item[' . $item['navigation_item_id'] . '][parent_id]', $item['parent_id'], $parents, false);
echo $this->form()->text('item[' . $item['navigation_item_id'] . '][weight]', $item['weight']);
?>

<a href="/admin/navigation/delete_item/<?php echo $item['navigation_item_id'];?>/?redirect=<?php echo $this->router->uri;?>">Delete item</a>

<?php if(isset($item['children'])):?>

<ul>

	<?php
	foreach($item['children'] as $child_item){
		echo '<li>' . $this->load->get_view('Admin_Navigation_EditPart', array(
			'item' => $child_item
		)) . '</li>';
	}
	?>
	
</ul>

<?php endif;?>