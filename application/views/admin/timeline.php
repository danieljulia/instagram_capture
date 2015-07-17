<?php
$this->load->view('header');
?>

<div class="container">

<div class="row">

	<h1>Timeline</h1>


</div>

<div id="content" class="row">
<?php if(isset($sets)): ?>
<ul class="sets nav nav-pills nav-stacked">
<?php

 foreach($sets as $set): ?>
<li role="presentation"><a href="<?php print site_url("admin/timeline/".$set['id'])?>"><?php print $set['name']?></a></li>
<?php endforeach; ?>
</ul>

</div>	
<?php
else:
?>


      <button id="change">Click to change the format</button>
    <div id="chart_div"></div>

<?php
endif;
?>
</div> <!-- end container -->	
	

</div> 
<script>
var data;




        google.load('visualization', '1', {packages: ['corechart']});
      google.setOnLoadCallback(drawChart);

      function drawChart() {

         data = new google.visualization.DataTable();
        data.addColumn('date', 'Time of Day');
        data.addColumn('number', 'Number');
     

/*
        data.addRows([
          [new Date(2015, 0, 1), 5],  [new Date(2015, 0, 2), 7],  [new Date(2015, 0, 3), 3],
          [new Date(2015, 0, 4), 1],  [new Date(2015, 0, 5), 3],  [new Date(2015, 0, 6), 4],
          [new Date(2015, 0, 7), 3],  [new Date(2015, 0, 8), 4],  [new Date(2015, 0, 9), 2],
          [new Date(2015, 0, 10), 5], [new Date(2015, 0, 11), 8], [new Date(2015, 0, 12), 6],
          [new Date(2015, 0, 13), 3], [new Date(2015, 0, 14), 3], [new Date(2015, 0, 15), 5],
          [new Date(2015, 0, 16), 7], [new Date(2015, 0, 17), 6], [new Date(2015, 0, 18), 6],
          [new Date(2015, 0, 19), 3], [new Date(2015, 0, 20), 1], [new Date(2015, 0, 21), 2],
          [new Date(2015, 0, 22), 4], [new Date(2015, 0, 23), 6], [new Date(2015, 0, 24), 5],
          [new Date(2015, 0, 25), 9], [new Date(2015, 0, 26), 4], [new Date(2015, 0, 27), 9],
          [new Date(2015, 0, 28), 8], [new Date(2015, 0, 29), 6], [new Date(2015, 0, 30), 4],
          [new Date(2015, 0, 31), 6], [new Date(2015, 1, 1), 7],  [new Date(2015, 1, 2), 9]
        ]);*/


     

     
      }


$(document).ready(function(){
	 $.getJSON("<?php print site_url("ajax/timeline/".$set_id)?>",function(mydata){
         console.log(mydata);
         var values=new Array();
         console.log("values loaded");
         $.each(mydata,function(i,d){
         	var dat=d.d;
         	var dtt=dat.split("-");
         	if(dat!="1970-01-01")
         		values.push([ new Date(dtt[0],dtt[1]-1,dtt[2]),parseInt(d.t)]);

         });
         console.log(values);

	 data.addRows(values);
	    var options = {
          title: 'Number of published photos by day',
          width: 900,
          height: 500,
          hAxis: {
            format: 'M/d/yy',
            gridlines: {count: 15}
          },
          vAxis: {
            gridlines: {color: 'none'},
            minValue: 0
          }
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

        chart.draw(data, options);
   var button = document.getElementById('change');

        button.onclick = function () {

          // If the format option matches, change it to the new option,
          // if not, reset it to the original format.
          options.hAxis.format === 'M/d/yy' ?
          options.hAxis.format = 'MMM dd, yyyy' :
          options.hAxis.format = 'M/d/yy';

          chart.draw(data, options);
        };
        
      });
});


      </script>



</body>
</html>