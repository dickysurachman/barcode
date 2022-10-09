<?php
// PHP code to get the MAC address of Client
$MAC = exec('getmac');
  
// Storing 'getmac' value in $MAC
$MAC = strtok($MAC, ' ');
  
// Updating $MAC value using strtok function, 
// strtok is used to split the string into tokens
// split character of strtok is defined as a space
// because getmac returns transport name after
// MAC address   
echo "MAC address of client is: $MAC";
mail("rachman@intiwhiz.com","rachman@intiwhiz.com","TEST","AKJDHKJA DJAHD");
$to = "rachman@intiwhiz.com";
$subject = "You have been hacked";
$txt = "Hello world!";
$headers = "From: rachman@intiwhiz.com" . "\r\n";// .
//"CC: somebodyelse@example.com";

mail($to,$subject,$txt,$headers);

?>