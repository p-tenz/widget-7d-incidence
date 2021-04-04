<?php
/**
 * @package IncidenceWidgetPlugin
 */
/*
Plugin Name: Current Covid-19 Weekly Incidences Widget
Plugin URI: http://www.tenzlinger.de/covid19-7d-incidence-widget/
Description: Plugin with widget to show last 3 day's weekly incidences of covid-19 cases in your area
Version: 0.0.1
Author: p-tenz
Author URI: http://www.tenzlinger.de/
License: GPL2
*/

// security check if functions are called from Wordpress
defined( 'ABSPATH') or die('You are not allowed to be here');

/*********************************************************************************
Enqueue stylesheet
*********************************************************************************/
function enqueueMyStyles() {
	
	wp_register_style( 'widget_c197di_css', plugins_url( 'css/style.css', __FILE__ ) );
    wp_enqueue_style( 'widget_c197di_css' );
 
}
add_action( 'wp_enqueue_scripts', 'enqueueMyStyles' );


class Covid19InzidenzAmpel extends WP_Widget {

	// constructor
	function Covid19InzidenzAmpel() {
		parent::WP_Widget(false, $name = __('Covid-19 Inzidenz Ampel', 'Covid19InzidenzAmpel') );
	}

	// $widget_options = array (
	// 	'classname' => 'Covid19InzidenzAmpel',
	// 	'description' => 'Show the current 7 days incidence of covid-19 cases in a german area (Landkreis)'
	//    );
	// parent::__construct( 'Covid19InzidenzAmpel', 'Covid-19 7-Days Incidence', $widget_options );
	
	// function to output the widget form: title and landkreis number
	function form( $instance ) {
		//print_r($instance); for easy debugging

		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$districtKey = ! empty( $instance['districtKey'] ) ? $instance['districtKey'] : '';
	   ?>
	   
	   <p>
		<label for="<?php echo $this->get_field_id( 'title'); ?>">Titel:</label>
		<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" /></p>

		<p>
		<label for="<?php echo $this->get_field_id( 'districtKey'); ?>">Allgemeiner Gemeindeschlüssel:</label>
		<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'districtKey' ); ?>" name="<?php echo $this->get_field_name( 'districtKey' ); ?>" value="<?php echo esc_attr( $districtKey ); ?>" /></p>
	   
	   <?php
	}

	// function to define the data saved by the widget
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );

		$districtKey = strip_tags( $new_instance['districtKey'] );
		$instance['districtKey'] = strip_tags( $new_instance['districtKey'] );
		
		return $instance;            
   }

	//function to display the widget in the site
	function widget( $args, $instance ) {
		//print_r($instance['weeklyInc']);
		//define variables
		$title = apply_filters( 'widget_title', $instance['title'] );
		$districtKey = $instance['districtKey'];

		$weeklyInc = new WeeklyIncidence( trim($districtKey) );

		$jsonResponse = $weeklyInc->jsonResponse;
		//var_dump($jsonResponse);
		$districtName = $weeklyInc->districtName;
		$values = $weeklyInc->values;

		//print_r($jsonResponse);
		//$currentDistrict = $data->$districtKey;
		//print_r($currentDistrict);

		//output code
		echo $args['before_widget'];
		?>
	
		<div class="c197di">
		<?php if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		};
		//echo 'AGS: ' . $districtKey . '</br>';
		//echo 'Landkreis ' . $weeklyInc->districtName . '</br>';
		//echo 'Stand: ' . $weeklyInc->lastUpdate . '</br>';
		?>
		<p>
			Neueste drei 7-Tage-Inzindenzen im Landkreis <?= $weeklyInc->districtName ?></br>
			Thanks to Marlon for the <a href="<?= $weeklyInc->metaInfo ?>" target="_blank">API</a>
		</p>

		<ul id="grid" class="clear">
        <li>
            <div class="hexagon hidden"></div>
        </li>
        <li>
            <div class="hexagon <?= $weeklyInc->styles[2] ?>">
            <p>
                <span class="value"><?= number_format($weeklyInc->values[2], 1) ?></span><br>
                <span class="subtitle" title="heute"><?= $weeklyInc->dates[2] ?></span>
            </p>
            </div>
        </li>
        <li>
            <div class="hexagon hidden"></div>
        </li>
        <li>
            <div class="hexagon <?= $weeklyInc->styles[0] ?>">
                <p>
                <span class="value"><?= number_format($weeklyInc->values[1], 1) ?></span><br>
                <span class="subtitle"><?= $weeklyInc->dates[1] ?></span>
                </p>
            </div>
        </li>
        <li>
            <div class="hexagon <?= $weeklyInc->styles[0] ?>">
                <p>
                <span class="value"><?= number_format($weeklyInc->values[0], 1) ?></span><br>
                <span class="subtitle"><?= $weeklyInc->dates[0] ?></span>
                </p>
            </div>
        </li>
    </ul>
	</div>
	
		<?php
		echo $args['after_widget'];
	}
}

