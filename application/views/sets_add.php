<?php require "header.php";
?>

<div class="container">

<div class="row">

	<h1>Add a set</h1>


</div>

<div id="content" class="row">

<?php
//http://www.codeigniter.com/userguide3/helpers/form_helper.html
echo form_open('sets/add');

/*
$hidden = array('username' => 'Joe', 'member_id' => '234');
echo form_open('email/send', '', $hidden);
*/
?>

Name: <?php echo form_input('name', ''); ?>
Lat: <?php echo form_input('lat', ''); ?>
Lng: <?php echo form_input('lng', ''); ?>
Distance: <?php echo form_input('distance', ''); ?>

<?php echo form_submit('mysubmit', 'Save');?>
<?php echo form_close();?>




</div> <!-- end container -->



</body>
</html>