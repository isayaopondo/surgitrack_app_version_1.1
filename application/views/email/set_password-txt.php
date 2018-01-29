<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head><title></title></head>
<body>
<div style="max-width: 800px; margin: 0; padding: 30px 0;">

    <table width="80%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="5%"></td>
            <td align="left" width="95%" style="font: 13px/18px Arial, Helvetica, sans-serif;">
                <h2 style="font: normal 20px/23px Arial, Helvetica, sans-serif; margin: 0; padding: 0 0 18px; color: black;">Welcome to <?php echo $site_name; ?>!</h2>
                You are invited to <?php echo $site_name; ?> as User within:<br />
                <h4 style="font: normal 20px/23px Arial, Helvetica, sans-serif; margin: 0; padding: 0 0 18px; color: black;"><?php echo $facilityname; ?>!</h4>
                To login, please follow this link to set your preferred password and continue:<br />
                <br />
                <br/>
                <?=$special_link?>
                <br/>
                <br />
                Kind Regards!<br />
                The <?php echo $site_name; ?> Team
            </td>
        </tr>
    </table>
    <br/>
    <p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#74787e;line-height:1.5em;margin-top:0;text-align:left;font-size:12px">
        If you’re having trouble clicking the "Reset Password" button, copy and paste the URL below
        into your web browser: <a href="<?=$special_link?>" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#3869d4"
                                  target="_blank"><?=$special_link?></a></p>
    <br/>
    <br/>

    <p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;line-height:1.5em;margin-top:0;color:#aeaeae;font-size:12px;text-align:center">&copy; <?=date('Y')?> <span class="il">Surgitrack</span>. All rights reserved.</p>
</div>
</body>
</html>