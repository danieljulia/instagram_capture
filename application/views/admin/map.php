<?php




$this->load->view('header');
?>

<div class="container">

<div class="row">

	<h1>Map</h1>


</div>



<div id="content" class="row">

<ul class="sets nav nav-pills nav-stacked">
<?php

 foreach($sets as $set): ?>
<li <?php if($set['id']==$set_id):?> class="active" <?php endif;?> role="presentation"><a href="<?php print site_url("admin/map/".$set['id'])?>"><?php print $set['name']?></a></li>
<?php endforeach; ?>
</ul>


</div>	



<div id="map">map</div>


</div> <!-- end container -->	


<script>

var map = L.map('map').setView([48, 10], 4);

var tiles = L.tileLayer('http://{s}.tiles.mapbox.com/v3/{id}/{z}/{x}/{y}.png', {
    attribution: '<a href="https://www.mapbox.com/about/maps/">Terms and Feedback</a>',
    id: 'examples.map-20v6611k'
}).addTo(map);

var addressPoints=new Array();
var heat;


function addPoint(lat,lng){
	var found=false;
	var num=addressPoints.length;
	for(var i=0;i<num;i++){
		if(addressPoints[i][0]==lat){
			if(addressPoints[i][1]==lng){
				addressPoints[i][2]++;
				found=true;
			}

		}
	}
	if(!found){
		addressPoints.push([lat,lng,1]);
	}
}
$(document).ready(function(){
		 $.getJSON("<?php print site_url("ajax/photos/".$set_id)?>",function(data){
		 	$.each(data,function(i,itm){
		 		if(itm.lat!=0){
		 			addPoint(parseFloat(itm.lat),parseFloat(itm.lng));
		 			
		 		}	

		 	});
		 	console.log(addressPoints);

		 	heat = L.heatLayer(addressPoints).addTo(map);
		 });

});
//var heat = L.heatLayer(addressPoints).addTo(map);

</script>


</body>
</html>