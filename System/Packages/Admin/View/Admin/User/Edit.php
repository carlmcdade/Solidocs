<h2>Editing user</h2>

<form action="/admin/user/edit/<?php echo $user['user_id'];?>" method="post">

	<div class="form vertical">
	
		<label>E-mail</label>
		<input type="text" name="email" value="<?php echo $user['email'];?>" />
		
		<label>Password (edit to change)</label>
		<input type="password" name="password" />
		
		<label>Groups</label>
		<select name="group[]" multiple="multiple">
			
			<?php
			foreach($groups as $group):
				
				$selected = '';
				
				if(in_array($group['group'], $user['group'])){
					$selected = ' selected="selected"';
				}
				
				echo '<option value="' . $group['group'] . '"' . $selected . '>' . $group['name'] . '</option>';
				
			endforeach;
			?>
			
		</select>
		
		<label>Save</label>
		<button type="submit">Save</button>
		
	</div>

</form>