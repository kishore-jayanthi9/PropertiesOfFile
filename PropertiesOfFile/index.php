<html>
<title>codeman</title>
<form action="submit.php" method="POST" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="file">
  
    <button type="submit" name="submit">Upload </button>
</form>

<?php
if ($entries = scandir('uploads/',SCANDIR_SORT_NONE)) 
    {
    foreach ($entries as $entry) {

        if ($entry != "." && $entry != "..") {
            
            

                if (filemtime('uploads/'.$entry) < (time()-1000)) 
                {
                    
                   unlink('uploads/'.$entry);
                   continue;
                }
                else
                    echo'<a href="uploads/'.$entry.'">'.$entry.'</a></t>';
            $str = 'Creation Date:'.date("F-d-Y-H-i-s.", filemtime("uploads/$entry")).'<br> Modified Date:'.date("F-d-Y-H-i-s.", fileatime("uploads/$entry")).'<br> Size:'.filesize('uploads/'.$entry).' Bytes';
            $imageFileType = strtolower(pathinfo($entry,PATHINFO_EXTENSION));
    
    
            if($imageFileType=="png" || $imageFileType == "jpg"){
                $fp = './uploads/'.$entry;
                $resource = $im = imagecreatefrompng($fp);
                $width = imagesx($resource);
                $height = imagesy($resource);
                $r_sum = 0.0;
                $g_sum = 0.0;
                $b_sum = 0.0;
                $count = 1;
                for($x = 0; $x < $width; $x++) {
                    for($y = 0; $y < $height; $y++) {
                        // pixel color at (x, y)
                        $rgb = imagecolorat($resource, $x, $y);    
                        $colors = imagecolorsforindex($resource, $rgb);
                        $b_sum += $colors['blue'];
                        $g_sum += $colors['green'];
                        $r_sum += $colors['red'];
                        $count += 1;
                    }
                }
                $r_avg = $r_sum / $count;
                $g_avg = $g_sum / $count;
                $b_avg = $b_sum / $count;
                $str = $str. '<br> Average Red color: '.$r_avg;
                $str = $str. '<br> Average Green color: '.$g_avg;
                $str = $str. '<br> Average Blue color: '.$b_avg;
                $str = $str. '<br> Image resolution: Width='.$width.' Height='.$height;
                
            }
            else {
                // Source : https://github.com/smalot/pdfparser/issues/117
                include "../vendor/autoload.php";
                
                
                $fp = './uploads/'.$entry;
                $parser = new \Smalot\PdfParser\Parser();

                $document = $parser->parseFile($fp);
                
               
                $pages    = $document->getPages();
                $content = '';
                foreach($pages as $page){
                    
                    $content .= $page->getText();
                    
                }
                $word_count = sizeof(explode(" ", $content));
                $line_count = sizeof(explode("\n", $content));
                //echo $word_count;
                $str = $str. '<br> Number of words in file: '. $word_count;
                
                $str = $str. '<br> Number of lines in file: '. $line_count;
            }

            
            echo '<button type="button" onclick="hint(\''.$entry.'\')">Properties</button>';
            echo  '<a href="delete.php?v='.$entry.'">Delete</a><br>';
            echo '<div id="prop-'.$entry.'" style="display: none;">'.$str.'</div>';
            
            
            
       
 
            
            
            }
        }

    //closedir($entry);
    }
    
    
     echo "<br>Deleted Files are<br>";
            
           if ($entries = scandir('deleted/',SCANDIR_SORT_NONE)) 
             {
             
             foreach ($entries as $entry) {

                if ($entry != "." && $entry != "..") 
                    {
                     echo $entry;
                     echo '<a href="restore.php?v='.$entry.'">Recover</a><br>';
                        }
                     }
               }
  
?>


<script  type="text/javascript">

//property division    
    function hint(id) {
    var x = document.getElementById('prop-'+id);
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}

//auto refreshing
setTimeout(function(){
   window.location.reload(1);
}, 500000);
        
</script>


</html>
