<?php
session_start();
$_SESSION['message'] = '';
$mysqlli = new mysqli('localhost', 'root', '', 'demo_reg_form');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //two password are matching
    if($_POST['password'] == $_POST['confirmpassword']){

        $username = $mysqlli->real_escape_string($_POST['username']);
        $email = $mysqlli->real_escape_string($_POST['email']);
        $password = md5($_POST['password']); //md5 hash password for security
        $avatar_path = $mysqlli->real_escape_string('images/'.$_FILES['avatar']['name']);

        //make sure file type is image
        if(preg_match("!image!", $_FILES['avatar']['type'])){
            // copy images to image/ folder
            if(copy($_FILES['avatar']['tmp_name'], $avatar_path)){
                $_SESSION['username'] = $username;
                $_SESSION['avatar'] = $avatar_path;

                $sql = "INSERT INTO users(username, email, pass, avatar) VALUES('$username', '$email', '$password', '$avatar_path');";

                //if query is successful redirect to welcome.php page and done!
                if($mysqlli->query($sql) === true){
                    $_SESSION['message'] = "Registration successful! Added <strong>$username</strong> to the database!";
                    header("location: welcome.php");
                }
                else{
                    $_SESSION['message'] = "User could not be added to a database!";
                }

            }
            else{
                $_SESSION['message'] = "File upload failed!";
            }   
        }
        else{
            $_SESSION['message'] = "Please only upload GIF, JPG or PNG images!";
        } 
    }
    else{
        $_SESSION['message'] = "Two passwords do not match!";
    }
} 

?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<link rel="stylesheet" href="form.css" type="text/css" />

<div class="container">
    <div class="row">
        <h1>Create an account</h1>
        <form action="form.php" class="form" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="alert alert-error"><?php $_SESSION['message'] ?></div>
            <input type="text" placeholder="User name" name="username" required />
            <br />
            <br />
            <input type="email" placeholder="Email" name="email" required />
            <br />
            <br />
            <input type="password" placeholder="Password" name="password" autocomplete="new-password" required />
            <br />
            <br />
            <input type="password" placeholder="Confirm password" name="confirmpassword" autocomplete="new-password" required />
            <div class="avatar"><label for="">Select your avatar</label><input type="file" name="avatar" accept="image/*" class="file-input" required /></div>
            <br />
            <input type="submit" value="Register" name="register" class="btn btn-primary">
        </form>
    </div>
</div>
