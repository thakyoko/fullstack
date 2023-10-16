<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';


class User extends REST_Controller {

	public function index_get($id=null)
	{
		$id = trim($this->get('id'));
		echo 'ok' . $id;
	}

	public function index_post()
	{
		# register
	}

	public function index_put()
	{
		# update
	}

}
