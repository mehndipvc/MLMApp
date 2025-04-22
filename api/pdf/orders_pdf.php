<?php
header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: GET');
header('Acess-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

include('../dbcon.php');
include('../common_functions.php');

$startDate = $_GET['startDate'];
$endDate = $_GET['endDate'];

if ($startDate == "") {
    $query = "SELECT *,(SELECT users.name FROM users WHERE users.user_id = orders.user_id) AS user_name,(SELECT users.user_type FROM users WHERE users.user_id = orders.user_id) AS user_type FROM `orders` WHERE 1";
} else {
    $query = "SELECT *,(SELECT users.name FROM users WHERE users.user_id = orders.user_id) AS user_name,(SELECT users.user_type FROM users WHERE users.user_id = orders.user_id) AS user_type FROM `orders` WHERE `date` BETWEEN '$startDate' AND '$endDate'";
}

$query_run = mysqli_query($conn, $query);

require __DIR__ . '/vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

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
$html .= '<th>Order Id</th>';
$html .= '<th>Order Items</th>';
$html .= '<th>Price</th>';
$html .= '</tr>';
$html .= '</thead>';
$html .= '<tbody>';
while ($row = mysqli_fetch_assoc($query_run)) {
    $html .= '<tr>';
    $html .= '<td>'.$row['date'].'</td>';
    $html .= '<td>'.$row['user_name'].' ('.$row['user_id'].')'.'</td>';
    $html .= '<td>'.$row['user_type'].'</td>';
    $html .= '<td>'.$row['order_id'].'</td>';
    $html .= '<td>'.$row['title'].'</td>';
    $html .= '<td>'.$row['price'].'</td>';
    $html .= '</tr>';
}
$html .= '</tbody>';
$html .= '</table>';

$options = new Options();
$options->setIsRemoteEnabled(true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);

$dompdf->render();
$dompdf->stream('order_report.pdf', ['Attachment' => 0]);