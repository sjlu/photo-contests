<?php
function checkEmail($email)
{
   $isValid = true;
   $atIndex = strrpos($email, "@");
   if (is_bool($atIndex) && !$atIndex)
   {
      $isValid = false;
   }
   else
   {
      $domain = substr($email, $atIndex+1);
      $local = substr($email, 0, $atIndex);
      $localLen = strlen($local);
      $domainLen = strlen($domain);
      if ($localLen < 1 || $localLen > 64)
      {
         // local part length exceeded
         $isValid = false;
      }
      else if ($domainLen < 1 || $domainLen > 255)
      {
         // domain part length exceeded
         $isValid = false;
      }
      else if ($local[0] == '.' || $local[$localLen-1] == '.')
      {
         // local part starts or ends with '.'
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $local))
      {
         // local part has two consecutive dots
         $isValid = false;
      }
      else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
      {
         // character not valid in domain part
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $domain))
      {
         // domain part has two consecutive dots
         $isValid = false;
      }
      else if
(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
                 str_replace("\\\\","",$local)))
      {
         // character not valid in local part unless 
         // local part is quoted
         if (!preg_match('/^"(\\\\"|[^"])+"$/',
             str_replace("\\\\","",$local)))
         {
            $isValid = false;
         }
      }
      if ($isValid && !(checkdnsrr($domain,"MX") || 
 ↪checkdnsrr($domain,"A")))
      {
         // domain not found in DNS
         $isValid = false;
      }
   }
   return $isValid;
}
 
if (isset($_GET['submit'])) {

   if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['confirm_email']) || empty($_POST['reason']))
   {
      $error = 'You are missing some information...';
   } 
   else if (!file_exists($_FILES['upfile']['tmp_name']))
   {
      $error = 'You forgot to upload an image!';
   } 
   else if ($_POST['email'] !== $_POST['confirm_email'])
   {
      $error = 'The two emails you have given did not match, please try again.';
   }
   else if (checkEmail($_POST['email']) === false)
   {
      $error = 'You did not provide us a valid email address.';
   }
   else if (!in_array(strtolower(substr($_FILES['upfile']['name'], strrpos($_FILES['upfile']['name'], '.') + 1)), array('gif','png','jpg','jpeg')))
   {
      $error = 'The file you gave us does not seem to be an image.';
   }

   if (isset($error))
   {
      header('Location: ' . $config['fb']['url'] . '/?tab=enter&error=' . urlencode($error));
   }
   else
   {
      $ext =  strtolower(substr($_FILES['upfile']['name'], strrpos($_FILES['upfile']['name'], '.') + 1));
      rename($_FILES['upfile']['tmp_name'], 'user_content/' . $_POST['uid'] . '.' . $ext);
     
      include('inc/SimpleImage.php'); 
      $image = new SimpleImage();
      $image->load('user_content/' . $_POST['uid'] . '.' . $ext);
      $image->resizeToWidth(300);
      $image->save('user_content/' . $_POST['uid'] . '.' . $ext);
      
      $db->addEntry($_POST['uid'],$ext, $_POST['name'],$_POST['email'],$_POST['reason']);
//      $db->Raw("INSERT INTO `entries` (`uid`,`name`,`email`,`reason`,`mod_status`) VALUES ('$_POST[uid]','$_POST[name]','$_POST[email]','$_POST[reason]','0')");
      header('Location: ' . $config['fb']['url'] . '/?tab=enter&success');
   }

}
else if (isset($_GET['delete']))
{
   $db->deleteEntry($user);
}
?>

<?php
if (isset($error))
{
   echo '<fb:error><fb:message>ERROR: ' . $error . '</fb:message></fb:error>';
}
?>

<?php 
if (isset($success)) {
   echo '<fb:success><fb:message>You have successfully submitted an entry! You can view it <a href="?tab=view&show">here</a>.</fb:message></fb:success>';
}
?>

<?php if (!isset($success)) { ?>

<?php 
if ($db->checkEntryExists($user)) { 
   echo '<fb:dialog id="confirm_delete" cancel_button=1>';
   echo '<fb:dialog-title>Are you sure you want to delete your entry?</fb:dialog-title>';
   echo '<fb:dialog-content><div style="font-weight: bold; font-size: 14px">Once it has been deleted, it cannot be undone. You can always submit a new entry though...</div></fb:dialog-content>';
   echo '<fb:dialog-button type="button" value="Yes, I\'m sure." href="?tab=enter&delete" />';
   echo '</fb:dialog>';
   echo '<fb:error><fb:message>You have already submitted an entry! You can either <a href="?tab=view&show">view it</a> or <a clicktoshowdialog="confirm_delete">delete it</a>.</fb:message></fb:error>';
} else { 
?>

<center>
<form name="form1" enctype="multipart/form-data" method="post" action="<?php echo $config['server']['url']; ?>/?tab=enter&submit">
<table class="editorkit" border="0" cellspacing="0" style="margin-top: 10px; width:400px; border: 1px solid #000000; padding: 10px; background-color: #ffffff;">
   <tr class="width_setter">
      <th style="width:100px"></th>
      <td></td>
   </tr>

   <tr>
   <th><label>Email:</label></th>
      <td class="editorkit_row">
      <input name="email" type="text" size="32" />
      </td>
      <td class="right_padding"></td>
   </tr>

   <tr>
   <th><label>Confirm Email:</label></th>
      <td class="editorkit_row">
      <input name="confirm_email" type="text" size="32" />
      </td>
      <td class="right_padding"></td>
   </tr>
   
   <tr>
      <th><label>Image:</label></th>
      <td class="editorkit_row">
      <input name="upfile" type="file" size="23" style="color: #003366; font-family: Verdana; font-weight: normal; font-size:11px">
      </td>
      <td class="right_padding"></td>
   </tr>

   <th><label>Why'd you choose this outfit? (< 50 words)</label></th>
      <td class="editorkit_row">
      <textarea cols="40" rows="4" name="reason" type="textbox" />
      </td>
      <td class="right_padding"></td>
   </tr>


   <?php $api_call = $facebook->api('/me'); ?>
   <input type="hidden" name="uid" value="<?php echo $user; ?>" />
   <input type="hidden" name="name" value="<?php echo $api_call['name']; ?>" />

   <tr>
      <th></th>
      <td class="editorkit_buttonset">
         <input name='upload' type='submit' id='upload' class="editorkit_button action" value='Submit' clickthrough="true" />
      </td>
      <td class="right_padding"></td>
   </tr>

</table>
</form>
</center>

<?php } ?>
<?php } ?>
