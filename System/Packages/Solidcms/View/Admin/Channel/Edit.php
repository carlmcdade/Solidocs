<h2>Editing <i>{name}</i> <a href="/admin/channel">Return</a></h2>

<form action="/admin/channel/edit/{channel}" method="post">

<?php
$options = array(0 => 'None');

foreach($items as $option){
	$options[$option['channel_item_id']] = $option['title'] . ' (' . $option['url'] . ')';
}

foreach($items as $item):?>
<div class="block">
	
	<?php
	$this->form_label('Title');
	$this->form_input('name=item[' . $item['channel_item_id'] . '][title]&value=' . $item['title']);
	
	$this->form_label('URL');
	$this->form_input('name=item[' . $item['channel_item_id'] . '][url]&value=' . $item['url']);
	
	$this->form_label('Parent');
	$this->form_select('name=item[' . $item['channel_item_id'] . '][parent_id]', $options, $item['parent_id']);
	
	$this->form_label('Depth');
	$this->form_input('name=item[' . $item['channel_item_id'] . '][depth]&value=' . $item['depth']);
	
	$this->form_label('Weight');
	$this->form_input('name=item[' . $item['channel_item_id'] . '][weight]&value=' . $item['weight']);
	?>
	
</div>
<?php endforeach;?>

<?php $this->form_button('Save');?>

</form>