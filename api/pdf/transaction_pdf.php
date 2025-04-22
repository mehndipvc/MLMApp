<?php
header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: GET');
header('Acess-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

include('../dbcon.php');
include('../common_functions.php');

require __DIR__ . '/vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$startDate = $_GET['startDate'];
$endDate = $_GET['endDate'];

if ($startDate == "") {
    $query = "SELECT *,(SELECT users.name FROM users WHERE users.user_id = transaction_records.for_user) AS user_name,(SELECT users.user_type FROM users WHERE users.user_id = transaction_records.for_user) AS user_type FROM `transaction_records` WHERE 1";
} else {
    $query = "SELECT *,(SELECT users.name FROM users WHERE users.user_id = transaction_records.for_user) AS user_name,(SELECT users.user_type FROM users WHERE users.user_id = transaction_records.for_user) AS user_type FROM `transaction_records` WHERE `date` BETWEEN '$startDate' AND '$endDate' ORDER BY id DESC";
}

$query_run = mysqli_query($conn, $query);

$html = '<link rel="stylesheet" href="https://unpkg.com/gutenberg-css@0.7">';
$html .= '<span style="width: 100%;text-align:end;font-size: 13px;"><em>Printed on '.date('d-m-Y').' at '.date('H:m:s').'</em></span>';
$html .= '<br>';
$html .= '<br>';
$html .= '<span><b>MEHNDI INTERIOR</b></span>';
$html .= '<br>';
$html .= '<span>DHAMAITALA LANE, DAKSHIN JAGADDAL</span>';
$html .= '<br>';
$html .= '<span>SONARPUR(RAJPUR)</span>';
$html .= '<br>';
$html .= '<span>KOLKATA - 700151</span>';
$html .= '<br>';
$html .= '<span>Contact : 033-29568455, Toll Free- 18008911988</span>';
$html .= '<br>';
$html .= '<span>www.mehndiinterior.com</span>';
$html .= '<br>';
$html .= '<br>';
$html .= '<span><b>SAIKAT LAHA</b></span>';
$html .= '<br>';
$html .= '<span>Ledger Account</span>';
$html .= '<br>';
$html .= '<span>GOLAPATI, KRISHNANAGAR, NADIA</span>';
$html .= '<br>';
if ($startDate != "") {
    $html .= '<span style="font-size: 13px;">'.$startDate.'to'.$endDate.'</span>';
}
$html .= '<br>';
$html .= '<br>';
$html .= '<table style="width: 100%;">';
$html .= '<thead>';
$html .= '<tr>';
$html .= '<th>Date</th>';
$html .= '<th>User</th>';
$html .= '<th>User Type</th>';
$html .= '<th>Type</th>';
$html .= '<th>Vch Type</th>';
$html .= '<th>Debit</th>';
$html .= '<th>Credit</th>';
$html .= '</tr>';
$html .= '</thead>';
$html .= '<tbody>';
while ($row = mysqli_fetch_assoc($query_run)) {
    $type = "";
    $debitAmount = "";
    $creditAmount = "";
    
    if ($row['type'] == "Received") {
        $type = "Cr";
        
        $debitAmount = "";
        $creditAmount = $row['amount'];
    } else {
        $type = "Dr";
        
        $debitAmount = $row['amount'];
        $creditAmount = "";
    }
    
    $html .= '<tr>';
    $html .= '<td>'.$row['date'].'</td>';
    $html .= '<td>'.$row['user_name'].' ('.$row['for_user'].')'.'</td>';
    $html .= '<td>'.$row['user_type'].'</td>';
    $html .= '<td>'.$type.'</td>';
    $html .= '<td>'.$row['type'].'</td>';
    $html .= '<td>'.$debitAmount.'</td>';
    $html .= '<td>'.$creditAmount.'</td>';
    $html .= '</tr>';
}
$html .= '</tbody>';
$html .= '</table>';

$options = new Options();
$options->setIsRemoteEnabled(true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);

$dompdf->render();
$dompdf->stream('transaction_report.pdf', ['Attachment' => 0]);