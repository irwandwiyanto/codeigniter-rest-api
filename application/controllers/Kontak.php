<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Kontak extends REST_Controller {

	function __construct($config = 'rest'){
		parent::__construct($config);

	}

	function index_get() {
		$id = $this->get('id');
		$get_id = $this->db->where('id', $id)->get('telepon')->result();

		$show_data = $this->db->get('telepon')->result();
		if ($show_data == null){
				$query = array('status' => 'empty data');
		} else {
			if ($id == ''){
				$query = $this->db->get('telepon')->result();
			} else {
				if ($get_id == null){
					$query = array('status' => 'no found');
				} else {
					$query = $this->db->where('id', $id)->get('telepon')->result();
				}
			}
		}	
		$this->response($query, 200);
	}

	function index_post() {
		$data = array(
			'id' 	=> $this->input->post('id'),
			'nama'	=> $this->input->post('nama'),
			'nomor'	=> $this->input->post('nomor'));
		$insert = $this->db->insert('telepon', $data);
		if ($insert) {
			$this->response($data, 200);
		} else {
			$this->response(array('status' => 'fail', 502));
		}
	}

	function index_put() {
		$id = $this->put('id');
		$data = array(
			'id'	=> $this->put('id'),
			'nama'  => $this->put('nama'),
			'nomor' => $this->put('nomor'));
		$this->db->where('id', $id);
		$update = $this->db->update('telepon', $data);
		if ($update) {
			$this->response($data, 200);
		} else {
			$this->response(array('status' => 'fail', 502));
		}
	}

    function index_delete() {
        $id = $this->delete('id');
        $get_id = $this->db->where('id', $id)->get('telepon')->result();
        if ($get_id == null) {
        	$this->response(array('status' => 'fail no found id'), 502);
        } else {
        	$this->db->where('id', $id)->delete('telepon');
        	$this->response(array('status' => 'success'), 201);
        }
    }

}
?>