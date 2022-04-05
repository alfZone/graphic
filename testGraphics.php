<?php
//echo "ola";
//require __DIR__ . '/../../config.php';
//require __DIR__ . '/../../autoload.php';
//require __DIR__ . '/../../bootstrap.php';

use classes\graphic\GraphicGoogle;

//Create the class
$gr = new GraphicGoogle();
$grb = new GraphicGoogle();
$gra = new GraphicGoogle();
$grc = new GraphicGoogle();
$grcb = new GraphicGoogle();
$grg = new GraphicGoogle();
$grp = new GraphicGoogle();

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

$opt="{
          title: 'Company Performance',
          hAxis: {title: 'Year',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };";
$gra->setOptions($opt);
$opt="{
      legend:'none'
    }";
$grc->setOptions($opt);

$opt="{
          title : 'Monthly Coffee Production by Country',
          vAxis: {title: 'Cups'},
          hAxis: {title: 'Month'},
          seriesType: 'bars',
          series: {3: {type: 'line'}}
        }";
$grcb->setOptions($opt);

$opt="{
          width: 400, height: 120,
          redFrom: 90, redTo: 100,
          yellowFrom:75, yellowTo: 90,
          minorTicks: 5
        }";
$grg->setOptions($opt);

$opt="{}";
$grp->setOptions($opt);


//send the data using json web service
$gr->getDataJson("https://esmonserrate.org/public//stats/criadores","name","num");
$grb->getDataJson("https://esmonserrate.org/public//stats/criadores/2ultimos","name","Dois Anos antes,Ultimo Ano,Ano Atual");
$gra->getDataJson("https://esmonserrate.org/public//stats/artigos/meses/seccao","dataMes","num","title");
//$gra->getDataJson("https://esmonserrate.org/public/stats/artigos/meses","dataMes","num");
$grc->getDataJson("https://esmonserrate.org/public//stats/criadores/2ultimos","name","Três Anos antes,Dois Anos antes,Ultimo Ano,Ano Atual");
$grcb->getDataJson("https://esmonserrate.org/public//stats/criadores/2ultimos","name","Três Anos antes,Dois Anos antes,Ultimo Ano,Ano Atual");
$grg->getDataJson("https://esmonserrate.org/public//stats/artigos/local","pp","num");
$grp->getDataJson("https://esmonserrate.org/public//stats/mapa","Country","Popularity");
//$gr->setData($dataForGrp);

//HTML with 2 call for tha classe
?>
<html>
  <head>
    <?php echo $gr->includes(); ?>   
  </head>
  <body>
    <?php echo $grp->geochart('GeoChart'); ?> 
    <div id="GeoChart" style="width: 900px; height: 500px;"></div>
    <?php echo $grg->gauge('gauge'); ?> 
    <div id="gauge" style="width: 100%; height: 130px"></div>
    <?php echo $grcb->comboChart('ComboChart'); ?> 
    <div id="ComboChart" style="width: 900px; height: 500px;"></div>
    <?php echo $grc->candlestickChar('candlestickChar'); ?> 
    <div id="candlestickChar" style="width: 900px; height: 500px;"></div>
    <?php echo $gra->corechart('areachart'); ?> 
    <div id="areachart" style="width: 900px; height: 500px;"></div>
    <?php echo $gr->piechart('piechart'); ?> 
    <div id="piechart" style="width: 900px; height: 500px;"></div>
    <?php echo $grb->barchart('barchart'); ?> 
     <div id="barchart" style="width: 900px; height: 500px;"></div>
  </body>
</html>
