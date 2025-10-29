<?php
class PaymentModel extends CI_Model {
    public function insert($data) {
        $this->db->insert('payments', $data);
        return $this->db->insert_id();
    }

    public function insertInstallments($payment_id, $installments) {
        foreach ($installments as $i => $ins) {
            $this->db->insert('installments', [
                'payment_id' => $payment_id,
                'installment_no' => $i + 1,
                'amount' => $ins['amount'],
                'due_date' => $ins['due_date']
            ]);
        }
    }
}
