<?php

/**
 * @package IncidenceWidgetPlugin
 */
/*
Plugin Name: Current Covid-19 Weekly Incidences Widget
Plugin URI: https://github.com/p-tenz/widget-7d-incidence
Description: Plugin with widget to show last 3 day's weekly incidences of covid-19 cases in your area
Version: 0.0.1
Author: p-tenz
Author URI: https://github.com/p-tenz/
License: GPL2
*/

// security check if functions are called from Wordpress
defined('ABSPATH') or die('You are not allowed to be here');

/* Enqueue stylesheet */
function enqueueMyStyles()
{
	// 
	wp_register_style('widget_c197di_css', plugins_url('css/style.css', __FILE__));
	wp_enqueue_style('widget_c197di_css');
}
add_action('wp_enqueue_scripts', 'enqueueMyStyles');

/* the following class is not used */
/* class covid19_weekly_incidences_widget extends WP_Widget {
	public function __construct()
    {
		parent::__construct(
            'covid19_weekly_incidences_widget',
            'Covid19 Weekly Incidences Widget',
            array(
                'description' => 'Shows the last three Covid.-19 weekly incidences in your area (only Germany) as colored hexagons.'
            )
        );
	}

	public function form($instance)
    {
		$defaults = array(
            'title' => 'Stuttgart',
            'districtKey' => '08111'
        );
        $instance = wp_parse_args((array)$instance, $defaults);

        $title = $instance['title'];
        $districtKey = $instance['districtKey'];
        
        ?>

		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php echo 'Titel:'; ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>

		<?php
    }

    public function update($new_instance, $old_instance)
    {
    }

    public function widget($args, $instance)
    {
    }
} */

class Covid19InzidenzAmpel extends WP_Widget
{
	// constructor
	function Covid19InzidenzAmpel()
	{
		parent::WP_Widget(false, $name = __('Covid-19 Inzidenz Ampel', 'Covid19InzidenzAmpel'));
	}


