<?php
 require_once 'vendor/autoload.php';

 $client = new Redmine\Client('http://dev.imeet.biz', '9b36518d7464c96182f17f43bd9d3d3960f8ef9a');
 $client->api('user')->create(array(
    'login'     => 'test',
    'firstname' => 'test',
    'lastname'  => 'rest',
    'mail'      => 'test@rest.com',
   'password'   => 'secret'
));
?>

