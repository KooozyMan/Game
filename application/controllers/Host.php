<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Host extends CI_Controller
{
    public function index()
    {
        $this->load->model('Questions_model');
        // $this->session->sess_destroy();
        $questionId = $this->session->userdata('questionId') ?? 0;

        $question = $this->Questions_model->get_question($questionId);

        if ($question) {
            $data['question'] = $question['question'];
            $data['answer'] = $question['answer'];
        } else {
            $data['question'] = '';
            $data['answer'] = '';
        }

        $this->load->view('host', $data);
    }
}
