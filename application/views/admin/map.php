<?php
$this->load->view('header');
?>

<div class="container">

<div class="row">

	<h1>Map</h1>


</div>



<div id="content" class="row">
<?php if(isset($sets)): ?>
<ul class="sets nav nav-pills nav-stacked">
<?php

 foreach($sets as $set): ?>
<li role="presentation"><a href="<?php print site_url("admin/map/".$set['id'])?>"><?php print $set['name']?></a></li>
<?php endforeach; ?>
</ul>

</div>	
<?php
else:
?>

map <?php print $set_id?>

<?php
endif;
?>
</div> <!-- end container -->	





</body>
</html>