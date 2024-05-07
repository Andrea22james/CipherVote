<?php session_start() ?>
<?php 
    require_once("admini/includes/config.php");

    $fetchingElections = mysqli_query($db, "SELECT * FROM positions ") OR die(mysqli_error($db));

    while($data = mysqli_fetch_assoc($fetchingElections)) {
        date_default_timezone_set('Asia/Kolkata');
        $current_time = time(); 
        $inserted_at = date("Y-m-d H:i:s", $current_time);     
        $time1 = new DateTime($inserted_at); 
        $time2 = new DateTime($data['starting_time']);
        $time3 = new DateTime($data['ending_time']);     
        $election_id = $data['id'];   
        if ($time3 < $time1) {
            $status = "Expired"; 
        } elseif ($time2 > $time1) {
            $status = "Inactive"; 
        } else {
            $status = "Active"; 
        }
    
        mysqli_query($db, "UPDATE positions SET status = '$status' WHERE id = '". $election_id ."'") OR die(mysqli_error($db));
    }
    
    
?>

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

                <?php 
                    if(isset($_GET['forgotpassword']))
                    {
                        ?>
                        <div class="container">
          <div class="forms-container">
            <div class="signin-signup">
              <form  method="POST"  class="sign-in-form">
              <h2 class="title">Reset password</h2>
                
                <br><div class="input-field">
                  <i class="fas fa-envelope"></i>
                  <input type="text" name="su_contact_no" class="form-control input_pass" placeholder="Email" required />
                </div>
               
                
                
            <br><button type="submit" name="otpbtn" class="btn">Send OTP</button>
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
                <h1>Try signing in?</h1>
               
                <br><button class="btn transparent" id="sign-up-btn">
                  Sign in
                </button>
              </div>
              <img src="img/password.svg" class="image" alt="" />
            </div>
            <div class="panel right-panel">
              <div class="content">
                <h2>Don't remember your password?</h2>
               <br>
                <button class="btn transparent" id="sign-in-btn">
                  Reset
                </button>
              </div>
              <img src="img/login.svg" class="image" alt="" />
            </div>
          </div>
        </div>
       
       
    
    
    <script src="app.js"></script>
      </body>
    
    
      
                    <?php
                        }
                         
                    
                    else if(isset($_GET['otpsent'])) {
                        ?>
                             <div class="container">
                                <div class="forms-container">
                                    <div class="signin-signup">
                                    <form  method="POST"  class="sign-in-form">
                                    <h2 class="text" style="font-size: 22px; color: green;">OTP has been sent to your email</h2><br>
                                        
                                       
                                        <div class="input-field">
                                        <i class="fas fa-lock"></i>
                                        <input type="text" id="otp" class="form-control" name="otp_code" placeholder="OTP" required autofocus>
                                        </div>
                                        
                                        
                                        <button type="submit" name="verifybtn" class="btn login_btn">Validate OTP</button>
                                        <br><br><h3><b><div class="d-flex justify-content-center links text-grey">
                                            Wrong E-mail ? <a href="?" class="ml-9 text-blue">  Sign Up again</a>
                                         </b></h3>
                                    
                                        
                                        
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
                                                    <button type="button" onclick="validateLoginForm()" class="btn login_btn">Login</button>
                                                    <br><h3><b><div class="d-flex justify-content-center links text-grey">
                                                 <a href="index.php?forgotpassword=1" class="ml-9 text-blue"> Forgot password ?</a>
                                                 </div></b></h3>
                                                
                                                
                                        </form>
                                                <br><br><br><div id="errorMessage" class="text-danger"></div>
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
                                                                        window.location.href = "step2.php";
                                                                    } else {
                                                                        window.location.href = "step2.php";
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
                                        <h1>Created Account ?</h1>
                                        <p>
                                        
                                        
                                                </p>
                                        <button class="btn transparent" id="sign-up-btn">
                                        Sign in
                                        </button>
                                    </div>
                                    <img src="img/otp.svg" class="image" alt="" />
                                    </div>
                                    <div class="panel right-panel">
                                    <div class="content">
                                        <h1> Error  in validating?</h1>
                                        <p>
                                       
                                        </p>
                                        <button class="btn transparent" id="sign-in-btn">
                                        Try again
                                        </button>
                                    </div>
                                    <img src="img/otpsign.svg" class="image" alt="" />
                                    </div>
                                </div>
                                </div>
                                <script src="app.js"></script>
                            </body>

                        <?php
                    
                    }
                    else if(isset($_GET['otpsuccess'])) 
                    {
                        ?>
                        <div class="container">
          <div class="forms-container">
            <div class="signin-signup">
              <form  method="POST"  class="sign-in-form">
              <h2 class="text" style="font-size: 22px; color: green;">OTP has been sent to your email</h2><br>
                
                <br><div class="input-field">
                  <i class="fas fa-lock"></i>
                  <input type="text" name="otp_code" class="form-control input_pass" placeholder="OTP" required />
                </div>
                <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="su_password" class="form-control input_pass" placeholder="New Password" required />
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="su_retype_password" class="form-control input_pass" placeholder="Retype Password" required />
            </div>
               
                
                
            <button type="submit" name="verifyreset" class="btn">Verify</button>
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
                <h1>Reset compelete ?</h1>
               
                <br><button class="btn transparent" id="sign-up-btn">
                  Sign in
                </button>
              </div>
              <img src="img/password.svg" class="image" alt="" />
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
    
    
      
                    <?php
                    }
                    else {
                ?>
                    <div class="container">
      <div class="forms-container">
        <div class="signin-signup">
          <form  method="POST"  class="sign-in-form">
          <h2 class="title">Sign up</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" name="su_username" class="form-control input_user" placeholder="Username" required />
            </div>
            <div class="input-field">
              <i class="fas fa-envelope"></i>
              <input type="text" name="su_contact_no" class="form-control input_pass" placeholder="Email ID" required />
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="su_password" class="form-control input_pass" placeholder="Password" required />
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="su_retype_password" class="form-control input_pass" placeholder="Retype Password" required />
            </div>
            
            <button type="submit" name="sign_up_btn" class="btn">Sign Up</button>
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
                <br><div id="errorMessage" class="text-danger"></div>
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
                                        window.location.href = "step.php";
                                    } else {
                                        window.location.href = "step.php";
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
            <h1>One of us ?</h1>
            <p>
            Enter your login credentials to access CipherVote
              
                    </p>
            <button class="btn transparent" id="sign-up-btn">
              Sign in
            </button>
          </div>
          <img src="img/signup.svg" class="image" alt="" />
        </div>
        <div class="panel right-panel">
          <div class="content">
            <h1>New here ?</h1>
            <p>
            Enter your details to create a free account
            </p>
            <button class="btn transparent" id="sign-in-btn">
              Sign Up
            </button>
          </div>
          <img src="img/login.svg" class="image" alt="" />
        </div>
      </div>
    </div>
   
   


<script src="app.js"></script>
  </body>


  
                <?php
                    }
                     
                ?>

                <?php 
                    if(isset($_GET['otpfailed']))
                    {
                ?>
                        <span class="bg-white text-danger text-center mt-1"> OTP sending failed! </span>
                <?php
                    }else if(isset($_GET['invalid'])) {
                ?>
                        <span class="bg-white text-danger text-center mt-1"> Passwords mismatched, please try again! </span>
                <?php
                
                    }else if(isset($_GET['wrongotp'])) {
                        ?>
                            <div class="mt-3">
                                <div class="d-flex justify-content-center links text-danger">
                                     Invalid OTP <a href="?sign-up=1" class="ml-3 text-blue">Sign Up again</a>
                                </div>
                            </div>
                        <?php
                        
                    }else if(isset($_GET['successful'])) {
                        ?>
                             <div class="mt-3">
                            <div class="d-flex justify-content-center links text-success">
                                Account Created successfully <a href="index.php" class="ml-2 text-blue">Sign In</a>
                            </div>
                        </div>
                        <?php
                        
                    }
                    else if(isset($_GET['not_registered'])) {
                        ?>
                                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                                <script src="hide.js"></script>
                                 <div id="hideDivyellow"><b>Email not registered</div></b>
                        <?php
                            
                    }else if(isset($_GET['admissionno'])) {
                        ?>
                                <span class="bg-white text-danger text-center mt-2 "> Invalid Admission Number </span>
                        <?php
                            }
                   
                    else if(isset($_GET['weak'])) {
                        ?>
                                <span class="bg-white text-danger text-center mt-2 mb-0">Password must have an uppercase, a lowercase, a number and a special character </span>
                        <?php
                    }else if(isset($_GET['length'])) {
                        ?>
                                <span class="bg-white text-danger text-center mt-2">Password must have at least 8 characters </span>
                        <?php
                    }else if(isset($_GET['user_exist'])) {
                        ?>
                                <span class="bg-white text-danger text-center mt-2">Email already registered </span>
                        <?php
                    }
                    else if(isset($_GET['email'])) {
                        ?>
                                <span class="bg-white text-danger text-center mt-2">Use JECC Email id </span>
                        <?php
                    }
                ?>
                       
			</div>
		</div>
	</div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
