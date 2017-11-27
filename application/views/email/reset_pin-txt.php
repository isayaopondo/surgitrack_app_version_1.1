Hi<?php if (strlen($username) > 0) { ?> <?php echo $username; ?><?php } ?>,

You have changed your Pin.
Please, keep it in your records so you don't forget it.
<?php if (strlen($username) > 0) { ?>

Your username: <?php echo $username; ?>
<?php } ?>

Your reset code: <?php echo $resetcode; ?>

<?php /* Your new password: <?php echo $new_password; ?>

*/ ?>

Thank you,
The <?php echo $site_name; ?> Team