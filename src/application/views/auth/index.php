<?php defined('BASEPATH') or exit('No direct script access allowed');

$buttons[] = [
	'text' => 'Create User',
	'class' => [
		'button',
		'create',
		'dialog',
		'new'
	],
	'href' => site_url('auth/create_user'),
	'style' => 'new',
];
$buttons[] = [
	'text' => 'Create Group',
	'class' => [
		'button',
		'create',
		'dialog',
		'new'
	],
	'href' => site_url('auth/create_group'),
	'style' => 'new',
];

?> <h2>Users</h2>

<?php print create_button_bar($buttons); ?>
<table class="list">
	<tr>
		<th>First Name</th>
		<th>Last Name</th>
		<th>Email</th>
		<th>Groups</th>
		<th>Status</th>
		<th>Action</th>
	</tr>
	<?php foreach ($users as $user) : ?>
		<tr>
			<td><?php print $user->first_name; ?></td>
			<td><?php print $user->last_name; ?></td>
			<td><?php print $user->email; ?></td>
			<td>
				<?php foreach ($user->groups as $group) : ?>
					<?php print anchor('auth/edit_group/' . $group->id, $group->name, 'class="edit dialog"'); ?><br />
				<?php endforeach ?>
			</td>
			<td><?php print ($user->active) ? anchor('auth/deactivate/' . $user->id, 'Active', "class='edit dialog' id='deactivate-user_$user->id'") : anchor('auth/activate/' . $user->id, 'Inactive', "class='activate-user' id='activate-user_$user->id'"); ?>
			</td>
			<td><?php print anchor('auth/edit_user/' . $user->id, 'Edit', 'class="edit dialog"'); ?></td>
		</tr>
	<?php endforeach; ?>
</table>