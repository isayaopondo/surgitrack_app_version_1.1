Welcome to <?php echo $site_name; ?>,

Thanks for joining <?php echo $site_name; ?>. We listed your sign in details below, make sure you keep them safe.
To verify your email address, please follow this link:

You are invited to <?php echo $site_name; ?> as Facility Administrator of:<br />
<?php echo $facilityname; ?>!
To login and setup facility details, please follow this link:<br />

<?php echo APP_URL.'/auth/login'; ?>


<?php if (strlen($username) > 0) { ?>

    Your username: <?php echo $username; ?>
<?php } ?>

Your email address: <?php echo $email; ?>
<?php if (isset($password)) { /* ?>

  Your password: <?php echo $password; ?>
  <?php */
} ?>


Regards!
The <?php echo $site_name; ?> Team