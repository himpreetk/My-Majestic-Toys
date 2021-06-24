<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

    defined('BASEPATH') OR exit ('No direct script access allowed');
    require_once APPPATH . 'libraries/REST_Controller.php';
    require_once APPPATH . 'libraries/Format.php';

    use Restserver\Libraries\REST_Controller;

    class Toy extends REST_Controller {

        function __construct () {
            parent::__construct ();
            $this->load->model('Toy_model', 'toy');
        }
        
        public function index_get () {
            $this->response ([
                    'status' => true ,
                    'message' => 'Welcome to CodeIgniter Rest API'
                ], REST_Controller::HTTP_OK );
        }
        
        // Get All Toys 
        public function toys_get () {
            $toys = $this->toy->getAllToys ();
            if ($toys) {
                $this->response ([
                    'status' => true ,
                    'data' => $toys
                ], REST_Controller::HTTP_OK ); // OK (200) being the HTTP response code
            } else {
                $this->response ([
                    'status' => false,
                    'message' => 'No toys now'
                ], REST_Controller::HTTP_NOT_FOUND ); // NOT_FOUND (404) being the HTTP response code
            }
        }

        // Check Availability
        public function check_get () {
            $id = $this->get('id');

            if ($id === null) {
                $this->response([
                    'status' => false,
                    'message' => 'Toy_ID is needed to complete your request!'
                ], REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            } else {
                $result = $this->toy->checkToyAvailability($id);
            }

            if ($result) {
                $this->response([
                    'status' => true,
                    'data' => 1,
                    'id' => $id,
                    'message' => 'It is possible to sell.'
                ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                $this->response([
                    'status' => true,
                    'data' => 0,
                    'id' => $id,
                    'message' => 'The store is zero.'
                ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            
            }
        }
    }
?>