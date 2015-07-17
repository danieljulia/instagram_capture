<?php
$this->load->view('header');
?>

<div class="container">

<div class="row">

	<h1>Exports</h1>


</div>



<div id="content" class="row">
<?php if(isset($sets)): ?>
<ul class="sets nav nav-pills nav-stacked">
<?php

 foreach($sets as $set): ?>
<li role="presentation"><a href="<?php print site_url("admin/export/".$set['id'])?>"><?php print $set['name']?></a></li>
<?php endforeach; ?>
</ul>

</div>	
<?php
else:
?>

<ul class="exports">
<li><a href="<?php print site_url("export/photos/".$set_id)?>">Photos (csv)</a></li>
<li><a href="<?php print site_url("export/photos_geo/".$set_id)?>">Photos geo (csv)</a></li>

<li>
<a href="<?php print site_url("export/users/".$set_id)?>">Users (csv)</a></li>
<li>
<a href="<?php print site_url("export/graph/".$set_id)?>">Graph (gdf)</a></li>
</ul>

<?php
endif;
?>
</div> <!-- end container -->	





</body>
</html>