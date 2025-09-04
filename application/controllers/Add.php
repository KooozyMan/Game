<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Add extends CI_Controller
{

    public function consturct()
    {
        parent::construct();
    }

    public function index()
    {
        $this->load->model('Types_model');
        $this->load->model('Alphabet_model');
        $types = $this->Types_model->get_types();
        $letters = $this->Alphabet_model->get_alphabet();

        $data = [
            'types' => $types,
            'letters' => $letters,
            'confirmation' => $this->session->flashdata('confirmation'),
            'confirmation_type' => $this->session->flashdata('confirmation_type')
        ];

        $this->load->view('add', $data);
    }

    public function addQuestion()
    {
        $this->load->model('Questions_model');
        $post = $this->input->post();
        $question = $post['question'] ?? '';
        $typeId = $post['type_id'] ?? 0;
        $answer = $post['answer'] ?? '';
        $letter = $post['letter_id'] ?? 0;

        if ($question && $typeId && $answer && $letter) {
            $this->Questions_model->add_question($question, $typeId, $answer, $letter);
            $this->session->set_flashdata('confirmation', 'لقد تم إضافة السوال');
            $this->session->set_flashdata('confirmation_type', '_200');
        } else {
            $this->session->set_flashdata('confirmation', 'لم يتم إضافة السوال لحدوث خطأ ما');
            $this->session->set_flashdata('confirmation_type', '_404');
        }

        redirect('Add');
    }

    public function addType()
    {
        $this->load->model('Types_model');
        $post = $this->input->post();

        $type = $post['type'] ?? '';

        if ($type) {
            $this->Types_model->add_type($type);
            $this->session->set_flashdata('confirmation', 'لقد تم إضافة النوع');
            $this->session->set_flashdata('confirmation_type', '_200');
        } else {
            $this->session->set_flashdata('confirmation', 'لم يتم إضافة النوع لحدوث خطأ ما');
            $this->session->set_flashdata('confirmation_type', '_404');
        }

        redirect('Add');
    }
}