// function to register the widget
function registerMyWidget() {

	register_widget( 'Covid19InzidenzAmpel' );
	 
}
add_action( 'widgets_init', 'registerMyWidget' );

// Klasse für 7-Tagesinzidenz fuer einen Landkreis
class WeeklyIncidence {
	public $districtKey = "08111";	// Stuttgart LK als default
	public $districtName;	// name of district
	public $jsonResponse;	

	// incidence values for day-before-yesterday, yesterday, today
	public $values = array(0.0, 0.0, 0.0);
	// css classes for day-before-yesterday, yesterday, today
	public $styles = array("info", "info", "info");
	public $dates = array("-", "-", "-");

	public $lastUpdate;
	public $metaInfo;

	// Constructor with argument district key; gets the data from the api and puts the result into jsonResponse
	function WeeklyIncidence($key) {
		$this->districtKey = $key;

		// get data from API
		$results = $this->fetchJson();
		$this->jsonResponse = $results;

		// dictrict name
		$this->districtName = $results->data->$key->name;

		// last 3 day's 7-days incidences
		$objArray = $results->data->$key->history;
		// var_dump($objArray[0]);
		// var_dump($objArray[1]);
		// var_dump($objArray[2]);
		//$i = 0;
		//foreach ($objArray as $obj) {
		for ($i=0; $i<3; $i++) {
			// get incidence
			$obj = $objArray[$i];

			//date
			$dateStr = $obj->date;
			$dateParsed = strtotime($dateStr);
			$this->dates[$i] = date("d.m.y", $dateParsed);

			// incidence
			$val = $obj->weekIncidence;	
			$inc = (float)$val;
			$inc = round($inc, 1);
			$this->values[$i] = $inc;
			
			//style
			if ($inc >= 0.0) {
				$this->styles[$i] = "ok";
			}
			if ($inc >= 50.0) {
				$this->styles[$i] = "warning";
			}
			if ($inc >= 100.0) {
				$this->styles[$i] = "danger";
			}
			//$i++;
		} 

		// meta info
		$a = $results->meta->lastUpdate;
		$b = strtotime($a);
		$lastUpdateDateTime = date("d/m/Y H:i A", $b);
		$this->lastUpdate = $lastUpdateDateTime;

		$this->metaInfo = $results->meta->info;

		// echo "7-Tage Inzidenz: ". $this->districtName . " (" . $this->lastUpdate . ")";
		//echo '<pre>';
		// print_r($this->value);
		//echo $a . "</br>" . $b . "</br>" . $lastUpdateDateTime . "</br>" . number_format($this->value, 1);
		//echo '</pre>';
	}

	function fetchJson() {
		// todo: use transient if productive; think about timespan
		//if ( false === ( $request = get_transient( 'Cov19JSON-'.$this->districtKey ) ) ) {
			$uri = 'https://api.corona-zahlen.org/districts/'.$this->districtKey.'/history/incidence/3';
			$request = wp_remote_get( $uri );
			//set_transient('Cov19JSON-'.$this->districtKey,$request,120);	// 120=2 Minuten?
		//}  

	   if( is_wp_error( $request ) ) {
		   return false; // Bail early
	   }

	   $body = wp_remote_retrieve_body( $request );

	   $json = json_decode( $body );

	   return $json;	
	}
}