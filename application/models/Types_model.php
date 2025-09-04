<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Types_model extends CI_Model
{
    public function get_types()
    {
        return $this->db->select('type_id, type')
            ->from('types')
            ->get()
            ->result_array();
    }

    public function add_type($type)
    {
        return $this->db->insert('types', [
            'type' => $type
        ]);
    }
}