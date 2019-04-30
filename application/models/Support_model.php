<?php


class Support_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }
    public function get_support($slug = FALSE)
    {
        if ($slug === FALSE)
        {
            $query = $this->db->get('support');
            return $query->result_array();
        }
        $query = $this->db->get_where('support', array('slug' => $slug));
        return $query->row_array();
    }
    public function add_support($data){
        return $this->db->insert('support', $data);
    }

    public function get_support_user($id){
        $query = $this->db->get_where('support',array(
            'user_id'=>$id
        ));
        return $query->result_array();
    }

    public function get_support_both($user_id, $proposition_id){
        $query = $this->db->get_where('support',array(
            'user_id'=>$user_id,
            'proposition_id'=>$proposition_id
        ));
        return $query->row_array();
    }

    public function get_support_proposition($id){
        $query = $this->db->get_where('support',array(
            'proposition_id'=>$id
        ));
        return $query->row_array();
    }

    public function get_support_count($proposition_id){
        $this->db->select_sum('essentielle');
        $this->db->select_sum('innovante');
        $this->db->select_sum('realisable');
        $query = $this->db->get_where('support',array(
            'proposition_id'=>$proposition_id
        ));
        return $query->row_array();
    }

    public function update_support($id, $data){
        $this->db->set($data);
        $this->db->where('id',$id);
        $this->db->update('support');
    }
}