<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Questions_model extends CI_Model {
    public function add_question($question, $typeId, $answer, $letter) {
        return $this->db->insert('questions', [
            'question' => $question,
            'type_id' => $typeId,
            'answer' => $answer,
            'letter_id' => $letter
        ]);
    }
}