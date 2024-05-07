<?php
session_start();

require_once("admini/includes/config.php");

if (!empty($_POST["contact_no"]) && !empty($_POST["password"])) {
    $contact_no = mysqli_real_escape_string($db, $_POST['contact_no']);
    $password = mysqli_real_escape_string($db, sha1($_POST['password']));

    $fetchingData = mysqli_query($db, "SELECT * FROM users WHERE contact_no = '" . $contact_no . "'") or die(mysqli_error($db));

    if (mysqli_num_rows($fetchingData) > 0) {
        $data = mysqli_fetch_assoc($fetchingData);

        if ($contact_no == $data['contact_no'] && $password == $data['password']) {
            $_SESSION['user_role'] = $data['user_role'];
            $_SESSION['username'] = $data['username'];
            $_SESSION['user_id'] = $data['id'];
                                $otp = rand(100000,999999);
                                $_SESSION['otp'] = $otp;
                                $_SESSION['mail'] = $contact_no;
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
                                $mail->addAddress($_POST["contact_no"]);
                
                                $mail->isHTML(true);
                                $mail->Subject="Your verification code";
                                $mail->Body="<p>Dear user, </p> <h3>Your otp  to login to your CipherVote account is $otp <br></h3>
                                <br><br>
                                <p>With regards,</p>
                                Team Ciphervote";
                
                                        if(!$mail->send()){
                                            echo "OTP sending failed";
                                        }
                                        else{
                                            
           
            if ($data['user_role'] === "Admin") {
                $_SESSION['key'] = "AdminKey";
                echo "success|admin"; 
            } else {
                $_SESSION['key'] = "VotersKey";
                $_SESSION['voter'] = $data['id'];
                echo "success"; 
            }
        }} else {
            echo "Email or password incorrect";
        }
    } else {
        echo "Email not registered";
    }
} else {
    echo "Fill in the fields";
}
?>
