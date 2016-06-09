<pre>
<?php 
/*
* Template Name: test
*/
$user = get_user_by('email', 'rr@rr.rr
');
$res1 = sendPushNotificationsASPN($user->ID);
$res2 = sendPushNotificarionsAndroid($user->ID);
var_dump($res1);
var_dump($res2);