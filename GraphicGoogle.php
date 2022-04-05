<?php 
namespace classes\graphic;

/**
 * @author alf
 * @copyright 2020
 * @version 2.4
 * @updated 2020/04/05 
 *
 */

/* The purpose of this class is to use google graphics in php, with data to be sent in array or json */
/*Requeriments:
    ---*/
/*Methods:
    __construct() - is the class constroctor
   + getDataJson($url,$key,$valueLista) - providing a url for a json webservice, a value for the tag ($key) and a $valueList for the list of values, the data will 
                                          be available to be used in a graph. The $col option is used to create a pivot table in which the values of the $col field 
                                          will be displayed in the columns
   + setOptions($options) - reads chart options in accordance with google charts. $option is a string with options like this
                            example "{ title: 'My activities', is3D: true,}"
   + includes() - is a mandatory inclusion for google graphics javascript
   + barchart($id) - draws a bar chart with the given data and as per the given options. $id is the HTML id
   + candlestickChar($id) - draws a candlestick chart with the given data and according to the given options. $id is the HTML code
   + comboChart($id) - Draws a combo tchart with the given data and according to the given options. $id is the HTML code
   + corechart($id) - draws a area chart with the given data and according to the given options. $id is the HTML code
   + gauge($id) - draws a graph with pressure gauges with the given data and according to the given options. $id is the HTML code
   + piechart($id) - draws a pie chart with the given data and as per the given options. $id is the HTML id
   
  
 */
/*
*Github
* https://github.com/alfZone/graphics
*/


// https://developers.google.com/chart/interactive/docs/gallery

//include_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";




class GraphicGoogle{
    
    public $gData;
    public $options;

    public function __construct(){  
    }

    public function getDataJson($url,$key,$valueList, $col=""){
      //providing a url to a json webservice, a value for the tag ($key) and a $value for the values, the data will be available to be used in a chart

      // Takes raw data from the request
      $json = file_get_contents($url);
      // Converts it into a PHP object
      $gData = json_decode($json,true);
      if ($col!=""){
        $ls="";
        $sep="";
        foreach($gData as $element){
          $list[$element[$col]]=$element[$col];
        }
        foreach($list as $k){
            //echo "$k";
            $ls.=$sep.$k;
            $sep=",";
          }
        
        //print_r($list);
        //echo "<br>-------------------<br>";
        foreach($gData as $element){
          foreach($list as $l){
            $aux[$element[$key]][$l]=0;
          }         
        }
        foreach($gData as $element){
          $aux[$element[$key]][$key]=$element[$key];
          $aux[$element[$key]][$element[$col]]=$aux[$element[$key]][$element[$col]]+$element[$valueList];
        }
        //print_r($aux);
        $gData=$aux;
        $valueList=$ls;
        $vl=$list;
      } else{
        $vl=explode(",", $valueList);
      }
      
      //echo "<br>vl=";
      //print_r($vl);
      $valueList=str_replace(",", "','", $valueList);
      //echo "<br>lista :$valueList<br><br>";
      //print_r($gData);
      $this->gData="[['" . $key . "','" . $valueList . "'],";
      foreach($gData as $element){
        $values="";
        $sep="";
        foreach($vl as $serie){
          $values.=$sep. $element[$serie];
          $sep=",";
        }  
        
        $this->gData.="['" . $element[$key] . "'," . $values . "]";
      }
      $this->gData=str_replace("][", "],[", $this->gData);
      $this->gData.="]";
      //echo $this->gData;
    }


    public function setOptions($options){
      //reads chart options in accordance with google charts. $option is a string with options like this example "{ title: 'My activities', is3D: true,}"
      $this->options=$options;

    }


    public function includes(){
      //is a mandatory inclusion for google graphics javascript
      return ' <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>';
    }
 
