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
		<!-- <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'districtKey' ); ?>" name="<?php echo $this->get_field_name( 'districtKey' ); ?>" value="<?php echo esc_attr( $districtKey ); ?>" /> -->
	   
		<select class='widefat' id="<?php echo $this->get_field_id('districtKey'); ?>"
                name="<?php echo $this->get_field_name('districtKey'); ?>" type="text">

		<option value="01001" <?php echo ($districtKey=='01001')?'selected':''; ?>>SK Flensburg</option>
<option value="01002" <?php echo ($districtKey=='01002')?'selected':''; ?>>SK Kiel</option>
<option value="01003" <?php echo ($districtKey=='01003')?'selected':''; ?>>SK Lübeck</option>
<option value="01004" <?php echo ($districtKey=='01004')?'selected':''; ?>>SK Neumünster</option>
<option value="01051" <?php echo ($districtKey=='01051')?'selected':''; ?>>LK Dithmarschen</option>
<option value="01053" <?php echo ($districtKey=='01053')?'selected':''; ?>>LK Herzogtum Lauenburg</option>
<option value="01054" <?php echo ($districtKey=='01054')?'selected':''; ?>>LK Nordfriesland</option>
<option value="01055" <?php echo ($districtKey=='01055')?'selected':''; ?>>LK Ostholstein</option>
<option value="01056" <?php echo ($districtKey=='01056')?'selected':''; ?>>LK Pinneberg</option>
<option value="01058" <?php echo ($districtKey=='01058')?'selected':''; ?>>LK Rendsburg-Eckernförde</option>
<option value="01057" <?php echo ($districtKey=='01057')?'selected':''; ?>>LK Plön</option>
<option value="01059" <?php echo ($districtKey=='01059')?'selected':''; ?>>LK Schleswig-Flensburg</option>
<option value="01060" <?php echo ($districtKey=='01060')?'selected':''; ?>>LK Segeberg</option>
<option value="01061" <?php echo ($districtKey=='01061')?'selected':''; ?>>LK Steinburg</option>
<option value="01062" <?php echo ($districtKey=='01062')?'selected':''; ?>>LK Stormarn</option>
<option value="02000" <?php echo ($districtKey=='02000')?'selected':''; ?>>SK Hamburg</option>
<option value="03101" <?php echo ($districtKey=='03101')?'selected':''; ?>>SK Braunschweig</option>
<option value="03102" <?php echo ($districtKey=='03102')?'selected':''; ?>>SK Salzgitter</option>
<option value="03103" <?php echo ($districtKey=='03103')?'selected':''; ?>>SK Wolfsburg</option>
<option value="03151" <?php echo ($districtKey=='03151')?'selected':''; ?>>LK Gifhorn</option>
<option value="03153" <?php echo ($districtKey=='03153')?'selected':''; ?>>LK Goslar</option>
<option value="03154" <?php echo ($districtKey=='03154')?'selected':''; ?>>LK Helmstedt</option>
<option value="03155" <?php echo ($districtKey=='03155')?'selected':''; ?>>LK Northeim</option>
<option value="03157" <?php echo ($districtKey=='03157')?'selected':''; ?>>LK Peine</option>
<option value="03158" <?php echo ($districtKey=='03158')?'selected':''; ?>>LK Wolfenbüttel</option>
<option value="03159" <?php echo ($districtKey=='03159')?'selected':''; ?>>LK Göttingen</option>
<option value="03241" <?php echo ($districtKey=='03241')?'selected':''; ?>>Region Hannover</option>
<option value="03251" <?php echo ($districtKey=='03251')?'selected':''; ?>>LK Diepholz</option>
<option value="03252" <?php echo ($districtKey=='03252')?'selected':''; ?>>LK Hameln-Pyrmont</option>
<option value="03254" <?php echo ($districtKey=='03254')?'selected':''; ?>>LK Hildesheim</option>
<option value="03255" <?php echo ($districtKey=='03255')?'selected':''; ?>>LK Holzminden</option>
<option value="03256" <?php echo ($districtKey=='03256')?'selected':''; ?>>LK Nienburg (Weser)</option>
<option value="03257" <?php echo ($districtKey=='03257')?'selected':''; ?>>LK Schaumburg</option>
<option value="03351" <?php echo ($districtKey=='03351')?'selected':''; ?>>LK Celle</option>
<option value="03352" <?php echo ($districtKey=='03352')?'selected':''; ?>>LK Cuxhaven</option>
<option value="03353" <?php echo ($districtKey=='03353')?'selected':''; ?>>LK Harburg</option>
<option value="03354" <?php echo ($districtKey=='03354')?'selected':''; ?>>LK Lüchow-Dannenberg</option>
<option value="03355" <?php echo ($districtKey=='03355')?'selected':''; ?>>LK Lüneburg</option>
<option value="03356" <?php echo ($districtKey=='03356')?'selected':''; ?>>LK Osterholz</option>
<option value="03357" <?php echo ($districtKey=='03357')?'selected':''; ?>>LK Rotenburg (Wümme)</option>
<option value="03358" <?php echo ($districtKey=='03358')?'selected':''; ?>>LK Heidekreis</option>
<option value="03359" <?php echo ($districtKey=='03359')?'selected':''; ?>>LK Stade</option>
<option value="03360" <?php echo ($districtKey=='03360')?'selected':''; ?>>LK Uelzen</option>
<option value="03361" <?php echo ($districtKey=='03361')?'selected':''; ?>>LK Verden</option>
<option value="03401" <?php echo ($districtKey=='03401')?'selected':''; ?>>SK Delmenhorst</option>
<option value="03403" <?php echo ($districtKey=='03403')?'selected':''; ?>>SK Oldenburg</option>
<option value="03402" <?php echo ($districtKey=='03402')?'selected':''; ?>>SK Emden</option>
<option value="03404" <?php echo ($districtKey=='03404')?'selected':''; ?>>SK Osnabrück</option>
<option value="03405" <?php echo ($districtKey=='03405')?'selected':''; ?>>SK Wilhelmshaven</option>
<option value="03451" <?php echo ($districtKey=='03451')?'selected':''; ?>>LK Ammerland</option>
<option value="03452" <?php echo ($districtKey=='03452')?'selected':''; ?>>LK Aurich</option>
<option value="03453" <?php echo ($districtKey=='03453')?'selected':''; ?>>LK Cloppenburg</option>
<option value="03454" <?php echo ($districtKey=='03454')?'selected':''; ?>>LK Emsland</option>
<option value="03455" <?php echo ($districtKey=='03455')?'selected':''; ?>>LK Friesland</option>
<option value="03456" <?php echo ($districtKey=='03456')?'selected':''; ?>>LK Grafschaft Bentheim</option>
<option value="03457" <?php echo ($districtKey=='03457')?'selected':''; ?>>LK Leer</option>
<option value="03458" <?php echo ($districtKey=='03458')?'selected':''; ?>>LK Oldenburg</option>
<option value="03459" <?php echo ($districtKey=='03459')?'selected':''; ?>>LK Osnabrück</option>
<option value="03460" <?php echo ($districtKey=='03460')?'selected':''; ?>>LK Vechta</option>
<option value="03461" <?php echo ($districtKey=='03461')?'selected':''; ?>>LK Wesermarsch</option>
<option value="03462" <?php echo ($districtKey=='03462')?'selected':''; ?>>LK Wittmund</option>
<option value="04011" <?php echo ($districtKey=='04011')?'selected':''; ?>>SK Bremen</option>
<option value="04012" <?php echo ($districtKey=='04012')?'selected':''; ?>>SK Bremerhaven</option>
<option value="05111" <?php echo ($districtKey=='05111')?'selected':''; ?>>SK Düsseldorf</option>
<option value="05112" <?php echo ($districtKey=='05112')?'selected':''; ?>>SK Duisburg</option>
<option value="05113" <?php echo ($districtKey=='05113')?'selected':''; ?>>SK Essen</option>
<option value="05114" <?php echo ($districtKey=='05114')?'selected':''; ?>>SK Krefeld</option>
<option value="05116" <?php echo ($districtKey=='05116')?'selected':''; ?>>SK Mönchengladbach</option>
<option value="05117" <?php echo ($districtKey=='05117')?'selected':''; ?>>SK Mülheim a.d.Ruhr</option>
<option value="05119" <?php echo ($districtKey=='05119')?'selected':''; ?>>SK Oberhausen</option>
<option value="05120" <?php echo ($districtKey=='05120')?'selected':''; ?>>SK Remscheid</option>
<option value="05122" <?php echo ($districtKey=='05122')?'selected':''; ?>>SK Solingen</option>
<option value="05124" <?php echo ($districtKey=='05124')?'selected':''; ?>>SK Wuppertal</option>
<option value="05154" <?php echo ($districtKey=='05154')?'selected':''; ?>>LK Kleve</option>
<option value="05158" <?php echo ($districtKey=='05158')?'selected':''; ?>>LK Mettmann</option>
<option value="05162" <?php echo ($districtKey=='05162')?'selected':''; ?>>LK Rhein-Kreis Neuss</option>
<option value="05166" <?php echo ($districtKey=='05166')?'selected':''; ?>>LK Viersen</option>
<option value="05170" <?php echo ($districtKey=='05170')?'selected':''; ?>>LK Wesel</option>
<option value="05314" <?php echo ($districtKey=='05314')?'selected':''; ?>>SK Bonn</option>
<option value="05315" <?php echo ($districtKey=='05315')?'selected':''; ?>>SK Köln</option>
<option value="05316" <?php echo ($districtKey=='05316')?'selected':''; ?>>SK Leverkusen</option>
<option value="05334" <?php echo ($districtKey=='05334')?'selected':''; ?>>StadtRegion Aachen</option>
<option value="05358" <?php echo ($districtKey=='05358')?'selected':''; ?>>LK Düren</option>
<option value="05362" <?php echo ($districtKey=='05362')?'selected':''; ?>>LK Rhein-Erft-Kreis</option>
<option value="05366" <?php echo ($districtKey=='05366')?'selected':''; ?>>LK Euskirchen</option>
<option value="05370" <?php echo ($districtKey=='05370')?'selected':''; ?>>LK Heinsberg</option>
<option value="05374" <?php echo ($districtKey=='05374')?'selected':''; ?>>LK Oberbergischer Kreis</option>
<option value="05378" <?php echo ($districtKey=='05378')?'selected':''; ?>>LK Rheinisch-Bergischer Kreis</option>
<option value="05382" <?php echo ($districtKey=='05382')?'selected':''; ?>>LK Rhein-Sieg-Kreis</option>
<option value="05512" <?php echo ($districtKey=='05512')?'selected':''; ?>>SK Bottrop</option>
<option value="05513" <?php echo ($districtKey=='05513')?'selected':''; ?>>SK Gelsenkirchen</option>
<option value="05515" <?php echo ($districtKey=='05515')?'selected':''; ?>>SK Münster</option>
<option value="05554" <?php echo ($districtKey=='05554')?'selected':''; ?>>LK Borken</option>
<option value="05558" <?php echo ($districtKey=='05558')?'selected':''; ?>>LK Coesfeld</option>
<option value="05562" <?php echo ($districtKey=='05562')?'selected':''; ?>>LK Recklinghausen</option>
<option value="05566" <?php echo ($districtKey=='05566')?'selected':''; ?>>LK Steinfurt</option>
<option value="05570" <?php echo ($districtKey=='05570')?'selected':''; ?>>LK Warendorf</option>
<option value="05711" <?php echo ($districtKey=='05711')?'selected':''; ?>>SK Bielefeld</option>
<option value="05754" <?php echo ($districtKey=='05754')?'selected':''; ?>>LK Gütersloh</option>
<option value="05758" <?php echo ($districtKey=='05758')?'selected':''; ?>>LK Herford</option>
<option value="05762" <?php echo ($districtKey=='05762')?'selected':''; ?>>LK Höxter</option>
<option value="05766" <?php echo ($districtKey=='05766')?'selected':''; ?>>LK Lippe</option>
<option value="05770" <?php echo ($districtKey=='05770')?'selected':''; ?>>LK Minden-Lübbecke</option>
<option value="05774" <?php echo ($districtKey=='05774')?'selected':''; ?>>LK Paderborn</option>
<option value="05911" <?php echo ($districtKey=='05911')?'selected':''; ?>>SK Bochum</option>
<option value="05913" <?php echo ($districtKey=='05913')?'selected':''; ?>>SK Dortmund</option>
<option value="05914" <?php echo ($districtKey=='05914')?'selected':''; ?>>SK Hagen</option>
<option value="05915" <?php echo ($districtKey=='05915')?'selected':''; ?>>SK Hamm</option>
<option value="05916" <?php echo ($districtKey=='05916')?'selected':''; ?>>SK Herne</option>
<option value="05954" <?php echo ($districtKey=='05954')?'selected':''; ?>>LK Ennepe-Ruhr-Kreis</option>
<option value="05958" <?php echo ($districtKey=='05958')?'selected':''; ?>>LK Hochsauerlandkreis</option>
<option value="05962" <?php echo ($districtKey=='05962')?'selected':''; ?>>LK Märkischer Kreis</option>
<option value="05966" <?php echo ($districtKey=='05966')?'selected':''; ?>>LK Olpe</option>
<option value="05970" <?php echo ($districtKey=='05970')?'selected':''; ?>>LK Siegen-Wittgenstein</option>
<option value="05974" <?php echo ($districtKey=='05974')?'selected':''; ?>>LK Soest</option>
<option value="05978" <?php echo ($districtKey=='05978')?'selected':''; ?>>LK Unna</option>
<option value="06411" <?php echo ($districtKey=='06411')?'selected':''; ?>>SK Darmstadt</option>
<option value="06412" <?php echo ($districtKey=='06412')?'selected':''; ?>>SK Frankfurt am Main</option>
<option value="06413" <?php echo ($districtKey=='06413')?'selected':''; ?>>SK Offenbach</option>
<option value="06414" <?php echo ($districtKey=='06414')?'selected':''; ?>>SK Wiesbaden</option>
<option value="06431" <?php echo ($districtKey=='06431')?'selected':''; ?>>LK Bergstraße</option>
<option value="06432" <?php echo ($districtKey=='06432')?'selected':''; ?>>LK Darmstadt-Dieburg</option>
<option value="06433" <?php echo ($districtKey=='06433')?'selected':''; ?>>LK Groß-Gerau</option>
<option value="06434" <?php echo ($districtKey=='06434')?'selected':''; ?>>LK Hochtaunuskreis</option>
<option value="06435" <?php echo ($districtKey=='06435')?'selected':''; ?>>LK Main-Kinzig-Kreis</option>
<option value="06436" <?php echo ($districtKey=='06436')?'selected':''; ?>>LK Main-Taunus-Kreis</option>
<option value="06437" <?php echo ($districtKey=='06437')?'selected':''; ?>>LK Odenwaldkreis</option>
<option value="06438" <?php echo ($districtKey=='06438')?'selected':''; ?>>LK Offenbach</option>
<option value="06439" <?php echo ($districtKey=='06439')?'selected':''; ?>>LK Rheingau-Taunus-Kreis</option>
<option value="06440" <?php echo ($districtKey=='06440')?'selected':''; ?>>LK Wetteraukreis</option>
<option value="06531" <?php echo ($districtKey=='06531')?'selected':''; ?>>LK Gießen</option>
<option value="06532" <?php echo ($districtKey=='06532')?'selected':''; ?>>LK Lahn-Dill-Kreis</option>
<option value="06533" <?php echo ($districtKey=='06533')?'selected':''; ?>>LK Limburg-Weilburg</option>
<option value="06534" <?php echo ($districtKey=='06534')?'selected':''; ?>>LK Marburg-Biedenkopf</option>
<option value="06535" <?php echo ($districtKey=='06535')?'selected':''; ?>>LK Vogelsbergkreis</option>
<option value="06611" <?php echo ($districtKey=='06611')?'selected':''; ?>>SK Kassel</option>
<option value="06631" <?php echo ($districtKey=='06631')?'selected':''; ?>>LK Fulda</option>
<option value="06632" <?php echo ($districtKey=='06632')?'selected':''; ?>>LK Hersfeld-Rotenburg</option>
<option value="06633" <?php echo ($districtKey=='06633')?'selected':''; ?>>LK Kassel</option>
<option value="06634" <?php echo ($districtKey=='06634')?'selected':''; ?>>LK Schwalm-Eder-Kreis</option>
<option value="06635" <?php echo ($districtKey=='06635')?'selected':''; ?>>LK Waldeck-Frankenberg</option>
<option value="06636" <?php echo ($districtKey=='06636')?'selected':''; ?>>LK Werra-Meißner-Kreis</option>
<option value="07131" <?php echo ($districtKey=='07131')?'selected':''; ?>>LK Ahrweiler</option>
<option value="07111" <?php echo ($districtKey=='07111')?'selected':''; ?>>SK Koblenz</option>
<option value="07132" <?php echo ($districtKey=='07132')?'selected':''; ?>>LK Altenkirchen</option>
<option value="07133" <?php echo ($districtKey=='07133')?'selected':''; ?>>LK Bad Kreuznach</option>
<option value="07134" <?php echo ($districtKey=='07134')?'selected':''; ?>>LK Birkenfeld</option>
<option value="07135" <?php echo ($districtKey=='07135')?'selected':''; ?>>LK Cochem-Zell</option>
<option value="07137" <?php echo ($districtKey=='07137')?'selected':''; ?>>LK Mayen-Koblenz</option>
<option value="07138" <?php echo ($districtKey=='07138')?'selected':''; ?>>LK Neuwied</option>
<option value="07140" <?php echo ($districtKey=='07140')?'selected':''; ?>>LK Rhein-Hunsrück-Kreis</option>
<option value="07141" <?php echo ($districtKey=='07141')?'selected':''; ?>>LK Rhein-Lahn-Kreis</option>
<option value="07143" <?php echo ($districtKey=='07143')?'selected':''; ?>>LK Westerwaldkreis</option>
<option value="07211" <?php echo ($districtKey=='07211')?'selected':''; ?>>SK Trier</option>
<option value="07231" <?php echo ($districtKey=='07231')?'selected':''; ?>>LK Bernkastel-Wittlich</option>
<option value="07232" <?php echo ($districtKey=='07232')?'selected':''; ?>>LK Bitburg-Prüm</option>
<option value="07233" <?php echo ($districtKey=='07233')?'selected':''; ?>>LK Vulkaneifel</option>
<option value="07235" <?php echo ($districtKey=='07235')?'selected':''; ?>>LK Trier-Saarburg</option>
<option value="07311" <?php echo ($districtKey=='07311')?'selected':''; ?>>SK Frankenthal</option>
<option value="07312" <?php echo ($districtKey=='07312')?'selected':''; ?>>SK Kaiserslautern</option>
<option value="07314" <?php echo ($districtKey=='07314')?'selected':''; ?>>SK Ludwigshafen</option>
<option value="07313" <?php echo ($districtKey=='07313')?'selected':''; ?>>SK Landau i.d.Pfalz</option>
<option value="07315" <?php echo ($districtKey=='07315')?'selected':''; ?>>SK Mainz</option>
<option value="07316" <?php echo ($districtKey=='07316')?'selected':''; ?>>SK Neustadt a.d.Weinstraße</option>
<option value="07317" <?php echo ($districtKey=='07317')?'selected':''; ?>>SK Pirmasens</option>
<option value="07318" <?php echo ($districtKey=='07318')?'selected':''; ?>>SK Speyer</option>
<option value="07319" <?php echo ($districtKey=='07319')?'selected':''; ?>>SK Worms</option>
<option value="07331" <?php echo ($districtKey=='07331')?'selected':''; ?>>LK Alzey-Worms</option>
<option value="07320" <?php echo ($districtKey=='07320')?'selected':''; ?>>SK Zweibrücken</option>
<option value="07332" <?php echo ($districtKey=='07332')?'selected':''; ?>>LK Bad Dürkheim</option>
<option value="07333" <?php echo ($districtKey=='07333')?'selected':''; ?>>LK Donnersbergkreis</option>
<option value="07334" <?php echo ($districtKey=='07334')?'selected':''; ?>>LK Germersheim</option>
<option value="07335" <?php echo ($districtKey=='07335')?'selected':''; ?>>LK Kaiserslautern</option>
<option value="07337" <?php echo ($districtKey=='07337')?'selected':''; ?>>LK Südliche Weinstraße</option>
<option value="07336" <?php echo ($districtKey=='07336')?'selected':''; ?>>LK Kusel</option>
<option value="07338" <?php echo ($districtKey=='07338')?'selected':''; ?>>LK Rhein-Pfalz-Kreis</option>
<option value="07339" <?php echo ($districtKey=='07339')?'selected':''; ?>>LK Mainz-Bingen</option>
<option value="07340" <?php echo ($districtKey=='07340')?'selected':''; ?>>LK Südwestpfalz</option>
<option value="08111" <?php echo ($districtKey=='08111')?'selected':''; ?>>SK Stuttgart</option>
<option value="08115" <?php echo ($districtKey=='08115')?'selected':''; ?>>LK Böblingen</option>
<option value="08116" <?php echo ($districtKey=='08116')?'selected':''; ?>>LK Esslingen</option>
<option value="08117" <?php echo ($districtKey=='08117')?'selected':''; ?>>LK Göppingen</option>
<option value="08118" <?php echo ($districtKey=='08118')?'selected':''; ?>>LK Ludwigsburg</option>
<option value="08119" <?php echo ($districtKey=='08119')?'selected':''; ?>>LK Rems-Murr-Kreis</option>
<option value="08121" <?php echo ($districtKey=='08121')?'selected':''; ?>>SK Heilbronn</option>
<option value="08125" <?php echo ($districtKey=='08125')?'selected':''; ?>>LK Heilbronn</option>
<option value="08126" <?php echo ($districtKey=='08126')?'selected':''; ?>>LK Hohenlohekreis</option>
<option value="08127" <?php echo ($districtKey=='08127')?'selected':''; ?>>LK Schwäbisch Hall</option>
<option value="08128" <?php echo ($districtKey=='08128')?'selected':''; ?>>LK Main-Tauber-Kreis</option>
<option value="08135" <?php echo ($districtKey=='08135')?'selected':''; ?>>LK Heidenheim</option>
<option value="08136" <?php echo ($districtKey=='08136')?'selected':''; ?>>LK Ostalbkreis</option>
<option value="08211" <?php echo ($districtKey=='08211')?'selected':''; ?>>SK Baden-Baden</option>
<option value="08212" <?php echo ($districtKey=='08212')?'selected':''; ?>>SK Karlsruhe</option>
<option value="08215" <?php echo ($districtKey=='08215')?'selected':''; ?>>LK Karlsruhe</option>
<option value="08216" <?php echo ($districtKey=='08216')?'selected':''; ?>>LK Rastatt</option>
<option value="08221" <?php echo ($districtKey=='08221')?'selected':''; ?>>SK Heidelberg</option>
<option value="08222" <?php echo ($districtKey=='08222')?'selected':''; ?>>SK Mannheim</option>
<option value="08225" <?php echo ($districtKey=='08225')?'selected':''; ?>>LK Neckar-Odenwald-Kreis</option>
<option value="08226" <?php echo ($districtKey=='08226')?'selected':''; ?>>LK Rhein-Neckar-Kreis</option>
<option value="08231" <?php echo ($districtKey=='08231')?'selected':''; ?>>SK Pforzheim</option>
<option value="08235" <?php echo ($districtKey=='08235')?'selected':''; ?>>LK Calw</option>
<option value="08236" <?php echo ($districtKey=='08236')?'selected':''; ?>>LK Enzkreis</option>
<option value="08237" <?php echo ($districtKey=='08237')?'selected':''; ?>>LK Freudenstadt</option>
<option value="08311" <?php echo ($districtKey=='08311')?'selected':''; ?>>SK Freiburg i.Breisgau</option>
<option value="08315" <?php echo ($districtKey=='08315')?'selected':''; ?>>LK Breisgau-Hochschwarzwald</option>
<option value="08316" <?php echo ($districtKey=='08316')?'selected':''; ?>>LK Emmendingen</option>
<option value="08317" <?php echo ($districtKey=='08317')?'selected':''; ?>>LK Ortenaukreis</option>
<option value="08325" <?php echo ($districtKey=='08325')?'selected':''; ?>>LK Rottweil</option>
<option value="08326" <?php echo ($districtKey=='08326')?'selected':''; ?>>LK Schwarzwald-Baar-Kreis</option>
<option value="08327" <?php echo ($districtKey=='08327')?'selected':''; ?>>LK Tuttlingen</option>
<option value="08335" <?php echo ($districtKey=='08335')?'selected':''; ?>>LK Konstanz</option>
<option value="08336" <?php echo ($districtKey=='08336')?'selected':''; ?>>LK Lörrach</option>
<option value="08337" <?php echo ($districtKey=='08337')?'selected':''; ?>>LK Waldshut</option>
<option value="08415" <?php echo ($districtKey=='08415')?'selected':''; ?>>LK Reutlingen</option>
<option value="08416" <?php echo ($districtKey=='08416')?'selected':''; ?>>LK Tübingen</option>
<option value="08417" <?php echo ($districtKey=='08417')?'selected':''; ?>>LK Zollernalbkreis</option>
<option value="08421" <?php echo ($districtKey=='08421')?'selected':''; ?>>SK Ulm</option>
<option value="08425" <?php echo ($districtKey=='08425')?'selected':''; ?>>LK Alb-Donau-Kreis</option>
<option value="08426" <?php echo ($districtKey=='08426')?'selected':''; ?>>LK Biberach</option>
<option value="08435" <?php echo ($districtKey=='08435')?'selected':''; ?>>LK Bodenseekreis</option>
<option value="08436" <?php echo ($districtKey=='08436')?'selected':''; ?>>LK Ravensburg</option>
<option value="08437" <?php echo ($districtKey=='08437')?'selected':''; ?>>LK Sigmaringen</option>
<option value="09161" <?php echo ($districtKey=='09161')?'selected':''; ?>>SK Ingolstadt</option>
<option value="09162" <?php echo ($districtKey=='09162')?'selected':''; ?>>SK München</option>
<option value="09163" <?php echo ($districtKey=='09163')?'selected':''; ?>>SK Rosenheim</option>
<option value="09171" <?php echo ($districtKey=='09171')?'selected':''; ?>>LK Altötting</option>
<option value="09172" <?php echo ($districtKey=='09172')?'selected':''; ?>>LK Berchtesgadener Land</option>
<option value="09173" <?php echo ($districtKey=='09173')?'selected':''; ?>>LK Bad Tölz-Wolfratshausen</option>
<option value="09174" <?php echo ($districtKey=='09174')?'selected':''; ?>>LK Dachau</option>
<option value="09175" <?php echo ($districtKey=='09175')?'selected':''; ?>>LK Ebersberg</option>
<option value="09176" <?php echo ($districtKey=='09176')?'selected':''; ?>>LK Eichstätt</option>
<option value="09177" <?php echo ($districtKey=='09177')?'selected':''; ?>>LK Erding</option>
<option value="09178" <?php echo ($districtKey=='09178')?'selected':''; ?>>LK Freising</option>
<option value="09179" <?php echo ($districtKey=='09179')?'selected':''; ?>>LK Fürstenfeldbruck</option>
<option value="09180" <?php echo ($districtKey=='09180')?'selected':''; ?>>LK Garmisch-Partenkirchen</option>
<option value="09181" <?php echo ($districtKey=='09181')?'selected':''; ?>>LK Landsberg a.Lech</option>
<option value="09182" <?php echo ($districtKey=='09182')?'selected':''; ?>>LK Miesbach</option>
<option value="09183" <?php echo ($districtKey=='09183')?'selected':''; ?>>LK Mühldorf a.Inn</option>
<option value="09184" <?php echo ($districtKey=='09184')?'selected':''; ?>>LK München</option>
<option value="09185" <?php echo ($districtKey=='09185')?'selected':''; ?>>LK Neuburg-Schrobenhausen</option>
<option value="09186" <?php echo ($districtKey=='09186')?'selected':''; ?>>LK Pfaffenhofen a.d.Ilm</option>
<option value="09187" <?php echo ($districtKey=='09187')?'selected':''; ?>>LK Rosenheim</option>
<option value="09188" <?php echo ($districtKey=='09188')?'selected':''; ?>>LK Starnberg</option>
<option value="09189" <?php echo ($districtKey=='09189')?'selected':''; ?>>LK Traunstein</option>
<option value="09190" <?php echo ($districtKey=='09190')?'selected':''; ?>>LK Weilheim-Schongau</option>
<option value="09261" <?php echo ($districtKey=='09261')?'selected':''; ?>>SK Landshut</option>
<option value="09262" <?php echo ($districtKey=='09262')?'selected':''; ?>>SK Passau</option>
<option value="09263" <?php echo ($districtKey=='09263')?'selected':''; ?>>SK Straubing</option>
<option value="09271" <?php echo ($districtKey=='09271')?'selected':''; ?>>LK Deggendorf</option>
<option value="09272" <?php echo ($districtKey=='09272')?'selected':''; ?>>LK Freyung-Grafenau</option>
<option value="09273" <?php echo ($districtKey=='09273')?'selected':''; ?>>LK Kelheim</option>
<option value="09274" <?php echo ($districtKey=='09274')?'selected':''; ?>>LK Landshut</option>
<option value="09275" <?php echo ($districtKey=='09275')?'selected':''; ?>>LK Passau</option>
<option value="09276" <?php echo ($districtKey=='09276')?'selected':''; ?>>LK Regen</option>
<option value="09277" <?php echo ($districtKey=='09277')?'selected':''; ?>>LK Rottal-Inn</option>
<option value="09278" <?php echo ($districtKey=='09278')?'selected':''; ?>>LK Straubing-Bogen</option>
<option value="09279" <?php echo ($districtKey=='09279')?'selected':''; ?>>LK Dingolfing-Landau</option>
<option value="09361" <?php echo ($districtKey=='09361')?'selected':''; ?>>SK Amberg</option>
<option value="09362" <?php echo ($districtKey=='09362')?'selected':''; ?>>SK Regensburg</option>
<option value="09363" <?php echo ($districtKey=='09363')?'selected':''; ?>>SK Weiden i.d.OPf.</option>
<option value="09371" <?php echo ($districtKey=='09371')?'selected':''; ?>>LK Amberg-Sulzbach</option>
<option value="09372" <?php echo ($districtKey=='09372')?'selected':''; ?>>LK Cham</option>
<option value="09373" <?php echo ($districtKey=='09373')?'selected':''; ?>>LK Neumarkt i.d.OPf.</option>
<option value="09374" <?php echo ($districtKey=='09374')?'selected':''; ?>>LK Neustadt a.d.Waldnaab</option>
<option value="09375" <?php echo ($districtKey=='09375')?'selected':''; ?>>LK Regensburg</option>
<option value="09376" <?php echo ($districtKey=='09376')?'selected':''; ?>>LK Schwandorf</option>
<option value="09377" <?php echo ($districtKey=='09377')?'selected':''; ?>>LK Tirschenreuth</option>
<option value="09461" <?php echo ($districtKey=='09461')?'selected':''; ?>>SK Bamberg</option>
<option value="09462" <?php echo ($districtKey=='09462')?'selected':''; ?>>SK Bayreuth</option>
<option value="09463" <?php echo ($districtKey=='09463')?'selected':''; ?>>SK Coburg</option>
<option value="09464" <?php echo ($districtKey=='09464')?'selected':''; ?>>SK Hof</option>
<option value="09471" <?php echo ($districtKey=='09471')?'selected':''; ?>>LK Bamberg</option>
<option value="09472" <?php echo ($districtKey=='09472')?'selected':''; ?>>LK Bayreuth</option>
<option value="09473" <?php echo ($districtKey=='09473')?'selected':''; ?>>LK Coburg</option>
<option value="09474" <?php echo ($districtKey=='09474')?'selected':''; ?>>LK Forchheim</option>
<option value="09475" <?php echo ($districtKey=='09475')?'selected':''; ?>>LK Hof</option>
<option value="09476" <?php echo ($districtKey=='09476')?'selected':''; ?>>LK Kronach</option>
<option value="09477" <?php echo ($districtKey=='09477')?'selected':''; ?>>LK Kulmbach</option>
<option value="09478" <?php echo ($districtKey=='09478')?'selected':''; ?>>LK Lichtenfels</option>
<option value="09479" <?php echo ($districtKey=='09479')?'selected':''; ?>>LK Wunsiedel i.Fichtelgebirge</option>
<option value="09561" <?php echo ($districtKey=='09561')?'selected':''; ?>>SK Ansbach</option>
<option value="09562" <?php echo ($districtKey=='09562')?'selected':''; ?>>SK Erlangen</option>
<option value="09563" <?php echo ($districtKey=='09563')?'selected':''; ?>>SK Fürth</option>
<option value="09564" <?php echo ($districtKey=='09564')?'selected':''; ?>>SK Nürnberg</option>
<option value="09565" <?php echo ($districtKey=='09565')?'selected':''; ?>>SK Schwabach</option>
<option value="09571" <?php echo ($districtKey=='09571')?'selected':''; ?>>LK Ansbach</option>
<option value="09572" <?php echo ($districtKey=='09572')?'selected':''; ?>>LK Erlangen-Höchstadt</option>
<option value="09573" <?php echo ($districtKey=='09573')?'selected':''; ?>>LK Fürth</option>
<option value="09574" <?php echo ($districtKey=='09574')?'selected':''; ?>>LK Nürnberger Land</option>
<option value="09575" <?php echo ($districtKey=='09575')?'selected':''; ?>>LK Neustadt a.d.Aisch-Bad Windsheim</option>
<option value="09576" <?php echo ($districtKey=='09576')?'selected':''; ?>>LK Roth</option>
<option value="09577" <?php echo ($districtKey=='09577')?'selected':''; ?>>LK Weißenburg-Gunzenhausen</option>
<option value="09661" <?php echo ($districtKey=='09661')?'selected':''; ?>>SK Aschaffenburg</option>
<option value="09663" <?php echo ($districtKey=='09663')?'selected':''; ?>>SK Würzburg</option>
<option value="09662" <?php echo ($districtKey=='09662')?'selected':''; ?>>SK Schweinfurt</option>
<option value="09671" <?php echo ($districtKey=='09671')?'selected':''; ?>>LK Aschaffenburg</option>
<option value="09672" <?php echo ($districtKey=='09672')?'selected':''; ?>>LK Bad Kissingen</option>
<option value="09673" <?php echo ($districtKey=='09673')?'selected':''; ?>>LK Rhön-Grabfeld</option>
<option value="09674" <?php echo ($districtKey=='09674')?'selected':''; ?>>LK Haßberge</option>
<option value="09675" <?php echo ($districtKey=='09675')?'selected':''; ?>>LK Kitzingen</option>
<option value="09676" <?php echo ($districtKey=='09676')?'selected':''; ?>>LK Miltenberg</option>
<option value="09677" <?php echo ($districtKey=='09677')?'selected':''; ?>>LK Main-Spessart</option>
<option value="09678" <?php echo ($districtKey=='09678')?'selected':''; ?>>LK Schweinfurt</option>
<option value="09679" <?php echo ($districtKey=='09679')?'selected':''; ?>>LK Würzburg</option>
<option value="09761" <?php echo ($districtKey=='09761')?'selected':''; ?>>SK Augsburg</option>
<option value="09762" <?php echo ($districtKey=='09762')?'selected':''; ?>>SK Kaufbeuren</option>
<option value="09763" <?php echo ($districtKey=='09763')?'selected':''; ?>>SK Kempten</option>
<option value="09764" <?php echo ($districtKey=='09764')?'selected':''; ?>>SK Memmingen</option>
<option value="09771" <?php echo ($districtKey=='09771')?'selected':''; ?>>LK Aichach-Friedberg</option>
<option value="09772" <?php echo ($districtKey=='09772')?'selected':''; ?>>LK Augsburg</option>
<option value="09773" <?php echo ($districtKey=='09773')?'selected':''; ?>>LK Dillingen a.d.Donau</option>
<option value="09774" <?php echo ($districtKey=='09774')?'selected':''; ?>>LK Günzburg</option>
<option value="09775" <?php echo ($districtKey=='09775')?'selected':''; ?>>LK Neu-Ulm</option>
<option value="09776" <?php echo ($districtKey=='09776')?'selected':''; ?>>LK Lindau</option>
<option value="09777" <?php echo ($districtKey=='09777')?'selected':''; ?>>LK Ostallgäu</option>
<option value="09778" <?php echo ($districtKey=='09778')?'selected':''; ?>>LK Unterallgäu</option>
<option value="09779" <?php echo ($districtKey=='09779')?'selected':''; ?>>LK Donau-Ries</option>
<option value="09780" <?php echo ($districtKey=='09780')?'selected':''; ?>>LK Oberallgäu</option>
<option value="10041" <?php echo ($districtKey=='10041')?'selected':''; ?>>LK Stadtverband Saarbrücken</option>
<option value="10042" <?php echo ($districtKey=='10042')?'selected':''; ?>>LK Merzig-Wadern</option>
<option value="10043" <?php echo ($districtKey=='10043')?'selected':''; ?>>LK Neunkirchen</option>
<option value="10044" <?php echo ($districtKey=='10044')?'selected':''; ?>>LK Saarlouis</option>
<option value="10045" <?php echo ($districtKey=='10045')?'selected':''; ?>>LK Saarpfalz-Kreis</option>
<option value="10046" <?php echo ($districtKey=='10046')?'selected':''; ?>>LK Sankt Wendel</option>
<option value="11001" <?php echo ($districtKey=='11001')?'selected':''; ?>>SK Berlin Mitte</option>
<option value="11002" <?php echo ($districtKey=='11002')?'selected':''; ?>>SK Berlin Friedrichshain-Kreuzberg</option>
<option value="11003" <?php echo ($districtKey=='11003')?'selected':''; ?>>SK Berlin Pankow</option>
<option value="11004" <?php echo ($districtKey=='11004')?'selected':''; ?>>SK Berlin Charlottenburg-Wilmersdorf</option>
<option value="11005" <?php echo ($districtKey=='11005')?'selected':''; ?>>SK Berlin Spandau</option>
<option value="11006" <?php echo ($districtKey=='11006')?'selected':''; ?>>SK Berlin Steglitz-Zehlendorf</option>
<option value="11007" <?php echo ($districtKey=='11007')?'selected':''; ?>>SK Berlin Tempelhof-Schöneberg</option>
<option value="11008" <?php echo ($districtKey=='11008')?'selected':''; ?>>SK Berlin Neukölln</option>
<option value="11009" <?php echo ($districtKey=='11009')?'selected':''; ?>>SK Berlin Treptow-Köpenick</option>
<option value="11010" <?php echo ($districtKey=='11010')?'selected':''; ?>>SK Berlin Marzahn-Hellersdorf</option>
<option value="11011" <?php echo ($districtKey=='11011')?'selected':''; ?>>SK Berlin Lichtenberg</option>
<option value="11012" <?php echo ($districtKey=='11012')?'selected':''; ?>>SK Berlin Reinickendorf</option>
<option value="12052" <?php echo ($districtKey=='12052')?'selected':''; ?>>SK Cottbus</option>
<option value="12051" <?php echo ($districtKey=='12051')?'selected':''; ?>>SK Brandenburg a.d.Havel</option>
<option value="12053" <?php echo ($districtKey=='12053')?'selected':''; ?>>SK Frankfurt (Oder)</option>
<option value="12054" <?php echo ($districtKey=='12054')?'selected':''; ?>>SK Potsdam</option>
<option value="12060" <?php echo ($districtKey=='12060')?'selected':''; ?>>LK Barnim</option>
<option value="12061" <?php echo ($districtKey=='12061')?'selected':''; ?>>LK Dahme-Spreewald</option>
<option value="12062" <?php echo ($districtKey=='12062')?'selected':''; ?>>LK Elbe-Elster</option>
<option value="12063" <?php echo ($districtKey=='12063')?'selected':''; ?>>LK Havelland</option>
<option value="12064" <?php echo ($districtKey=='12064')?'selected':''; ?>>LK Märkisch-Oderland</option>
<option value="12065" <?php echo ($districtKey=='12065')?'selected':''; ?>>LK Oberhavel</option>
<option value="12066" <?php echo ($districtKey=='12066')?'selected':''; ?>>LK Oberspreewald-Lausitz</option>
<option value="12067" <?php echo ($districtKey=='12067')?'selected':''; ?>>LK Oder-Spree</option>
<option value="12068" <?php echo ($districtKey=='12068')?'selected':''; ?>>LK Ostprignitz-Ruppin</option>
<option value="12069" <?php echo ($districtKey=='12069')?'selected':''; ?>>LK Potsdam-Mittelmark</option>
<option value="12070" <?php echo ($districtKey=='12070')?'selected':''; ?>>LK Prignitz</option>
<option value="12071" <?php echo ($districtKey=='12071')?'selected':''; ?>>LK Spree-Neiße</option>
<option value="12072" <?php echo ($districtKey=='12072')?'selected':''; ?>>LK Teltow-Fläming</option>
<option value="12073" <?php echo ($districtKey=='12073')?'selected':''; ?>>LK Uckermark</option>
<option value="13003" <?php echo ($districtKey=='13003')?'selected':''; ?>>SK Rostock</option>
<option value="13004" <?php echo ($districtKey=='13004')?'selected':''; ?>>SK Schwerin</option>
<option value="13071" <?php echo ($districtKey=='13071')?'selected':''; ?>>LK Mecklenburgische Seenplatte</option>
<option value="13072" <?php echo ($districtKey=='13072')?'selected':''; ?>>LK Rostock</option>
<option value="13073" <?php echo ($districtKey=='13073')?'selected':''; ?>>LK Vorpommern-Rügen</option>
<option value="13074" <?php echo ($districtKey=='13074')?'selected':''; ?>>LK Nordwestmecklenburg</option>
<option value="13075" <?php echo ($districtKey=='13075')?'selected':''; ?>>LK Vorpommern-Greifswald</option>
<option value="13076" <?php echo ($districtKey=='13076')?'selected':''; ?>>LK Ludwigslust-Parchim</option>
<option value="14511" <?php echo ($districtKey=='14511')?'selected':''; ?>>SK Chemnitz</option>
<option value="14521" <?php echo ($districtKey=='14521')?'selected':''; ?>>LK Erzgebirgskreis</option>
<option value="14522" <?php echo ($districtKey=='14522')?'selected':''; ?>>LK Mittelsachsen</option>
<option value="14523" <?php echo ($districtKey=='14523')?'selected':''; ?>>LK Vogtlandkreis</option>
<option value="14524" <?php echo ($districtKey=='14524')?'selected':''; ?>>LK Zwickau</option>
<option value="14612" <?php echo ($districtKey=='14612')?'selected':''; ?>>SK Dresden</option>
<option value="14625" <?php echo ($districtKey=='14625')?'selected':''; ?>>LK Bautzen</option>
<option value="14626" <?php echo ($districtKey=='14626')?'selected':''; ?>>LK Görlitz</option>
<option value="14627" <?php echo ($districtKey=='14627')?'selected':''; ?>>LK Meißen</option>
<option value="14628" <?php echo ($districtKey=='14628')?'selected':''; ?>>LK Sächsische Schweiz-Osterzgebirge</option>
<option value="14713" <?php echo ($districtKey=='14713')?'selected':''; ?>>SK Leipzig</option>
<option value="14729" <?php echo ($districtKey=='14729')?'selected':''; ?>>LK Leipzig</option>
<option value="14730" <?php echo ($districtKey=='14730')?'selected':''; ?>>LK Nordsachsen</option>
<option value="15001" <?php echo ($districtKey=='15001')?'selected':''; ?>>SK Dessau-Roßlau</option>
<option value="15002" <?php echo ($districtKey=='15002')?'selected':''; ?>>SK Halle</option>
<option value="15003" <?php echo ($districtKey=='15003')?'selected':''; ?>>SK Magdeburg</option>
<option value="15081" <?php echo ($districtKey=='15081')?'selected':''; ?>>LK Altmarkkreis Salzwedel</option>
<option value="15082" <?php echo ($districtKey=='15082')?'selected':''; ?>>LK Anhalt-Bitterfeld</option>
<option value="15083" <?php echo ($districtKey=='15083')?'selected':''; ?>>LK Börde</option>
<option value="15084" <?php echo ($districtKey=='15084')?'selected':''; ?>>LK Burgenlandkreis</option>
<option value="15085" <?php echo ($districtKey=='15085')?'selected':''; ?>>LK Harz</option>
<option value="15086" <?php echo ($districtKey=='15086')?'selected':''; ?>>LK Jerichower Land</option>
<option value="15087" <?php echo ($districtKey=='15087')?'selected':''; ?>>LK Mansfeld-Südharz</option>
<option value="15088" <?php echo ($districtKey=='15088')?'selected':''; ?>>LK Saalekreis</option>
<option value="15089" <?php echo ($districtKey=='15089')?'selected':''; ?>>LK Salzlandkreis</option>
<option value="15090" <?php echo ($districtKey=='15090')?'selected':''; ?>>LK Stendal</option>
<option value="15091" <?php echo ($districtKey=='15091')?'selected':''; ?>>LK Wittenberg</option>
<option value="16051" <?php echo ($districtKey=='16051')?'selected':''; ?>>SK Erfurt</option>
<option value="16052" <?php echo ($districtKey=='16052')?'selected':''; ?>>SK Gera</option>
<option value="16053" <?php echo ($districtKey=='16053')?'selected':''; ?>>SK Jena</option>
<option value="16054" <?php echo ($districtKey=='16054')?'selected':''; ?>>SK Suhl</option>
<option value="16055" <?php echo ($districtKey=='16055')?'selected':''; ?>>SK Weimar</option>
<option value="16061" <?php echo ($districtKey=='16061')?'selected':''; ?>>LK Eichsfeld</option>
<option value="16056" <?php echo ($districtKey=='16056')?'selected':''; ?>>SK Eisenach</option>
<option value="16062" <?php echo ($districtKey=='16062')?'selected':''; ?>>LK Nordhausen</option>
<option value="16063" <?php echo ($districtKey=='16063')?'selected':''; ?>>LK Wartburgkreis</option>
<option value="16064" <?php echo ($districtKey=='16064')?'selected':''; ?>>LK Unstrut-Hainich-Kreis</option>
<option value="16065" <?php echo ($districtKey=='16065')?'selected':''; ?>>LK Kyffhäuserkreis</option>
<option value="16066" <?php echo ($districtKey=='16066')?'selected':''; ?>>LK Schmalkalden-Meiningen</option>
<option value="16067" <?php echo ($districtKey=='16067')?'selected':''; ?>>LK Gotha</option>
<option value="16068" <?php echo ($districtKey=='16068')?'selected':''; ?>>LK Sömmerda</option>
<option value="16069" <?php echo ($districtKey=='16069')?'selected':''; ?>>LK Hildburghausen</option>
<option value="16070" <?php echo ($districtKey=='16070')?'selected':''; ?>>LK Ilm-Kreis</option>
<option value="16071" <?php echo ($districtKey=='16071')?'selected':''; ?>>LK Weimarer Land</option>
<option value="16072" <?php echo ($districtKey=='16072')?'selected':''; ?>>LK Sonneberg</option>
<option value="16073" <?php echo ($districtKey=='16073')?'selected':''; ?>>LK Saalfeld-Rudolstadt</option>
<option value="16074" <?php echo ($districtKey=='16074')?'selected':''; ?>>LK Saale-Holzland-Kreis</option>
<option value="16075" <?php echo ($districtKey=='16075')?'selected':''; ?>>LK Saale-Orla-Kreis</option>
<option value="16076" <?php echo ($districtKey=='16076')?'selected':''; ?>>LK Greiz</option>
<option value="16077" <?php echo ($districtKey=='16077')?'selected':''; ?>>LK Altenburger Land</option>

</select>
</p>





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