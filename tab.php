<?php include 'inc/config.php'; ?>
<style>
#wrapper {
   width: 520px;
   margin: 0 auto; border: 0; padding: 0;
   position: relative;
}

#non-fans {
   width: 520px;
   position: absolute; top: 0; left: 0;
}
</style>

<div id="wrapper">
   <fb:visible-to-connection>
      <a href="<?php echo $config['fb']['url']; ?>">
         <img src="<?php echo $config['server']['url']; ?>/img/tab-fan.jpg" />
         Click the image to view the contest!
      </a>
   <fb:else>
      <div id="non-fans">
         <img src="<?php echo $config['server']['url']; ?>/img/tab-not-fan.jpg" />
      </div>
   </fb:else>
   </fb:visible-to-connection>
</div>