  public function geochart($id){
      //draws a pie chart with the given data and as per the given options
      ?>
        <script type="text/javascript">
          google.charts.load('current', {'packages':['geochart']});
          google.charts.setOnLoadCallback(drawRegionsMap);

          function drawRegionsMap() {

            var data = google.visualization.arrayToDataTable(<?=$this->gData?>);

            var options = <?=$this->options?>;
            
            var chart = new google.visualization.GeoChart(document.getElementById('<?=$id?>'));

            chart.draw(data, options);
          }
        </script>
      <?php
    }
  
  
  public function gauge($id){
      //draws a graph with pressure gauges with the given data and according to the given options. $id is the HTML code
      ?>
        <script type="text/javascript">
          google.charts.load('current', {'packages':['gauge']});
          google.charts.setOnLoadCallback(drawChart);

          function drawChart() {

            var data = google.visualization.arrayToDataTable(<?=$this->gData?>);

            var options = <?=$this->options?>;
            
            var chart = new google.visualization.Gauge(document.getElementById('<?=$id?>'));

            chart.draw(data, options);
            
            setInterval(function() {
              data.setValue(0, 1, 40 + Math.round(60 * Math.random()));
              chart.draw(data, options);
            }, 13000);
            setInterval(function() {
              data.setValue(1, 1, 40 + Math.round(60 * Math.random()));
              chart.draw(data, options);
            }, 5000);
            setInterval(function() {
              data.setValue(2, 1, 60 + Math.round(20 * Math.random()));
              chart.draw(data, options);
            }, 26000);
          }
        </script>
      <?php
    }
  
  public function comboChart($id){
      //Draws a combo tchart with the given data and according to the given options. $id is the HTML code
      ?>
        <script type="text/javascript">
          google.charts.load('current', {'packages':['corechart']});
          google.charts.setOnLoadCallback(drawVisualization);

          function drawVisualization() {

            var data = google.visualization.arrayToDataTable(<?=$this->gData?>);

            var options = <?=$this->options?>;
            
            var chart = new google.visualization.ComboChart(document.getElementById('<?=$id?>'));

            chart.draw(data, options);
          }
        </script>
      <?php
    }
  
  public function candlestickChar($id){
      //draws a pie chart with the given data and as per the given options
      ?>
        <script type="text/javascript">
          google.charts.load('current', {'packages':['corechart']});
          google.charts.setOnLoadCallback(drawChart);

          function drawChart() {

            var data = google.visualization.arrayToDataTable(<?=$this->gData?>);

            var options = <?=$this->options?>;
            
            var chart = new google.visualization.CandlestickChart(document.getElementById('<?=$id?>'));

            chart.draw(data, options);
          }
        </script>
      <?php
    }
  
   public function corechart($id){
      //draws a area chart with the given data and according to the given options. $id is the HTML code
      ?>
        <script type="text/javascript">
          google.charts.load('current', {'packages':['corechart']});
          google.charts.setOnLoadCallback(drawChart);

          function drawChart() {

            var data = google.visualization.arrayToDataTable(<?=$this->gData?>);

            var options = <?=$this->options?>;
            
            var chart = new google.visualization.AreaChart(document.getElementById('<?=$id?>'));

            chart.draw(data, options);
          }
        </script>
      <?php
    }
  
  public function barchart($id){
      //draws a pie chart with the given data and as per the given options
      ?>
        <script type="text/javascript">
          google.charts.load('current', {'packages':['bar']});
          google.charts.setOnLoadCallback(drawChart);

          function drawChart() {

            var data = google.visualization.arrayToDataTable(<?=$this->gData?>);

            var options = <?=$this->options?>;
            
            var chart = new google.charts.Bar(document.getElementById('<?=$id?>'));

            chart.draw(data, google.charts.Bar.convertOptions(options));
          }
        </script>
      <?php
    }
  
  
    public function piechart($id){
      //draws a pie chart with the given data and as per the given options
      ?>
        <script type="text/javascript">
          google.charts.load('current', {'packages':['corechart']});
          google.charts.setOnLoadCallback(drawChart);

          function drawChart() {

            var data = google.visualization.arrayToDataTable(<?=$this->gData?>);

            var options = <?=$this->options?>;

            var chart = new google.visualization.PieChart(document.getElementById('<?=$id?>'));

            chart.draw(data, options);
          }
        </script>
      <?php
    }
}

?>
