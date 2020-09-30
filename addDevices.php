<?php 
include_once("sessionCheck.php");
include_once("header.php"); 
$currentAsset = $_SESSION['currentAssetID'];
$currentUser = $_SESSION['id'];
if ($_SESSION['currentAssetID']) {
    include("db_connection.php");
    $getDeviceQry = "SELECT `asset_name`, `description`, `steam_isolator`, `water_isolator`, `cda_isolator`, `elec_isolator` FROM `assets` WHERE `asset_id` = $currentAsset";

    if ($getDevicesQRES = mysqli_query($link, $getDeviceQry)) {
        $deviceRow = mysqli_fetch_assoc($getDevicesQRES);
    }
    $getCurrentIsolationsQRY = "SELECT `isolation_id`, `steam_isolated`, `water_isolated`, `cda_isolated`, `elec_isolated` FROM `isolations` WHERE `assets_asset_id` = $currentAsset AND `date_removed` IS NULL";
    if ($getCurrentIso = mysqli_query($link, $getCurrentIsolationsQRY)) {
        $currIsoRow = mysqli_fetch_assoc($getCurrentIso); 
    }
} else {
    echo "error with getting session id from previous page";
}
?>  
<div class="mainContent">
    <div class="jumbotron isocd-jtron">
        <p class="page-title">Isolation devices for <?php echo $_SESSION['currentAssetDesc']; ?></p>
        <hr class="isolTitleHR">
        <div class="card addIso-card">
        <p class="card-header">Select devices to isolate</p>
            <div class="card-body editCard">
                <h6><b>Steam Isolator:&#160;</b><span id="steamVN"><?php echo $deviceRow['steam_isolator']; ?></span></h6>
                <div name='addSteamFrmName' id='addSteamFrm'>
                    <p><b>Status:&#160;<span class="steamNItext" id="steamNItextID">Not Isolated</span></b></p>
                    <button type="button" class="btn btn-secondary addIso-btn" id="btn-scan-addSteam-qr" onclick="btnScanAdd(this.id)"><i class="fa fa-barcode"></i>&#160;&#160;Scan Device QR Code</button>
                </div>
                <div name='remSteamFrmName' id='remSteamFrm'>
                    <p><b>Status:&#160;<span class="steamIText" id="steamItextID">Isolated&#160;&#160;<i class="fas fa-key"></i></span>&#160;</b></p>
                    <button type="button" class="btn btn-secondary addIso-btn" id="btn-scan-remSteam-qr" onclick="btnScanRemove(this.id)"><i class="fa fa-barcode"></i>&#160;&#160;Scan Steam Device QR Code</button>
                </div>
                <div class='canvasPH' id="steamCanvasPH"></div>
				<canvas class="scanCanvas" hidden="" id="qr-canvas"></canvas>
                <div class='resultPH' id='steamResultPH'></div>
                <div id="qr-result" hidden=""><b>Data:</b> <span id="outputData"></div>
                    <form method="post">
                        <input type="text" id="steamDeviceID" name="steamDeviceID" hidden="true">
                        <button id="hdBtnAddSteamId" type="submit" name="submit" value="hdPostBtnAddSte" hidden="true"></button>
                        <button id="hdBtnRemSteamId" type="submit" name="submit" value="hdPostBtnRemSte" hidden="true"></button>
                    </form>
            </div>
        <hr class="devcd-divider"> 
        <div class="card-body editCard">
            <h6><b>Water Isolator:&#160;</b><span id="waterVN"><?php echo $deviceRow['water_isolator']; ?></span></h6>
            <div name='addWaterFrmName' id='addWaterFrm'>
                <p><b>Status:&#160;<span class="waterNItext" id="waterNItextID">Not Isolated</span></b></p>
                <button type="button" class="btn btn-secondary addIso-btn" id="btn-scan-addWater-qr" onclick="btnScanAdd(this.id)"><i class="fa fa-barcode"></i>&#160;&#160;Scan Device QR Code</button>
            </div>
            <div name='remWaterFrmName' id='remWaterFrm'>
                <p><b>Status:&#160;<span class="waterIText" id="waterItextID">Isolated&#160;&#160;<i class="fas fa-key"></i></span>&#160;</b></p>
                <button type="button" class="btn btn-secondary addIso-btn" id="btn-scan-remWater-qr" onclick="btnScanRemove(this.id)"><i class="fa fa-barcode"></i>&#160;&#160;Scan Water Device QR Code</button>
            </div>
            <div class='canvasPH' id="waterCanvasPH"></div>
                <form method="post">
                    <input type="text" id="waterDeviceID" name="waterDeviceID" hidden="true">
                    <button id="hdBtnAddWaterId" type="submit" name="submit" value="hdPostBtnAddWat" hidden="true"></button>
                    <button id="hdBtnRemWaterId" type="submit" name="submit" value="hdPostBtnRemWat" hidden="true"></button>
                </form>
            </div>
        <hr class="devcd-divider"> 
        <div class="card-body editCard">
            <h6><b>CDA Isolator:&#160;</b><span id="cdaVN"><?php echo $deviceRow['cda_isolator']; ?></span></h6>
            <div name='addCdaFrmName' id='addCdaFrm'>
                <p><b>Status:&#160;<span class="cdaNItext" id="cdaNItextID">Not Isolated</span></b></p>
                <button type="button" class="btn btn-secondary addIso-btn" id="btn-scan-addCda-qr" onclick="btnScanAdd(this.id)"><i class="fa fa-barcode"></i>&#160;&#160;Scan Device QR Code</button>
            </div>
            <div name='remCdaFrmName' id='remCdaFrm'>
                <p><b>Status:&#160;<span class="cdaIText" id="cdaItextID">Isolated&#160;&#160;<i class="fas fa-key"></i></span>&#160;</b></p>
                <button type="button" class="btn btn-secondary addIso-btn" id="btn-scan-remCda-qr" onclick="btnScanRemove(this.id)"><i class="fa fa-barcode"></i>&#160;&#160;Scan Device QR Code</button>
            </div>
            <div class='canvasPH' id="cdaCanvasPH"></div>
                <form method="post">
                    <input type="text" id="cdaDeviceID" name="cdaDeviceID" hidden="true">
                    <button id="hdBtnRemCdaId" type="submit" name="submit" value="hdPostBtnRemCda" hidden="true"></button>
                    <button id="hdBtnAddCdaId" type="submit" name="submit" value="hdPostBtnAddCda" hidden="true"></button>
                </form>
            </div>
        <hr class="devcd-divider"> 
        <div class="card-body editCard">
            <h6><b>Electrical Isolator:&#160;</b><span id="elecVN"><?php echo $deviceRow['elec_isolator']; ?></span></h6>
            <div name='addElecFrmName' id='addElecFrm'>
                <p><b>Status:&#160;<span class="elecNItext" id="elecNItextID">Not Isolated</span></b></p>
                <button type="button" class="btn btn-secondary addIso-btn" id="btn-scan-addElec-qr" onclick="btnScanAdd(this.id)"><i class="fa fa-barcode"></i>&#160;&#160;Scan Device QR Code</button>
            </div>
            <div name='remElecFrmName' id='remElecFrm'>
                <p><b>Status:&#160;<span class="elecIText" id="elecItextID">Isolated&#160;&#160;<i class="fas fa-key"></i></span>&#160;</b></p>
                <button type="button" class="btn btn-secondary addIso-btn" id="btn-scan-remElec-qr" onclick="btnScanRemove(this.id)"><i class="fa fa-barcode"></i>&#160;&#160;Scan Device QR Code</button>
            </div>
            <div class='canvasPH' id="elecCanvasPH"></div>
                <form method="post">
                    <input type="text" id="elecDeviceID" name="elecDeviceID" hidden="true">
                    <button id="hdBtnRemElecId" type="submit" name="submit" hidden="true" value="hdPostBtnRemElec" ></button>
                    <button id="hdBtnAddElecId" type="submit" name="submit" hidden="true" value="hdPostBtnAddElec" ></button>
                </form>
            </div>
            <hr class="devcd-divider"> 
        <div class="card-body editCard">
            <form method="post">
                <div>
                    <input type='hidden' name='steamIsolatedHD' id='steamIsolatedHD' value=<?php echo $currIsoRow['steam_isolated'];?> >
                    <input type='hidden' name='waterIsolatedHD' id='waterIsolatedHD' value=<?php echo $currIsoRow['water_isolated'];?> >
                    <input type='hidden' name='cdaIsolatedHD' id='cdaIsolatedHD' value=<?php echo $currIsoRow['cda_isolated'];?> >
                    <input type='hidden' name='elecIsolatedHD' id='elecIsolatedHD' value=<?php echo $currIsoRow['elec_isolated'];?> >
                    <button type="submit" name="submit" value="saveBtn" class="btn btn-secondary savIso-btn"><i class="fa fa-arrow-alt-circle-left"></i>&#160;&#160;&#160;Confirm & View Isolation</button>
                </div>
            </form>
        </div>
		<script src="js/qrEdit.min.js"></script>
        <div class="modal fade" id="saveModal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="window.location.href = 'editDevices.php';"><i class="fa fa-times"></i>&nbsp;&nbsp;&nbsp;Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="noIsoModal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="window.location.href = 'isolations.php';"><i class="fa fa-arrow-alt-circle-left"></i>&nbsp;&nbsp;&nbsp;Return to main screen</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="dNotFound" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
        <div class="modal fade" id="finishMod" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="window.location.href = 'isolations.php';"><i class="fa fa-times"></i>&nbsp;&nbsp;&nbsp;Close</button>
                    </div>
                </div>
            </div>
        </div>
    <?php include_once("footer.php");?>
