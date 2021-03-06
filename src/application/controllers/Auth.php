<?php defined('BASEPATH') or exit ('No direct script access allowed');


class Auth extends CI_Controller {

	public $data = [];

	function __construct() {

		parent::__construct();
		$this->load->database();
		$this->load->library(['ion_auth', 'form_validation']);
		$this->load->helper(['url', 'language']);

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		define('IS_EDITOR', 0);
		define('IS_ADMIN', 0);
	}

	/**
	 * redirect if needed, otherwise display the user list
	 */
	function index() {
		if ( ! $this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		elseif ( ! $this->ion_auth->is_admin())    // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		else
		{
			// set the flash data error message if there is one
			$this->data ['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			// list the users
			$this->data ['users'] = $this->ion_auth->users()->result();

			foreach ($this->data ['users'] as $k => $user)
			{
				$this->data ['users'] [$k]->groups = $this->ion_auth->get_users_groups($user->id)
					->result();
			}

			$this->data ['target'] = 'auth/index';
			$this->data ['title'] = 'User List';
			$this->_render_page('page/index', $this->data);
		}

	}

	/**
	 * log the user in
	 */
	function login() {
		$_COOKIE = [];
		$this->data ['title'] = 'Login';

		// validate form input
		$this->form_validation->set_rules('identity', 'Identity', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() === TRUE)
		{
			// check to see if the user is logging in
			// check for 'remember me'
			$remember = ( bool ) $this->input->post('remember');

			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
			{
				// if the login is successful
				// redirect them back to the home page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				if ($this->session->userdata('user_id') == 1)
				{
					//redirect('database/run_updates');
				}
				//if the value is set, return to the last page the user was viewing
				if ($uri = $this->input->cookie('uri'))
				{
					redirect($uri);
				}
				else
				{
					redirect('/', 'refresh');
				}
			}
			else
			{
				// if the login was un-successful
				// redirect them back to the login page
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('auth/login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
			}
		}
		else
		{
			// the user is not logging in so display the login page
			// set the flash data error message if there is one
			$this->data ['message'] = $this->session->flashdata('message');

			$this->data ['identity'] = [
				'name' => 'identity',
				'id' => 'identity',
				'type' => 'email',
				'value' => $this->form_validation->set_value('identity'),
			];
			$this->data ['password'] = [
				'name' => 'password',
				'id' => 'password',
				'type' => 'password',
			];
			$this->data ['target'] = 'auth/login';

			$this->_render_page('page/index', $this->data);
			$this->session->set_userdata('sale_year', get_current_year());
		}

	}

	/*
	 * log the user out
	 */
	function logout() {

		$this->data ['title'] = 'Logout';

		// log the user out
		$logout = $this->ion_auth->logout();

		// redirect them to the login page
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect('auth/login', 'refresh');

	}

	/**
	 * change password
	 */
	function change_password() {

		$this->form_validation->set_rules('old', 'Old Password:', 'required');
		$this->form_validation->set_rules('new', 'New Passwored (at least %s characters long):', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
		$this->form_validation->set_rules('new_confirm', 'Confirm New Password:', 'required');

		if ( ! $this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}

		$user = $this->ion_auth->user()->row();

		if ($this->form_validation->run() === FALSE)
		{
			// display the form
			// set the flash data error message if there is one
			$this->data ['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data ['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
			$this->data ['old_password'] = [
				'name' => 'old',
				'id' => 'old',
				'type' => 'password',
			];
			$this->data ['new_password'] = [
				'name' => 'new',
				'id' => 'new',
				'type' => 'password',
				'pattern' => '^.{' . $this->data ['min_password_length'] . '}.*$',
			];
			$this->data ['new_password_confirm'] = [
				'name' => 'new_confirm',
				'id' => 'new_confirm',
				'type' => 'password',
				'pattern' => '^.{' . $this->data ['min_password_length'] . '}.*$',
			];
			$this->data ['user_id'] = [
				'name' => 'user_id',
				'id' => 'user_id',
				'type' => 'hidden',
				'value' => $user->id,
			];

			// render
			$this->data ['target'] = 'auth/change_password';
			$this->data ['title'] = 'Change Password';
			$this->_render_page('page/index', $this->data);
		}
		else
		{
			$identity = $this->session->userdata('identity');

			$change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

			if ($change)
			{
				// if the password was successfully changed
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				$this->logout();
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('auth/change_password', 'refresh');
			}
		}

	}

	/**
	 * forgot password
	 */
	function forgot_password() {

		$this->form_validation->set_rules('email', 'Email Address', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			// setup the input
			$this->data ['email'] = [
				'name' => 'email',
				'id' => 'email',
			];

			if ($this->config->item('identity', 'ion_auth') == 'username')
			{
				$this->data ['identity_label'] = 'Username';
			}
			else
			{
				$this->data ['identity_label'] = 'Email';
			}

			// set any errors and display the form
			$this->data ['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->data ['target'] = 'auth/forgot_password';
			$this->data ['title'] = 'Forgot Password';
			$this->_render_page('page/index', $this->data);
		}
		else
		{
			// get identity from username or email
			if ($this->config->item('identity', 'ion_auth') == 'username')
			{
				$identity = $this->ion_auth->where('username', strtolower($this->input->post('email')))
					->users()
					->row();
			}
			else
			{
				$identity = $this->ion_auth->where('email', strtolower($this->input->post('email')))
					->users()
					->row();
			}
			if (empty ($identity))
			{
				$this->ion_auth->set_message('forgot_password_email_not_found');
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect('auth/forgot_password', 'refresh');
			}

			// run the forgotten password method to email an activation code to the user
			$forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

			if ($forgotten)
			{
				// if there were no errors

				$this->session->set_flashdata('message', 'Please check your email including spam box for the reset instructions');

				redirect('auth/login', 'refresh'); // we should display a confirmation page here instead of the login page
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('auth/forgot_password', 'refresh');
			}
		}

	}

	// reset password - final step for forgotten password
	public function reset_password($code = NULL) {

		if ( ! $code)
		{
			show_404();
		}

		$user = $this->ion_auth->forgotten_password_check($code);

		if ($user)
		{
			// if the code is valid then display the password reset form

			$this->form_validation->set_rules('new', 'New Password (at least %s characters long):', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
			$this->form_validation->set_rules('new_confirm', 'Confirm New Password:', 'required');

			if ($this->form_validation->run() == FALSE)
			{
				// display the form

				// set the flash data error message if there is one
				$this->data ['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$this->data ['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
				$this->data ['new_password'] = [
					'name' => 'new',
					'id' => 'new',
					'type' => 'password',
					'pattern' => '^.{' . $this->data ['min_password_length'] . '}.*$',
				];
				$this->data ['new_password_confirm'] = [
					'name' => 'new_confirm',
					'id' => 'new_confirm',
					'type' => 'password',
					'pattern' => '^.{' . $this->data ['min_password_length'] . '}.*$',
				];
				$this->data ['user_id'] = [
					'name' => 'user_id',
					'id' => 'user_id',
					'type' => 'hidden',
					'value' => $user->id,
				];
				$this->data ['csrf'] = $this->_get_csrf_nonce();
				$this->data ['code'] = $code;

				// render
				$this->data ['target'] = 'auth/reset_password';
				$this->data ['title'] = 'Reset Password';
				$this->_render_page('page/index', $this->data);
			}
			else
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id'))
				{

					// something fishy might be up
					$this->ion_auth->clear_forgotten_password_code($code);

					show_error($this->lang->line('error_csrf'));
				}
				else
				{
					// finally change the password
					$identity = $user->{$this->config->item('identity', 'ion_auth')};

					$change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

					if ($change)
					{
						// if the password was successfully changed
						$this->session->set_flashdata('message', $this->ion_auth->messages());
						$this->logout();
					}
					else
					{
						$this->session->set_flashdata('message', $this->ion_auth->errors());
						redirect('auth/reset_password/' . $code, 'refresh');
					}
				}
			}
		}
		else
		{
			// if the code is invalid then send them back to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect('auth/forgot_password', 'refresh');
		}

	}

	// activate the user
	function activate($id, $code = FALSE) {

		if ($code !== FALSE)
		{
			$activation = $this->ion_auth->activate($id, $code);
		}
		else
		{
			if ($this->ion_auth->is_admin())
			{
				$activation = $this->ion_auth->activate($id);
			}
		}

		if ($activation)
		{
			// redirect them to the auth page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect('auth', 'refresh');
		}
		else
		{
			// redirect them to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect('auth/forgot_password', 'refresh');
		}

	}

	// deactivate the user
	function deactivate($id = NULL) {

		$id = $this->config->item('use_mongodb', 'ion_auth') ? ( string ) $id : ( int ) $id;

		$this->load->library('form_validation');
		$this->form_validation->set_rules('confirm', 'confirmation', 'required');
		$this->form_validation->set_rules('id', 'user ID', 'required|alpha_numeric');

		if ($this->form_validation->run() == FALSE)
		{
			// insert csrf check
			$this->data ['csrf'] = $this->_get_csrf_nonce();
			$this->data ['user'] = $this->ion_auth->user($id)->row();
			$this->data ['target'] = 'auth/deactivate_user';
			$this->data ['title'] = 'Deactivate User';
			if ($this->input->get('ajax') == 1)
			{
				$this->_render_page($this->data['target'], $this->data);
			}
			else
			{
				$this->_render_page('page/index', $this->data);
			}
		}
		else
		{
			// do we really want to deactivate?
			if ($this->input->post('confirm') == 'yes')
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
				{
					show_error($this->lang->line('error_csrf'));
				}

				// do we have the right userlevel?
				if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
				{
					$this->ion_auth->deactivate($id);
				}
			}

			// redirect them back to the auth page
			redirect('auth', 'refresh');
		}

	}

	// create a new user
	function create_user() {

		$this->data ['title'] = 'Create User';

		if ( ! $this->ion_auth->logged_in() || ! $this->ion_auth->is_admin())
		{
			redirect('auth', 'refresh');
		}

		$tables = $this->config->item('tables', 'ion_auth');

		// validate form input
		//$this->form_validation->set_rules ( 'first_name', 'First Name:', 'required|xss_clean' );
		//$this->form_validation->set_rules ( 'last_name', 'Last Name:', 'required|xss_clean' );
		$this->form_validation->set_rules('email', 'Email:', 'required|valid_email|is_unique[' . $tables ['users'] . '.email]');
		$this->form_validation->set_rules('password', 'Password:', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', 'Password Confirmation:', 'required');

		if ($this->form_validation->run() == TRUE)
		{
			$username = strtolower($this->input->post('first_name')) . ' ' . strtolower($this->input->post('last_name'));
			$email = strtolower($this->input->post('email'));
			$password = $this->input->post('password');

			$additional_data = [
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'company' => $this->input->post('company'),
				'phone' => $this->input->post('phone'),
			];
		}
		if ($this->form_validation->run() == TRUE && $this->ion_auth->register($username, $password, $email, $additional_data))
		{
			// check to see if we are creating the user
			// redirect them back to the admin page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect('auth', 'refresh');
		}
		else
		{
			// display the create user form
			// set the flash data error message if there is one
			$this->data ['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->data ['first_name'] = [
				'name' => 'first_name',
				'id' => 'first_name',
				'type' => 'text',
				'value' => $this->form_validation->set_value('first_name'),
			];
			$this->data ['last_name'] = [
				'name' => 'last_name',
				'id' => 'last_name',
				'type' => 'text',
				'value' => $this->form_validation->set_value('last_name'),
			];
			$this->data ['email'] = [
				'name' => 'email',
				'id' => 'email',
				'type' => 'text',
				'value' => $this->form_validation->set_value('email'),
			];
			$this->data ['password'] = [
				'name' => 'password',
				'id' => 'password',
				'type' => 'password',
				'value' => $this->form_validation->set_value('password'),
			];
			$this->data ['password_confirm'] = [
				'name' => 'password_confirm',
				'id' => 'password_confirm',
				'type' => 'password',
				'value' => $this->form_validation->set_value('password_confirm'),
			];
			$this->data ['target'] = 'auth/create_user';
			if ($this->input->get('ajax') == 1)
			{
				$this->_render_page($this->data ['target'], $this->data);
			}
			else
			{
				$this->_render_page('page/index', $this->data);
			}
		}

	}

	// edit a user
	function edit_user($id) {

		$this->data ['title'] = 'Edit User';

		if ( ! $this->ion_auth->logged_in() || ( ! $this->ion_auth->is_admin() && ! ($this->ion_auth->user()
						->row()->id == $id)))
		{
			redirect('auth', 'refresh');
		}

		$user = $this->ion_auth->user($id)->row();
		$this->load->model('User_preferences_model','user_preferences');
		$preferences = $this->user_preferences->get_all($id);
		$groups = $this->ion_auth->groups()->result_array();
		$currentGroups = $this->ion_auth->get_users_groups($id)->result();
		$tables = $this->config->item('tables', 'ion_auth');

		// validate form input
		$this->form_validation->set_rules('first_name', 'First Name', 'required|xss_clean');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required|xss_clean');
		$this->form_validation->set_rules('email', 'Email:', 'required|valid_email|is_unique_to_row[' . $tables ['users'] . '.email.' . $id . ']');

		$this->form_validation->set_rules('groups', $this->lang->line('edit_user_validation_groups_label', 'xss_clean'));

		if (isset ($_POST) && ! empty ($_POST))
		{
			// do we have a valid request?
			if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
			{
				show_error($this->lang->line('error_csrf'));
			}

			$data = [
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'email' => $this->input->post('email'),

			];

			// Only allow updating groups if user is admin
			if ($this->ion_auth->is_admin())
			{
				// Update the groups user belongs to
				$groupData = $this->input->post('groups');

				if (isset ($groupData) && ! empty ($groupData))
				{

					$this->ion_auth->remove_from_group('', $id);

					foreach ($groupData as $grp)
					{
						$this->ion_auth->add_to_group($grp, $id);
					}
				}
			}

			// update the password if it was posted
			if ($this->input->post('password'))
			{
				$this->form_validation->set_rules('password', 'Password:', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', 'Password Confirmation:', 'required');

				$data ['password'] = $this->input->post('password');
			}

			if ($this->form_validation->run() === TRUE)
			{
				$this->ion_auth->update($user->id, $data);

				// check to see if we are creating the user
				// redirect them back to the admin page
				$this->session->set_flashdata('message', 'User Saved');
				if ($this->ion_auth->is_admin())
				{
					redirect('auth', 'refresh');
				}
				else
				{
					redirect('/', 'refresh');
				}
			}
		}

		// display the edit user form
		$this->data ['csrf'] = $this->_get_csrf_nonce();

		// set the flash data error message if there is one
		$this->data ['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		// pass the user to the view
		$this->data ['user'] = $user;
		$this->data ['groups'] = $groups;
		$this->data ['currentGroups'] = $currentGroups;

		$this->data ['first_name'] = [
			'name' => 'first_name',
			'id' => 'first_name',
			'type' => 'text',
			'value' => $this->form_validation->set_value('first_name', $user->first_name),
		];
		$this->data ['last_name'] = [
			'name' => 'last_name',
			'id' => 'last_name',
			'type' => 'text',
			'value' => $this->form_validation->set_value('last_name', $user->last_name),
		];
		$this->data ['email'] = [
			'name' => 'email',
			'id' => 'email',
			'type' => 'email',
			'value' => $this->form_validation->set_value('email', $user->email),
		];
		$this->data ['password'] = [
			'name' => 'password',
			'id' => 'password',
			'type' => 'password',
		];
		$this->data ['password_confirm'] = [
			'name' => 'password_confirm',
			'id' => 'password_confirm',
			'type' => 'password',
		];
		$this->data['preferences'] = $preferences;
		$this->data ['target'] = 'auth/edit_user';
		$this->data['ajax'] = $this->input->get('ajax');
		if ($this->data['ajax'] == 1)
		{
			$this->_render_page($this->data ['target'], $this->data);
		}
		else
		{
			$this->_render_page('page/index', $this->data);
		}

	}

	// create a new group
	function create_group() {

		$this->data ['title'] = $this->lang->line('create_group_title');

		if ( ! $this->ion_auth->logged_in() || ! $this->ion_auth->is_admin())
		{
			redirect('auth', 'refresh');
		}

		// validate form input
		$this->form_validation->set_rules('group_name', 'Group Name', 'required|alpha_dash|xss_clean');
		$this->form_validation->set_rules('description', 'Group Description', 'xss_clean');

		if ($this->form_validation->run() == TRUE)
		{
			$new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));
			if ($new_group_id)
			{
				// check to see if we are creating the group
				// redirect them back to the admin page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect('auth', 'refresh');
			}
		}
		else
		{
			// display the create group form
			// set the flash data error message if there is one
			$this->data ['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->data ['group_name'] = [
				'name' => 'group_name',
				'id' => 'group_name',
				'type' => 'text',
				'value' => $this->form_validation->set_value('group_name'),
			];
			$this->data ['description'] = [
				'name' => 'description',
				'id' => 'description',
				'type' => 'text',
				'value' => $this->form_validation->set_value('description'),
			];
			$this->data ['target'] = 'auth/create_group';
			if ($this->input->get('ajax') == 1)
			{
				$this->_render_page($this->data ['target'], $this->data);
			}
			else
			{
				$this->_render_page('page/index', $this->data);
			}
		}

	}

	// edit a group
	function edit_group($id) {
		// bail if no group id given
		if ( ! $id || empty ($id))
		{
			redirect('auth', 'refresh');
		}

		$this->data ['title'] = $this->lang->line('edit_group_title');

		if ( ! $this->ion_auth->logged_in() || ! $this->ion_auth->is_admin())
		{
			redirect('auth', 'refresh');
		}

		$group = $this->ion_auth->group($id)->row();

		// validate form input
		$this->form_validation->set_rules('group_name', 'Group Name', 'required|alpha_dash|xss_clean');
		$this->form_validation->set_rules('group_description', 'Group Description', 'xss_clean');

		if (isset ($_POST) && ! empty ($_POST))
		{
			if ($this->form_validation->run() === TRUE)
			{
				$group_update = $this->ion_auth->update_group($id, $_POST ['group_name'], $_POST ['group_description']);

				if ($group_update)
				{
					$this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
				}
				else
				{
					$this->session->set_flashdata('message', $this->ion_auth->errors());
				}
				redirect('auth', 'refresh');
			}
		}

		// set the flash data error message if there is one
		$this->data ['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		// pass the user to the view
		$this->data ['group'] = $group;

		$this->data ['group_name'] = [
			'name' => 'group_name',
			'id' => 'group_name',
			'type' => 'text',
			'value' => $this->form_validation->set_value('group_name', $group->name),
		];
		$this->data ['group_description'] = [
			'name' => 'group_description',
			'id' => 'group_description',
			'type' => 'text',
			'value' => $this->form_validation->set_value('group_description', $group->description),
		];
		$this->data ['target'] = 'auth/edit_group';
		if ($this->input->get('ajax') == 1)
		{
			$this->_render_page($this->data['target'], $this->data);
		}
		else
		{
			$this->_render_page('page/index', $this->data);
		}

	}

	function _get_csrf_nonce() {

		$this->load->helper('string');
		$key = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return [
			$key => $value,
		];

	}

	function _valid_csrf_nonce() {

		if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE && $this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}

	}

	function _render_page($view, $data = NULL, $render = FALSE) {

		$this->viewdata = (empty ($data)) ? $this->data : $data;

		$view_html = $this->load->view($view, $this->viewdata, $render);

		if ( ! $render)
		{
			return $view_html;
		}

	}

}
