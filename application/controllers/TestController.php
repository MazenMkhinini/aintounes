<?php


class TestController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('proposition_model');
        $this->load->model('theme_model');
        $this->load->model('besoin_model');
    }
    public function index(){
        if($this->input->method()=='post')
            echo $this->input->get_post('title');
        else
            show_404();
    }
    public function test(){
        print_r($this->theme_model->get_theme_title('Administration'));
    }
}