<script type="text/javascript">
    function showAddSteamFrm() {$('#remSteamFrm').hide();$('#addSteamFrm').show();}
    function showRemSteamFrm() {$('#addSteamFrm').hide();$('#remSteamFrm').show();}
    function showAddWaterFrm() {$('#remWaterFrm').hide();$('#addWaterFrm').show();}
    function showRemWaterFrm() {$('#addWaterFrm').hide();$('#remWaterFrm').show();}
    function showAddCdaFrm() {$('#remCdaFrm').hide();$('#addCdaFrm').show();}
    function showRemCdaFrm() {$('#addCdaFrm').hide();$('#remCdaFrm').show();}
    function showAddElecFrm() {$('#remElecFrm').hide();$('#addElecFrm').show();}
    function showRemElecFrm() {$('#addElecFrm').hide();$('#remElecFrm').show();}
    if ($(steamIsolatedHD).val() == 1) {showRemSteamFrm();} else {showAddSteamFrm();}
    if ($(waterIsolatedHD).val() == 1) {showRemWaterFrm();} else {showAddWaterFrm();}
    if ($(cdaIsolatedHD).val() == 1) {showRemCdaFrm();} else {showAddCdaFrm();}
    if ($(elecIsolatedHD).val() == 1) {showRemElecFrm();} else {showAddElecFrm();}
    function launchSM(title, content) {$('#saveModal .modal-title').text(title);$('#saveModal .modal-body').text(content);$('#saveModal').modal('show');}
    function launchRM(title, content) {$('#removedIsoModal .modal-title').text(title);$('#removedIsoModal .modal-body').text(content);$('#removedIsoModal').modal('show');}
    function launchDNF(title, content) {$('#dNotFound .modal-title').text(title);$('#dNotFound .modal-body').text(content);$('#dNotFound').modal('show');}
    function launchFM(title, content) {$('#finishMod .modal-title').text(title);$('#finishMod .modal-body').text(content);$('#finishMod').modal('show');}
    function launchNI(title, content) {$('#noIsoModal .modal-title').text(title);$('#noIsoModal .modal-body').text(content);$('#noIsoModal').modal('show');}
