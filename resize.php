<?php 
include('inc/SimpleImage.php');
include('inc/config.php');

$entries = $db->getEntries(0);

foreach ($entries as $entry)
{
   $image = new SimpleImage();
   $image->load('user_content/' . $entry['uid'] . '.' . $entry['ext']);
   $image->resizeToWidth(300);
   $image->save('user_content/' . $entry['uid'] . '.' . $entry['ext']);
}
