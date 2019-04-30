<?php


class Besoins extends CI_Controller
{
    public function get($id=-1){
        $this->load->model('besoin_model');
        header('Content-Type: application/json');
        if($id==-1)
            echo json_encode($this->besoin_model->get_besoins());
        else{
            $prop = $this->proposition_model->get_besoin_id($id);
            if(!$prop)
                echo json_encode(array(
                    'code'=>'1',
                    'message'=>'No need with that ID exists'
                ));
            else
                echo json_encode($prop);
        }
    }
    public function add(){
        $this->load->model('besoin_model');
        header('Content-Type: application/json');
        if($this->input->method()=="post"){
            $data = array(
                'title'=>html_entity_decode($this->security->xss_clean($this->input->get_post('title'))),
            );

            $this->besoin_model->add_besoin($data);
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
                    'message'=>'You must provide an ID to update a need'
                ));
                return;
            }
            $id = html_entity_decode($this->security->xss_clean($this->input->get_post('id')));
            if(!$this->theme_model->get_besoin_id($id)){
                echo json_encode(array(
                    'code'=>1,
                    'message'=>'No need with that ID exists ('.$id.')'
                ));
                return;
            }
            $data = array(
                'id'=>$id,
                'title'=>html_entity_decode($this->security->xss_clean($this->input->get_post('title')))
            );

            $this->besoin_model->update_besoin($data['id'], $data['title']);
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