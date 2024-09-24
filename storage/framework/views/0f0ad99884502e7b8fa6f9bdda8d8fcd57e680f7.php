<!DOCTYPE html>
<html>
<head>
    <title>New Admin Registration</title>
</head>
<body>
<div style="border: 1px solid #ddd;margin: auto;width: 70%;padding: 20px;line-height: 1.2;">
    Hi <?php echo e($name); ?> <br>,
    <p>Welcome to Thomas Cook</p>
    <p>Your login Credential:</p>
    <p>Username : <?php echo e($username); ?></p>
    <p>Password : <?php echo e($password); ?></p>
    <p>Please click here to login : <a href="<?php echo e($login_link); ?>">Login</a></p>

    Warm regards,<br>
    BPC Partner by Thomas Cook
</div>

</body>
</html>
<?php /**PATH /home/dataseed/prod-thomascook.dataseedtech.com/resources/views/email/logintext.blade.php ENDPATH**/ ?>