<?php


class Support extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('support_model');
    }
    public function get($id=-1){
        header('Content-Type: application/json');
        if($id==-1)
            echo json_encode($this->support_model->get_support());
        else{
            $prop = $this->support_model->get_support_id($id);
            if(!$prop)
                echo json_encode(array(
                    'code'=>'1',
                    'message'=>'No support with that ID exists'
                ));
            else
                echo json_encode($prop);
        }
    }

    public function getpropcount($id){
        header('Content-Type: application/json');
        echo json_encode($this->support_model->get_support_count($id));
    }

    public function getbyuser($id){
        header('Content-Type: application/json');
        echo json_encode($this->support_model->get_support_user($id));
    }

    public function getbyproposition($id){
        header('Content-Type: application/json');
        echo json_encode($this->support_model->get_support_proposition($id));
    }

    public function set(){
        $this->load->model('proposition_model');
        header('Content-Type: application/json');
        if($this->input->method()=="post"){
            if (!$this->input->get_post('user_id')){
                echo json_encode(array(
                    'code'=>1,
                    'message'=>'A user ID must be provided'
                ));
                return;
            }
            if (!$this->input->get_post('proposition_id')){
                echo json_encode(array(
                    'code'=>1,
                    'message'=>'A proposition ID must be provided'
                ));
                return;
            }

            $data = array(
                'user_id'=>html_entity_decode($this->security->xss_clean($this->input->get_post('user_id'))),
                'proposition_id'=>html_entity_decode($this->security->xss_clean($this->input->get_post('proposition_id'))),
            );
            if(!$this->proposition_model->get_proposition_id($data['proposition_id'])){
                echo json_encode(array(
                    'code'=>1,
                    'message'=>'No proposition with that id exists ('.$data['proposition_id'].')'
                ));
                return;
            }

            $this->input->get_post('essentielle')=='1'?$essentielle=1:$essentielle=0;
            $this->input->get_post('realisable')=='1'?$realisable=1:$realisable=0;
            $this->input->get_post('innovante')=='1'?$innovante=1:$innovante=0;

            $data['essentielle'] = $essentielle;
            $data['realisable'] = $realisable;
            $data['innovante'] = $innovante;

            $support = $this->support_model->get_support_both($data['user_id'], $data['proposition_id']);
            if($support){
                $data = array();
                $data['essentielle'] = $essentielle;
                $data['realisable'] = $realisable;
                $data['innovante'] = $innovante;
                $this->support_model->update_support($support['id'], $data);
                echo json_encode(array(
                    'code'=>0,
                    'message'=>'Data updated successfully'
                ));
                return;
            }
            else
                $this->support_model->add_support($data);

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
}