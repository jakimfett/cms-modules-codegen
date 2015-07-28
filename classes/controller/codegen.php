<?php

class Controller_Codegen extends Controller_Template
{

    public $template  = 'template/blank';
    public $title;
    public $limit     = 10;
    public $locations = array('q7', '7w', 'tn');
    public $codes     = array();
    public $min;
    public $max;

    /**
     * Loads the template [View] object.
     */
    public function before()
    {
        parent::before();

        Theme::set_theme('labyrinth');

        $this->title = 'Promo Code Generator';

        $this->template->header          = View::factory('template/header');
        $this->template->header->scripts = array(
            'https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js',
            'media/labyrinth/js/script.js',
            'media/labyrinth/js/jquery.fitvids.js'
        );

        $this->template->header->title = $this->title;
        $this->template->body          = View::factory('template/generate');
        $this->template->footer        = View::factory('template/footer');


        $this->limit = $this->request->param('limit', 10);

        $this->min = $this->_convert_alpha_to_integer('10');
        $this->max = $this->_convert_alpha_to_integer('zz');
    }

    public function action_generate()
    {

        foreach ($this->locations as $location) {
            for ($i = 0; $i < $this->limit; $i++) {
                $duplicate = true;
                while ($duplicate) {
                    $random = rand($this->min, $this->max);
                    if (!in_array($random, $this->codes)) {
                        $duplicate     = false;
                        $this->codes[] = $location . $this->_convert_integer_to_alpha($random);
                    }
                }
            }
        }

        $this->template->body->min          = $this->min;
        $this->template->body->max          = $this->max;
        $this->template->body->codes        = $this->codes;
        $this->template->body->total_unique = $this->max - $this->min;
        $this->template->body->locations    = $this->locations;
    }

    private function _convert_alpha_to_integer($alpha)
    {
        return base_convert($alpha, 36, 10);
    }

    private function _convert_integer_to_alpha($int)
    {
        return base_convert($int, 10, 36);
    }

    public function after()
    {
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
