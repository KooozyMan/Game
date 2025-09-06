<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends CI_Controller
{

    public function index()
    {
        // Arabic alphabet
        $this->load->model('Alphabet_model');
        $alphabet = $this->Alphabet_model->get_alphabet();

        shuffle($alphabet); // random order

        // board size (rows x cols)
        $rows = 7;
        $cols = 7;

        $grid = [];
        $i = 0;

        for ($r = 0; $r < $rows; $r++) {
            for ($c = 0; $c < $cols; $c++) {
                $isEdge = ($r == 0 || $r == $rows - 1 || $c == 0 || $c == $cols - 1);

                if ($isEdge) {
                    if ($r == 0 || $r == $rows - 1) {
                        $grid[$r][$c] = ['id' => -1, 'letter' => '']; // red edge
                    } else {
                        $grid[$r][$c] = ['id' => 0, 'letter' => ''];  // green edge
                    }
                } else {
                    $letterObj = $alphabet[$i % count($alphabet)];
                    // Make sure $letterObj comes as ['letter_id'=>..., 'letter'=>...]
                    $grid[$r][$c] = [
                        'id' => $letterObj['id'],
                        'letter' => $letterObj['letter']
                    ];
                    $i++;
                }
            }
        }

        $this->load->model('Types_model');
        $types = $this->Types_model->get_types();
        $data = [
            'grid' => $grid,
            'types' => $types
        ];
        $this->load->view('main', $data);
    }

    public function getQuestion()
    {
        $this->load->model('Questions_model');
        $letter_id = $this->input->post('letter') ?? '';
        $typeId = $this->input->post('type_id') ?? '';

        if ($letter_id && $typeId) {
            $sessionKey = "used_questions";
            $usedIds = $this->session->userdata($sessionKey) ?? [];
            $question = $this->Questions_model->get_random_question($typeId, $letter_id, []);
            if (!$question) {
                echo json_encode([
                    'status' => 'error1',
                    'message' => 'No more questions available'
                ]);
                return;
            }
            $usedIds[] = $question['question_id'];
            $this->session->set_userdata($sessionKey, $usedIds);

            echo json_encode([
                'status' => 'success',
                'question' => $question['question'],
                'answer' => $question['answer']
            ]);
        } else {
            echo json_encode([
                'status' => 'error2'
            ]);
        }
    }
}