	// function to output the widget form: title and landkreis number
	function form($instance)
	{
		//print_r($instance);

		// just two controls: title and district
		$title = !empty($instance['title']) ? $instance['title'] : 'Stuttgart';
		$districtKey = !empty($instance['districtKey']) ? $instance['districtKey'] : '08111';
?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Titel:</label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('districtKey'); ?>">Allgemeiner Gemeindeschlüssel:</label>
			<select class='widefat' id="<?php echo $this->get_field_id('districtKey'); ?>" name="<?php echo $this->get_field_name('districtKey'); ?>" type="text">
				<option value='05334' <?php echo ($districtKey == '05334') ? 'selected' : ''; ?>>Aachen (StadtRegion)</option>
				<option value='07131' <?php echo ($districtKey == '07131') ? 'selected' : ''; ?>>Ahrweiler (LK) </option>
				<option value='09771' <?php echo ($districtKey == '09771') ? 'selected' : ''; ?>>Aichach-Friedberg (LK) </option>
				<option value='08425' <?php echo ($districtKey == '08425') ? 'selected' : ''; ?>>Alb-Donau-Kreis (LK) </option>
				<option value='16077' <?php echo ($districtKey == '16077') ? 'selected' : ''; ?>>Altenburger Land (LK) </option>
				<option value='07132' <?php echo ($districtKey == '07132') ? 'selected' : ''; ?>>Altenkirchen (LK) </option>
				<option value='15081' <?php echo ($districtKey == '15081') ? 'selected' : ''; ?>>Altmarkkreis Salzwedel (LK) </option>
				<option value='09171' <?php echo ($districtKey == '09171') ? 'selected' : ''; ?>>Altötting (LK) </option>
				<option value='07331' <?php echo ($districtKey == '07331') ? 'selected' : ''; ?>>Alzey-Worms (LK) </option>
				<option value='09361' <?php echo ($districtKey == '09361') ? 'selected' : ''; ?>>Amberg (SK) </option>
				<option value='09371' <?php echo ($districtKey == '09371') ? 'selected' : ''; ?>>Amberg-Sulzbach (LK) </option>
				<option value='03451' <?php echo ($districtKey == '03451') ? 'selected' : ''; ?>>Ammerland (LK) </option>
				<option value='15082' <?php echo ($districtKey == '15082') ? 'selected' : ''; ?>>Anhalt-Bitterfeld (LK) </option>
				<option value='09571' <?php echo ($districtKey == '09571') ? 'selected' : ''; ?>>Ansbach (LK) </option>
				<option value='09561' <?php echo ($districtKey == '09561') ? 'selected' : ''; ?>>Ansbach (SK) </option>
				<option value='09671' <?php echo ($districtKey == '09671') ? 'selected' : ''; ?>>Aschaffenburg (LK) </option>
				<option value='09661' <?php echo ($districtKey == '09661') ? 'selected' : ''; ?>>Aschaffenburg (SK) </option>
				<option value='09772' <?php echo ($districtKey == '09772') ? 'selected' : ''; ?>>Augsburg (LK) </option>
				<option value='09761' <?php echo ($districtKey == '09761') ? 'selected' : ''; ?>>Augsburg (SK) </option>
				<option value='03452' <?php echo ($districtKey == '03452') ? 'selected' : ''; ?>>Aurich (LK) </option>
				<option value='07332' <?php echo ($districtKey == '07332') ? 'selected' : ''; ?>>Bad Dürkheim (LK) </option>
				<option value='09672' <?php echo ($districtKey == '09672') ? 'selected' : ''; ?>>Bad Kissingen (LK) </option>
				<option value='07133' <?php echo ($districtKey == '07133') ? 'selected' : ''; ?>>Bad Kreuznach (LK) </option>
				<option value='09173' <?php echo ($districtKey == '09173') ? 'selected' : ''; ?>>Bad Tölz-Wolfratshausen (LK) </option>
				<option value='08211' <?php echo ($districtKey == '08211') ? 'selected' : ''; ?>>Baden-Baden (SK) </option>
				<option value='09471' <?php echo ($districtKey == '09471') ? 'selected' : ''; ?>>Bamberg (LK) </option>
				<option value='09461' <?php echo ($districtKey == '09461') ? 'selected' : ''; ?>>Bamberg (SK) </option>
				<option value='12060' <?php echo ($districtKey == '12060') ? 'selected' : ''; ?>>Barnim (LK) </option>
				<option value='14625' <?php echo ($districtKey == '14625') ? 'selected' : ''; ?>>Bautzen (LK) </option>
				<option value='09472' <?php echo ($districtKey == '09472') ? 'selected' : ''; ?>>Bayreuth (LK) </option>
				<option value='09462' <?php echo ($districtKey == '09462') ? 'selected' : ''; ?>>Bayreuth (SK) </option>
				<option value='09172' <?php echo ($districtKey == '09172') ? 'selected' : ''; ?>>Berchtesgadener Land (LK) </option>
				<option value='06431' <?php echo ($districtKey == '06431') ? 'selected' : ''; ?>>Bergstraße (LK) </option>
				<option value='11004' <?php echo ($districtKey == '11004') ? 'selected' : ''; ?>>Berlin Charlottenburg-Wilmersdorf (SK) </option>
				<option value='11002' <?php echo ($districtKey == '11002') ? 'selected' : ''; ?>>Berlin Friedrichshain-Kreuzberg (SK) </option>
				<option value='11011' <?php echo ($districtKey == '11011') ? 'selected' : ''; ?>>Berlin Lichtenberg (SK) </option>
				<option value='11010' <?php echo ($districtKey == '11010') ? 'selected' : ''; ?>>Berlin Marzahn-Hellersdorf (SK) </option>
				<option value='11001' <?php echo ($districtKey == '11001') ? 'selected' : ''; ?>>Berlin Mitte (SK) </option>
				<option value='11008' <?php echo ($districtKey == '11008') ? 'selected' : ''; ?>>Berlin Neukölln (SK) </option>
				<option value='11003' <?php echo ($districtKey == '11003') ? 'selected' : ''; ?>>Berlin Pankow (SK) </option>
				<option value='11012' <?php echo ($districtKey == '11012') ? 'selected' : ''; ?>>Berlin Reinickendorf (SK) </option>
				<option value='11005' <?php echo ($districtKey == '11005') ? 'selected' : ''; ?>>Berlin Spandau (SK) </option>
				<option value='11006' <?php echo ($districtKey == '11006') ? 'selected' : ''; ?>>Berlin Steglitz-Zehlendorf (SK) </option>
				<option value='11007' <?php echo ($districtKey == '11007') ? 'selected' : ''; ?>>Berlin Tempelhof-Schöneberg (SK) </option>
				<option value='11009' <?php echo ($districtKey == '11009') ? 'selected' : ''; ?>>Berlin Treptow-Köpenick (SK) </option>
				<option value='07231' <?php echo ($districtKey == '07231') ? 'selected' : ''; ?>>Bernkastel-Wittlich (LK) </option>
				<option value='08426' <?php echo ($districtKey == '08426') ? 'selected' : ''; ?>>Biberach (LK) </option>
				<option value='05711' <?php echo ($districtKey == '05711') ? 'selected' : ''; ?>>Bielefeld (SK) </option>
				<option value='07134' <?php echo ($districtKey == '07134') ? 'selected' : ''; ?>>Birkenfeld (LK) </option>
				<option value='07232' <?php echo ($districtKey == '07232') ? 'selected' : ''; ?>>Bitburg-Prüm (LK) </option>
				<option value='08115' <?php echo ($districtKey == '08115') ? 'selected' : ''; ?>>Böblingen (LK) </option>
				<option value='05911' <?php echo ($districtKey == '05911') ? 'selected' : ''; ?>>Bochum (SK) </option>
				<option value='08435' <?php echo ($districtKey == '08435') ? 'selected' : ''; ?>>Bodenseekreis (LK) </option>
				<option value='05314' <?php echo ($districtKey == '05314') ? 'selected' : ''; ?>>Bonn (SK) </option>
				<option value='15083' <?php echo ($districtKey == '15083') ? 'selected' : ''; ?>>Börde (LK) </option>
				<option value='05554' <?php echo ($districtKey == '05554') ? 'selected' : ''; ?>>Borken (LK) </option>
				<option value='05512' <?php echo ($districtKey == '05512') ? 'selected' : ''; ?>>Bottrop (SK) </option>
				<option value='12051' <?php echo ($districtKey == '12051') ? 'selected' : ''; ?>>Brandenburg a.d.Havel (SK) </option>
				<option value='03101' <?php echo ($districtKey == '03101') ? 'selected' : ''; ?>>Braunschweig (SK) </option>
				<option value='08315' <?php echo ($districtKey == '08315') ? 'selected' : ''; ?>>Breisgau-Hochschwarzwald (LK) </option>
				<option value='04011' <?php echo ($districtKey == '04011') ? 'selected' : ''; ?>>Bremen (SK) </option>
				<option value='04012' <?php echo ($districtKey == '04012') ? 'selected' : ''; ?>>Bremerhaven (SK) </option>
				<option value='15084' <?php echo ($districtKey == '15084') ? 'selected' : ''; ?>>Burgenlandkreis (LK) </option>
				<option value='08235' <?php echo ($districtKey == '08235') ? 'selected' : ''; ?>>Calw (LK) </option>
				<option value='03351' <?php echo ($districtKey == '03351') ? 'selected' : ''; ?>>Celle (LK) </option>
				<option value='09372' <?php echo ($districtKey == '09372') ? 'selected' : ''; ?>>Cham (LK) </option>
				<option value='14511' <?php echo ($districtKey == '14511') ? 'selected' : ''; ?>>Chemnitz (SK) </option>
				<option value='03453' <?php echo ($districtKey == '03453') ? 'selected' : ''; ?>>Cloppenburg (LK) </option>
				<option value='09473' <?php echo ($districtKey == '09473') ? 'selected' : ''; ?>>Coburg (LK) </option>
				<option value='09463' <?php echo ($districtKey == '09463') ? 'selected' : ''; ?>>Coburg (SK) </option>
				<option value='07135' <?php echo ($districtKey == '07135') ? 'selected' : ''; ?>>Cochem-Zell (LK) </option>
				<option value='05558' <?php echo ($districtKey == '05558') ? 'selected' : ''; ?>>Coesfeld (LK) </option>
				<option value='12052' <?php echo ($districtKey == '12052') ? 'selected' : ''; ?>>Cottbus (SK) </option>
				<option value='03352' <?php echo ($districtKey == '03352') ? 'selected' : ''; ?>>Cuxhaven (LK) </option>
				<option value='09174' <?php echo ($districtKey == '09174') ? 'selected' : ''; ?>>Dachau (LK) </option>
				<option value='12061' <?php echo ($districtKey == '12061') ? 'selected' : ''; ?>>Dahme-Spreewald (LK) </option>
				<option value='06411' <?php echo ($districtKey == '06411') ? 'selected' : ''; ?>>Darmstadt (SK) </option>
				<option value='06432' <?php echo ($districtKey == '06432') ? 'selected' : ''; ?>>Darmstadt-Dieburg (LK) </option>
				<option value='09271' <?php echo ($districtKey == '09271') ? 'selected' : ''; ?>>Deggendorf (LK) </option>
				<option value='03401' <?php echo ($districtKey == '03401') ? 'selected' : ''; ?>>Delmenhorst (SK) </option>
				<option value='15001' <?php echo ($districtKey == '15001') ? 'selected' : ''; ?>>Dessau-Roßlau (SK) </option>
				<option value='03251' <?php echo ($districtKey == '03251') ? 'selected' : ''; ?>>Diepholz (LK) </option>
				<option value='09773' <?php echo ($districtKey == '09773') ? 'selected' : ''; ?>>Dillingen a.d.Donau (LK) </option>
				<option value='09279' <?php echo ($districtKey == '09279') ? 'selected' : ''; ?>>Dingolfing-Landau (LK) </option>
				<option value='01051' <?php echo ($districtKey == '01051') ? 'selected' : ''; ?>>Dithmarschen (LK) </option>
				<option value='09779' <?php echo ($districtKey == '09779') ? 'selected' : ''; ?>>Donau-Ries (LK) </option>
				<option value='07333' <?php echo ($districtKey == '07333') ? 'selected' : ''; ?>>Donnersbergkreis (LK) </option>
				<option value='05913' <?php echo ($districtKey == '05913') ? 'selected' : ''; ?>>Dortmund (SK) </option>
				<option value='14612' <?php echo ($districtKey == '14612') ? 'selected' : ''; ?>>Dresden (SK) </option>
				<option value='05112' <?php echo ($districtKey == '05112') ? 'selected' : ''; ?>>Duisburg (SK) </option>
				<option value='05358' <?php echo ($districtKey == '05358') ? 'selected' : ''; ?>>Düren (LK) </option>
				<option value='05111' <?php echo ($districtKey == '05111') ? 'selected' : ''; ?>>Düsseldorf (SK) </option>
				<option value='09175' <?php echo ($districtKey == '09175') ? 'selected' : ''; ?>>Ebersberg (LK) </option>
				<option value='16061' <?php echo ($districtKey == '16061') ? 'selected' : ''; ?>>Eichsfeld (LK) </option>
				<option value='09176' <?php echo ($districtKey == '09176') ? 'selected' : ''; ?>>Eichstätt (LK) </option>
				<option value='16056' <?php echo ($districtKey == '16056') ? 'selected' : ''; ?>>Eisenach (SK) </option>
				<option value='12062' <?php echo ($districtKey == '12062') ? 'selected' : ''; ?>>Elbe-Elster (LK) </option>
				<option value='03402' <?php echo ($districtKey == '03402') ? 'selected' : ''; ?>>Emden (SK) </option>
				<option value='08316' <?php echo ($districtKey == '08316') ? 'selected' : ''; ?>>Emmendingen (LK) </option>
				<option value='03454' <?php echo ($districtKey == '03454') ? 'selected' : ''; ?>>Emsland (LK) </option>
				<option value='05954' <?php echo ($districtKey == '05954') ? 'selected' : ''; ?>>Ennepe-Ruhr-Kreis (LK) </option>
				<option value='08236' <?php echo ($districtKey == '08236') ? 'selected' : ''; ?>>Enzkreis (LK) </option>
				<option value='09177' <?php echo ($districtKey == '09177') ? 'selected' : ''; ?>>Erding (LK) </option>
				<option value='16051' <?php echo ($districtKey == '16051') ? 'selected' : ''; ?>>Erfurt (SK) </option>
				<option value='09562' <?php echo ($districtKey == '09562') ? 'selected' : ''; ?>>Erlangen (SK) </option>
				<option value='09572' <?php echo ($districtKey == '09572') ? 'selected' : ''; ?>>Erlangen-Höchstadt (LK) </option>
				<option value='14521' <?php echo ($districtKey == '14521') ? 'selected' : ''; ?>>Erzgebirgskreis (LK) </option>
				<option value='05113' <?php echo ($districtKey == '05113') ? 'selected' : ''; ?>>Essen (SK) </option>
				<option value='08116' <?php echo ($districtKey == '08116') ? 'selected' : ''; ?>>Esslingen (LK) </option>
				<option value='05366' <?php echo ($districtKey == '05366') ? 'selected' : ''; ?>>Euskirchen (LK) </option>
				<option value='01001' <?php echo ($districtKey == '01001') ? 'selected' : ''; ?>>Flensburg (SK) </option>
				<option value='09474' <?php echo ($districtKey == '09474') ? 'selected' : ''; ?>>Forchheim (LK) </option>
				<option value='07311' <?php echo ($districtKey == '07311') ? 'selected' : ''; ?>>Frankenthal (SK) </option>
				<option value='12053' <?php echo ($districtKey == '12053') ? 'selected' : ''; ?>>Frankfurt (Oder) (SK) </option>
				<option value='06412' <?php echo ($districtKey == '06412') ? 'selected' : ''; ?>>Frankfurt am Main (SK) </option>
				<option value='08311' <?php echo ($districtKey == '08311') ? 'selected' : ''; ?>>Freiburg i.Breisgau (SK) </option>
				<option value='09178' <?php echo ($districtKey == '09178') ? 'selected' : ''; ?>>Freising (LK) </option>
				<option value='08237' <?php echo ($districtKey == '08237') ? 'selected' : ''; ?>>Freudenstadt (LK) </option>
				<option value='09272' <?php echo ($districtKey == '09272') ? 'selected' : ''; ?>>Freyung-Grafenau (LK) </option>
				<option value='03455' <?php echo ($districtKey == '03455') ? 'selected' : ''; ?>>Friesland (LK) </option>
				<option value='06631' <?php echo ($districtKey == '06631') ? 'selected' : ''; ?>>Fulda (LK) </option>
				<option value='09179' <?php echo ($districtKey == '09179') ? 'selected' : ''; ?>>Fürstenfeldbruck (LK) </option>
				<option value='09573' <?php echo ($districtKey == '09573') ? 'selected' : ''; ?>>Fürth (LK) </option>
				<option value='09563' <?php echo ($districtKey == '09563') ? 'selected' : ''; ?>>Fürth (SK) </option>
				<option value='09180' <?php echo ($districtKey == '09180') ? 'selected' : ''; ?>>Garmisch-Partenkirchen (LK) </option>
				<option value='05513' <?php echo ($districtKey == '05513') ? 'selected' : ''; ?>>Gelsenkirchen (SK) </option>
				<option value='16052' <?php echo ($districtKey == '16052') ? 'selected' : ''; ?>>Gera (SK) </option>
				<option value='07334' <?php echo ($districtKey == '07334') ? 'selected' : ''; ?>>Germersheim (LK) </option>
				<option value='06531' <?php echo ($districtKey == '06531') ? 'selected' : ''; ?>>Gießen (LK) </option>
				<option value='03151' <?php echo ($districtKey == '03151') ? 'selected' : ''; ?>>Gifhorn (LK) </option>
				<option value='08117' <?php echo ($districtKey == '08117') ? 'selected' : ''; ?>>Göppingen (LK) </option>
				<option value='14626' <?php echo ($districtKey == '14626') ? 'selected' : ''; ?>>Görlitz (LK) </option>
				<option value='03153' <?php echo ($districtKey == '03153') ? 'selected' : ''; ?>>Goslar (LK) </option>
				<option value='16067' <?php echo ($districtKey == '16067') ? 'selected' : ''; ?>>Gotha (LK) </option>
				<option value='03159' <?php echo ($districtKey == '03159') ? 'selected' : ''; ?>>Göttingen (LK) </option>
				<option value='03456' <?php echo ($districtKey == '03456') ? 'selected' : ''; ?>>Grafschaft Bentheim (LK) </option>
				<option value='16076' <?php echo ($districtKey == '16076') ? 'selected' : ''; ?>>Greiz (LK) </option>
				<option value='06433' <?php echo ($districtKey == '06433') ? 'selected' : ''; ?>>Groß-Gerau (LK) </option>
				<option value='09774' <?php echo ($districtKey == '09774') ? 'selected' : ''; ?>>Günzburg (LK) </option>
				<option value='05754' <?php echo ($districtKey == '05754') ? 'selected' : ''; ?>>Gütersloh (LK) </option>
				<option value='05914' <?php echo ($districtKey == '05914') ? 'selected' : ''; ?>>Hagen (SK) </option>
				<option value='15002' <?php echo ($districtKey == '15002') ? 'selected' : ''; ?>>Halle (SK) </option>
				<option value='02000' <?php echo ($districtKey == '02000') ? 'selected' : ''; ?>>Hamburg (SK) </option>
				<option value='03252' <?php echo ($districtKey == '03252') ? 'selected' : ''; ?>>Hameln-Pyrmont (LK) </option>
				<option value='05915' <?php echo ($districtKey == '05915') ? 'selected' : ''; ?>>Hamm (SK) </option>
				<option value='03241' <?php echo ($districtKey == '03241') ? 'selected' : ''; ?>>Hannover (Region)</option>
				<option value='03353' <?php echo ($districtKey == '03353') ? 'selected' : ''; ?>>Harburg (LK) </option>
				<option value='15085' <?php echo ($districtKey == '15085') ? 'selected' : ''; ?>>Harz (LK) </option>
				<option value='09674' <?php echo ($districtKey == '09674') ? 'selected' : ''; ?>>Haßberge (LK) </option>
				<option value='12063' <?php echo ($districtKey == '12063') ? 'selected' : ''; ?>>Havelland (LK) </option>
				<option value='03358' <?php echo ($districtKey == '03358') ? 'selected' : ''; ?>>Heidekreis (LK) </option>
				<option value='08221' <?php echo ($districtKey == '08221') ? 'selected' : ''; ?>>Heidelberg (SK) </option>
				<option value='08135' <?php echo ($districtKey == '08135') ? 'selected' : ''; ?>>Heidenheim (LK) </option>
				<option value='08125' <?php echo ($districtKey == '08125') ? 'selected' : ''; ?>>Heilbronn (LK) </option>
				<option value='08121' <?php echo ($districtKey == '08121') ? 'selected' : ''; ?>>Heilbronn (SK) </option>
				<option value='05370' <?php echo ($districtKey == '05370') ? 'selected' : ''; ?>>Heinsberg (LK) </option>
				<option value='03154' <?php echo ($districtKey == '03154') ? 'selected' : ''; ?>>Helmstedt (LK) </option>
				<option value='05758' <?php echo ($districtKey == '05758') ? 'selected' : ''; ?>>Herford (LK) </option>
				<option value='05916' <?php echo ($districtKey == '05916') ? 'selected' : ''; ?>>Herne (SK) </option>
				<option value='06632' <?php echo ($districtKey == '06632') ? 'selected' : ''; ?>>Hersfeld-Rotenburg (LK) </option>
				<option value='01053' <?php echo ($districtKey == '01053') ? 'selected' : ''; ?>>Herzogtum Lauenburg (LK) </option>
				<option value='16069' <?php echo ($districtKey == '16069') ? 'selected' : ''; ?>>Hildburghausen (LK) </option>
				<option value='03254' <?php echo ($districtKey == '03254') ? 'selected' : ''; ?>>Hildesheim (LK) </option>
				<option value='05958' <?php echo ($districtKey == '05958') ? 'selected' : ''; ?>>Hochsauerlandkreis (LK) </option>
				<option value='06434' <?php echo ($districtKey == '06434') ? 'selected' : ''; ?>>Hochtaunuskreis (LK) </option>
				<option value='09475' <?php echo ($districtKey == '09475') ? 'selected' : ''; ?>>Hof (LK) </option>
				<option value='09464' <?php echo ($districtKey == '09464') ? 'selected' : ''; ?>>Hof (SK) </option>
				<option value='08126' <?php echo ($districtKey == '08126') ? 'selected' : ''; ?>>Hohenlohekreis (LK) </option>
				<option value='03255' <?php echo ($districtKey == '03255') ? 'selected' : ''; ?>>Holzminden (LK) </option>
				<option value='05762' <?php echo ($districtKey == '05762') ? 'selected' : ''; ?>>Höxter (LK) </option>
				<option value='16070' <?php echo ($districtKey == '16070') ? 'selected' : ''; ?>>Ilm-Kreis (LK) </option>
				<option value='09161' <?php echo ($districtKey == '09161') ? 'selected' : ''; ?>>Ingolstadt (SK) </option>
				<option value='16053' <?php echo ($districtKey == '16053') ? 'selected' : ''; ?>>Jena (SK) </option>
				<option value='15086' <?php echo ($districtKey == '15086') ? 'selected' : ''; ?>>Jerichower Land (LK) </option>
				<option value='07335' <?php echo ($districtKey == '07335') ? 'selected' : ''; ?>>Kaiserslautern (LK) </option>
				<option value='07312' <?php echo ($districtKey == '07312') ? 'selected' : ''; ?>>Kaiserslautern (SK) </option>
				<option value='08215' <?php echo ($districtKey == '08215') ? 'selected' : ''; ?>>Karlsruhe (LK) </option>
				<option value='08212' <?php echo ($districtKey == '08212') ? 'selected' : ''; ?>>Karlsruhe (SK) </option>
				<option value='06633' <?php echo ($districtKey == '06633') ? 'selected' : ''; ?>>Kassel (LK) </option>
				<option value='06611' <?php echo ($districtKey == '06611') ? 'selected' : ''; ?>>Kassel (SK) </option>
				<option value='09762' <?php echo ($districtKey == '09762') ? 'selected' : ''; ?>>Kaufbeuren (SK) </option>
				<option value='09273' <?php echo ($districtKey == '09273') ? 'selected' : ''; ?>>Kelheim (LK) </option>
				<option value='09763' <?php echo ($districtKey == '09763') ? 'selected' : ''; ?>>Kempten (SK) </option>
				<option value='01002' <?php echo ($districtKey == '01002') ? 'selected' : ''; ?>>Kiel (SK) </option>
				<option value='09675' <?php echo ($districtKey == '09675') ? 'selected' : ''; ?>>Kitzingen (LK) </option>
				<option value='05154' <?php echo ($districtKey == '05154') ? 'selected' : ''; ?>>Kleve (LK) </option>
				<option value='07111' <?php echo ($districtKey == '07111') ? 'selected' : ''; ?>>Koblenz (SK) </option>
				<option value='05315' <?php echo ($districtKey == '05315') ? 'selected' : ''; ?>>Köln (SK) </option>
				<option value='08335' <?php echo ($districtKey == '08335') ? 'selected' : ''; ?>>Konstanz (LK) </option>
				<option value='05114' <?php echo ($districtKey == '05114') ? 'selected' : ''; ?>>Krefeld (SK) </option>
				<option value='09476' <?php echo ($districtKey == '09476') ? 'selected' : ''; ?>>Kronach (LK) </option>
				<option value='09477' <?php echo ($districtKey == '09477') ? 'selected' : ''; ?>>Kulmbach (LK) </option>
				<option value='07336' <?php echo ($districtKey == '07336') ? 'selected' : ''; ?>>Kusel (LK) </option>
				<option value='16065' <?php echo ($districtKey == '16065') ? 'selected' : ''; ?>>Kyffhäuserkreis (LK) </option>
				<option value='06532' <?php echo ($districtKey == '06532') ? 'selected' : ''; ?>>Lahn-Dill-Kreis (LK) </option>
				<option value='07313' <?php echo ($districtKey == '07313') ? 'selected' : ''; ?>>Landau i.d.Pfalz (SK) </option>
				<option value='09181' <?php echo ($districtKey == '09181') ? 'selected' : ''; ?>>Landsberg a.Lech (LK) </option>
				<option value='09274' <?php echo ($districtKey == '09274') ? 'selected' : ''; ?>>Landshut (LK) </option>
				<option value='09261' <?php echo ($districtKey == '09261') ? 'selected' : ''; ?>>Landshut (SK) </option>
				<option value='03457' <?php echo ($districtKey == '03457') ? 'selected' : ''; ?>>Leer (LK) </option>
				<option value='14729' <?php echo ($districtKey == '14729') ? 'selected' : ''; ?>>Leipzig (LK) </option>
				<option value='14713' <?php echo ($districtKey == '14713') ? 'selected' : ''; ?>>Leipzig (SK) </option>
				<option value='05316' <?php echo ($districtKey == '05316') ? 'selected' : ''; ?>>Leverkusen (SK) </option>
				<option value='09478' <?php echo ($districtKey == '09478') ? 'selected' : ''; ?>>Lichtenfels (LK) </option>
				<option value='06533' <?php echo ($districtKey == '06533') ? 'selected' : ''; ?>>Limburg-Weilburg (LK) </option>
				<option value='09776' <?php echo ($districtKey == '09776') ? 'selected' : ''; ?>>Lindau (LK) </option>
				<option value='05766' <?php echo ($districtKey == '05766') ? 'selected' : ''; ?>>Lippe (LK) </option>
				<option value='08336' <?php echo ($districtKey == '08336') ? 'selected' : ''; ?>>Lörrach (LK) </option>
				<option value='01003' <?php echo ($districtKey == '01003') ? 'selected' : ''; ?>>Lübeck (SK) </option>
				<option value='03354' <?php echo ($districtKey == '03354') ? 'selected' : ''; ?>>Lüchow-Dannenberg (LK) </option>
				<option value='08118' <?php echo ($districtKey == '08118') ? 'selected' : ''; ?>>Ludwigsburg (LK) </option>
				<option value='07314' <?php echo ($districtKey == '07314') ? 'selected' : ''; ?>>Ludwigshafen (SK) </option>
				<option value='13076' <?php echo ($districtKey == '13076') ? 'selected' : ''; ?>>Ludwigslust-Parchim (LK) </option>
				<option value='03355' <?php echo ($districtKey == '03355') ? 'selected' : ''; ?>>Lüneburg (LK) </option>
				<option value='15003' <?php echo ($districtKey == '15003') ? 'selected' : ''; ?>>Magdeburg (SK) </option>
				<option value='06435' <?php echo ($districtKey == '06435') ? 'selected' : ''; ?>>Main-Kinzig-Kreis (LK) </option>
				<option value='09677' <?php echo ($districtKey == '09677') ? 'selected' : ''; ?>>Main-Spessart (LK) </option>
				<option value='08128' <?php echo ($districtKey == '08128') ? 'selected' : ''; ?>>Main-Tauber-Kreis (LK) </option>
				<option value='06436' <?php echo ($districtKey == '06436') ? 'selected' : ''; ?>>Main-Taunus-Kreis (LK) </option>
				<option value='07315' <?php echo ($districtKey == '07315') ? 'selected' : ''; ?>>Mainz (SK) </option>
				<option value='07339' <?php echo ($districtKey == '07339') ? 'selected' : ''; ?>>Mainz-Bingen (LK) </option>
				<option value='08222' <?php echo ($districtKey == '08222') ? 'selected' : ''; ?>>Mannheim (SK) </option>
				<option value='15087' <?php echo ($districtKey == '15087') ? 'selected' : ''; ?>>Mansfeld-Südharz (LK) </option>
				<option value='06534' <?php echo ($districtKey == '06534') ? 'selected' : ''; ?>>Marburg-Biedenkopf (LK) </option>
				<option value='05962' <?php echo ($districtKey == '05962') ? 'selected' : ''; ?>>Märkischer Kreis (LK) </option>
				<option value='12064' <?php echo ($districtKey == '12064') ? 'selected' : ''; ?>>Märkisch-Oderland (LK) </option>
				<option value='07137' <?php echo ($districtKey == '07137') ? 'selected' : ''; ?>>Mayen-Koblenz (LK) </option>
				<option value='13071' <?php echo ($districtKey == '13071') ? 'selected' : ''; ?>>Mecklenburgische Seenplatte (LK) </option>
				<option value='14627' <?php echo ($districtKey == '14627') ? 'selected' : ''; ?>>Meißen (LK) </option>
				<option value='09764' <?php echo ($districtKey == '09764') ? 'selected' : ''; ?>>Memmingen (SK) </option>
				<option value='10042' <?php echo ($districtKey == '10042') ? 'selected' : ''; ?>>Merzig-Wadern (LK) </option>
				<option value='05158' <?php echo ($districtKey == '05158') ? 'selected' : ''; ?>>Mettmann (LK) </option>
				<option value='09182' <?php echo ($districtKey == '09182') ? 'selected' : ''; ?>>Miesbach (LK) </option>
				<option value='09676' <?php echo ($districtKey == '09676') ? 'selected' : ''; ?>>Miltenberg (LK) </option>
				<option value='05770' <?php echo ($districtKey == '05770') ? 'selected' : ''; ?>>Minden-Lübbecke (LK) </option>
				<option value='14522' <?php echo ($districtKey == '14522') ? 'selected' : ''; ?>>Mittelsachsen (LK) </option>
				<option value='05116' <?php echo ($districtKey == '05116') ? 'selected' : ''; ?>>Mönchengladbach (SK) </option>
				<option value='09183' <?php echo ($districtKey == '09183') ? 'selected' : ''; ?>>Mühldorf a.Inn (LK) </option>
				<option value='05117' <?php echo ($districtKey == '05117') ? 'selected' : ''; ?>>Mülheim a.d.Ruhr (SK) </option>
				<option value='09184' <?php echo ($districtKey == '09184') ? 'selected' : ''; ?>>München (LK) </option>
				<option value='09162' <?php echo ($districtKey == '09162') ? 'selected' : ''; ?>>München (SK) </option>
				<option value='05515' <?php echo ($districtKey == '05515') ? 'selected' : ''; ?>>Münster (SK) </option>
				<option value='08225' <?php echo ($districtKey == '08225') ? 'selected' : ''; ?>>Neckar-Odenwald-Kreis (LK) </option>
				<option value='09185' <?php echo ($districtKey == '09185') ? 'selected' : ''; ?>>Neuburg-Schrobenhausen (LK) </option>
				<option value='09373' <?php echo ($districtKey == '09373') ? 'selected' : ''; ?>>Neumarkt i.d.OPf. (LK) </option>
				<option value='01004' <?php echo ($districtKey == '01004') ? 'selected' : ''; ?>>Neumünster (SK) </option>
				<option value='10043' <?php echo ($districtKey == '10043') ? 'selected' : ''; ?>>Neunkirchen (LK) </option>
				<option value='09575' <?php echo ($districtKey == '09575') ? 'selected' : ''; ?>>Neustadt a.d.Aisch-Bad Windsheim (LK) </option>
				<option value='09374' <?php echo ($districtKey == '09374') ? 'selected' : ''; ?>>Neustadt a.d.Waldnaab (LK) </option>
				<option value='07316' <?php echo ($districtKey == '07316') ? 'selected' : ''; ?>>Neustadt a.d.Weinstraße (SK) </option>
				<option value='09775' <?php echo ($districtKey == '09775') ? 'selected' : ''; ?>>Neu-Ulm (LK) </option>
				<option value='07138' <?php echo ($districtKey == '07138') ? 'selected' : ''; ?>>Neuwied (LK) </option>
				<option value='03256' <?php echo ($districtKey == '03256') ? 'selected' : ''; ?>>Nienburg (Weser) (LK) </option>
				<option value='01054' <?php echo ($districtKey == '01054') ? 'selected' : ''; ?>>Nordfriesland (LK) </option>
				<option value='16062' <?php echo ($districtKey == '16062') ? 'selected' : ''; ?>>Nordhausen (LK) </option>
				<option value='14730' <?php echo ($districtKey == '14730') ? 'selected' : ''; ?>>Nordsachsen (LK) </option>
				<option value='13074' <?php echo ($districtKey == '13074') ? 'selected' : ''; ?>>Nordwestmecklenburg (LK) </option>
				<option value='03155' <?php echo ($districtKey == '03155') ? 'selected' : ''; ?>>Northeim (LK) </option>
				<option value='09564' <?php echo ($districtKey == '09564') ? 'selected' : ''; ?>>Nürnberg (SK) </option>
				<option value='09574' <?php echo ($districtKey == '09574') ? 'selected' : ''; ?>>Nürnberger Land (LK) </option>
				<option value='09780' <?php echo ($districtKey == '09780') ? 'selected' : ''; ?>>Oberallgäu (LK) </option>
				<option value='05374' <?php echo ($districtKey == '05374') ? 'selected' : ''; ?>>Oberbergischer Kreis (LK) </option>
				<option value='05119' <?php echo ($districtKey == '05119') ? 'selected' : ''; ?>>Oberhausen (SK) </option>
				<option value='12065' <?php echo ($districtKey == '12065') ? 'selected' : ''; ?>>Oberhavel (LK) </option>
				<option value='12066' <?php echo ($districtKey == '12066') ? 'selected' : ''; ?>>Oberspreewald-Lausitz (LK) </option>
				<option value='06437' <?php echo ($districtKey == '06437') ? 'selected' : ''; ?>>Odenwaldkreis (LK) </option>
				<option value='12067' <?php echo ($districtKey == '12067') ? 'selected' : ''; ?>>Oder-Spree (LK) </option>
				<option value='06438' <?php echo ($districtKey == '06438') ? 'selected' : ''; ?>>Offenbach (LK) </option>
				<option value='06413' <?php echo ($districtKey == '06413') ? 'selected' : ''; ?>>Offenbach (SK) </option>
				<option value='03458' <?php echo ($districtKey == '03458') ? 'selected' : ''; ?>>Oldenburg (LK) </option>
				<option value='03403' <?php echo ($districtKey == '03403') ? 'selected' : ''; ?>>Oldenburg (SK) </option>
				<option value='05966' <?php echo ($districtKey == '05966') ? 'selected' : ''; ?>>Olpe (LK) </option>
				<option value='08317' <?php echo ($districtKey == '08317') ? 'selected' : ''; ?>>Ortenaukreis (LK) </option>
				<option value='03459' <?php echo ($districtKey == '03459') ? 'selected' : ''; ?>>Osnabrück (LK) </option>
				<option value='03404' <?php echo ($districtKey == '03404') ? 'selected' : ''; ?>>Osnabrück (SK) </option>
				<option value='08136' <?php echo ($districtKey == '08136') ? 'selected' : ''; ?>>Ostalbkreis (LK) </option>
				<option value='09777' <?php echo ($districtKey == '09777') ? 'selected' : ''; ?>>Ostallgäu (LK) </option>
				<option value='03356' <?php echo ($districtKey == '03356') ? 'selected' : ''; ?>>Osterholz (LK) </option>
				<option value='01055' <?php echo ($districtKey == '01055') ? 'selected' : ''; ?>>Ostholstein (LK) </option>
				<option value='12068' <?php echo ($districtKey == '12068') ? 'selected' : ''; ?>>Ostprignitz-Ruppin (LK) </option>
				<option value='05774' <?php echo ($districtKey == '05774') ? 'selected' : ''; ?>>Paderborn (LK) </option>
				<option value='09275' <?php echo ($districtKey == '09275') ? 'selected' : ''; ?>>Passau (LK) </option>
				<option value='09262' <?php echo ($districtKey == '09262') ? 'selected' : ''; ?>>Passau (SK) </option>
				<option value='03157' <?php echo ($districtKey == '03157') ? 'selected' : ''; ?>>Peine (LK) </option>
				<option value='09186' <?php echo ($districtKey == '09186') ? 'selected' : ''; ?>>Pfaffenhofen a.d.Ilm (LK) </option>
				<option value='08231' <?php echo ($districtKey == '08231') ? 'selected' : ''; ?>>Pforzheim (SK) </option>
				<option value='01056' <?php echo ($districtKey == '01056') ? 'selected' : ''; ?>>Pinneberg (LK) </option>
				<option value='07317' <?php echo ($districtKey == '07317') ? 'selected' : ''; ?>>Pirmasens (SK) </option>
				<option value='01057' <?php echo ($districtKey == '01057') ? 'selected' : ''; ?>>Plön (LK) </option>
				<option value='12054' <?php echo ($districtKey == '12054') ? 'selected' : ''; ?>>Potsdam (SK) </option>
				<option value='12069' <?php echo ($districtKey == '12069') ? 'selected' : ''; ?>>Potsdam-Mittelmark (LK) </option>
				<option value='12070' <?php echo ($districtKey == '12070') ? 'selected' : ''; ?>>Prignitz (LK) </option>
				<option value='08216' <?php echo ($districtKey == '08216') ? 'selected' : ''; ?>>Rastatt (LK) </option>
				<option value='08436' <?php echo ($districtKey == '08436') ? 'selected' : ''; ?>>Ravensburg (LK) </option>
				<option value='05562' <?php echo ($districtKey == '05562') ? 'selected' : ''; ?>>Recklinghausen (LK) </option>
				<option value='09276' <?php echo ($districtKey == '09276') ? 'selected' : ''; ?>>Regen (LK) </option>
				<option value='09375' <?php echo ($districtKey == '09375') ? 'selected' : ''; ?>>Regensburg (LK) </option>
				<option value='09362' <?php echo ($districtKey == '09362') ? 'selected' : ''; ?>>Regensburg (SK) </option>
				<option value='05120' <?php echo ($districtKey == '05120') ? 'selected' : ''; ?>>Remscheid (SK) </option>
				<option value='08119' <?php echo ($districtKey == '08119') ? 'selected' : ''; ?>>Rems-Murr-Kreis (LK) </option>
				<option value='01058' <?php echo ($districtKey == '01058') ? 'selected' : ''; ?>>Rendsburg-Eckernförde (LK) </option>
				<option value='08415' <?php echo ($districtKey == '08415') ? 'selected' : ''; ?>>Reutlingen (LK) </option>
				<option value='05362' <?php echo ($districtKey == '05362') ? 'selected' : ''; ?>>Rhein-Erft-Kreis (LK) </option>
				<option value='06439' <?php echo ($districtKey == '06439') ? 'selected' : ''; ?>>Rheingau-Taunus-Kreis (LK) </option>
				<option value='07140' <?php echo ($districtKey == '07140') ? 'selected' : ''; ?>>Rhein-Hunsrück-Kreis (LK) </option>
				<option value='05378' <?php echo ($districtKey == '05378') ? 'selected' : ''; ?>>Rheinisch-Bergischer Kreis (LK) </option>
				<option value='05162' <?php echo ($districtKey == '05162') ? 'selected' : ''; ?>>Rhein-Kreis Neuss (LK) </option>
				<option value='07141' <?php echo ($districtKey == '07141') ? 'selected' : ''; ?>>Rhein-Lahn-Kreis (LK) </option>
				<option value='08226' <?php echo ($districtKey == '08226') ? 'selected' : ''; ?>>Rhein-Neckar-Kreis (LK) </option>
				<option value='07338' <?php echo ($districtKey == '07338') ? 'selected' : ''; ?>>Rhein-Pfalz-Kreis (LK) </option>
				<option value='05382' <?php echo ($districtKey == '05382') ? 'selected' : ''; ?>>Rhein-Sieg-Kreis (LK) </option>
				<option value='09673' <?php echo ($districtKey == '09673') ? 'selected' : ''; ?>>Rhön-Grabfeld (LK) </option>
				<option value='09187' <?php echo ($districtKey == '09187') ? 'selected' : ''; ?>>Rosenheim (LK) </option>
				<option value='09163' <?php echo ($districtKey == '09163') ? 'selected' : ''; ?>>Rosenheim (SK) </option>
				<option value='13072' <?php echo ($districtKey == '13072') ? 'selected' : ''; ?>>Rostock (LK) </option>
				<option value='13003' <?php echo ($districtKey == '13003') ? 'selected' : ''; ?>>Rostock (SK) </option>
				<option value='03357' <?php echo ($districtKey == '03357') ? 'selected' : ''; ?>>Rotenburg (Wümme) (LK) </option>
				<option value='09576' <?php echo ($districtKey == '09576') ? 'selected' : ''; ?>>Roth (LK) </option>
				<option value='09277' <?php echo ($districtKey == '09277') ? 'selected' : ''; ?>>Rottal-Inn (LK) </option>
				<option value='08325' <?php echo ($districtKey == '08325') ? 'selected' : ''; ?>>Rottweil (LK) </option>
				<option value='16074' <?php echo ($districtKey == '16074') ? 'selected' : ''; ?>>Saale-Holzland-Kreis (LK) </option>
				<option value='15088' <?php echo ($districtKey == '15088') ? 'selected' : ''; ?>>Saalekreis (LK) </option>
				<option value='16075' <?php echo ($districtKey == '16075') ? 'selected' : ''; ?>>Saale-Orla-Kreis (LK) </option>
				<option value='16073' <?php echo ($districtKey == '16073') ? 'selected' : ''; ?>>Saalfeld-Rudolstadt (LK) </option>
				<option value='10044' <?php echo ($districtKey == '10044') ? 'selected' : ''; ?>>Saarlouis (LK) </option>
				<option value='10045' <?php echo ($districtKey == '10045') ? 'selected' : ''; ?>>Saarpfalz-Kreis (LK) </option>
				<option value='14628' <?php echo ($districtKey == '14628') ? 'selected' : ''; ?>>Sächsische Schweiz-Osterzgebirge (LK) </option>
				<option value='03102' <?php echo ($districtKey == '03102') ? 'selected' : ''; ?>>Salzgitter (SK) </option>
				<option value='15089' <?php echo ($districtKey == '15089') ? 'selected' : ''; ?>>Salzlandkreis (LK) </option>
				<option value='10046' <?php echo ($districtKey == '10046') ? 'selected' : ''; ?>>Sankt Wendel (LK) </option>
				<option value='03257' <?php echo ($districtKey == '03257') ? 'selected' : ''; ?>>Schaumburg (LK) </option>
				<option value='01059' <?php echo ($districtKey == '01059') ? 'selected' : ''; ?>>Schleswig-Flensburg (LK) </option>
				<option value='16066' <?php echo ($districtKey == '16066') ? 'selected' : ''; ?>>Schmalkalden-Meiningen (LK) </option>
				<option value='09565' <?php echo ($districtKey == '09565') ? 'selected' : ''; ?>>Schwabach (SK) </option>
				<option value='08127' <?php echo ($districtKey == '08127') ? 'selected' : ''; ?>>Schwäbisch Hall (LK) </option>
				<option value='06634' <?php echo ($districtKey == '06634') ? 'selected' : ''; ?>>Schwalm-Eder-Kreis (LK) </option>
				<option value='09376' <?php echo ($districtKey == '09376') ? 'selected' : ''; ?>>Schwandorf (LK) </option>
				<option value='08326' <?php echo ($districtKey == '08326') ? 'selected' : ''; ?>>Schwarzwald-Baar-Kreis (LK) </option>
				<option value='09678' <?php echo ($districtKey == '09678') ? 'selected' : ''; ?>>Schweinfurt (LK) </option>
				<option value='09662' <?php echo ($districtKey == '09662') ? 'selected' : ''; ?>>Schweinfurt (SK) </option>
				<option value='13004' <?php echo ($districtKey == '13004') ? 'selected' : ''; ?>>Schwerin (SK) </option>
				<option value='01060' <?php echo ($districtKey == '01060') ? 'selected' : ''; ?>>Segeberg (LK) </option>
				<option value='05970' <?php echo ($districtKey == '05970') ? 'selected' : ''; ?>>Siegen-Wittgenstein (LK) </option>
				<option value='08437' <?php echo ($districtKey == '08437') ? 'selected' : ''; ?>>Sigmaringen (LK) </option>
				<option value='05974' <?php echo ($districtKey == '05974') ? 'selected' : ''; ?>>Soest (LK) </option>
				<option value='05122' <?php echo ($districtKey == '05122') ? 'selected' : ''; ?>>Solingen (SK) </option>
				<option value='16068' <?php echo ($districtKey == '16068') ? 'selected' : ''; ?>>Sömmerda (LK) </option>
				<option value='16072' <?php echo ($districtKey == '16072') ? 'selected' : ''; ?>>Sonneberg (LK) </option>
				<option value='07318' <?php echo ($districtKey == '07318') ? 'selected' : ''; ?>>Speyer (SK) </option>
				<option value='12071' <?php echo ($districtKey == '12071') ? 'selected' : ''; ?>>Spree-Neiße (LK) </option>
				<option value='03359' <?php echo ($districtKey == '03359') ? 'selected' : ''; ?>>Stade (LK) </option>
				<option value='10041' <?php echo ($districtKey == '10041') ? 'selected' : ''; ?>>Stadtverband Saarbrücken (LK) </option>
				<option value='09188' <?php echo ($districtKey == '09188') ? 'selected' : ''; ?>>Starnberg (LK) </option>
				<option value='01061' <?php echo ($districtKey == '01061') ? 'selected' : ''; ?>>Steinburg (LK) </option>
				<option value='05566' <?php echo ($districtKey == '05566') ? 'selected' : ''; ?>>Steinfurt (LK) </option>
				<option value='15090' <?php echo ($districtKey == '15090') ? 'selected' : ''; ?>>Stendal (LK) </option>
				<option value='01062' <?php echo ($districtKey == '01062') ? 'selected' : ''; ?>>Stormarn (LK) </option>
				<option value='09263' <?php echo ($districtKey == '09263') ? 'selected' : ''; ?>>Straubing (SK) </option>
				<option value='09278' <?php echo ($districtKey == '09278') ? 'selected' : ''; ?>>Straubing-Bogen (LK) </option>
				<option value='08111' <?php echo ($districtKey == '08111') ? 'selected' : ''; ?>>Stuttgart (SK) </option>
				<option value='07337' <?php echo ($districtKey == '07337') ? 'selected' : ''; ?>>Südliche Weinstraße (LK) </option>
				<option value='07340' <?php echo ($districtKey == '07340') ? 'selected' : ''; ?>>Südwestpfalz (LK) </option>
				<option value='16054' <?php echo ($districtKey == '16054') ? 'selected' : ''; ?>>Suhl (SK) </option>
				<option value='12072' <?php echo ($districtKey == '12072') ? 'selected' : ''; ?>>Teltow-Fläming (LK) </option>
				<option value='09377' <?php echo ($districtKey == '09377') ? 'selected' : ''; ?>>Tirschenreuth (LK) </option>
				<option value='09189' <?php echo ($districtKey == '09189') ? 'selected' : ''; ?>>Traunstein (LK) </option>
				<option value='07211' <?php echo ($districtKey == '07211') ? 'selected' : ''; ?>>Trier (SK) </option>
				<option value='07235' <?php echo ($districtKey == '07235') ? 'selected' : ''; ?>>Trier-Saarburg (LK) </option>
				<option value='08416' <?php echo ($districtKey == '08416') ? 'selected' : ''; ?>>Tübingen (LK) </option>
				<option value='08327' <?php echo ($districtKey == '08327') ? 'selected' : ''; ?>>Tuttlingen (LK) </option>
				<option value='12073' <?php echo ($districtKey == '12073') ? 'selected' : ''; ?>>Uckermark (LK) </option>
				<option value='03360' <?php echo ($districtKey == '03360') ? 'selected' : ''; ?>>Uelzen (LK) </option>
				<option value='08421' <?php echo ($districtKey == '08421') ? 'selected' : ''; ?>>Ulm (SK) </option>
				<option value='05978' <?php echo ($districtKey == '05978') ? 'selected' : ''; ?>>Unna (LK) </option>
				<option value='16064' <?php echo ($districtKey == '16064') ? 'selected' : ''; ?>>Unstrut-Hainich-Kreis (LK) </option>
				<option value='09778' <?php echo ($districtKey == '09778') ? 'selected' : ''; ?>>Unterallgäu (LK) </option>
				<option value='03460' <?php echo ($districtKey == '03460') ? 'selected' : ''; ?>>Vechta (LK) </option>
				<option value='03361' <?php echo ($districtKey == '03361') ? 'selected' : ''; ?>>Verden (LK) </option>
				<option value='05166' <?php echo ($districtKey == '05166') ? 'selected' : ''; ?>>Viersen (LK) </option>
				<option value='06535' <?php echo ($districtKey == '06535') ? 'selected' : ''; ?>>Vogelsbergkreis (LK) </option>
				<option value='14523' <?php echo ($districtKey == '14523') ? 'selected' : ''; ?>>Vogtlandkreis (LK) </option>
				<option value='13075' <?php echo ($districtKey == '13075') ? 'selected' : ''; ?>>Vorpommern-Greifswald (LK) </option>
				<option value='13073' <?php echo ($districtKey == '13073') ? 'selected' : ''; ?>>Vorpommern-Rügen (LK) </option>
				<option value='07233' <?php echo ($districtKey == '07233') ? 'selected' : ''; ?>>Vulkaneifel (LK) </option>
				<option value='06635' <?php echo ($districtKey == '06635') ? 'selected' : ''; ?>>Waldeck-Frankenberg (LK) </option>
				<option value='08337' <?php echo ($districtKey == '08337') ? 'selected' : ''; ?>>Waldshut (LK) </option>
				<option value='05570' <?php echo ($districtKey == '05570') ? 'selected' : ''; ?>>Warendorf (LK) </option>
				<option value='16063' <?php echo ($districtKey == '16063') ? 'selected' : ''; ?>>Wartburgkreis (LK) </option>
				<option value='09363' <?php echo ($districtKey == '09363') ? 'selected' : ''; ?>>Weiden i.d.OPf. (SK) </option>
				<option value='09190' <?php echo ($districtKey == '09190') ? 'selected' : ''; ?>>Weilheim-Schongau (LK) </option>
				<option value='16055' <?php echo ($districtKey == '16055') ? 'selected' : ''; ?>>Weimar (SK) </option>
				<option value='16071' <?php echo ($districtKey == '16071') ? 'selected' : ''; ?>>Weimarer Land (LK) </option>
				<option value='09577' <?php echo ($districtKey == '09577') ? 'selected' : ''; ?>>Weißenburg-Gunzenhausen (LK) </option>
				<option value='06636' <?php echo ($districtKey == '06636') ? 'selected' : ''; ?>>Werra-Meißner-Kreis (LK) </option>
				<option value='05170' <?php echo ($districtKey == '05170') ? 'selected' : ''; ?>>Wesel (LK) </option>
				<option value='03461' <?php echo ($districtKey == '03461') ? 'selected' : ''; ?>>Wesermarsch (LK) </option>
				<option value='07143' <?php echo ($districtKey == '07143') ? 'selected' : ''; ?>>Westerwaldkreis (LK) </option>
				<option value='06440' <?php echo ($districtKey == '06440') ? 'selected' : ''; ?>>Wetteraukreis (LK) </option>
				<option value='06414' <?php echo ($districtKey == '06414') ? 'selected' : ''; ?>>Wiesbaden (SK) </option>
				<option value='03405' <?php echo ($districtKey == '03405') ? 'selected' : ''; ?>>Wilhelmshaven (SK) </option>
				<option value='15091' <?php echo ($districtKey == '15091') ? 'selected' : ''; ?>>Wittenberg (LK) </option>
				<option value='03462' <?php echo ($districtKey == '03462') ? 'selected' : ''; ?>>Wittmund (LK) </option>
				<option value='03158' <?php echo ($districtKey == '03158') ? 'selected' : ''; ?>>Wolfenbüttel (LK) </option>
				<option value='03103' <?php echo ($districtKey == '03103') ? 'selected' : ''; ?>>Wolfsburg (SK) </option>
				<option value='07319' <?php echo ($districtKey == '07319') ? 'selected' : ''; ?>>Worms (SK) </option>
				<option value='09479' <?php echo ($districtKey == '09479') ? 'selected' : ''; ?>>Wunsiedel i.Fichtelgebirge (LK) </option>
				<option value='05124' <?php echo ($districtKey == '05124') ? 'selected' : ''; ?>>Wuppertal (SK) </option>
				<option value='09679' <?php echo ($districtKey == '09679') ? 'selected' : ''; ?>>Würzburg (LK) </option>
				<option value='09663' <?php echo ($districtKey == '09663') ? 'selected' : ''; ?>>Würzburg (SK) </option>
				<option value='08417' <?php echo ($districtKey == '08417') ? 'selected' : ''; ?>>Zollernalbkreis (LK) </option>
				<option value='07320' <?php echo ($districtKey == '07320') ? 'selected' : ''; ?>>Zweibrücken (SK) </option>
				<option value='14524' <?php echo ($districtKey == '14524') ? 'selected' : ''; ?>>Zwickau (LK) </option>
			</select>
		</p>
	<?php
	}

