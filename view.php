<?php 
function getSize($maxwidth, $file)
{ 
   list($width,$height) = getimagesize($file);
   if ($width > $maxwidth)
   {
      $height = $maxwidth/$width * $height;
      $width = $maxwidth;
   }
   
   return array($width, $height);
}

function viewEntry($entry)
{
   list($width,$height) = getSize(300, 'user_content/' . $entry['uid'] . '.' . $entry['ext']);
   $html = '<table border=0><tr>';
   $html.= '<td>';
   $html.= '<img src="' . $GLOBALS['app_config']['server']['url'] . '/user_content/' . $entry['uid'] . '.' . $entry['ext'] . '"';
   $html.= 'height=' . $height . ' width=' . $width . ' />';
   $html.= '</td><td style="padding-left: 10px">';
   $html.= '<div style="font-size: 22px; font-weight: bold"><fb:name uid="' . $entry['uid'] . '" firstnameonly=1 linked=0 reflexive=0 /></div>';
   if ($GLOBALS['app_config']['admin'])
      $html.='<div style="font-size: 18px;"><a href="mailto:' . $entry['email'] . '">' . $entry['email'] . '</a></div>';
   $html.= '<div style="font-size: 16px">' . $entry['reason'] . '</div>';
   $html.= '</td>';
   $html.= '</tr></table>';

   return $html;
}

function displayEntries ($entries, $admin=0)
{
   $i = 0;
   $html = '<table border="0" align="center">';
   $html .= '<tr>';
   foreach ($entries as $entry)
   {
      $i++;
      $html .= '<td>';
      $html .= renderEntry($entry);
      $html .= '</td>';
      if (($i % 4) == 0)
         $html .='</tr><tr>';
   }
   $html .= '</tr></table>';
   return $html;
}

function renderEntry ($entry)
{
   list($width,$height) = getSize(150, 'user_content/' . $entry['uid'] . '.' . $entry['ext']);
   // entry is an array with uid, name, reason
   $html = '<div style="border: 1px solid #000; padding: 10px;"><a href="?tab=view&show=' . $entry['uid'] . '">';
   $html .='<img src="' . $GLOBALS['app_config']['server']['url'] . '/user_content/' . $entry['uid'] . '.' . $entry['ext'] . '" width="' . $width . '" height="' . $height . '" />';
   $html .='<br /><div align="center" style="font-size: 14px; font-weight: bold;"><fb:name uid="' . $entry['uid'] . '" firstnameonly=1 linked=0 reflexive=0 /></a></div>';
   $html .= '</div>';
   return $html;
}

?>

<?php 
if (isset($_GET['show']))
{
   echo '<a href="?tab=view"><div align="right" style="font-size: 18px; margin-right: 10px;">Back to other entries</div></a>';
   if (empty($_GET['show']))
      $_GET['show'] = $user;
   echo viewEntry($db->getEntry($_GET['show']));
}
else
{
?>

   <?php if ($config['admin'] == true) { ?>
   <fb:tabs>
      <fb:tab-item href="?tab=view&mod" title="Require Moderation" />
      <fb:tab-item href="?tab=view" title="Approved Entries" />
   </fb:tabs>
   <div style="height: 10px;"></div>
   <?php } ?>

   <?php if (isset($_GET['mod'])) { ?>
   <fb:explanation><fb:message>All the following entries requrire moderation, please accept if you approve this to go public.</fb:message></fb:explanation>
   <?php } else { ?>
      <?php if($config['admin'] == true) { ?>
         <fb:explanation><fb:message>This is what the public normally sees (excluding this message), you can delete entries here if you'd like.</fb:message></fb:explanation>
      <?php } ?>
   <?php } ?>

   <?php if (!isset($_GET['page'])) $_GET['page'] = 0; ?>
   <?php $count = $db->getEntriesCount(); ?>
   <?php if ($_GET['page'] !== 0) $pagination = '<a href="?tab=view&page=' . $_GET['page']-1 . '">Previous</a>'; ?> 

   <?php
   echo displayEntries($db->getEntries(0));
   ?>
<?php } ?>
