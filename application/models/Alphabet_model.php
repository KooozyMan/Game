<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alphabet_model extends CI_Model {
    public function get_alphabet() {
        return $this->db->select('id, letter')
            ->from('alphabet')
            ->get()
            ->result_array();
    }
}