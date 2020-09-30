<?php 
    include_once("sessionCheck.php");
    include_once("header.php"); 
?>
    <div class="mainContent">
        <div class="jumbotron isocd-jtron">
            <p class="page-title text-nowrap">Factory 2 Isolations</p>
            <hr class="isolTitleHR">
            <div class="card-deck">
<?php
    include("db_connection.php");

    $f2IsolationsQuery = "SELECT isolations.*, `user_firstName`, `user_lastName`, `user_telephone`, `asset_name`, `location`, `description` FROM `isolations` JOIN users ON `users_user_id` = `user_id` JOIN assets ON `assets_asset_id` = `asset_id` WHERE `date_removed` IS NULL AND `location` = \"F2\" ORDER BY `last_updated` DESC";

    if ($result = mysqli_query($link, $f2IsolationsQuery)) {

        while ($row = mysqli_fetch_assoc($result)) {

            $displayTimestamp = new DateTime($row['date_isolated']);
            $updateTimestamp = new DateTime($row['last_updated']);

            include("isolationCard.php");
        }
    } else {

        echo "There are no registered isolations";
    }
?>
        </div>	
    </div>
</div>
<?php include_once("footer.php"); ?>

