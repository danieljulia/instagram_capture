<?php require "header.php";
?>

<div class="container">

<div class="row">

	<h1>Capturing info</h1>

	<div id="info">
	loading contents...
	</div>
</div>

<div id="content" class="row">

<div class="col-md-4">		
	
<div id="map" style="width: 100%; height: 400px"></div>
</div>
<div class="col-md-8">	
	<div id="images">

	</div>

	</div>
</div>	

	

</div> <!-- end container -->


	<script>
		var map = L.map('map').setView([41, 1], 8);

		L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
			attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
		}).addTo(map);

	
	</script>


<script>
$(document).ready(function(){
	search();

});


var pags=0;
var total=0;
var next_url="";
var count=0;
var max=2000;
var markers;
markers=new Array();

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

		html="";

		for(var i=0;i<markers.length;i++){
				map.removeLayer(markers[i]);
		}
		

		markers=new Array();
		$.each(data.data,function(i,itm){
			html+="<img src='"+itm.u+"'>";
			if(itm.l!=0){
				var m=L.marker([itm.l, itm.g]).bindPopup("Hello world").addTo(map);
				markers.push(m);
			}
		});


		 var group = new L.featureGroup(markers);
		 map.fitBounds(group.getBounds());

		$('#images').html(html);

		count++;
		if(data.count==0){
			console.log("finished");
			$('#info').html("captura acabada");
			return;

		}
		if(count<max){
			search();
		}
	});
}

function timeConverter(UNIX_timestamp){
  var a = new Date(UNIX_timestamp*1000);
  var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
  var year = a.getFullYear();
  var month = months[a.getMonth()];
  var date = a.getDate();
  var hour = a.getHours();
  var min = a.getMinutes();
  var sec = a.getSeconds();
  var time = date + ',' + month + ' ' + year + ' ' + hour + ':' + min + ':' + sec ;
  return time;
}


</script>

</body>
</html>