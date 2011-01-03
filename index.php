<?php include 'inc/config.php'; ?>

<?php
function renderButton($button, $select)
{
   $html = '<a href="?tab=' . $button . '">';
   $html .= '<img src="' . $GLOBALS['app_config']['server']['url'] . '/img/' . $button;
   if ($button == $select)
      $html .= '-select';
   $html .= '.jpg';
   $html .= '" />';
   $html .= '</a>';
   
   return $html;
}
?>

<?php if (!isset($_GET['tab'])) $_GET['tab'] = 'details'; ?>

<table border=0 cellspacing=0 cellpadding==0 style="margin-bottom: -3px;">
<tr>
   <td>
      <img src="<?php echo $config['server']['url']; ?>/img/main-top.jpg" />
   </td>
   <td>
      <a href="?tab=details&rules#rules"><img src="<?php echo $config['server']['url']; ?>/img/main-rules.jpg" border="0"/></a>
   </td>
   <td>
      <a href="?tab=details&rules"><img src="<?php echo $config['server']['url']; ?>/img/main-privacy.jpg" /></a>
   </td>
</tr>
</table>
   

<img src="<?php echo $config['server']['url']; ?>/img/main-bottom.jpg" />

<?php $buttons = array('details','enter','view','invite'); ?>

<table border="0" cellspacing="1" cellpadding="0" style="margin-top: -34px;">
<tr>
   <td width="260px"></td>
   <?php
   foreach ($buttons as $button)
   {
      $html = '<td>';
      $html .= renderButton($button, $_GET['tab']);
      $html .= '</td>';
      echo $html;
   }
   ?>
</tr>
</table>


<div style="width: 740px; border-left: 10px solid #1f2353;  border-right: 10px solid #1f2353;  border-bottom: 10px solid #1f2353; background-color: #f7f7f7; margin-top: -13px; padding-top: 10px">

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
