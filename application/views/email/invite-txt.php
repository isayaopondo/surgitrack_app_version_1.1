Welcome to <?php echo $site_name; ?>,

You are invited to <?php echo $site_name; ?> as Facility Administrator of:
<?php echo $facilityname; ?>
To login and setup facility details, please follow this link:

http://app.surgitrack.co.za/login


Please verify your email within <?php echo $activation_period; ?> hours, otherwise your registration will become invalid and you will have to register again.
<?php if (strlen($username) > 0) { ?>

    Your username: <?php echo $username; ?>
<?php } ?>

Your email address: <?php echo $email; ?>



Have fun!
The <?php echo $site_name; ?> Team