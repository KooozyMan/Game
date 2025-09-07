<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Alphabet_model extends CI_Model
{
    public function get_alphabet()
    {
        return $this->db->select('id, letter')
            ->from('alphabet')
            ->where_not_in('id', [26, 27, 28]) // temp solution since no questions exist for these letters
            ->get()
            ->result_array();
    }
}