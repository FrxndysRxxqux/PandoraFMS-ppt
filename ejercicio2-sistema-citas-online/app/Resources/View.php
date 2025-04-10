<?php
namespace App\Resources;

class View {
    protected $template;
    protected $data = [];

    public function render($template, $data = []) {
        $this->template = $template;
        $this->data = $data;

        //convert associative array keys into variables
        extract($this->data);

        //include the template
        include $this->template;
    }
}