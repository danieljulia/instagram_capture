<?php
header('Content-type: text/csv');
header('Content-Disposition: attachment; filename="instagram_data.csv"');
?>

"username","photo_url","lat","lng","created_time"
<?php
foreach($photos as $p):
	if($p['lat']!=0){
?>

"<?php  print $p['username']; ?>","<?php  print $p['photo_url']; ?>","<?php  print $p['lat']; ?>","<?php  print $p['lng']; ?>","<?php  print $p['created_time']; ?>"
<?php
}
 endforeach; 