<?php

$data = $_POST['email'];



$arry[] = explode(',', $data);





foreach ($arry as $row) {
    $arlength = count($row);
    for ($i = 0; $i < $arlength; $i++) {
        $farry[] = explode(',', $row[$i]);
    }
}

header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=file.csv");
header("Pragma: no-cache");
header("Expires: 0");

$file = fopen('php://output', 'w');
fputcsv($file, array('Email'));
foreach ($farry as $row) {
    fputcsv($file, $row);
}
exit();








