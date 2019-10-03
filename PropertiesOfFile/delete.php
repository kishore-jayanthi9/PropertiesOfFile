<?php
$dl_file= $_GET['v']; 
echo "<script> alert('domesj')</script>";
$source = './uploads/'.$dl_file.'';
$destination = './deleted/'.$dl_file.'';
copy($source,$destination);
unlink($source);
header("Location:./index.php");
?>
