<?php


class Themes extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('theme_model');
    }
    public function get($id=-1){
        header('Content-Type: application/json');
        if($id==-1)
            echo json_encode($this->theme_model->get_themes());
        else{
            $prop = $this->proposition_model->get_theme_id($id);
            if(!$prop)
                echo json_encode(array(
                    'code'=>'1',
                    'message'=>'No theme with that ID exists'
                ));
            else
                echo json_encode($prop);
        }
    }
    public function add(){
        header('Content-Type: application/json');
        if($this->input->method()=="post"){
            $data = array(
                'title'=>html_entity_decode($this->security->xss_clean($this->input->get_post('title'))),
            );

            $this->theme_model->add_theme($data);
            echo json_encode(array(
                'code'=>0,
                'message'=>'Data added successfully'
            ));
        }
        else
            echo json_encode(array(
                'code'=>1,
                'message'=>'Methods other than POST are not supported'
            ));
    }
    public function update(){
        header('Content-Type: application/json');
        if($this->input->method()=="patch"){
            if(!$this->input->get_post('id')){
                echo json_encode(array(
                    'code'=>1,
                    'message'=>'You must provide an ID to update a theme'
                ));
                return;
            }
            $id = html_entity_decode($this->security->xss_clean($this->input->get_post('id')));
            if(!$this->theme_model->get_theme_id($id)){
                echo json_encode(array(
                    'code'=>1,
                    'message'=>'No theme with that ID exists ('.$id.')'
                ));
                return;
            }
            $data = array(
                'id'=>$id,
                'title'=>html_entity_decode($this->security->xss_clean($this->input->get_post('title')))
            );

            $this->theme_model->update_theme($data['id'], $data['title']);
            echo json_encode(array(
                'code'=>0,
                'message'=>'Data updated successfully'
            ));
        }
        else
            echo json_encode(array(
                'code'=>1,
                'message'=>'Methods other than PATCH are not supported'
            ));
    }
}