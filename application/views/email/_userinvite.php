Dear  <?php if (strlen($username) > 0) { ?>Dr. <?php echo $username; ?><br /><?php } ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head><title>Welcome to <?php echo $site_name; ?>!</title></head>
<body>
<div style="max-width: 800px; margin: 0; padding: 30px 0;">
    <table width="80%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="5%"></td>
            <td align="left" width="95%" style="font: 13px/18px Arial, Helvetica, sans-serif;">
                <h2 style="font: normal 20px/23px Arial, Helvetica, sans-serif; margin: 0; padding: 0 0 18px; color: black;">Welcome to <?php echo $site_name; ?>!</h2>
                You are invited to <?php echo $site_name; ?> as User within:<br />
                <h4 style="font: normal 20px/23px Arial, Helvetica, sans-serif; margin: 0; padding: 0 0 18px; color: black;"><?php echo $facilityname; ?>!</h4>
                To login, please follow this link:<br />
                <br />
                <big style="font: 16px/18px Arial, Helvetica, sans-serif;"><b><a href="<?=base_url()?>auth/login" style="color: #3366cc;">Continue....</a></b></big><br />
                <br />
                Link doesn't work? Copy the following link to your browser address bar:<br />
                <nobr><a href="<?=base_url()?>auth/login" style="color: #3366cc;"><?=base_url()?>auth/login</a></nobr><br />
                <br />
                <br />
                Your email address/Username: <?php echo $email; ?><br />
                <?php if (isset($password)){?> Your password: <?php echo trim($password);?><?php }?><br />
                <br />
                <br />
                Kind Regards!<br />
                The <?php echo $site_name; ?> Team
            </td>
        </tr>
    </table>
</div>
</body>
</html>
</html>