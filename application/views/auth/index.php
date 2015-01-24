<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

$buttons[] = array("text"=>"Create User","class"=>array("button new"),"href"=>site_url("auth/create_user"));
$buttons[] = array("text"=>"Create Group","class"=>array("button new"),"href"=>site_url("auth/create_group"));

?> <h2>Users</h2>

<?=create_button_bar($buttons); ?>
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
