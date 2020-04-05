<?php

class CardController {
    private $css_class = "";
    private $url = "";

    function __construct($url) {
        $this->url = $url;
        $this->css_class = $this->extract_name($url);
    }

    function get_name(){
        return $this->css_class;
    }

    function get_css_block(){
        return "\n.".$this->get_name()."{background:url(".$this->url.") center center no-repeat;}";
    }

    function get_html_simple_block(){
        return "\r<div class=\"card {toggle:'".$this->get_name()."'}\"></div>";
    }

    function get_html_block(){
        return "\r<div class=\"card {toggle:'".$this->get_name()."'}\">
						\r<div class=\"off\"></div>
						\r<div class=\"on\"></div>
					</div>";
    }
    private function extract_name($str){
        $tmp = pathinfo($str);
        return $tmp['filename'];
    }
}