</body>
</html>

<?php 
    require_once("admini/includes/config.php");

    if(isset($_POST['sign_up_btn']))
    {
        $su_username = mysqli_real_escape_string($db, $_POST['su_username']);
        $su_contact_no = mysqli_real_escape_string($db, $_POST['su_contact_no']);
        $su_pass = mysqli_real_escape_string($db,($_POST['su_password']));
        $su_password = mysqli_real_escape_string($db, sha1($_POST['su_password']));
        $su_retype_password = mysqli_real_escape_string($db, sha1($_POST['su_retype_password']));
        $user_role = "Voter"; 
        $_SESSION['username'] =  $su_username;
        $_SESSION['email'] =  $su_contact_no;
        $_SESSION['password'] =  $su_password;
        $_SESSION['userrole'] = $user_role;
        $password_pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
        $emailsample="@jecc.ac.in";
        $check_query = mysqli_query($db, "SELECT * FROM users where contact_no ='$su_contact_no'");
        $rowCount = mysqli_num_rows($check_query);

        if($rowCount > 0){
            ?>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                <script src="hide.js"></script>
                <div id="hideDiv"><b>Email already registered</div></b>
            
            <?php
        }
        else{
            if( strlen($su_username)<7)
            {
             ?> 
              <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
              <script src="hide.js"></script>
                  <div id="hideDiv"><b>
                   The Username is too short 
                 </div></b>
              
            <?php 
            }
            else{
                if(strpos($su_contact_no,$emailsample)!==false )
                {

                    if(strlen($su_pass)<8)
                    {
                        ?> 
               <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
              <script src="hide.js"></script>
                  <div id="hideDiv"><b>
                    Password must have atleast 8 characters
                 </div></b>
              
            <?php

                    }
                    else{
                        if (preg_match($password_pattern, $su_pass))
                        {

                            if($su_password == $su_retype_password )
                            {
                                $otp = rand(100000,999999);
                                $_SESSION['otp'] = $otp;
                                $_SESSION['mail'] = $su_contact_no;
                                require "Mail/phpmailer/PHPMailerAutoload.php";
                                $mail = new PHPMailer;
                
                                $mail->isSMTP();
                                $mail->Host='smtp.gmail.com';
                                $mail->Port=587;
                                $mail->SMTPAuth=true;
                                $mail->SMTPSecure='tls';
                
                                $mail->Username='ciphervote@gmail.com';
                                $mail->Password='ibipxhaiioxstnlp';
                
                                $mail->setFrom('ciphervote@gmail.com', 'OTP Verification');
                                $mail->addAddress($_POST["su_contact_no"]);
                
                                $mail->isHTML(true);
                                $mail->Subject="Your verification code";
                                $mail->Body="<p>Dear user, </p> <h3>Your verification code to access CipherVote is $otp <br></h3>
                                <br><br>
                                <p>With regards,</p>
                                Team Ciphervote";
                
                                        if(!$mail->send()){
                                            ?>
                                                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                                                <script src="hide.js"></script>
                                                 <div id="hideDiv"><b>
                                                    OTP sending failed !
                                                 </div></b>
                                            <?php
                                        }else{
                                             ?>

                                                    <script>location.assign("index.php?otpsent=1");</script>
                                                    
                                             <?php
                                        }
                                

                            

                            }else {
                        ?>
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                            <script src="hide.js"></script>
                            <div id="hideDiv"><b> Passwords doesn't match </div></b>
                                
                        <?php
                            }
                        }
                        else {
                            ?>
                                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                                <script src="hide.js"></script>
                                <div id="hideDiv" text-align: justify><b> Requires uppercase , lowercase , number and special character in password.  </div></b>
                            <?php
                                }
                            }
                        }
                else
                {
                    ?>
                         <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                            <script src="hide.js"></script>
                            <div id="hideDiv"><b>Use JECC Email</div></b>
                    <?php

                }
            }
        }       
    }
        

    else if(isset($_POST["verifybtn"])){
       
        $su_username=$_SESSION['username']  ;
        $su_contact_no=$_SESSION['email'] ;
        $su_password=$_SESSION['password'] ;
        $user_role=$_SESSION['userrole'] ;
        $otp_code = $_POST['otp_code'];
        $otp = $_SESSION['otp'];
        if($otp != $otp_code){
            ?>
                 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                 <script src="hide.js"></script>
                 <div id="hideDivotp"><b>Invalid OTP</div></b>
           <?php
        }else{
           
            mysqli_query($db, "INSERT INTO users(username, contact_no, password, user_role) VALUES('". $su_username ."', '". $su_contact_no ."', '". $su_password ."', '". $user_role ."')") or die(mysqli_error($db));
            session_destroy();
            ?>
             <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
             <script src="hide.js"></script>
             <div id="hideDivotpgreen"><b> Account registered successfully </div></b>
             <?php
        }

    }
    else if(isset($_POST["otpbtn"]))
    {
        
        $su_contact_no = mysqli_real_escape_string($db, $_POST['su_contact_no']);
        $check_query = mysqli_query($db, "SELECT * FROM users where contact_no ='$su_contact_no'");
        $rowCount = mysqli_num_rows($check_query);
        $_SESSION['emai'] =  $su_contact_no;


        if($rowCount == 0){
            ?>
            
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                <script>
                    $(function()
                        {
                            setTimeout(function() { $("#hideDi").fadeOut(500); }, 2500)
                        })

                </script>
                <div  id="hideDi"><b>Email not registered</div></b>
            
            <?php
        }
        else
        {

            $otp = rand(100000,999999);
                                $_SESSION['otp'] = $otp;
                                $_SESSION['mail'] = $su_contact_no;
                                require "Mail/phpmailer/PHPMailerAutoload.php";
                                $mail = new PHPMailer;
                
                                $mail->isSMTP();
                                $mail->Host='smtp.gmail.com';
                                $mail->Port=587;
                                $mail->SMTPAuth=true;
                                $mail->SMTPSecure='tls';
                
                                $mail->Username='ciphervote@gmail.com';
                                $mail->Password='ibipxhaiioxstnlp';
                
                                $mail->setFrom('ciphervote@gmail.com', 'OTP Verification');
                                $mail->addAddress($_POST["su_contact_no"]);
                
                                $mail->isHTML(true);
                                $mail->Subject="Your verification code";
                                $mail->Body="<p>Dear user, </p> <h3>Your verification code to reset password is $otp <br></h3>
                                <br><br>
                                <p>With regards,</p>
                                Team Ciphervote";
                
                                        if(!$mail->send()){
                                            ?>
            
                                            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                                            <script>
                                                $(function()
                                                    {
                                                        setTimeout(function() { $("#hideDi").fadeOut(500); }, 2500)
                                                    })
                            
                                            </script>
                                            <div  id="hideDi"><b>OTP sending failed</div></b>
                                        
                                            <?php
                                        }else{
                                             ?>

                                                    <script>location.assign("index.php?otpsuccess=1");</script>
                                                    
                                             <?php
                                        }
                                

                            

                            }

        

    }
    if(isset($_POST["verifyreset"]))
    {
       
        $su_pass = mysqli_real_escape_string($db,($_POST['su_password']));
        $su_password = mysqli_real_escape_string($db, sha1($_POST['su_password']));
        $su_retype_password = mysqli_real_escape_string($db, sha1($_POST['su_retype_password']));
        $otp_code = $_POST['otp_code'];
        $otp = $_SESSION['otp'];
        $su_contact_no = $_SESSION['emai'] ;
        if($otp != $otp_code){
            ?>
                 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                 <script src="hide.js"></script>
                 <div id="hideDiv"><b>Invalid OTP</div></b>
           <?php
        }
        else
            {
                 $password_pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
                 if(strlen($su_pass)<8)
                            {
                                ?> 
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                    <script src="hide.js"></script>
                        <div id="hideDiv"><b>
                            Password must have atleast 8 characters
                        </div></b>
                    
                    <?php

                    }
                    else{
                        if (preg_match($password_pattern, $su_pass))
                        {

                            if($su_password == $su_retype_password )
                            {
                                
                                mysqli_query($db, "UPDATE users SET password = '$su_password' WHERE contact_no ='$su_contact_no'") or die(mysqli_error($db));
                                session_destroy();
                                ?>
                                
                                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                                
                                <script>
                                 $(function()
                                {
                                    setTimeout(function() { $("#hideDivgreen").fadeOut(500); }, 2500)
                                        
                                })
                                </script>
                                <div id="hideDivgreen"><b> Password changed successfully </div></b>
                                <?php

                            }
                            else
                            {
                                ?>
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                            <script src="hide.js"></script>
                            <div id="hideDiv"><b> Passwords doesn't match </div></b>
                                
                            <?php

                            }
                        }
                        else
                        {
                            ?> 
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                           <script src="hide.js"></script>
                               <div id="hideDiv"><b>
                               Include an uppercase, lowercase, number, and special character in your password. 
                              </div></b>
                           
                         <?php

                        }
                    }
             }

    }

?>