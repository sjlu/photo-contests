<div style="font-size: 22px; font-weight: bold; margin-bottom: 8px;">Details</div>

<div style="margin-left: 15px; font-size: 14px">
<?php
$fh = fopen("details.txt", 'r');
$pageText = fread($fh, 25000);
echo nl2br($pageText);
?>
</div>


<div style="font-size: 22px; font-weight: bold; margin-bottom: 8px;">
<a clicktotoggle="rules">View Official Rules & Privacy Policy</a>
</div>
<div id="rules" style="margin-left: 15px; font-size: 12px; <?php if(!isset($_GET['rules'])) echo 'display:none;'; ?>">
<?php
$fh = fopen("rules.txt", 'r');
$pageText = fread($fh, 25000);
echo nl2br($pageText);
?>
</div>
