<?php


class Propositions extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('proposition_model');
        $this->load->model('theme_model');
        $this->load->model('besoin_model');
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
            $theme = $this->theme_id(html_entity_decode($this->security->xss_clean($this->input->get_post('theme'))));
            $besoin = $this->besoin_id(html_entity_decode($this->security->xss_clean($this->input->get_post('besoin'))));
            $data = array(
                'title'=>html_entity_decode($this->security->xss_clean($this->input->get_post('title'))),
                'description'=>html_entity_decode($this->security->xss_clean($this->input->get_post('description'))),
                'solution'=>html_entity_decode($this->security->xss_clean($this->input->get_post('solution'))),
                'theme'=>$theme,
                'besoin'=>$besoin
            );
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

    public function update(){
        header('Content-Type: application/json');
        if($this->input->method()=="patch"){
            if(!$this->input->get_post('id')){
                echo json_encode(array(
                    'code'=>1,
                    'message'=>'You must provide an ID to update a proposition'
                ));
                return;
            }

            $id = $this->security->xss_clean($this->input->get_post('id'));
            if(!$this->proposition_model->get_proposition_id($id)){
                echo json_encode(array(
                    'code'=>1,
                    'message'=>'No proposition with that ID exists ('.$id.')'
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
            $this->proposition_model->update_proposition($id, $data);
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

    private function theme_id($theme){
        if(is_numeric($theme))
            return $theme;
        return $this->theme_model->get_theme_title($theme)['id'];
    }
    private function besoin_id($besoin){
        if(is_numeric($besoin))
            return $besoin;
        return $this->besoin_model->get_besoin_title($besoin)['id'];
    }

}