</script>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (isset($_POST["submit"])) {
    $isoID = $currIsoRow['isolation_id'];
    $currentAsset = $_SESSION['currentAssetID'];
    $currentUser = $_SESSION['id'];
    function updateDB($sourceToIsolate, $val, $isoID, $currentAsset, $modalOPstr) {
        include("db_connection.php");
        $getDeviceQry = "SELECT `asset_name`, `description`, `steam_isolator`, `water_isolator`, `cda_isolator`, `elec_isolator` FROM `assets` WHERE `asset_id` = $currentAsset";
        if ($getDevicesQRES = mysqli_query($link, $getDeviceQry)) {
            $deviceRow = mysqli_fetch_assoc($getDevicesQRES);
        }
        $updateIsoSQL = "UPDATE `isolations` SET $sourceToIsolate = $val, `last_updated` = NOW() WHERE `isolation_id` = $isoID";
        if (mysqli_query($link, $updateIsoSQL)) {
            ?>
            <script type='text/javascript'> $(document).ready(function(){ 
                launchSM('Info', '<?php echo $modalOPstr; ?>');
                });
            </script>
            <?php
        } else {
        ?>
        <script type='text/javascript'> $(document).ready(function(){ 
            launchSM('Error', 'Isolation not written to database');
            });
        </script>
        <?php
        } 
    }
    switch ($_POST["submit"]) {
        case "saveBtn":
            if ($_POST['steamIsolatedHD'] == 1 || $_POST['waterIsolatedHD'] == 1 || $_POST['cdaIsolatedHD'] == 1 || $_POST['elecIsolatedHD'] == 1) {
                $isoID = $currIsoRow['isolation_id'];
                $currentAsset = $_SESSION['currentAssetID'];
                $currentUser = $_SESSION['id'];
                include("db_connection.php");
                $getStakeholdersQRY = "SELECT `user_email` FROM `users` JOIN `stakeholders` ON `users_user_id` = `user_id` WHERE `assets_asset_id` = $currentAsset"; 
                if ($stakeholderRes = mysqli_query($link, $getStakeholdersQRY)) {
                    while ($stakeholderRow = mysqli_fetch_assoc($stakeholderRes)) {    
                        $emailTo = "".$stakeholderRow['user_email']."";
                        $subject = "LOCNET Notification";
                        $body = "Isolations for: ".$deviceRow['asset_name']."-".$deviceRow["description"]." have been updated.";
                        $headers = "From: locnet@biocoda.com";
                        if (mail($emailTo, $subject, $body, $headers)) {
                            $noAddon = " Asset stakeholders have been notified.";
                        } else {
                            $noAddon = " Asset stakeholders have not been notified.";
                        }
                    }
                    $sMOutputStr = "Isolations for: ".$deviceRow['asset_name']."-".$deviceRow["description"]." have been updated.".$noAddon;
                    ?>
                    <script type='text/javascript'> $(document).ready(function(){ 
                        launchFM('Info', '<?php echo $sMOutputStr ?>');
                        });
                    </script>
                    <?php
                }        
            } else {
                $isoRemoveQRY = "UPDATE `isolations` SET `date_removed` = NOW() WHERE `isolation_id` = $isoID";
                // $getStakeholdersQRY = "SELECT `user_email` FROM `users` JOIN `stakeholders` ON `users_user_id` = `user_id` WHERE `assets_asset_id` = $currentAsset"; 
                if (mysqli_query($link, $isoRemoveQRY)) {
                    // if ($stakeholderRes = mysqli_query($link, $getStakeholdersQRY)) {
                    //     while ($stakeholderRow = mysqli_fetch_assoc($stakeholderRes)) {
                    //         $emailTo = "".$stakeholderRow['user_email']."";
                    //         $subject = "LOCNET Notification";
                    //         $body = "All isolations have been removed from: ".$deviceRow['asset_name']." ".$deviceRow['description'].".";
                    //         $headers = "From: locnet@biocoda.com";
                    //         if (mail($emailTo, $subject, $body, $headers)) {
                    //             $noAddon = " Asset stakeholders have been notified.";
                    //         } else {
                    //             $noAddon = " Asset stakeholders have not been notified.";
                    //         }
                    //     }
                    // }
                    $sMOutputStr = "You have selected no devices to isolate for: ".$deviceRow['asset_name']."-".$deviceRow["description"]."";
                    ?>
                    <script type='text/javascript'> $(document).ready(function(){ 
                        launchNI('Warning', '<?php echo $sMOutputStr; ?>');
                        });
                    </script>
                    <?php
                }
            }
            break;
        case "hdPostBtnAddSte":
            if ($deviceRow['steam_isolator'] == $_POST['steamDeviceID']) {
                $addSteOPstr = "The steam isolation for ".$deviceRow['asset_name']."-".$deviceRow["description"]." has been added";
                updateDB('`steam_isolated`', 1, $isoID, $currentAsset, $addSteOPstr);
            } else {
                $sMOutputStr = "".$_POST['steamDeviceID']." is not the steam isolation device for ".$deviceRow['asset_name']."-".$deviceRow["description"]."";
                ?>
                <script type='text/javascript'> $(document).ready(function(){ 
                    launchDNF('Info', '<?php echo $sMOutputStr; ?>');
                    });
                </script>
                <?php
            }
            break;
        case "hdPostBtnRemSte":
            if ($deviceRow['steam_isolator'] == $_POST['steamDeviceID']) {
                $remSteOPstr = "The steam isolation for ".$deviceRow['asset_name']."-".$deviceRow["description"]." has been removed";
                updateDB('`steam_isolated`', 0, $isoID, $currentAsset, $remSteOPstr);
            } else {
                $sMOutputStr = "".$_POST['steamDeviceID']." is not the steam isolation device for ".$deviceRow['asset_name']."-".$deviceRow["description"]."";
                ?>
                <script type='text/javascript'> $(document).ready(function(){ 
                    launchDNF('Info', '<?php echo $sMOutputStr; ?>');
                    });
                </script>
                <?php
            }
            break;
        case "hdPostBtnAddWat":
            if ($deviceRow['water_isolator'] == $_POST['waterDeviceID']) {
                $addWatOPstr = "The water isolation for ".$deviceRow['asset_name']."-".$deviceRow["description"]." has been added";
                updateDB('`water_isolated`', 1, $isoID, $currentAsset, $addWatOPstr);
            } else {
                $sMOutputStr = "".$_POST['waterDeviceID']." is not the water isolation device for ".$deviceRow['asset_name']."-".$deviceRow["description"]."";
                ?>
                <script type='text/javascript'> $(document).ready(function(){ 
                    launchDNF('Info', '<?php echo $sMOutputStr; ?>');
                    });
                </script>
                <?php
            }
            break;  
        case "hdPostBtnRemWat":
            if ($deviceRow['water_isolator'] == $_POST['waterDeviceID']) {
                $remWatOPstr = "The water isolation for ".$deviceRow['asset_name']."-".$deviceRow["description"]." has been removed";
                updateDB('`water_isolated`', 0, $isoID, $currentAsset, $remWatOPstr);
            } else {
                $sMOutputStr = "".$_POST['waterDeviceID']." is not the water isolation device for ".$deviceRow['asset_name']."-".$deviceRow["description"]."";
                ?>
                <script type='text/javascript'> $(document).ready(function(){ 
                    launchDNF('Info', '<?php echo $sMOutputStr; ?>');
                    });
                </script>
                <?php
            }
            break;
        case "hdPostBtnAddCda":
            if ($deviceRow['cda_isolator'] == $_POST['cdaDeviceID']) {
                $addCdaOPstr = "The CDA isolation for ".$deviceRow['asset_name']."-".$deviceRow["description"]." has been added";
                updateDB('`cda_isolated`', 1, $isoID, $currentAsset, $addCdaOPstr);
            } else {
                $sMOutputStr = "".$_POST['cdaDeviceID']." is not the CDA isolation device for ".$deviceRow['asset_name']."-".$deviceRow["description"]."";
                ?>
                <script type='text/javascript'> $(document).ready(function(){ 
                    launchDNF('Info', '<?php echo $sMOutputStr; ?>');
                    });
                </script>
                <?php
            }
            break;  
        case "hdPostBtnRemCda":
            if ($deviceRow['cda_isolator'] == $_POST['cdaDeviceID']) {
                $remCdaOPstr = "The CDA isolation for ".$deviceRow['asset_name']."-".$deviceRow["description"]." has been removed";
                updateDB('`cda_isolated`', 0, $isoID, $currentAsset, $remCdaOPstr);
            } else {
                $sMOutputStr = "".$_POST['cdaDeviceID']." is not the CDA isolation device for ".$deviceRow['asset_name']."-".$deviceRow["description"]."";
                ?>
                <script type='text/javascript'> $(document).ready(function(){ 
                    launchDNF('Info', '<?php echo $sMOutputStr; ?>');
                    });
                </script>
                <?php
            }
            break;  
        case "hdPostBtnAddElec":
            if ($deviceRow['elec_isolator'] == $_POST['elecDeviceID']) {
                $addEleOPstr = "The Electrical isolation for ".$deviceRow['asset_name']."-".$deviceRow["description"]." has been added";
                updateDB('`elec_isolated`', 1, $isoID, $currentAsset, $addEleOPstr);
            } else {
                $sMOutputStr = "".$_POST['elecDeviceID']." is not the electrical isolation device for ".$deviceRow['asset_name']."-".$deviceRow["description"]."";
                ?>
                <script type='text/javascript'> $(document).ready(function(){ 
                    launchDNF('Info', '<?php echo $sMOutputStr; ?>');
                    });
                </script>
                <?php
            }
            break;   
        case "hdPostBtnRemElec":
            if ($deviceRow['elec_isolator'] == $_POST['elecDeviceID']) {
                $remEleOPstr = "The Electrical isolation for ".$deviceRow['asset_name']."-".$deviceRow["description"]." has been removed";
                updateDB('`elec_isolated`', 0, $isoID, $currentAsset, $remEleOPstr);
            } else {
                $sMOutputStr = "".$_POST['elecDeviceID']." is not the electrical isolation device for ".$deviceRow['asset_name']."-".$deviceRow["description"]."";
                ?>
                <script type='text/javascript'> $(document).ready(function(){ 
                    launchDNF('Info', '<?php echo $sMOutputStr; ?>');
                    });
                </script>
                <?php
            }
            break;   
        }
    }
?>  

        

