<?php include 'inc/config.php'; ?>

<img src="<?php echo $config['server']['url']; ?>/img/main.png">

<table border="0" cellspacing="0" cellpadding="0" style="margin-top: -34px;">
<tr>
   <td width="250px" style="border-right: 1px solid #575a7e">
   </td>
   <td style="border-right: 1px solid #575a7e">
      <a href="?tab=details"><img src="<?php echo $config['server']['url']; ?>/img/details.png"></a>
   </td>
   <td style="border-right: 1px solid #575a7e">
      <a href="?tab=enter"><img src="<?php echo $config['server']['url']; ?>/img/enter.png"></a>
   </td>
   <td style="border-right: 1px solid #575a7e">
      <a href="?tab=view"><img src="<?php echo $config['server']['url']; ?>/img/view.png"></a>
   </td>
   <td style="border-right: 1px solid #575a7e">
      <a href="?tab=invite"><img src="<?php echo $config['server']['url']; ?>/img/invite.png"></a>
   </td>
</tr>
</table>


<div style="width: 740px; border: 10px solid #1f2353; padding-top: 10px; background-color: #f7f7f7; margin-top: -3px;">

<div style="margin: 10px;">

<?php
   switch ($_GET['tab'])
   {
      case 'details': include 'details.php'; break;
      case 'enter': include 'enter.php'; break;
      case 'view': include 'view.php'; break;
      case 'invite': include 'invite.php'; break;
      default: include 'details.php'; break;
   }
?>
</div>

</div>
