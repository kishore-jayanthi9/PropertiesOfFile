<?php

if(isset($_POST['submit'])){
    $file = $_FILES['file'];
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileError = $_FILES['file']['error'];  
    $imageFileType = strtolower(pathinfo($fileName,PATHINFO_EXTENSION));
    } 
    
if($imageFileType=="png" || $imageFileType == "jpg" || $imageFileType=="pdf" && filesize('uploads/'.$fileName)<(1024*1024*2) )
    {
    
    if($fileError==0)
        {
        $fileDestination = 'uploads/'.basename($fileName);
            if (file_exists($fileDestination))
                {
                     echo "<script>alert('File already exists')</script>";
                }
                
        if(move_uploaded_file($fileTmpName, $fileDestination))
            {
            echo "<script>alert('File uploaded sucessfully')</script>";
            }
        else
            echo "<script>alert('There is a problem in uploading')</script>";
        }
    }
else
    echo "<script>alert('File Format is not supported')</script>";
    header('Location:./index.php');
?>

