<?php
if(strpos($text, "/statistic")===0 and in_array($userId, $adminId)== True) {
    $selectColleague = mysqli_query($mysqli, "SELECT * FROM `tg_colleagues`");
    $numColleague = mysqli_num_rows($selectColleague);
    $listInvoice = fopen("database/statistic.txt", "w");
    fwrite($listInvoice, "");
    fclose($listInvoice);
    while($increment <= $numColleague) {
        $rowColleague = mysqli_fetch_assoc($selectColleague);
        $recordColleague = $rowColleague["colleague"];
        $selectInvoice = mysqli_query($mysqli, "SELECT SUM(price) AS price_sum FROM `tg_invoices` WHERE `colleague` LIKE '$recordColleague'"); 
        $rowInvoice = mysqli_fetch_assoc($selectInvoice); 
        $sumInvoice = $rowInvoice['price_sum'];
        if(!empty($sumInvoice)) {
            $file = fopen("database/statistic.txt", "a+");
            fwrite($file, "$recordColleague <b>-</b> ($sumInvoice$)\n");
            fclose($file);
        }
        $increment++;
    }
    $resultFile = file_get_contents("database/statistic.txt");
    sendMessage($chatId, "📊 <u>Statistic</u>:\n$resultFile");
}
?>