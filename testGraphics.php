<?php
//echo "ola";
//require __DIR__ . '/../config.php';
//require __DIR__ . '/../autoload.php';
//require __DIR__ . '/../bootstrap.php';

use classes\graphic\GraphicGoogle;

//Create the class
$gr = new GraphicGoogle();

//send the options for the graphic - see google graphics for more details
$opt="{
  title: 'As minhas atividades',
  is3D: true,
}";
$gr->setOptions($opt);

//send the data using json web service
$gr->getDataJson("https://galeria.esmonserrate.org/public//stats/criadores","nome","num");
//$gr->setData($dataForGrp);

//HTML with 2 call for tha classe
?>
<html>
  <head>
    <?php echo $gr->includes(); ?>   
  </head>
  <body>
    <?php echo $gr->piechart(); ?> 
    <div id="piechart" style="width: 900px; height: 500px;"></div>
  </body>
</html>
