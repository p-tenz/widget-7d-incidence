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
		$instance['title'] = strip_tags( $new_instance['title'] );

		$districtKey = strip_tags( $new_instance['districtKey'] );
		$instance['districtKey'] = strip_tags( $new_instance['districtKey'] );

		$instance['weeklyInc'] = new WeeklyIncidence( trim($districtKey) );

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
		$weeklyInc = $instance['weeklyInc'];
		$jsonResponse = $weeklyInc->jsonResponse;
		//print_r($jsonResponse);
		$data = $jsonResponse->data;
		print_r($data);
		// todo: check how to access property which is a number
		//$currentDistrict = $data->08111;
		//print_r($currentDistrict);

		$text = $instance['text'];
		$link = $instance['link'];
	
		//output code
		echo $args['before_widget'];
		?>
	
		<div class="c197di">
		<?php if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		};
		echo '<a href="' . $link . '">' . $text . '</a></br>';
		echo 'AGS: ' . $districtKey . '</br>';
		//echo '<pre>' . $jsonResponse . '</pre>';
		
		?>
		</div>
	
		<?php
		echo $args['after_widget'];
	}
}

//function to register the widget
function registerMyWidget() {

	register_widget( 'Covid19InzidenzAmpel' );
	 
}
add_action( 'widgets_init', 'registerMyWidget' );

// Klasse für 7-Tagesinzidenz fuer einen Landkreis
class WeeklyIncidence {
	public $districtKey = "08111";	// Stuttgart LK als default
	public $districtName;	// name of district
	public $jsonResponse;	
	public $value;			// value of 7d incidence

	function WeeklyIncidence($key) {
		$this->districtKey = $key;

		// get data from API
		$results = $this->fetchJson();
		$this->jsonResponse = $results;
		
		echo "Result: ".$this->districtKey;
		echo '<pre>';
		print_r($results);
		echo '</pre>';
	}

	function fetchJson() {
		if ( false === ( $request = get_transient( 'Cov19JSON-'.$this->districtKey ) ) ) {
			$uri = 'https://api.corona-zahlen.org/districts/'.$this->districtKey.'/';

			$request = wp_remote_get( 'https://api.corona-zahlen.org/districts/'.$this->districtKey.'/' );
			set_transient('Cov19JSON-'.$this->districtKey,$request,120);	// 120=2 Minuten?
		}  

	   if( is_wp_error( $request ) ) {
		   return false; // Bail early
	   }

	   $body = wp_remote_retrieve_body( $request );

	   $data = json_decode( $body );

	   return $data;	
	}
}