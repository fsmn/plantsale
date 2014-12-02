<h2><?php echo lang('index_heading');?></h2>

<div id="infoMessage"><?php echo $message;?></div>

<table class="list">
	<tr>
		<th>First Name</th>
		<th>Last Name</th>
		<th>Email</th>
		<th>Groups</th>
		<th>Status</th>
		<th>Action</th>
	</tr>
	<?php foreach ($users as $user):?>
		<tr>
			<td><?php echo $user->first_name;?></td>
			<td><?php echo $user->last_name;?></td>
			<td><?php echo $user->email;?></td>
			<td>
				<?php foreach ($user->groups as $group):?>
					<?php echo anchor("auth/edit_group/".$group->id, $group->name) ;?><br />
                <?php endforeach?>
			</td>
			<td><?php echo ($user->active) ? anchor("auth/deactivate/".$user->id, "Active","class='deactivate-user' id='deactivate-user_$user->id'") : anchor("auth/activate/". $user->id, "Inactive");?></td>
			<td><?php echo anchor("auth/edit_user/".$user->id, 'Edit') ;?></td>
		</tr>
	<?php endforeach;?>
</table>

<div class="button-box"><ul class="button-list"><li><?php echo anchor('auth/create_user', "New User", "class='button new new-user'")?></li>
<li><?php echo anchor('auth/create_group', "New Group", "class='button new new-group'")?></li></ul></div>