<?php
    session_start();
    if (array_key_exists("id", $_COOKIE)) {
        $_SESSION["id"] = $_COOKIE['id'];
    }
    if (array_key_exists("id", $_SESSION)) {
        echo "<a href='index.php?logout=1' style='position: fixed; z-index: 999; width:52px; height:52px; bottom:22px; right:24px; background-color:#C36000; color:#FFF; border-radius:50px; text-align:center; box-shadow: 2px 2px 3px #999;'><i class='fas fa-sign-out-alt fa-2x' style='margin-top:13px; margin-left:2px;'></i></a>";
    } else {
        header("Location: index.php");
    }
?>

