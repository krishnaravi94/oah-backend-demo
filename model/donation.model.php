<?php
require_once PROJECT_ROOT_PATH . "\model\database.class.php";

class DonationModel extends Database
{

    public function getDonations()
    {
        return $this->select("SELECT * FROM donations");
    }

    public function createDonation()
    {
        $body = file_get_contents("php://input");

        // Decode the JSON object
        $object = json_decode($body, true);
        // print_r ($object);
        // print_r ($object['donor_name']);
        // echo ($_POST['donor_name']);
        $data = array(
            'receipt_number'=>$object['receipt_number'],
            'donor_name' => $object['donor_name'],
            'donor_address' => $object['donor_address'],
            'donor_email' => $object['donor_email'],
            'mode_of_payment' => $object['mode_of_payment'],
            'transaction_details' => $object['transaction_details'],
            'purpose_of_donation' => $object['purpose_of_donation'],
            'donation_amount' => $object['donation_amount'],
            'amount_in_words'=>$object['amount_in_words'],
            'receipt_date' => date("Y-m-d"),
            'event_date' => $object['event_date'],
            'created_by' => 1,
            'printed'=>'N',
            'email'=>'N',
            'payment_date' => $object['payment_date'],
            'status'=>$object['status'],
            'cancelled_by'=>$object['cancelled_by'],
            'cancelled_date'=>$object['cancelled_date']

        );

        return $this->insert('donations', $data);
    }
    public function updateDonation(){}
    public function deleteDonation(){}
    // public function updateReceiptNumber() {
    //     $id = $this->db->lastid();
    //     $data = array(
    //         'receipt_number' => $this->receipt_prefix . "" . $this->invoiceNum($id)
    //     );

    //     $where = array(
    //         "id" => $id
    //     );

    //     $this->db->update("donations", $data, $where, 1);
    // }
}
