<?php
$this->load->view('header');
?>

<div class="container">

<div class="row">

	<h1>View set</h1>


</div>

<div id="content" class="row">
<a class="btn btn-lg btn-primary" href="<?php print site_url("sets/parse/".$id)?>">Parse set '<?php print $set->name?>'</a>


<div class="row">
<h2>Num: <?php print count($photos) ?></h2>
<?php foreach($photos as $p): ?>
<a target="instagram" href="<?php print $p['link']?>" title="<?php print $p['caption']?>"><img src="<?php print $p['photo_url']?>"></a>
<?php endforeach; ?>

</div>


</div>	

	

</div> <!-- end container -->



</body>
</html>