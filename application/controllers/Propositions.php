<?php


class Propositions extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('proposition_model');
    }
    public function index(){
        echo "";
    }
    public function get($id=-1){
        header('Content-Type: application/json');
        if($id==-1)
            echo json_encode($this->proposition_model->get_propositions());
        else{
            $prop = $this->proposition_model->get_proposition_id($id);
            if(!$prop)
                echo json_encode(array(
                    'code'=>'1',
                    'message'=>'No proposition with that ID exists'
                ));
            else
                echo json_encode($prop);
        }
    }

    public function add(){
        header('Content-Type: application/json');
        if($this->input->method()=="post"){
            $data = array(
                'title'=>$this->input->get_post('title'),
                'description'=>$this->input->get_post('description'),
                'solution'=>$this->input->get_post('solution')
            );
            if ($this->input->get_post('risks'))
                $data['risks']=$this->input->get_post('risks');
            if ($this->input->get_post('examples'))
                $data['examples']=$this->input->get_post('examples');
            if ($this->input->get_post('budget'))
                $data['budget']=$this->input->get_post('budget');
            if ($this->input->get_post('law'))
                $data['law']=$this->input->get_post('law');
            if ($this->input->get_post('environment'))
                $data['environment']=$this->input->get_post('environment');
            if ($this->input->get_post('equality'))
                $data['equality']=$this->input->get_post('equality');
            if ($this->input->get_post('reference'))
                $data['reference']=$this->input->get_post('reference');
            $this->proposition_model->add_proposition($data);
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

    public function delete($id){
        header('Content-Type: application/json');
        if($this->input->method()=="delete"){
            $prop = $this->proposition_model->get_proposition_id($id);
            if(!$prop)
                echo json_encode(array(
                    'code'=>'1',
                    'message'=>'No proposition with that ID exists'
                ));
            else {
                $this->proposition_model->delete_proposition($id);
                echo json_encode(array(
                    'code' => '0',
                    'message' => 'Proposition deleted successfully (ID: '.$id.')'
                ));
            }
        }
        else
            echo json_encode(array(
                'code' => '1',
                'message' => 'Methods other than DELETE are not supported'
            ));
    }
}