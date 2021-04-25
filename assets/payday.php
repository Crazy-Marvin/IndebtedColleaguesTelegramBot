<?php
if(strpos($text, "/payday")===0 and in_array($userId, $adminId)== True) {
    $selectInvoice = mysqli_query($mysqli, "SELECT * FROM `tg_invoices` ORDER BY `tg_invoices`.`id` ASC");
    $numInvoice = mysqli_num_rows($selectInvoice);
    $listInvoice = fopen("database/invoices.txt", "w");
    fwrite($listInvoice, "");
    fclose($listInvoice);
    while($increment <= $numInvoice) {
        $rowInvoice = mysqli_fetch_assoc($selectInvoice);
        $recordId = $rowInvoice["id"];
        $recordAgent = $rowInvoice["colleague"];
        $recordFood = $rowInvoice["food"];
        $recordPrice = $rowInvoice["price"];
        $file = fopen("database/invoices.txt", "a+");
        fwrite($file, "<code>[$recordId]</code> <b>-</b> $recordAgent <b>-</b> $recordFood (<i>$recordPrice</i>$)\n");
        fclose($file);
        $increment++;
    }
    $resultFile = file_get_contents("database/invoices.txt");
    sendMessage($chatId, "💰 <u>Invoices List</u>:\n$resultFile");
}
?>