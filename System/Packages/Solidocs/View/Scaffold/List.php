<h2>{table} <a href="<?php echo $this->router->assemble($this->router->route_key, array('action' => 'add'));?>">Add</a></h2>

<table class="list">

	<thead>
		<tr>
		<?php
		foreach($fields as $field){
			echo '<th>' . $field . '</th>';
		}
		?>
		</tr>
	</thead>
	
	<tbody>
	<?php
	foreach($records as $record){
		echo '<tr>';
		
		foreach($record as $col){
			$col = strip_tags($col);
			
			if(strlen($col) > 30){
				$col = substr($col, 0, 30) . '...';
			}
			
			echo '<td>' . $col . '</td>';
		}
		
		echo '</tr>';
	}
	?>
	</tbody>

</table>