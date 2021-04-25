<?php
if(strpos($text, "/newInvoice")===0 and in_array($userId, $adminId)== True) {
    $command = explode(" ", $text, 4);
    $name = $command[1];
    $surname = $command[2];
    $food = $command[3];
    $colleague = $name . " " . $surname;
    $selectColleague = mysqli_query($mysqli, "SELECT * FROM `tg_colleagues` WHERE `colleague` LIKE '$colleague'");
    $selectFood = mysqli_query($mysqli, "SELECT * FROM `tg_foods` WHERE `food` LIKE '$food'");
    if(($rowColleague = mysqli_fetch_assoc($selectColleague)) AND ($rowFood = mysqli_fetch_assoc($selectFood))){
        $recordPrice = $rowFood["price"];
        $insertInvoice = mysqli_query($mysqli, "INSERT INTO `halmpwct_indebtedcolleagues`.`tg_invoices` (`id`, `colleague`, `food`, `price`) VALUES (NULL, '$colleague', '$food', '$recordPrice')");
        sendMessage($chatId, "✔️ I have created new invoice for <i>$colleague</i>.");
    } else {
        sendMessage($chatId, "❗️ Something went wrong.");
    }
}

if(strpos($text, "/delInvoice")===0 and in_array($userId, $adminId)== True) {
    $command = explode(" ", $text, 2);
    $invoices = $command[1];
    $selectInvoices = mysqli_query($mysqli, "SELECT * FROM `tg_invoices` WHERE `id` = $invoices");
    if($rowInvoices = mysqli_fetch_assoc($selectInvoices)) {
        $recordColleague = $rowInvoices["colleague"];
        $deleteInvoices = mysqli_query($mysqli, "DELETE FROM `tg_invoices` WHERE `invoices`.`id` = $invoices");
        sendMessage($chatId, "✔️ I have removed <i>$recordColleague</i> to the invoices list.");
    } else {
        sendMessage($chatId, "❗️ Invoices not found.");
    }
}
?>