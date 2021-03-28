<?php
/**
 * @package IncidenceWidgetPlugin
 */
/*
Plugin Name: Covid-19 Seven Days Incidence Widget
Plugin URI: http://www.tenzlinger.de/covid19-7d-incidence-widget/
Description: Plugin with widget to show current 7 days incidence of covid-19 cases in your area
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
		$link = ! empty( $instance['link'] ) ? $instance['link'] : 'Your link here';
		$text = ! empty( $instance['text'] ) ? $instance['text'] : 'Your text here';
	   ?>
	   
	   <p>
		<label for="<?php echo $this->get_field_id( 'title'); ?>">Titel:</label>
		<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" /></p>

		<p>
		<label for="<?php echo $this->get_field_id( 'districtKey'); ?>">Allgemeiner Gemeindeschlüssel:</label>
		<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'districtKey' ); ?>" name="<?php echo $this->get_field_name( 'districtKey' ); ?>" value="<?php echo esc_attr( $districtKey ); ?>" /></p>

		
	   <p>
		<label for="<?php echo $this->get_field_id( 'text'); ?>">Text in the call to action box:</label>
		<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>" value="<?php echo esc_attr( $text ); ?>" /></p>
	   
	   <p>
		<label for="<?php echo $this->get_field_id( 'link'); ?>">Your link:</label>
		<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" value="<?php echo esc_attr( $link ); ?>" /></p>
	   
	   <?php
	}

	// function to define the data saved by the widget
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		// TODO: nur Titel und AGS (=districtKey) in Widget Einstellungen
		$instance['title'] = strip_tags( $new_instance['title'] );

		$districtKey = strip_tags( $new_instance['districtKey'] );
		$instance['districtKey'] = strip_tags( $new_instance['districtKey'] );

		$instance['text'] = strip_tags( $new_instance['text'] );
		$instance['link'] = strip_tags( $new_instance['link'] );
		
		return $instance;            
   }

	//function to display the widget in the site
	function widget( $args, $instance ) {
		//print_r($instance['weeklyInc']);
		//define variables
		$title = apply_filters( 'widget_title', $instance['title'] );
		$districtKey = $instance['districtKey'];

		$weeklyInc = new WeeklyIncidence( trim($districtKey) );

		//$weeklyInc = $instance['weeklyInc'];
		$jsonResponse = $weeklyInc->jsonResponse;
		//var_dump($jsonResponse);
		$districtName = $weeklyInc->districtName;
		$value = $weeklyInc->value;

		//print_r($districtName . $value);

		//print_r($jsonResponse);
		//$data = $jsonResponse->data;
		//print_r($data);
		// todo: check how to access property which is a number
		//$currentDistrict = $data->$districtKey;
		//print_r($currentDistrict);

		$text = $instance['text'];
		$link = $instance['link'];
	

		// $p1g=50;
		// $p2g=20;

		// $red = "A30303";
		// $yellow = "F4EC00";
		// $green = "03A350";

		// $p1arr = $this->Gradient3($green,$yellow,$red,$p1g+1);
		// $p2arr = $this->Gradient3($green,$yellow,$red,$p2g+1);

		$ampelvalue1 = $weeklyInc->value;
		$ampelvalue2 = $weeklyInc->value - 12.8;

		$bordercol = "000";

		$ampelcol1 = 51;
		$ampelcol2 = 21;

		//output code
		echo $args['before_widget'];
		?>
	
		<div class="c197di">
		<?php if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		};
		//echo '<a href="' . $link . '">' . $text . '</a></br>';
		//echo 'AGS: ' . $districtKey . '</br>';
		echo 'Landkreis ' . $weeklyInc->districtName . '</br>';
		echo '7-Tage Inz.: ' . number_format($weeklyInc->value, 1) . '</br>';
		echo 'Stand: ' . $weeklyInc->lastUpdate . '</br>';
		//echo '<pre>' . $jsonResponse . '</pre>';
		echo '<a href="' . $weeklyInc->metaInfo . '" target="_blank">Thank you Marlon</a>';
		?>
		</div>

		
		<div class="hexagon hexagon-with-border <?= $weeklyInc->css ?>">
			<div class="hexagon-shape">
				<div class="hexagon-shape-inner">
					<div class="hexagon-shape-inner-2"></div>
				</div>
			</div>
			<div class="hexagon-shape content-panel">
				<div class="hexagon-shape-inner">
					<div class="hexagon-shape-inner-2"></div>
				</div>
			</div>
			<div class="hexagon-content">
				<div class="content-title"><?= number_format($weeklyInc->value, 1) ?></div>
				<div class="content-sub">7-day inc.</div>
			</div>
		</div>

		<div class="hexagon hexagon-with-border info">
			<div class="hexagon-shape">
				<div class="hexagon-shape-inner">
					<div class="hexagon-shape-inner-2"></div>
				</div>
			</div>
			<div class="hexagon-shape content-panel">
				<div class="hexagon-shape-inner">
					<div class="hexagon-shape-inner-2"></div>
				</div>
			</div>
			<div class="hexagon-content">
				<div class="content-title"><?= $weeklyInc->newCases ?></div>
				<div class="content-sub">new cases</div>
			</div>
		</div>
		<p>
		Stand: <?= $weeklyInc->lastUpdate ?></br>
		<a href="<?= $weeklyInc->metaInfo ?>" target="_blank">Thank you Marlon</a>
		</p>


		<!-- <div class="c197di" style="margin: auto">
   		<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="173" height="153" viewbox="-5 -5 170 148.56406460551017 ">

   			<path fill="#000" d="M-5 69.28203230275508L38 -5L122 -5L165 69.28203230275508L122 143.56406460551017L38 143.56406460551017Z"></path>

   			<path fill="#2aae42" d="M0 69.28203230275508L40 0L120 0L160 69.28203230275508L120 138.56406460551017L40 138.56406460551017Z"></path>
   			<path fill="#4fba36" d="M0 69.28203230275508L160 69.28203230275508L120 138.56406460551017L40 138.56406460551017Z"></path>

   			<line x1="0" y1="69" x2="160" y2="69" style="stroke:#000;stroke-width:3" />

   			<text x="80" y="15" fill="black" text-anchor="middle" style="font-size:12px;" fill-opacity="0.5">Today</text>
              <text x="80" y="132" fill="black" text-anchor="middle" style="font-size:12px;" fill-opacity="0.5">Yesterday</text>

               <text x="80" y="55" fill="black" text-anchor="middle" style="font-size:28px;font-weight:bold;">
                   <?= round($ampelvalue1,1) ?>
              </text>
              <text x="80" y="105" fill="black" text-anchor="middle" style="font-size:28px;font-weight:bold;">
              <?= round($ampelvalue2,1) ?>
              </text>
   		</svg>
		</div> -->

	
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
	public $value = 0.0;			// value of 7d incidence
	public $newCases = 0;
	public $css = "info";
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

		// 7-days incidence
		$value = (float)($results->data->$key->weekIncidence);		
		$this->value = round($value, 1);

		// css
		if ($value >= 50.0) {
			$this->css = "warning";
		}
		if ($value >= 100.0) {
			$this->css = "danger";
		}

		// new cases
		$this->newCases = $results->data->$key->delta->cases;

		// meta info
		$a = $results->meta->lastUpdate;
		$b = strtotime($a);
		$lastUpdateDateTime = date("d/m/Y H:i A", $b);
		$this->lastUpdate = $lastUpdateDateTime;

		$this->metaInfo = $results->meta->info;

		// echo "7-Tage Inzidenz: ". $this->districtName . " (" . $this->lastUpdate . ")";
		echo '<pre>';
		// print_r($this->value);
		echo $a . "</br>" . $b . "</br>" . $lastUpdateDateTime . "</br>" . number_format($this->value, 1);
		echo '</pre>';
	}

	function fetchJson() {
		// todo: use transient if productive; think about timespan
		//if ( false === ( $request = get_transient( 'Cov19JSON-'.$this->districtKey ) ) ) {
			$uri = 'https://api.corona-zahlen.org/districts/'.$this->districtKey.'/';

			$request = wp_remote_get( 'https://api.corona-zahlen.org/districts/'.$this->districtKey.'/' );
			//set_transient('Cov19JSON-'.$this->districtKey,$request,120);	// 120=2 Minuten?
		//}  

	   if( is_wp_error( $request ) ) {
		   return false; // Bail early
	   }

	   $body = wp_remote_retrieve_body( $request );

	   // try returning as arrays
	   //$json = json_decode( $body, true );
	   $json = json_decode( $body );

	   return $json;	
	}

	function Gradient3($from, $to1, $to2, $steps) {
		$arr1 = $this->Gradient($from,$to1,$steps/2);
		$arr2 = $this->Gradient($to1,$to2,$steps/2);
		return array_merge($arr1,$arr2);
	}

	function Gradient($HexFrom, $HexTo, $ColorSteps) {
	  $FromRGB['r'] = hexdec(substr($HexFrom, 0, 2));
	  $FromRGB['g'] = hexdec(substr($HexFrom, 2, 2));
	  $FromRGB['b'] = hexdec(substr($HexFrom, 4, 2));

	  $ToRGB['r'] = hexdec(substr($HexTo, 0, 2));
	  $ToRGB['g'] = hexdec(substr($HexTo, 2, 2));
	  $ToRGB['b'] = hexdec(substr($HexTo, 4, 2));

	  $StepRGB['r'] = ($FromRGB['r'] - $ToRGB['r']) / ($ColorSteps - 1);
	  $StepRGB['g'] = ($FromRGB['g'] - $ToRGB['g']) / ($ColorSteps - 1);
	  $StepRGB['b'] = ($FromRGB['b'] - $ToRGB['b']) / ($ColorSteps - 1);

	  for($i = 0; $i <= $ColorSteps; $i++) {
	    $RGB['r'] = floor($FromRGB['r'] - ($StepRGB['r'] * $i));
	    $RGB['g'] = floor($FromRGB['g'] - ($StepRGB['g'] * $i));
	    $RGB['b'] = floor($FromRGB['b'] - ($StepRGB['b'] * $i));

	    if($RGB['r']<0) $RGB['r']=0;
	    if($RGB['g']<0) $RGB['g']=0;
	    if($RGB['b']<0) $RGB['b']=0;

	    if($RGB['r']>255) $RGB['r']=255;
	    if($RGB['g']>255) $RGB['g']=255;
	    if($RGB['b']>255) $RGB['b']=255;

	    $HexRGB['r'] = sprintf('%02x', ($RGB['r']));
	    $HexRGB['g'] = sprintf('%02x', ($RGB['g']));
	    $HexRGB['b'] = sprintf('%02x', ($RGB['b']));

	    $GradientColors[] = implode(NULL, $HexRGB);
	  }
	  return $GradientColors;
	}

}