<?php

class Controller_Codegen extends Controller_Template
{

    public $template = 'template/blank';
    public $title;
    public $locations = array('q7', '7w', 'tn');
    public $codes = array();
    public $min;
    public $max;
    private $_model = NULL;

    /**
     * Loads the template [View] object.
     */
    public function before() {
        parent::before();
        $this->_model = Model::factory("Codegen");

        Theme::set_theme('labyrinth');

        $this->title = 'Promo Code Generator';

        $this->template->header = View::factory('template/header');
        $this->template->header->scripts = array();

        $this->template->header->title = $this->title;

        $this->template->footer = View::factory('template/footer');


        $this->limit = $this->request->param('limit', 10);

        $this->min = $this->_convert_alpha_to_integer('1000');
        $this->max = $this->_convert_alpha_to_integer('zzzz');
    }

    public function action_generate() {
        $this->limit = (int) $this->request->param('limit', 10);
        $this->template->body = View::factory('template/generate');

        $existing_codes = $this->_model->get_existing_promo_codes_as_array();



        for ($i = 0; $i < $this->limit; $i++) {
            $duplicate = true;
            while ($duplicate) {
                $random = rand($this->min, $this->max);
                if (!in_array($random, $this->codes) && !in_array($random, $existing_codes)) {
                    $duplicate = false;
                    $this->codes[] = $this->_convert_integer_to_alpha($random);
                }
            }
        }
        $result = $this->_model->put_generated_codes_into_database($this->codes);
        $this->template->body->success = false;
        if (is_array($result)) {
            if (!is_null($result[0]) && !is_null($result[1])) {
                if ($result[1] === $this->limit) {
                    $this->template->body->success = true;
                }
            }
        }

        $this->template->body->generated = $this->limit;
    }

    public function action_get_unprinted() {
        $unprinted = $this->_model->get_unprinted_promo_codes();
        foreach ($unprinted as $code) {
            $this->codes[] = $code["code"];
        }
        $this->_make_csv_download($this->codes);
    }

    private function _make_csv_download(Array $values, $filename = 'codes.csv') {
        $this->template->body = View::factory('template/csv_download');
        $this->template->body->filename = $filename;
        $this->template->body->content = '';
        foreach ($values as $code) {
            $this->template->body->content .= strtoupper($code) . "\r\n";
        }
        echo $this->template->body->render();
        exit();
    }

    private function _convert_alpha_to_integer($alpha) {
        return base_convert($alpha, 36, 10);
    }

    private function _convert_integer_to_alpha($int) {
        return strtoupper(base_convert($int, 10, 36));
    }

    public function after() {
        if ($this->auto_render === TRUE) {
            if (empty($this->template->body->content)) {
                $this->template->body->content = '';
            }
            $body = $this->template->header->render();
            $body .= $this->template->body->render();
            $body .= $this->template->footer->render();
            $this->response->body($body);
        }
    }

}
