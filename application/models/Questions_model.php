<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Questions_model extends CI_Model
{
    // scraped questions from https://rufaa2.yoo7.com/t1036-topic
    public function add_question($question, $typeId, $answer, $letter)
    {
        return $this->db->insert('questions', [
            'question' => $question,
            'type_id' => $typeId,
            'answer' => $answer,
            'letter_id' => $letter
        ]);
    }

    public function get_random_question($typeId, $letter_id, $usedIds = [])
    {
        $this->db->select('question_id, question, answer')
            ->from('questions')
            ->where('type_id', $typeId)
            ->where('letter_id', $letter_id);

        if (!empty($usedIds)) {
            $this->db->where_not_in('question_id', $usedIds);
        }
        $this->db->order_by('RAND()');
        $this->db->limit(1);

        return $this->db->get()->row_array();
    }
}