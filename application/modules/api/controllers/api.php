<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Api extends REST_Controller
{

	function __construct()
	{
		// Construct the parent class
		parent::__construct();

		// Configure limits on our controller methods
		// Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
		$this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
		$this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
		$this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
	}

	public function index()
	{
		$users = null;
		$this->load->view('welcome_message');
		$this->response($users, REST_Controller::HTTP_OK);
	}
	public function index_get()
	{
		$this->data['message'] = 'API Version 1.0';
		$this->data['data'] = 'run from /Application/modules/api/controllers/v1/welcome.php';
		$this->response($this->data);
	}

	public function users_get($id=null)
	{
		$id = $this->get('id');
		$this->data['message'] = $id ;
		$this->data['data'] = 'run from /Application/modules/api/controllers/v1/welcome.php';
		$this->response($this->data);
		return;
		// Users from a data store e.g. database
		$users = [
			['id' => 1, 'name' => 'John', 'email' => 'john@example.com', 'fact' => 'Loves coding'],
			['id' => 2, 'name' => 'Jim', 'email' => 'jim@example.com', 'fact' => 'Developed on CodeIgniter'],
			['id' => 3, 'name' => 'Jane', 'email' => 'jane@example.com', 'fact' => 'Lives in the USA', ['hobbies' => ['guitar', 'cycling']]],
		];

		$id = $this->get('id');

		$res = null;
		foreach ($users as $user) {
			if ($user['id'] == $id) {
				$res = $user;
				break; // User found, so exit the loop
			}
		}
		$users = $res;
		if ($users) {
			// Set the response and exit
			$this->response($id, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
		} else {
			// Set the response and exit
			$this->response([
				'status' => FALSE,
				'message' => 'No users were found'
			], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
		}
	}
}