	// function to define the data saved by the widget
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);

		$districtKey = strip_tags($new_instance['districtKey']);
		$instance['districtKey'] = strip_tags($new_instance['districtKey']);

		return $instance;
	}

	// function to display the widget in the site
	function widget($args, $instance)
	{
		// read values from backend form
		$title = apply_filters('widget_title', $instance['title']);
		$districtKey = $instance['districtKey'];

		// get incidences from API
		$weeklyInc = new WeeklyIncidence(trim($districtKey));

		// handle result
		//$jsonResponse = $weeklyInc->jsonResponse;
		//var_dump($jsonResponse);
		$districtName = $weeklyInc->districtName;

		// output code to show widget
		echo $args['before_widget'];
	?>

		<div class="c197di">
			<?php if (!empty($title)) {
				echo $args['before_title'] . $title . $args['after_title'];
			};
			?>

			<?php if (!empty($weeklyInc->error)) {
				echo "<p class='error'>" . $weeklyInc->error . "</p>";
			};
			?>

			<p>
				Neueste drei 7-Tage-Inzindenzen im Kreis <strong><?= $weeklyInc->districtName ?></strong></br>
			</p>

			<ul id="grid" class="clear">
				<li>
					<div class="hexagon hidden"></div>
				</li>
				<li>
					<div class="hexagon <?= $weeklyInc->styles[2] ?>">
						<p>
							<span class="value"><?= number_format($weeklyInc->values[2], 1) ?></span><br>
							<span class="subtitle" title="latest"><?= $weeklyInc->dates[2] ?></span>
						</p>
					</div>
				</li>
				<li>
					<div class="hexagon hidden"></div>
				</li>
				<li>
					<div class="hexagon <?= $weeklyInc->styles[1] ?>">
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
			<p class="footer">
				Thanks to Marlon for the <a href="<?= $weeklyInc->metaInfo ?>" target="_blank">API</a>
			</p>
		</div>

<?php
		echo $args['after_widget'];
	}
}

