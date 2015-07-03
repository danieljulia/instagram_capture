<?php
$this->load->view('header');
?>



<div class="row">

	<h1>Sets</h1>


</div>

<div id="content" class="row">
<h2><a class="btn btn-md btn-primary" href='<?php print site_url('sets/add')?>'>Create set</a></h2>
<ul class="sets nav nav-pills nav-stacked">
<?php

 foreach($sets as $set): ?>
<li role="presentation"><a href="<?php print site_url("sets/config/".$set['id'])?>"><?php print $set['name']?></a></li>
<?php endforeach; ?>
</ul>

</div>	

	

<?php 
$this->load->view('footer');
?>