<?php include 'inc/config.php'; ?>
<?php print_r($_POST); ?>
<fb:visible-to-connection>
   <img src="<?php echo $config['server']['url']; ?>/img/tab-not-fan.jpg" />
   <fb:else><a href="<?php echo $config['fb']['url']; ?>"><img src="<?php echo $config['server']['url']; ?>/img/main.jpg" /></a></fb:else>
</fb:visible-to-connection>
