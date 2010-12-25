<?php 
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
   else if (!in_array(strtolower(substr($_FILES['upfile']['name'], strrpos($_FILES['upfile']['name'], '.') + 1)), array('gif','png','jpg')))
   {
      $error = 'The file you gave us does not seem to be an image.';
   }

   if (isset($error))
   {
      header('Location: ' . $config['fb']['url'] . '/?tab=enter&error=' . urlencode($error));
   }
   else
   {
      rename($_FILES['upfile']['tmp_name'], 'user_content/' . $_POST['fb_sig_user'] . '.' . strtolower(substr($_FILES['upfile']['name'], strrpos($_FILES['upfile']['name'], '.') + 1)));
      $db->addEntry($_POST['fb_sig_user'],$_POST['name'],$_POST['email'],$_POST['reason']);
      header('Location: ' . $config['fb']['url'] . '/?tab=enter&success');
   }

   // This is where we need to add the entry into the database.
   // It have id (auto-incre), uid, name, email, reason, mod_status

}
?>

<?php
if (isset($error))
{
   echo '<fb:error><fb:message>' . $error . '</fb:message></fb:error>';
}
?>

<?php if (!isset($success)) { ?>

<?php if ($db->checkEntryExists($_POST['fb_sig_user'])) { echo '<fb:error><fb:message>You have already submitted an entry!</fb:message></fb:error>'; } else { ?>

<center>
<form name="form1" enctype="multipart/form-data" method="post" action="<?php echo $config['server']['url']; ?>/?tab=enter&submit">
<table class="editorkit" border="0" cellspacing="0" style="margin-top: 10px; width:400px; border: 1px solid #000000; padding: 10px; background-color: #ffffff;">
   <tr class="width_setter">
      <th style="width:100px"></th>
      <td></td>
   </tr>

   <tr>
   <th><label>Name:</label></th>
      <td class="editorkit_row">
      <input name="name" type="text" size="32" />
      </td>
      <td class="right_padding"></td>
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
