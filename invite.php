<center>
<fb:request-form
method="post"
type="<?php echo $config['app']['name']; ?>"
invite="true"
content="Your friend wants you to check this contest out! <fb:req-choice url='<?php echo $config['fb']['url']; ?>' label='GO' /> ">
<fb:multi-friend-selector actiontext="Share this page with your friends" rows="3" showborder="false" cols="5" />
</fb:request-form>
</center>
