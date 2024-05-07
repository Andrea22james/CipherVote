<?php session_start() ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="assets/css/login.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time(); ?>">
   
  
    <title>CIPHERVOTE</title>
  </head>
  <div class="container">
          <div class="forms-container">
            <div class="signin-signup">
              <form  method="POST"  class="sign-in-form">
              <h2 class="text" style="font-size: 22px; color: green;">OTP has been sent to your email</h2><br>
                
                <br><div class="input-field">
                  <i class="fas fa-lock"></i>
                  <input type="text" name="otp_code" class="form-control input_pass" placeholder="OTP" required />
                </div>
              
               
                
                
            <button type="submit" name="verifyreset" class="btn">Verify</button>
            <br><br><h3><b><div class="d-flex justify-content-center links text-grey">
            <a href="index.php" class="ml-9 text-blue">  Login again</a></b></h3>
               </form>
    
              <form method="POST" class="sign-up-form">
                    <h2 class="title">Sign in</h2>
                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input type="text" id="contact_no" name="contact_no" class="form-control input_user" placeholder="Email" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password" class="form-control input_pass" placeholder="Password" required />
                    </div>
                    
                    <div>
                        <button type="button" onclick="validateLoginForm()" class="btn login_btn">Login</button>
                    </div>
                    <br><h3><b><div class="d-flex justify-content-center links text-grey">
                         <a href="index.php?forgotpassword=1" class="ml-9 text-blue"> Forgot password ?</a>
                                             </div></b></h3>
              </form>
                    <br><br><div id="errorMessage" class="text-danger"></div>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                    <script>
                        function validateLoginForm() 
                        {
                            var contact_no = $("#contact_no").val(); 
                            var password = $("#password").val(); 
                             $.ajax({
                                type: "POST",
                                url: "validate_login.php",
                                data: {
                                    contact_no: contact_no,
                                    password: password
                                },
                                success: function(response) {
                                    var responseParts = response.split('|'); 
                                    var status = responseParts[0].trim(); 
                                    var userRole = responseParts[1]; 
    
                                    if (status === "success") {
                                        if (userRole === "admin") {
                                            window.location.href = "admini/home.php";
                                        } else {
                                            window.location.href = "voters/index.php";
                                        }
                                    } else {
                                        $("#errorMessage").text(status).show();
                                        $(function() {
                                            setTimeout(function() {
                                                $("#errorMessage").fadeOut(500);
                                            }, 2500);
                                        });
                                    }
                                }
                            });
    
                        }
    
                    </script>     
            </div>
          </div>
          
    
          <div class="panels-container">
            <div class="panel left-panel">
              <div class="content">
                <h1>2 factor Authentication</h1>
               
                
              </div>
              <img src="img/step.svg" class="image" alt="" />
            </div>
            <div class="panel right-panel">
              <div class="content">
               <h3>You were trying to reset your password.<br><br> Haven't finished yet? </h3><br>
            
                <button class="btn transparent" id="sign-in-btn">
                  Go back
                </button>
              </div>
              <img src="img/login.svg" class="image" alt="" />
            </div>
          </div>
        </div>
       
       
    
    
    <script src="app.js"></script>
      </body>
      </html>
      <?php 
    require_once("admini/includes/config.php");

    if(isset($_POST['verifyreset']))
    {
        $otp_code = $_POST['otp_code'];
        $otp = $_SESSION['otp'];
        if($otp != $otp_code) {
    ?>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            <script src="hide.js"></script>
            <div id="hideDivotp"><b>Invalid OTP</b></div>
    <?php
        } else {
            if ($_SESSION['user_role'] === "Admin") {
                echo '<script>window.location.href = "admini/home.php";</script>';
            } else {
                echo '<script>window.location.href = "voters/index.php";</script>';
            }
        }
    }
    ?>
    