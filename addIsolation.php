<?php include_once("sessionCheck.php"); include_once("header.php");?>
    <div class="mainContent">
        <div class="jumbotron isocd-jtron">
            <p class="page-title">Add Isolation</p>
            <hr class="isolTitleHR">
            <div class="card addIso-card">
                <p class="card-header addIso-card-header">Select Asset to Isolate</p>
                <div class="card-body">
                    <canvas hidden="" id="qr-canvas"></canvas>
                    <button type="button" class="btn btn-secondary addIso-btn" id="btn-scan-qr"><i class="fas fa-barcode"></i>&#160;&#160;Scan Asset QR Code</button>
                    <div id="qr-result" hidden=""><b>Data:</b> <span id="outputData"></span></div>
                    <form method="post">
                        <input type="number" id="assetID" name="assetIDfromForm" hidden="true">
                        <button id="hiddenPostBtn" type="submit" name="submit" hidden="true"></button>
                    </form>
                </div>
            </div>
            <script src="js/qrAdd.min.js"></script>
            <div class="modal fade" id="notFound" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <i class="fa fa-exclamation-circle modalTitleFA" aria-hidden="true"></i>
                            <h5 class="modal-title"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;&nbsp;&nbsp;Close</button>
                        </div>
                    </div>
                </div>    
            </div>    
            <div class="modal fade" id="assetFound" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <i class="fa fa-question-circle modalTitleFA" aria-hidden="true"></i>
                            <h5 class="modal-title"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="yesButton" data-dismiss="modal" onclick="window.location.href = 'addDevices.php';"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Yes</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;No</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="alreadyIsod" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <i class="fa fa-exclamation-circle modalTitleFA" aria-hidden="true"></i>
                            <h5 class="modal-title"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="editButton" data-dismiss="modal" onclick="window.location.href = 'editDevices.php';"><i class="fa fa-pencil-square-o"></i>&nbsp;&nbsp;&nbsp;Edit</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-undo"></i>&nbsp;&nbsp;&nbsp;Change Asset</button>
                        </div>
                    </div>
                </div>
            </div>
<?php include_once("footer.php");
if (array_key_exists("submit", $_POST)) {
    $post_assetID = $_POST['assetIDfromForm'];
    include("db_connection.php");
    $getAssetQRY = "SELECT * FROM `assets` WHERE `asset_id` = $post_assetID";
    $isolationCheckQRY = "SELECT * FROM `isolations` WHERE `assets_asset_id` = $post_assetID AND `date_removed` IS NULL";
    if ($assetQRES = mysqli_query($link, $getAssetQRY)) {
        $row = mysqli_fetch_assoc($assetQRES);
        if (isset($row)) {
            if ($assetAlreadyIsod = mysqli_query($link, $isolationCheckQRY)) {
                $assetIsolatedRow = mysqli_fetch_assoc($assetAlreadyIsod);
                if (isset($assetIsolatedRow)) {
                    $modalOPstring = $row['asset_name']."-".$row["description"]." already has current isolations - do you want to edit these or change to another asset?";
                    $_SESSION['currentAssetID'] = $row['asset_id'];
                    $_SESSION['currentAssetDesc'] = $row['asset_name']."-".$row["description"];
                    ?>
                    <script type='text/javascript'> $(document).ready(function(){ 
                        launchAI("Warning", '<?php echo $modalOPstring ?>');
                        $('#assetFound').on('shown.bs.modal', function(event) {
                            $('#editButton').focus();
                        })
                        });
                    </script>
                    <?php
                } else {
                    $newAsset = $row['asset_id'];
                    $newUser = $_SESSION['id'];
                    $insertIsoSQL = "INSERT INTO `isolations`(`isolation_id`, `assets_asset_id`, `users_user_id`, `date_removed`, `steam_isolated`, `water_isolated`, `cda_isolated`, `elec_isolated`, `last_updated`) 
                            VALUES (null, $newAsset, $newUser, null, 0, 0, 0, 0, NOW())"; 
                    if (mysqli_query($link, $insertIsoSQL)) {
                        $modalOPstring = "You have selected ".$row['asset_name']."-".$row["description"]." is this correct?";
                        $_SESSION['currentAssetID'] = $row['asset_id'];
                        $_SESSION['currentAssetDesc'] = $row['asset_name']."-".$row["description"];
                        ?>
                        <script type='text/javascript'> $(document).ready(function(){ 
                            launchAF('Are you sure?', '<?php echo $modalOPstring ?>');
                            $('#assetFound').on('shown.bs.modal', function(event) {
                                $('#yesButton').focus();
                            })
                            });
                        </script>
                        <?php
                    }
                }
            } 
        } else {
        ?>
        <script type='text/javascript'> $(document).ready(function(){ 
            launchNF('Unknown Asset', 'Asset not found');
            });
        </script>
        <?php
        }
    } else {
    ?>
    <script type='text/javascript'> $(document).ready(function(){ 
        launchNF('Unknown Asset', 'Asset not found');
        });
    </script>
    <?php
    }
}
?></div></div>


