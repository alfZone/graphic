<?php 
namespace classes\graphic;

/**
 * @author alf
 * @copyright 2020
 * @version 1.2
 * @updated 2020/04/01 
 *
 */

/* The purpose of this class is to use google graphics in php, with data to be sent in array or json */
/*Requeriments:
    ---*/
/*Methods:
    __construct() - is the class constroctor
   + getDataJson($url,$key,$value) - providing a url to a json webservice, a value for the tag ($key) and a $value for the values, the data 
                                     will be available to be used in a chart
   + setOptions($options) - reads chart options in accordance with google charts. $option is a string with options like this
                            example "{ title: 'My activities', is3D: true,}"
   + includes() - is a mandatory inclusion for google graphics javascript
   + piechart($id) - draws a pie chart with the given data and as per the given options. $id is the HTML id
   + piechart($id) - draws a bar chart with the given data and as per the given options. $id is the HTML id
 */


//include_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";


class GraphicGoogle{
    
    public $gData;
    public $options;

    public function __construct(){  
    }

    public function getDataJson($url,$key,$valueList){
      //providing a url to a json webservice, a value for the tag ($key) and a $value for the values, the data will be available to be used in a chart

      $vl=explode(",", $valueList);
      // Takes raw data from the request
      $json = file_get_contents($url);
      // Converts it into a PHP object
      $gData = json_decode($json,true);
      $valueList=str_replace(",", "','", $valueList);
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
