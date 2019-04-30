<?php


class Proposition_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }
    public function get_propositions($slug = FALSE)
    {
        if ($slug === FALSE)
        {
            $query = $this->db->get('proposition');
            return $query->result_array();
        }
        $query = $this->db->get_where('proposition', array('slug' => $slug));
        return $query->row_array();
    }
    public function get_proposition_id($id){
        $query = $this->db->get_where('proposition', array('id'=>$id));
        return $query->row_array();
    }

    public function add_proposition($data){
        return $this->db->insert('proposition', $data);
    }
    public function delete_proposition($id){
        return $this->db->delete('proposition', array(
            'id'=>$id
        ));
    }
    public function update_proposition($id, $data){
        $this->db->set($data);
        $this->db->where('id',$id);
        $this->db->update('proposition');
    }
}