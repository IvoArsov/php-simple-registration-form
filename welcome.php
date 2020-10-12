<link rel="stylesheet" href="form.css" type="text/css" />

<?php session_start(); ?>

<div class="body content container">
    <div class="welcome row">
        <div class="col-md-12 alert alert-error"><?php echo $_SESSION['message'] ?></div>
        <span class="avatar-pic"><img src="<?php echo $_SESSION['avatar'] ?>" alt="avatar" /></span>
        <h3 class="welcome-sign">Welcome <?php echo $_SESSION['username'] ?></h3>
    </div>
    <pre>
</div>