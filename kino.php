<?php
$connect = mysqli_connect('localhost','root','', 'Kino');

if($connect){
    echo "";
}
else{
    die("Kino connection failed\n");
}
?>