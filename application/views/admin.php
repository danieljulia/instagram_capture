<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

	<style type="text/css">

	</style>
	<script type="text/javascript" src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
</head>
<body>

<div id="container">
	<h1>Instagram tool</h1>

	<div id="body">
		
	<div id="info">
	</div>

	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>

<script>
$(document).ready(function(){
	search();

});


var pags=0;
var total=0;
var next_url="";
var count=0;
var max=20;

function search(){

	var uri="<?php echo site_url()?>cron/cron";

	if(next_url!=""){

	}
	uri+="?url="+encodeURIComponent(next_url);

	console.log("buscant a ",uri);

	$.getJSON(uri,function(data){
		console.log(data);
		total+=data.count;
		next_url=data.url;
		$('#info').html(total+" fotos");
		count++;
		if(count<max){
			search();
		}
	});
}
</script>

</body>
</html>