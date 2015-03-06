<?php
$addr=$_POST['addr'];
$contact_no=$_POST['contact_no'];
?>
<p align="center">Review</p>
<hr />
<table align="center" width="100%" cellpadding="5">
<tr><td width="25%">Address</td><td><?php echo($addr);?></td></tr>
<tr><td>Contact Number</td><td><?php echo($contact_no);?></td></tr>
<tr><td></td><td><button class="std_btn" onclick="makeChangesToProfile()">Make Changes</button></td></tr>
</table>

<script type="text/javascript" src="../js.js"></script>
