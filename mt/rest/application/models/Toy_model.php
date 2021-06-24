<?php
    class Toy_model extends CI_model {
        public function getAllToys () {
            return $this->db->get('toys')->result_array();
        }

        public function checkToyAvailability ($id) {
            $result = $this->db->select('stock')
                    ->where('id = ', $id)
                    ->get('toys')
                    ->result_array();

            return $result[0]['stock'] != '0' ? true : false;
        }
    }
?>