<?php


class Besoin_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }
    public function get_besoins($slug = FALSE)
    {
        if ($slug === FALSE)
        {
            $query = $this->db->get('besoin');
            return $query->result_array();
        }
        $query = $this->db->get_where('besoin', array('slug' => $slug));
        return $query->row_array();
    }
    public function get_besoin_id($id){
        $query = $this->db->get_where('besoin', array('id'=>$id));
        return $query->row_array();
    }
    public function get_besoin_title($title){
        $query = $this->db->get_where('besoin', array('title'=>$title));
        return $query->row_array();
    }
    public function add_besoin($data){
        return $this->db->insert('besoin', $data);
    }
    public function delete_besoin($id){
        return $this->db->delete('besoin', array(
            'id'=>$id
        ));
    }
    public function update_besoin($id, $besoin){
        $this->db->set('title', $besoin);
        $this->db->where('id',$id);
        $this->db->update('besoin');
    }
}