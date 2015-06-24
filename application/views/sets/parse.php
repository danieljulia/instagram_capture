<?php 

$this->load->view('header');
?>

<div class="container">

<div class="row">

	<h1>Capturing info for set '<?php print $set->name?>'</h1>

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
	
	var uri="<?php echo site_url()?>cron/parse/<?php print $set->id?>";

	if(next_url!=""){

	}
	uri+="?url="+encodeURIComponent(next_url);

	console.log("buscant a ",uri);
	

	$.getJSON(uri,function(data){
		console.log(data);
		total+=data.count;
		next_url=data.url;
		$('#info').html(total+" fotos : "+data.headers[1]+" "+createDate(data.data[0].t));

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

function createDate(unix_timestamp){
	var date = new Date(unix_timestamp*1000);
	return date.toString();
	/*
	// hours part from the timestamp
	var hours = date.getHours();
	// minutes part from the timestamp
	var minutes = "0" + date.getMinutes();
	// seconds part from the timestamp
	var seconds = "0" + date.getSeconds();

	// will display time in 10:30:23 format
	var formattedTime = hours + ':' + minutes.substr(-2) + ':' + seconds.substr(-2);
	return formattedTime;
	*/

}

</script>

</body>
</html>