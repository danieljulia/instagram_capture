<?php
$this->load->view('header');
?>

<div class="container">

<div class="row">

	<h1>Sets</h1>


</div>

<div id="content" class="row">
<h2><a href='<?php print site_url('sets/add')?>'>Create set</a></h2>
<ul class="sets">
<?php

 foreach($sets as $set): ?>
<li><a href="<?php print site_url("sets/view/".$set['id'])?>"><?php print $set['name']?></a></li>
<?php endforeach; ?>
</ul>

</div>	

	

</div> <!-- end container -->



</body>
</html>