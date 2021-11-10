<?php
class Excel extends CI_Model
{
 function select()
 {
   $this->db->query('select * from datamhs');
    $query = $this->db->get('datamhs');
    return $query;
   }

 function insert($data)
 {
  $this->db->insert_batch('datamhs', $data);
 }

 public function view()
 {
     return $this->db->get('datamhs')->result(); // Tampilkan semua data yang ada di tabel siswa
 }
}
