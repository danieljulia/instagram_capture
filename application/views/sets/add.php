<?php 
$this->load->view('header');
//require "../header.php";
?>

<div class="container">

<div class="row">

	<h1>Create a set</h1>


</div>

<div id="content" class="row">

<?php

if(isset($name)):

?>

Set created '<?php echo $name?>'


<?php
else:

//http://www.codeigniter.com/userguide3/helpers/form_helper.html
echo form_open('sets/add',array('class' => 'myform', 'role' => 'form'));


/*
$hidden = array('username' => 'Joe', 'member_id' => '234');
echo form_open('email/send', '', $hidden);
*/
?>

<div class="col-md-6">

<div class="form-group">
 <label for="name">Name</label>
<?php echo form_input(array('name'=>'name','placeholder'=>'type the set name','class' => 'form-control')) ?>
</div>


<?php echo form_submit(array('value'=> 'Continue','class' => 'form-control'));?>
<?php echo form_close();?>



<?php
endif;
?>
</div>
<div class="col-md-6">


</div>


</div> <!-- end container -->



</body>
</html>