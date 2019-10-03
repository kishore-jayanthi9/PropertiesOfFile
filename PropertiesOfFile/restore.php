<?php
  $resource_name=$_GET['v'];
  rename('./deleted/'.$resource_name,'./uploads/'.$resource_name);  
  unlink('./deleted/'.$resource_name );    
  header('Location:./index.php');
?>
