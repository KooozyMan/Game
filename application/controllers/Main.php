<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends CI_Controller
{

    public function index()
    {
        // Arabic alphabet
        $alphabet = ['أ', 'ب', 'ت', 'ث', 'ج', 'ح', 'خ', 'د', 'ذ', 'ر', 'ز', 'س', 'ش', 'ص', 'ض', 'ط', 'ظ', 'ع', 'غ', 'ف', 'ق', 'ك', 'ل', 'م', 'ن', 'هـ', 'و', 'ي'];

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
                    $grid[$r][$c] = ""; // edge has no letter
                } else {
                    $grid[$r][$c] = $alphabet[$i % count($alphabet)];
                    $i++;
                }
            }
        }

        $data['grid'] = $grid;
        $this->load->view('main', $data);
    }
}
