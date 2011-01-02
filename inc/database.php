<?php

  #############################################################################
  # Burst Development MySQL Object                                            #
  # Copyright (c) 2007 Burst Development, LLC                                 #
  #                                                                           #
  # This file is property of Burst Development, LLC.  You should not be       #
  # seeing this message unless you are a client of, or an employee of Burst   #
  # Development.                                                              #
  #                                                                           #
  # Defines a class for usage with a MySQL Database.                          #
  # Originally written by Russell Frank, 10 13 07.                            #
  #############################################################################

class BurstMySQL {
   var $mConnection;
   var $mDBName;
   var $mQueries = array();
   var $mTotal=0;

   public function __construct ($mHost, $mUser, $mPass, $mDatabase, 
                                 $mPort=3306) {
      $this->mConnection = @mysql_connect($mHost . ':' . $mPort, $mUser, $mPass)
                                          or $this->OnError();
      $this->mDBName = $mDatabase;
      mysql_select_db ($mDatabase, $this->mConnection);
   }

   public function OnError ($mQuery) {
      echo ('<br><div style="border-style:solid; border-width: 1px; border-color: #ffd04d; background-color: #fff5b1; padding:10px">
             <div style="letter-spacing: 1px; font-family: verdana; font-size: 20px; text-align: left; color: #003355">
             Oops! Something went wrong.<br />Please report to the developers how you generated this error.</div>
             <div style="font-family: verdana; font-size: 12px; text-align: left;"></div></div>');
      $this->logError(mysql_error($this->mConnection), $mQuery);    
      die();
   }

   public function logError ($error, $mQuery) {
      $handle = fopen('/var/www/db.log','a+'); // ammend data to end of file, create file if it doesn't exist.
      $timestamp = date('m.d.Y h:iA T');
      fwrite($handle, "[" . $timestamp . "] " . $mQuery . " -- " . $error . " \r\n");
      fclose($handle);
   }

   public function Raw ($mQuery) {
      $mReturnData = array();
      $mResult = @mysql_query ($mQuery, $this->mConnection) or $this->OnError($mQuery);
      while ($row = @mysql_fetch_array ($mResult, MYSQL_ASSOC))
        $mReturnData[] = $row;
      return $mReturnData;
   }

   public function getEntry($uid)
   {
      $entry = $this->Raw("SELECT * FROM `entries` WHERE `uid`='$uid' LIMIT 1");
      return $entry[0];
   }

   public function getEntries($beg, $mod_status=0)
   {
      return $this->Raw("SELECT * FROM `entries` WHERE `mod_status`='$mod_status' ORDER BY `id` LIMIT $beg,9");
   }

   public function addEntry($uid, $ext, $name, $email, $reason)
   {
      $name = mysql_real_escape_string($name);
      $email = mysql_real_escape_string($email);
      $reason = mysql_real_escape_string($reason);

      $this->Raw("INSERT INTO `entries` (`uid`,`ext`, `name`,`email`,`reason`,`mod_status`) VALUES ('$uid','$ext','$name','$email','$reason','0')");
      return true;
   }

   public function checkEntryExists($uid)
   {
      $db_call = $this->Raw("SELECT COUNT(*) FROM `entries` WHERE `uid`='$uid'");
      if ($db_call[0]['COUNT(*)'] > 0)
         return true;

      return false;
   }

   public function approveMod($uid)
   {
      if ($this->checkEntryExists($uid))
      {
         $this->Raw("UPDATE `entries` SET `mod_status`='1' WHERE `uid`='$uid'");
         return true;
      }   

      return false;
   }

   public function deleteEntry($uid)
   {
      if ($this->checkEntryExists($uid))
      {
         $this->Raw("DELETE FROM `entries` WHERE `uid`='$uid' LIMIT 1");
         return true;
      }

      return false;
   }

   public function __destruct () {
      foreach ($this->mQueries as $mQuery) {
         if (!@mysql_query ($mQuery, $this->mConnection))
            $this->OnError();
      }
      @mysql_close ($this->mConnection);
   }
}

?>

