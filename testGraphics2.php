<?php
//echo "ola";
//require __DIR__ . '/../../config.php';
//require __DIR__ . '/../../autoload.php';
//require __DIR__ . '/../../bootstrap.php';

use classes\graphic\GraphicAnyChart;

//Create the class
$gr = new GraphicAnyChart();
$gr1 = new GraphicAnyChart();

//see https://www.anychart.com/ for mor options
$opt="
  // set a chart title
  chart.title('User in action')
  // set an array of angles at which the words will be laid out
  chart.angles([0])
  // enable a color range
  chart.colorRange(false);
  // set the color range length
  chart.colorRange().length('80%');
";
$gr->setOptions($opt);

$opt="
  // set a chart title
  chart.title('Activitie')
  // set an array of angles at which the words will be laid out
  chart.angles([0,90])
  // enable a color range
  chart.colorRange(true);
  // set the color range length
  chart.colorRange().length('80%');
";
$gr1->setOptions($opt);

$gr->getDataJson("https://esmonserrate.org/public//stats/criadores","name","num");
$gr1->getDataJson("https://esmonserrate.org/public//stats/artigos/meses/seccao","title","num","dataMes");

?>
<!DOCTYPE html>
<html>
 <head>
  <title>JavaScript Tag Cloud Chart</title>
  <?php echo $gr->includes()?>
  
 </head>
  <body>
   <div id="cloud"></div>
   <?php  $gr->tagCloudchart("cloud"); ?>  

   <div id="cloud2"></div>
   <?php  $gr1->tagCloudchart("cloud2"); ?>  
  </body>

  
</html>
