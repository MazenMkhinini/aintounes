<?php


class TestController extends CI_Controller
{
    public function index(){
        if($this->input->method()=='post')
            echo $this->input->get_post('title');
        else
            show_404();
    }
    public function test(){
        echo"test";
    }
}