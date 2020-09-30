<?php
    session_start(); 
    include_once("header.php"); 
?>
<div class="mainContent" id="home">        
	<div class="jumbotron">
		<h1 class="display-4">LOCNET</h1>
		<p class="lead">Equipment&#160;Isolation&#160;Register</p>
		<hr>
		<div class="card loginCard">
			<div class="card-body login-card-body">    
				<form method="post">
					<div class="form-group">
						<label for="emailFromLoginField">Email address</label>
						<input type="email" id="loginEmail" name="emailFromLoginField" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="passwordFromLoginField">Password</label>
						<input type="password" name="passwordFromLoginField" class="form-control" required>
					</div>
                    <div class="form-group">
                        <input type="checkbox" name="stayLoggedIn" value=1><label for="stayLoggedIn">&nbsp;&nbsp;&nbsp;Stay logged in?</label>
                    </div>
					    <button type="submit" name="submit" onclick="saveEmailLS()" class="btn btn-secondary btn-lg">LOGIN</button>
				</form>
			</div>
		</div>
        <hr> 
        <script type="text/javascript">
            function saveEmailLS() {
                localStorage.setItem('lastLoginEmail', document.getElementById("loginEmail").value);
            }
            function getEmailFromLS() {
                if (localStorage.getItem('lastLoginEmail')) {
                    document.getElementById("loginEmail").value = localStorage.getItem('lastLoginEmail');
                }
            }
            getEmailFromLS();
        </script>
        <div class="modal fade" id="indexModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            function launchIndexModal(title, content) {
                $("#indexModal .modal-title").text(title);
                $("#indexModal .modal-body").text(content);
                $('#indexModal').modal('show');
            }
        </script>
<?php include("footer.php");?>
<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    function goToPage($url) {
        echo '<script language="javascript">window.location.href ="'.$url.'"</script>';
    }

    if (array_key_exists("logout", $_GET)) {

        unset($_SESSION);
        setcookie("id", "", time() - 60*60);
        $_COOKIE["id"] = "";

        session_destroy();

        goToPage('index.php');

    } else if ((array_key_exists("id", $_SESSION) AND $_SESSION['id']) OR (array_key_exists("id", $_COOKIE) AND $_COOKIE['id'])) {

        goToPage('isolations.php');
    }

    if (array_key_exists("submit", $_POST)) {

        include("db_connection.php");

        $userQuery = "SELECT `user_id`, `user_password` FROM `users` WHERE user_email = '".mysqli_real_escape_string($link, $_POST['emailFromLoginField'])."'";

        $result = mysqli_query($link, $userQuery);

        $row = mysqli_fetch_array($result);        

        if (isset($row)) {

            $hashedPass = md5(md5($row['user_id']).$_POST['passwordFromLoginField']);

            // echo $hashedPass;

            if ($hashedPass == $row['user_password']) {
            
                $_SESSION['id'] = $row['user_id'];

                if (isset($_POST['stayLoggedIn']) AND $_POST['stayLoggedIn'] == '1') {

                    setcookie("id", row['user_id'], time() + 60*60*72);
                }

                goToPage('isolations.php');

             } else {

                ?>
                <script type='text/javascript'> $(document).ready(function(){ 
                    launchIndexModal('Login Failed', 'Incorrect password');  
                    });
                </script>
                <?php
            }

        } else {

            ?>
            <script type='text/javascript'> $(document).ready(function(){ 
                launchIndexModal('Login Failed', 'Unknown email address');
                });
            </script>
            <?php
        } 
    }
?>
	</div> 
</div>






