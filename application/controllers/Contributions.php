<?php

class Contributions extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('contribution_model');
        $this->load->model('theme_model');
        $this->load->model('besoin_model');
    }
    public function index(){
        echo "";
    }
    public function get($id=-1){
        header('Content-Type: application/json');
        if($id==-1)
            echo json_encode($this->contribution_model->get_contributions());
        else{
            $prop = $this->contribution_model->get_contribution_id($id);
            if(!$prop)
                echo json_encode(array(
                    'code'=>'1',
                    'message'=>'No contribution with that ID exists'
                ));
            else
                echo json_encode($prop);
        }
    }

    public function getbyprop($id){
        header('Content-Type: application/json');
        $prop = $this->contribution_model->get_contribution_prop($id);
        echo json_encode($prop);

    }

    public function add(){
        header('Content-Type: application/json');
        if($this->input->method()=="post"){
            if(!$this->input->get_post('user_id')){
                echo json_encode(array(
                    'code'=>1,
                    'message'=>'A user ID must be provided'
                ));
                return;
            }
            $data = array(
                'title'=>html_entity_decode($this->security->xss_clean($this->input->get_post('title'))),
                'description'=>html_entity_decode($this->security->xss_clean($this->input->get_post('description'))),
                'solution'=>html_entity_decode($this->security->xss_clean($this->input->get_post('solution'))),
                'user_id'=>html_entity_decode($this->security->xss_clean($this->input->get_post('user_id'))),
            );
            if(!$this->input->get_post('proposition_id')){
                if (!$this->input->get_post('contribution_id')) {
                    echo json_encode(array(
                        'code' => 1,
                        'message' => 'A contribution or proposition ID must be provided'
                    ));
                    return;
                }
                else
                    $data['contribution_id'] = html_entity_decode($this->security->xss_clean($this->input->get_post('contribution_id')));
            }
            else {
                $data['proposition_id'] = html_entity_decode($this->security->xss_clean($this->input->get_post('proposition_id')));
            }
            if($this->input->get_post('approved')){
                $approved = html_entity_decode($this->security->xss_clean($this->input->get_post('approved')));
                if($approved != '1' && $approved != '0')
                {
                    echo json_encode(array(
                        'code'=>1,
                        'message'=>'The field approved must be either \'1\' (true) or \'0\' (false)'
                    ));
                    return;
                }
                $data['approved'] = $approved;
            }

            if ($this->input->get_post('risks'))
                $data['risks']=html_entity_decode($this->security->xss_clean($this->input->get_post('risks')));
            if ($this->input->get_post('examples'))
                $data['examples']=html_entity_decode($this->security->xss_clean($this->input->get_post('examples')));
            if ($this->input->get_post('budget'))
                $data['budget']=html_entity_decode($this->security->xss_clean($this->input->get_post('budget')));
            if ($this->input->get_post('law'))
                $data['law']=html_entity_decode($this->security->xss_clean($this->input->get_post('law')));
            if ($this->input->get_post('environment'))
                $data['environment']=html_entity_decode($this->security->xss_clean($this->input->get_post('environment')));
            if ($this->input->get_post('equality'))
                $data['equality']=html_entity_decode($this->security->xss_clean($this->input->get_post('equality')));
            if ($this->input->get_post('reference'))
                $data['reference']=html_entity_decode($this->security->xss_clean($this->input->get_post('reference')));
            $this->contribution_model->add_contribution($data);
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
                    'message'=>'You must provide an ID to update a contribution'
                ));
                return;
            }

            $id = $this->security->xss_clean($this->input->get_post('id'));
            if(!$this->contribution_model->get_contribution_id($id)){
                echo json_encode(array(
                    'code'=>1,
                    'message'=>'No contribution with that ID exists ('.$id.')'
                ));
                return;
            }
            $data = array();
            if ($this->input->get_post('title'))
                $data['title']=html_entity_decode($this->security->xss_clean($this->input->get_post('title')));
            if ($this->input->get_post('description'))
                $data['description']=html_entity_decode($this->security->xss_clean($this->input->get_post('description')));
            if ($this->input->get_post('solution'))
                $data['solution']=html_entity_decode($this->security->xss_clean($this->input->get_post('solution')));
            if ($this->input->get_post('theme')) {
                $theme = $this->theme_id(html_entity_decode($this->security->xss_clean($this->input->get_post('theme'))));
                $data['theme']=$theme;
            }
            if ($this->input->get_post('besoin')) {
                $besoin = $this->theme_id(html_entity_decode($this->security->xss_clean($this->input->get_post('besoin'))));
                $data['besoin']=$besoin;
            }
            if ($this->input->get_post('risks'))
                $data['risks']=html_entity_decode($this->security->xss_clean($this->input->get_post('risks')));
            if ($this->input->get_post('examples'))
                $data['examples']=html_entity_decode($this->security->xss_clean($this->input->get_post('examples')));
            if ($this->input->get_post('budget'))
                $data['budget']=html_entity_decode($this->security->xss_clean($this->input->get_post('budget')));
            if ($this->input->get_post('law'))
                $data['law']=html_entity_decode($this->security->xss_clean($this->input->get_post('law')));
            if ($this->input->get_post('environment'))
                $data['environment']=html_entity_decode($this->security->xss_clean($this->input->get_post('environment')));
            if ($this->input->get_post('equality'))
                $data['equality']=html_entity_decode($this->security->xss_clean($this->input->get_post('equality')));
            if ($this->input->get_post('reference'))
                $data['reference']=html_entity_decode($this->security->xss_clean($this->input->get_post('reference')));
            $this->contribution_model->update_contribution($id, $data);
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

    public function delete($id){
        header('Content-Type: application/json');
        $id = html_entity_decode($this->security->xss_clean($id));
        if($this->input->method()=="delete"){
            $prop = $this->contribution_model->get_contribution_id($id);
            if(!$prop)
                echo json_encode(array(
                    'code'=>'1',
                    'message'=>'No contribution with that ID exists'
                ));
            else {
                $this->contribution_model->delete_contribution($id);
                echo json_encode(array(
                    'code' => '0',
                    'message' => 'Contribution deleted successfully (ID: '.$id.')'
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