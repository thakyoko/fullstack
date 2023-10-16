<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Customer extends REST_Controller {

	public function __construct()
	{
		parent::__construct();

		// load database
		$this->load->database();

		// load model from /application/model/customers.php
		$this->load->model('customers');
	}

	public function index_get()
	{

		$id = trim($this->get('id'));
		
		if ($id > 0) {
			$data = $this->customers->get($id);
			$this->data['results'] = $data;
			$this->response($this->data);
		}

		$search = trim($this->get('search'));
		if ($search) {
			$wh["fullname LIKE '%$search%' OR phone LIKE '%$search%'"] = null;
			$data = $this->customers->get_many_by($wh);
			$this->data['results'] = $data;
			$this->response($this->data);
		}

		$data = $this->customers->get_all();

		$this->data['results'] = $data;
		$this->response($this->data);
	}

	public function index_post($value='')
	{
		# create data 
		$val['fullname'] = trim($this->post('fullname'));
		$val['email'] = trim($this->post('email'));
		$val['phone'] = trim($this->post('phone'));

		if (!$val['email'] || !$val['fullname']) {
			$this->data['status'] = false;
			$this->data['message'] = 'email or phone not value !';
			$this->response($this->data,400);
		}

		$row = $this->customers->count_by('email',$val['email']);
		if ($row > 0) {
			$this->data['status'] = false;
			$this->data['message'] = 'data ready !';
			$this->response($this->data,400);
		}

		$this->customers->insert($val);
		$this->data['message'] = 'insert new row success';
		$this->response($this->data,201);
	}

	public function index_put($value='')
	{
		# update
		$val['fullname'] = trim($this->put('fullname'));
		$val['email'] = trim($this->put('email'));
		$val['phone'] = trim($this->put('phone'));

		if (!$val['email'] || !$val['fullname']) {
			$this->data['status'] = false;
			$this->data['message'] = 'email or phone not value !';
			$this->response($this->data,400);
		}

		$id = trim($this->put('id'));

		$this->customers->update($id,$val);
		$this->data['message'] = 'update data success';
		$this->response($this->data,201);

	}

	public function index_delete($id=0)
	{
		# delete data by id
		$this->customers->delete($id);
		$this->data['message'] = 'delete success';
		$this->response($this->data,201);
	}

}
