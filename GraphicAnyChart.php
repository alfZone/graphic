<?php 
namespace classes\graphic;

/**
 * @author alf
 * @copyright 2020
 * @version 1.0
 * @updated 2020/04/01 
 *
 */

/* The purpose of this class is to use AnyChart graphics in php, with data to be sent in array or json */
/* see https://www.anychart.com/ for mor options */
/*Requeriments:
    ---*/
/*Methods:
    __construct() - is the class constroctor
   + getDataJson($url,$key,$value) - providing a url to a json webservice, a value for the tag ($key) and a $value for the values, the data 
                                     will be available to be used in a chart
   + setOptions($options) - reads chart options in accordance with google charts. $option is a string with options like this
                            example "{ title: 'My activities', is3D: true,}"
   + includes() - is a mandatory inclusion for google graphics javascript
   + tagCloudchart() - draws a text cloud chart with the given data and as per the given options
 */


//include_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";


class GraphicAnyChart{
    
    public $gData;
    public $options;

    public function __construct(){  
    }

    public function getDataJson($url,$key,$value,$category=""){
      //providing a url to a json webservice, a value for the tag ($key) and a $value for the values, the data will be available to be used in a chart

      // Takes raw data from the request
      $json = file_get_contents($url);
      // Converts it into a PHP object
      $gData = json_decode($json,true);
      
      //print_r($gData);
      $this->gData="[";
      foreach($gData as $element){
        if ($category==""){
          $this->gData.='{"x":"' . $element[$key] . '", "value":' . $element[$value] . "}";
        }else{
          $this->gData.='{"x":"' . $element[$key] . '", "value":' . $element[$value] . ', "category": "' . $element[$category] . '"}';
        }
        
      }
      $this->gData=str_replace("}{", "},{", $this->gData);
      $this->gData.="]";
      //echo $this->gData;
    }


    public function setOptions($options){
      //reads chart options in accordance with google charts. $option is a string with options like this example "{ title: 'My activities', is3D: true,}"
      //print_r($option);
      //foreach($option as $key -> $value){

      //}
      $this->options=$options;

    }


    public function includes(){
      //is a mandatory inclusion for google graphics javascript
      return ' <script src="https://cdn.anychart.com/releases/v8/js/anychart-base.min.js"></script>
      <script src="https://cdn.anychart.com/releases/v8/js/anychart-tag-cloud.min.js"></script>';
    }
 
    public function tagCloudchart($container){
      //draws a word cloud chart with the given data and as per the given options
      ?>
        <style>
          html, body, #<?=$container?> {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            }
      </style>
        <script>

        <!-- chart code will be here -->
        anychart.onDocumentReady(function() {
          var data = <?=$this->gData;?>

        // create a tag (word) cloud chart
          var chart = anychart.tagCloud(data);

          <?=$this->options;?>

          // display the word cloud chart
          chart.container("<?=$container?>");
          chart.draw();
        });
    </script>
      <?php
    }
}

?>