// function to register the widget
function registerMyWidget()
{
	register_widget('Covid19InzidenzAmpel');
}
add_action('widgets_init', 'registerMyWidget');

// class containing last 3 weekly incidences for a district
class WeeklyIncidence
{
	public $districtKey = "08111";	// Stuttgart as default
	public $districtName;	// name of district
	public $jsonResponse;

	// incidence values for day-before-yesterday, yesterday, today
	public $values = array(-1.0, -1.0, -1.0);
	// css classes for day-before-yesterday, yesterday, today
	public $styles = array("info", "info", "info");
	public $dates = array("-", "-", "-");

	public $lastUpdate;
	public $metaInfo = "https://github.com/marlon360/rki-covid-api";
	public $error;

	// Constructor with argument district key; gets the data from the api and puts the result into jsonResponse
	// On error check this->error for error message
	function WeeklyIncidence($key)
	{
		$this->districtKey = $key;

		// get data from API
		$results = $this->fetchJson();

		// check if API returns error
		if ($this->error === null) {
			$this->error = $results->error->message;
		}

		$this->jsonResponse = $results;

		// dictrict name
		$this->districtName = $results->data->$key->name;

		// last 3 day's 7-days incidences
		$objArray = $results->data->$key->history;
		//$i = 0;
		//foreach ($objArray as $obj) {
		for ($i = 0; $i < 3; $i++) {
			$obj = $objArray[$i];

			// date
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
			if ($inc >= 200.0) {
				$this->styles[$i] = "more-danger";
			}
			//$i++;
		}

		// meta info
		$a = $results->meta->lastUpdate;
		$b = strtotime($a);
		$lastUpdateDateTime = date("d/m/Y H:i A", $b);
		$this->lastUpdate = $lastUpdateDateTime;

		$this->metaInfo = $results->meta->info;
		// }
	}

	/*
	Calls API to get district's last incidences. Returns Json or false (sets error prop).
	*/
	function fetchJson()
	{
		// todo: use transient; think about timespan
		//if ( false === ( $response = get_transient( 'Cov19JSON-'.$this->districtKey ) ) ) {
		$uri = 'https://api.corona-zahlen.org/districts/' . $this->districtKey . '/history/incidence/3';
		$response = wp_remote_get($uri);
		//var_dump($response);
		//set_transient('Cov19JSON-'.$this->districtKey,$response,60*60);	// 60*60sec=1h
		//}  

		// not tested yet:
		if (is_wp_error($response)) {
			// echo $response->get_error_message();
			$this->error = $response->get_error_message();
			return false; // fail
		}

		$body = wp_remote_retrieve_body($response);

		$json = json_decode($body);

		// not tested yet:
		if (json_last_error() !== JSON_ERROR_NONE) {
			// JSON is invalid
			$this->error = json_last_error_msg();
			return false;
		}

		return $json;
	}
}

function isJSON($string)
{
	return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
}
