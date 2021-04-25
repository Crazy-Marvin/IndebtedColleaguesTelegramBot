<?php
if(strpos($text, "/newFood")===0 and in_array($userId, $adminId)== True) {
    $command = explode(" ", $text, 3);
    $food = $command[1];
    $price = $command[2];
    $selectFood = mysqli_query($mysqli, "SELECT * FROM `tg_foods` WHERE `food` LIKE '%$food%'");
    if($rowFood = mysqli_fetch_assoc($selectFood)) {
        sendMessage($chatId, "❗️ This foods already exists.");
    } else {
        $insertFoods = mysqli_query($mysqli, "INSERT INTO `halmpwct_indebtedcolleagues`.`tg_foods` (`id`, `food`, `price`) VALUES (NULL, '$food', '$price')");
        sendMessage($chatId, "✔️ I have added <i>$food</i> to the foods list.");
    }
}

if(strpos($text, "/delFood")===0 and in_array($userId, $adminId)== True) {
    $command = explode(" ", $text, 2);
    $food = $command[1];
    $selectFood = mysqli_query($mysqli, "SELECT * FROM `tg_foods` WHERE `id` = $food");
    if($rowFood = mysqli_fetch_assoc($selectFood)) {
        $recordFood = $rowFood["food"];
        $deleteFood = mysqli_query($mysqli, "DELETE FROM `tg_foods` WHERE `tg_foods`.`id` = $food");
        sendMessage($chatId, "✔️ I have removed <i>$recordFood</i> to the foods list.");
    } else {
        sendMessage($chatId, "❗️ Foods not found.");
    }
}

if(strpos($text, "/listFoods")===0 and in_array($userId, $adminId)== True) {
    $selectFood = mysqli_query($mysqli, "SELECT * FROM `tg_foods` ORDER BY `tg_foods`.`id` ASC");
    $numFood = mysqli_num_rows($selectFood);
    $listFood = fopen("database/foods.txt", "w");
    fwrite($listFood, "");
    fclose($listFood);
    while($increment <= $numFood) {
        $rowFood = mysqli_fetch_assoc($selectFood);
        $recordId = $rowFood["id"];
        $recordFood = $rowFood["food"];
        $recordPrice = $rowFood["price"];
        $file = fopen("database/foods.txt", "a+");
        fwrite($file, "<code>[$recordId]</code> <b>-</b> $recordFood ($recordPrice$)\n");
        fclose($file);
        $increment++;
    }
    $resultFile = file_get_contents("database/foods.txt");
    sendMessage($chatId, "🍎 <u>Foods List</u>:\n$resultFile");
}
?>