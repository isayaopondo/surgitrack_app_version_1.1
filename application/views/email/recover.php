<?php
$special_link = str_replace( '"','',$special_link );
?>
<!DOCTYPE html>
<html lang="en-us">
<head><title></title></head>
<body>
<div style="max-width: 800px; margin: 0; padding: 30px 0;">
    <table width="80%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="5%"></td>
            <td align="left" width="95%" style="font: 13px/18px Arial, Helvetica, sans-serif;">
                <h2 style="font: normal 20px/23px Arial, Helvetica, sans-serif; margin: 0; padding: 0 0 18px; color: black;"> Hello <?=$username?>!</h2>
                <br/>
                <p>You are receiving this email because we received a password reset request for your account.</p>

                <br/>
                Click on this link to reset your password:
                <br/>
                <?=$special_link?>
                <br/>
                <p>If you did not request a password reset, no further action is required.</p>
                <br/>

                <br/>
                Regards!<br/>
                Surgitrack Team
            </td>
        </tr>
    </table>

    <br/>
    <p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#74787e;line-height:1.5em;margin-top:0;text-align:left;font-size:12px">
        If you're having trouble clicking the "Reset Password" button, copy and paste the URL below
        into your web browser:
        <?php
       echo '<a href="'.$special_link.'"style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#3869d4"
                                  target="_blank">'.$special_link.'</a>' ;
        ?>
    </p>
    <br/>
    <br/>

    <p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;line-height:1.5em;margin-top:0;color:#aeaeae;font-size:12px;text-align:center">&copy; <?=date('Y')?> <span class="il">Surgitrack</span>. All rights reserved.</p>

</div>
</body>
</html>
