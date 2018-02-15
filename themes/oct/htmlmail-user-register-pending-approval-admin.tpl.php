<?php

/**
 * @file
 * Sample template for HTML Mail test messages.
 */
global $base_url;
global $base_path;
?>

<div style="background-color: #fbffb2; width:100%; height:100%;">
<table width="600" border="0" cellpadding="0" cellspacing="0" style="margin:10px auto;">
  <tr>
    <td width="600" height="150"><img src="<?php print $base_url . $base_path . drupal_get_path('theme', 'oct'); ?>/images/OCT_Backstage_header.gif" width="600" height="150" alt="Backstage" /></td>
  </tr>
  <tr>
    <td width="600" height="50">&nbsp;</td>
  </tr>
  <tr>
    <td style="font-family: Georgia, 'Times New Roman', Times, serif;font-size: 16px;color: #3b5f94;">
      <p style="font-family: Georgia, 'Times New Roman', Times, serif;font-size: 24px;color: #CD7622;text-align: center;"><?php print t('Congratulations!');?></p>
      <div style="font-family: Georgia, 'Times New Roman', Times, serif;font-size: 16px;color: #3b5f94;"><?php echo $body; ?></div>
    </td>
  </tr>
  <tr>
    <td width="600" height="50">&nbsp;</td>
  </tr>
  <tr>
    <td width="600" height="250"><img src="<?php print $base_url . $base_path . drupal_get_path('theme', 'oct'); ?>/images/OCT_footer.gif" width="600" height="250" alt="OCT" /></td>
  </tr>
</table>
</div>