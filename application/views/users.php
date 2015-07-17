<?php 
$this->load->view('header');
//require "../header.php";
?>
<div class="container">



<?php if(isset($sets)): ?>
	<div id="content" class="row">
<ul class="sets nav nav-pills nav-stacked">
<?php

 foreach($sets as $set): ?>
<li <?php if($set['id']==$set_id):?> class="active" <?php endif;?> role="presentation"><a href="<?php print site_url("admin/users/".$set['id'])?>"><?php print $set['name']?></a></li>
<?php endforeach; ?>
</ul>

</div>	
<?php endif; ?>


<div class="row">
    <div>
		<?php print ($output->output); ?>
    </div>
      </div>
        </div>
</body>
</html>
