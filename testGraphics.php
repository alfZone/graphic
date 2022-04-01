<?php
//echo "ola";
//require __DIR__ . '/../config.php';
//require __DIR__ . '/../autoload.php';
//require __DIR__ . '/../bootstrap.php';

use classes\graphic\GraphicGoogle;


$gr = new GraphicGoogle();

$opt="{
  title: 'As minhas atividades',
  is3D: true,
}";


$gr->getDataJson("https://galeria.esmonserrate.org/public//stats/criadores","nome","num");
$gr->setOptions($opt);

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
