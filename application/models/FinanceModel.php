<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FinanceModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getcenter()
    {
        $this->db->select('id ,name');
        $query = $this->db->get('center_details');


        return $query->result();
    }

    public function getstudents()
    {
        $this->db->select('s.id, s.name, s.total_fees, s.remaining_amount, s.created_at, s.center_id, s.batch_id, 
                       b.batch_name as batch_name, c.name as center_name');
        $this->db->from('students s');
        $this->db->join('batches b', 's.batch_id = b.id', 'left'); 
        $this->db->join('center_details c', 's.center_id = c.id', 'left'); 
        $query = $this->db->get();

        return $query->result();
    }

    public function getExpensesWithCenter()
{
    $this->db->select('
        expenses.id,
        expenses.center_id,
        expenses.title,
        expenses.date,
        expenses.amount,
        expenses.category,
        expenses.description,
        expenses.type,
        expenses.created_at,
        center_details.name as center_name,
        
        center_details.address
    ');
    $this->db->from('expenses');
    $this->db->join('center_details', 'center_details.id = expenses.center_id', 'left');
    $this->db->order_by('expenses.date', 'DESC');
    
    $query = $this->db->get();
    return $query->result();
}







}