<?php
include_once($_SERVER["DOCUMENT_ROOT"]."/views/Segments.php");
Segments::header();
?>

<div class='dashboard_div'>
<h1 style="text-align:center"><?=$site_name?> Cert</h1><hr />

<center>
<img src = "/static/images/certificate.png" class="certificate_img"/>
</center>

</div>

<?php
Segments::footer();
?>