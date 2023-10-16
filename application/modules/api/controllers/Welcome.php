<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Welcome extends REST_Controller
{
	public function index_get()
	{
		$this->data['message'] = 'API Version 1.0';
		$this->data['data'] = 'run from /Application/modules/api/controllers/v1/welcome.php';
		$this->response($this->data);
	}

}