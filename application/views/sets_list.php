<?php require "header.php";
?>

<div class="container">

<div class="row">

	<h1>Sets</h1>


</div>

<div id="content" class="row">
<ul class="sets">
<?php

print_r($sets);

 foreach($sets as $set): ?>
<li><a href="<?php print site_url("sets/view/".$set['id'])?>"><?php print $set['name']?></a></li>
<?php endforeach; ?>
</ul>

</div>	

	

</div> <!-- end container -->



</body>
</html>