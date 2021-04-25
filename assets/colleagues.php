<?php
if(strpos($text, "/newColleague")===0 and in_array($userId, $adminId)== True) {
    $command = explode(" ", $text, 2);
    $colleague = $command[1];
    $selectColleague = mysqli_query($mysqli, "SELECT * FROM `tg_colleagues` WHERE `colleague` LIKE '%$colleague%'");
    if($rowColleague = mysqli_fetch_assoc($selectColleague)) {
        sendMessage($chatId, "❗️ This colleague already exists.");
    } else {
        $insertColleague = mysqli_query($mysqli, "INSERT INTO `halmpwct_indebtedcolleagues`.`tg_colleagues` (`id`, `colleague`) VALUES (NULL, '$colleague')");
        sendMessage($chatId, "✔️ I have added <i>$colleague</i> to the colleague list.");
    }
}

if(strpos($text, "/delColleague")===0 and in_array($userId, $adminId)== True) {
    $command = explode(" ", $text, 2);
    $colleague = $command[1];
    $selectColleague = mysqli_query($mysqli, "SELECT * FROM `tg_colleagues` WHERE `id` = $colleague");
    if($rowColleague = mysqli_fetch_assoc($selectColleague)) {
        $recordColleague = $rowColleague["colleague"];
        $deleteColleague = mysqli_query($mysqli, "DELETE FROM `tg_colleagues` WHERE `colleagues`.`id` = $colleague");
        sendMessage($chatId, "✔️ I have removed <i>$recordColleague</i> to the colleague list.");
    } else {
        sendMessage($chatId, "❗️ Colleague not found.");
    }
}

if(strpos($text, "/listColleagues")===0 and in_array($userId, $adminId)== True) {
    $selectColleague = mysqli_query($mysqli, "SELECT * FROM `tg_colleagues` ORDER BY `colleagues`.`id` ASC");
    $numColleague = mysqli_num_rows($selectColleague);
    $listColleague = fopen("database/colleagues.txt", "w");
    fwrite($listColleague, "");
    fclose($listColleague);
    while($increment <= $numColleague) {
        $rowColleague = mysqli_fetch_assoc($selectColleague);
        $recordId = $rowColleague["id"];
        $recordColleague = $rowColleague["colleague"];
        $file = fopen("database/colleagues.txt", "a+");
        fwrite($file, "<code>[$recordId]</code> <b>-</b> $recordColleague\n");
        fclose($file);
        $increment++;
    }
    $resultFile = file_get_contents("database/colleagues.txt");
    sendMessage($chatId, "⛑ <u>Colleague List</u>:\n$resultFile");
}
?>