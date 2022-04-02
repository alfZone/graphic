<?php
//echo "ola";
//require __DIR__ . '/../config.php';
//require __DIR__ . '/../autoload.php';
//require __DIR__ . '/../bootstrap.php';

use classes\graphic\GraphicGoogle;

//Create the class
$gr = new GraphicGoogle();
$grb = new GraphicGoogle();

//send the options for the graphic - see google graphics for more details
$opt="{
  title: 'As minhas atividades',
  is3D: true,
}";
$gr->setOptions($opt);

$opt="{
          chart: {
            title: 'Company Performance',
            subtitle: 'Sales, Expenses, and Profit: 2014-2017',
          },
          bars: 'horizontal' // Required for Material Bar Charts.
        };";
$grb->setOptions($opt);

//send the data using json web service
$gr->getDataJson("https://esmonserrate.org/public//stats/criadores","name","num");
$grb->getDataJson("https://esmonserrate.org/public//stats/criadores/2ultimos","name","Ultimo Ano,Ano Atual");
//$gr->setData($dataForGrp);

//HTML with 2 call for tha classe
?>
<html>
  <head>
    <?php echo $gr->includes(); ?>   
  </head>
  <body>
    <?php echo $gr->piechart('piechart'); ?> 
    <div id="piechart" style="width: 900px; height: 500px;"></div>
    <?php echo $grb->barchart('barchart'); ?> 
     <div id="barchart" style="width: 900px; height: 500px;"></div>
  </body>
</html>
