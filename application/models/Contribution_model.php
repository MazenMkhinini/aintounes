<?php


class Contribution_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }
    public function get_contributions($slug = FALSE)
    {
        if ($slug === FALSE)
        {
            $query = $this->db->get('contribution');
            return $query->result_array();
        }
        $query = $this->db->get_where('contribution', array('slug' => $slug));
        return $query->row_array();
    }
    public function get_contribution_id($id){
        $query = $this->db->get_where('contribution', array('id'=>$id));
        return $query->row_array();
    }
    public function get_contribution_prop($id){
        $query = $this->db->get_where('contribution', array('proposition_id'=>$id));
        return $query->result_array();
    }

    public function add_contribution($data){
        return $this->db->insert('contribution', $data);
    }
    public function delete_contribution($id){
        return $this->db->delete('contribution', array(
            'id'=>$id
        ));
    }
    public function update_contribution($id, $data){
        $this->db->set($data);
        $this->db->where('id',$id);
        $this->db->update('contribution');
    }
}