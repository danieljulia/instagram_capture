<?php
header('Content-type: text/csv');
header('Content-Disposition: attachment; filename="instagram_users_set_'.$id.'.csv"');
?>
"username","profile_picture","photos","comments","likes","lat","lng"
<?php
foreach($users as $p):
?>"<?php  print $p['username']; ?>","<?php  print $p['profile_picture']; ?>","<?php  print $p['photos']; ?>","<?php  print $p['comments']; ?>","<?php  print $p['likes']; ?>","<?php  print $p['lat']; ?>","<?php  print $p['lng']; ?>"
<?php
 endforeach; 