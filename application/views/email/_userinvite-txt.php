Welcome to <?php echo $site_name; ?>,


You are invited to <?php echo $site_name; ?> as user within:<br />
<?php echo $facilityname; ?>!
To login and setup facility details, please follow this link:<br />

<?php echo base_url().'/auth/login'; ?>


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