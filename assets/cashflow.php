<?php
if(strpos($text, "/cashflow")===0 and in_array($userId, $adminId)== True) {
    $command = explode(" ", $text, 3);
    $name = $command[1];
    $surname = $command[2];
    $colleague = $name . " " . $surname;
    $selectColleague = mysqli_query($mysqli, "SELECT * FROM `tg_colleagues` WHERE `colleague` LIKE '$Colleague'");
    if($rowColleague = mysqli_fetch_assoc($selectColleague)) {
        $selectInvoices = mysqli_query($mysqli, "SELECT * FROM `tg_invoices` WHERE `colleague` LIKE '$Colleague'");
        if($rowInvoices = mysqli_fetch_assoc($selectInvoices)) {
            $selectInvoices = mysqli_query($mysqli, "SELECT * FROM `tg_invoices` WHERE `colleague` LIKE '$Colleague'");
            $numInvoices = mysqli_num_rows($selectInvoices);
            while($increment <= $numInvoices) {
                $rowInvoices = mysqli_fetch_assoc($selectInvoices);
                $recordPrice = $rowInvoices["price"];
                $totalCount += $recordPrice;
                $file = fopen("database/cashflow.txt", "w");
                fwrite($file, "$totalCount");
                fclose($file);
                $deleteInvoices = mysqli_query($mysqli, "DELETE FROM `tg_invoices` WHERE `tg_invoices`.`colleague` LIKE '$Colleague'");
                $increment++;
            }
            $resultFile = file_get_contents("database/cashflow.txt");
            sendMessage($chatId, "✔️ All colleague's invoices have been deleted <i>($resultFile$)</i>.");
        } else {
            sendMessage($chatId, "❗️ This colleague have no invoices.");
        }
    } else {
        sendMessage($chatId, "❗️ Colleague not found.");
    }
}
?>