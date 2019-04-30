<?php


class Theme_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }
    public function get_themes($slug = FALSE)
    {
        if ($slug === FALSE)
        {
            $query = $this->db->get('theme');
            return $query->result_array();
        }
        $query = $this->db->get_where('theme', array('slug' => $slug));
        return $query->row_array();
    }
    public function get_theme_id($id){
        $query = $this->db->get_where('theme', array('id'=>$id));
        return $query->row_array();
    }
    public function get_theme_title($title){
        $query = $this->db->get_where('theme', array('title'=>$title));
        return $query->row_array();
    }
    public function add_theme($data){
        return $this->db->insert('theme', $data);
    }
    public function delete_theme($id){
        return $this->db->delete('theme', array(
            'id'=>$id
        ));
    }
    public function update_theme($id, $theme){

        $this->db->set('title', $theme);
        $this->db->where('id',$id);
        $this->db->update('theme');
    }
}