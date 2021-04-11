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
defined( 'ABSPATH') or die('You are not allowed to be here');

/*********************************************************************************
Enqueue stylesheet
*********************************************************************************/
function enqueueMyStyles() {
	// 
	wp_register_style( 'widget_c197di_css', plugins_url( 'css/style.css', __FILE__ ) );
    wp_enqueue_style( 'widget_c197di_css' );
 
}
add_action( 'wp_enqueue_scripts', 'enqueueMyStyles' );

class covid19_weekly_incidences_widget extends WP_Widget {
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
}

class Covid19InzidenzAmpel extends WP_Widget {
	// constructor
	function Covid19InzidenzAmpel() {
		parent::WP_Widget(false, $name = __('Covid-19 Inzidenz Ampel', 'Covid19InzidenzAmpel') );
	}

	
	// function to output the widget form: title and landkreis number
	function form( $instance ) {
		//print_r($instance);

		// just two controls: title and district
		$title = ! empty( $instance['title'] ) ? $instance['title'] : 'Stuttgart';
		$districtKey = ! empty( $instance['districtKey'] ) ? $instance['districtKey'] : '08111';
	   ?>
	   
	   	<p>
		<label for="<?php echo $this->get_field_id( 'title'); ?>">Titel:</label>
		<input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'districtKey'); ?>">Allgemeiner Gemeindeschlüssel:</label>   
		<select class='widefat' id="<?php echo $this->get_field_id('districtKey'); ?>"
                name="<?php echo $this->get_field_name('districtKey'); ?>" type="text">
			<option value="01001" <?php echo ($districtKey=='01001')?'selected':''; ?>>Flensburg</option>
			<option value="01002" <?php echo ($districtKey=='01002')?'selected':''; ?>>Kiel</option>
			<option value="01003" <?php echo ($districtKey=='01003')?'selected':''; ?>>Lübeck</option>
			<option value="01004" <?php echo ($districtKey=='01004')?'selected':''; ?>>Neumünster</option>
			<option value="01051" <?php echo ($districtKey=='01051')?'selected':''; ?>>Dithmarschen</option>
			<option value="01053" <?php echo ($districtKey=='01053')?'selected':''; ?>>Herzogtum Lauenburg</option>
			<option value="01054" <?php echo ($districtKey=='01054')?'selected':''; ?>>Nordfriesland</option>
			<option value="01055" <?php echo ($districtKey=='01055')?'selected':''; ?>>Ostholstein</option>
			<option value="01056" <?php echo ($districtKey=='01056')?'selected':''; ?>>Pinneberg</option>
			<option value="01058" <?php echo ($districtKey=='01058')?'selected':''; ?>>Rendsburg-Eckernförde</option>
			<option value="01057" <?php echo ($districtKey=='01057')?'selected':''; ?>>Plön</option>
			<option value="01059" <?php echo ($districtKey=='01059')?'selected':''; ?>>Schleswig-Flensburg</option>
			<option value="01060" <?php echo ($districtKey=='01060')?'selected':''; ?>>Segeberg</option>
			<option value="01061" <?php echo ($districtKey=='01061')?'selected':''; ?>>Steinburg</option>
			<option value="01062" <?php echo ($districtKey=='01062')?'selected':''; ?>>Stormarn</option>
			<option value="02000" <?php echo ($districtKey=='02000')?'selected':''; ?>>Hamburg</option>
			<option value="03101" <?php echo ($districtKey=='03101')?'selected':''; ?>>Braunschweig</option>
			<option value="03102" <?php echo ($districtKey=='03102')?'selected':''; ?>>Salzgitter</option>
			<option value="03103" <?php echo ($districtKey=='03103')?'selected':''; ?>>Wolfsburg</option>
			<option value="03151" <?php echo ($districtKey=='03151')?'selected':''; ?>>Gifhorn</option>
			<option value="03153" <?php echo ($districtKey=='03153')?'selected':''; ?>>Goslar</option>
			<option value="03154" <?php echo ($districtKey=='03154')?'selected':''; ?>>Helmstedt</option>
			<option value="03155" <?php echo ($districtKey=='03155')?'selected':''; ?>>Northeim</option>
			<option value="03157" <?php echo ($districtKey=='03157')?'selected':''; ?>>Peine</option>
			<option value="03158" <?php echo ($districtKey=='03158')?'selected':''; ?>>Wolfenbüttel</option>
			<option value="03159" <?php echo ($districtKey=='03159')?'selected':''; ?>>Göttingen</option>
			<option value="03241" <?php echo ($districtKey=='03241')?'selected':''; ?>>Region Hannover</option>
			<option value="03251" <?php echo ($districtKey=='03251')?'selected':''; ?>>Diepholz</option>
			<option value="03252" <?php echo ($districtKey=='03252')?'selected':''; ?>>Hameln-Pyrmont</option>
			<option value="03254" <?php echo ($districtKey=='03254')?'selected':''; ?>>Hildesheim</option>
			<option value="03255" <?php echo ($districtKey=='03255')?'selected':''; ?>>Holzminden</option>
			<option value="03256" <?php echo ($districtKey=='03256')?'selected':''; ?>>Nienburg (Weser)</option>
			<option value="03257" <?php echo ($districtKey=='03257')?'selected':''; ?>>Schaumburg</option>
			<option value="03351" <?php echo ($districtKey=='03351')?'selected':''; ?>>Celle</option>
			<option value="03352" <?php echo ($districtKey=='03352')?'selected':''; ?>>Cuxhaven</option>
			<option value="03353" <?php echo ($districtKey=='03353')?'selected':''; ?>>Harburg</option>
			<option value="03354" <?php echo ($districtKey=='03354')?'selected':''; ?>>Lüchow-Dannenberg</option>
			<option value="03355" <?php echo ($districtKey=='03355')?'selected':''; ?>>Lüneburg</option>
			<option value="03356" <?php echo ($districtKey=='03356')?'selected':''; ?>>Osterholz</option>
			<option value="03357" <?php echo ($districtKey=='03357')?'selected':''; ?>>Rotenburg (Wümme)</option>
			<option value="03358" <?php echo ($districtKey=='03358')?'selected':''; ?>>Heidekreis</option>
			<option value="03359" <?php echo ($districtKey=='03359')?'selected':''; ?>>Stade</option>
			<option value="03360" <?php echo ($districtKey=='03360')?'selected':''; ?>>Uelzen</option>
			<option value="03361" <?php echo ($districtKey=='03361')?'selected':''; ?>>Verden</option>
			<option value="03401" <?php echo ($districtKey=='03401')?'selected':''; ?>>Delmenhorst</option>
			<option value="03403" <?php echo ($districtKey=='03403')?'selected':''; ?>>Oldenburg</option>
			<option value="03402" <?php echo ($districtKey=='03402')?'selected':''; ?>>Emden</option>
			<option value="03404" <?php echo ($districtKey=='03404')?'selected':''; ?>>Osnabrück</option>
			<option value="03405" <?php echo ($districtKey=='03405')?'selected':''; ?>>Wilhelmshaven</option>
			<option value="03451" <?php echo ($districtKey=='03451')?'selected':''; ?>>Ammerland</option>
			<option value="03452" <?php echo ($districtKey=='03452')?'selected':''; ?>>Aurich</option>
			<option value="03453" <?php echo ($districtKey=='03453')?'selected':''; ?>>Cloppenburg</option>
			<option value="03454" <?php echo ($districtKey=='03454')?'selected':''; ?>>Emsland</option>
			<option value="03455" <?php echo ($districtKey=='03455')?'selected':''; ?>>Friesland</option>
			<option value="03456" <?php echo ($districtKey=='03456')?'selected':''; ?>>Grafschaft Bentheim</option>
			<option value="03457" <?php echo ($districtKey=='03457')?'selected':''; ?>>Leer</option>
			<option value="03458" <?php echo ($districtKey=='03458')?'selected':''; ?>>Oldenburg</option>
			<option value="03459" <?php echo ($districtKey=='03459')?'selected':''; ?>>Osnabrück</option>
			<option value="03460" <?php echo ($districtKey=='03460')?'selected':''; ?>>Vechta</option>
			<option value="03461" <?php echo ($districtKey=='03461')?'selected':''; ?>>Wesermarsch</option>
			<option value="03462" <?php echo ($districtKey=='03462')?'selected':''; ?>>Wittmund</option>
			<option value="04011" <?php echo ($districtKey=='04011')?'selected':''; ?>>Bremen</option>
			<option value="04012" <?php echo ($districtKey=='04012')?'selected':''; ?>>Bremerhaven</option>
			<option value="05111" <?php echo ($districtKey=='05111')?'selected':''; ?>>Düsseldorf</option>
			<option value="05112" <?php echo ($districtKey=='05112')?'selected':''; ?>>Duisburg</option>
			<option value="05113" <?php echo ($districtKey=='05113')?'selected':''; ?>>Essen</option>
			<option value="05114" <?php echo ($districtKey=='05114')?'selected':''; ?>>Krefeld</option>
			<option value="05116" <?php echo ($districtKey=='05116')?'selected':''; ?>>Mönchengladbach</option>
			<option value="05117" <?php echo ($districtKey=='05117')?'selected':''; ?>>Mülheim a.d.Ruhr</option>
			<option value="05119" <?php echo ($districtKey=='05119')?'selected':''; ?>>Oberhausen</option>
			<option value="05120" <?php echo ($districtKey=='05120')?'selected':''; ?>>Remscheid</option>
			<option value="05122" <?php echo ($districtKey=='05122')?'selected':''; ?>>Solingen</option>
			<option value="05124" <?php echo ($districtKey=='05124')?'selected':''; ?>>Wuppertal</option>
			<option value="05154" <?php echo ($districtKey=='05154')?'selected':''; ?>>Kleve</option>
			<option value="05158" <?php echo ($districtKey=='05158')?'selected':''; ?>>Mettmann</option>
			<option value="05162" <?php echo ($districtKey=='05162')?'selected':''; ?>>Rhein-Kreis Neuss</option>
			<option value="05166" <?php echo ($districtKey=='05166')?'selected':''; ?>>Viersen</option>
			<option value="05170" <?php echo ($districtKey=='05170')?'selected':''; ?>>Wesel</option>
			<option value="05314" <?php echo ($districtKey=='05314')?'selected':''; ?>>Bonn</option>
			<option value="05315" <?php echo ($districtKey=='05315')?'selected':''; ?>>Köln</option>
			<option value="05316" <?php echo ($districtKey=='05316')?'selected':''; ?>>Leverkusen</option>
			<option value="05334" <?php echo ($districtKey=='05334')?'selected':''; ?>>StadtRegion Aachen</option>
			<option value="05358" <?php echo ($districtKey=='05358')?'selected':''; ?>>Düren</option>
			<option value="05362" <?php echo ($districtKey=='05362')?'selected':''; ?>>Rhein-Erft-Kreis</option>
			<option value="05366" <?php echo ($districtKey=='05366')?'selected':''; ?>>Euskirchen</option>
			<option value="05370" <?php echo ($districtKey=='05370')?'selected':''; ?>>Heinsberg</option>
			<option value="05374" <?php echo ($districtKey=='05374')?'selected':''; ?>>Oberbergischer Kreis</option>
			<option value="05378" <?php echo ($districtKey=='05378')?'selected':''; ?>>Rheinisch-Bergischer Kreis</option>
			<option value="05382" <?php echo ($districtKey=='05382')?'selected':''; ?>>Rhein-Sieg-Kreis</option>
			<option value="05512" <?php echo ($districtKey=='05512')?'selected':''; ?>>Bottrop</option>
			<option value="05513" <?php echo ($districtKey=='05513')?'selected':''; ?>>Gelsenkirchen</option>
			<option value="05515" <?php echo ($districtKey=='05515')?'selected':''; ?>>Münster</option>
			<option value="05554" <?php echo ($districtKey=='05554')?'selected':''; ?>>Borken</option>
			<option value="05558" <?php echo ($districtKey=='05558')?'selected':''; ?>>Coesfeld</option>
			<option value="05562" <?php echo ($districtKey=='05562')?'selected':''; ?>>Recklinghausen</option>
			<option value="05566" <?php echo ($districtKey=='05566')?'selected':''; ?>>Steinfurt</option>
			<option value="05570" <?php echo ($districtKey=='05570')?'selected':''; ?>>Warendorf</option>
			<option value="05711" <?php echo ($districtKey=='05711')?'selected':''; ?>>Bielefeld</option>
			<option value="05754" <?php echo ($districtKey=='05754')?'selected':''; ?>>Gütersloh</option>
			<option value="05758" <?php echo ($districtKey=='05758')?'selected':''; ?>>Herford</option>
			<option value="05762" <?php echo ($districtKey=='05762')?'selected':''; ?>>Höxter</option>
			<option value="05766" <?php echo ($districtKey=='05766')?'selected':''; ?>>Lippe</option>
			<option value="05770" <?php echo ($districtKey=='05770')?'selected':''; ?>>Minden-Lübbecke</option>
			<option value="05774" <?php echo ($districtKey=='05774')?'selected':''; ?>>Paderborn</option>
			<option value="05911" <?php echo ($districtKey=='05911')?'selected':''; ?>>Bochum</option>
			<option value="05913" <?php echo ($districtKey=='05913')?'selected':''; ?>>Dortmund</option>
			<option value="05914" <?php echo ($districtKey=='05914')?'selected':''; ?>>Hagen</option>
			<option value="05915" <?php echo ($districtKey=='05915')?'selected':''; ?>>Hamm</option>
			<option value="05916" <?php echo ($districtKey=='05916')?'selected':''; ?>>Herne</option>
			<option value="05954" <?php echo ($districtKey=='05954')?'selected':''; ?>>Ennepe-Ruhr-Kreis</option>
			<option value="05958" <?php echo ($districtKey=='05958')?'selected':''; ?>>Hochsauerlandkreis</option>
			<option value="05962" <?php echo ($districtKey=='05962')?'selected':''; ?>>Märkischer Kreis</option>
			<option value="05966" <?php echo ($districtKey=='05966')?'selected':''; ?>>Olpe</option>
			<option value="05970" <?php echo ($districtKey=='05970')?'selected':''; ?>>Siegen-Wittgenstein</option>
			<option value="05974" <?php echo ($districtKey=='05974')?'selected':''; ?>>Soest</option>
			<option value="05978" <?php echo ($districtKey=='05978')?'selected':''; ?>>Unna</option>
			<option value="06411" <?php echo ($districtKey=='06411')?'selected':''; ?>>Darmstadt</option>
			<option value="06412" <?php echo ($districtKey=='06412')?'selected':''; ?>>Frankfurt am Main</option>
			<option value="06413" <?php echo ($districtKey=='06413')?'selected':''; ?>>Offenbach</option>
			<option value="06414" <?php echo ($districtKey=='06414')?'selected':''; ?>>Wiesbaden</option>
			<option value="06431" <?php echo ($districtKey=='06431')?'selected':''; ?>>Bergstraße</option>
			<option value="06432" <?php echo ($districtKey=='06432')?'selected':''; ?>>Darmstadt-Dieburg</option>
			<option value="06433" <?php echo ($districtKey=='06433')?'selected':''; ?>>Groß-Gerau</option>
			<option value="06434" <?php echo ($districtKey=='06434')?'selected':''; ?>>Hochtaunuskreis</option>
			<option value="06435" <?php echo ($districtKey=='06435')?'selected':''; ?>>Main-Kinzig-Kreis</option>
			<option value="06436" <?php echo ($districtKey=='06436')?'selected':''; ?>>Main-Taunus-Kreis</option>
			<option value="06437" <?php echo ($districtKey=='06437')?'selected':''; ?>>Odenwaldkreis</option>
			<option value="06438" <?php echo ($districtKey=='06438')?'selected':''; ?>>Offenbach</option>
			<option value="06439" <?php echo ($districtKey=='06439')?'selected':''; ?>>Rheingau-Taunus-Kreis</option>
			<option value="06440" <?php echo ($districtKey=='06440')?'selected':''; ?>>Wetteraukreis</option>
			<option value="06531" <?php echo ($districtKey=='06531')?'selected':''; ?>>Gießen</option>
			<option value="06532" <?php echo ($districtKey=='06532')?'selected':''; ?>>Lahn-Dill-Kreis</option>
			<option value="06533" <?php echo ($districtKey=='06533')?'selected':''; ?>>Limburg-Weilburg</option>
			<option value="06534" <?php echo ($districtKey=='06534')?'selected':''; ?>>Marburg-Biedenkopf</option>
			<option value="06535" <?php echo ($districtKey=='06535')?'selected':''; ?>>Vogelsbergkreis</option>
			<option value="06611" <?php echo ($districtKey=='06611')?'selected':''; ?>>Kassel</option>
			<option value="06631" <?php echo ($districtKey=='06631')?'selected':''; ?>>Fulda</option>
			<option value="06632" <?php echo ($districtKey=='06632')?'selected':''; ?>>Hersfeld-Rotenburg</option>
			<option value="06633" <?php echo ($districtKey=='06633')?'selected':''; ?>>Kassel</option>
			<option value="06634" <?php echo ($districtKey=='06634')?'selected':''; ?>>Schwalm-Eder-Kreis</option>
			<option value="06635" <?php echo ($districtKey=='06635')?'selected':''; ?>>Waldeck-Frankenberg</option>
			<option value="06636" <?php echo ($districtKey=='06636')?'selected':''; ?>>Werra-Meißner-Kreis</option>
			<option value="07131" <?php echo ($districtKey=='07131')?'selected':''; ?>>Ahrweiler</option>
			<option value="07111" <?php echo ($districtKey=='07111')?'selected':''; ?>>Koblenz</option>
			<option value="07132" <?php echo ($districtKey=='07132')?'selected':''; ?>>Altenkirchen</option>
			<option value="07133" <?php echo ($districtKey=='07133')?'selected':''; ?>>Bad Kreuznach</option>
			<option value="07134" <?php echo ($districtKey=='07134')?'selected':''; ?>>Birkenfeld</option>
			<option value="07135" <?php echo ($districtKey=='07135')?'selected':''; ?>>Cochem-Zell</option>
			<option value="07137" <?php echo ($districtKey=='07137')?'selected':''; ?>>Mayen-Koblenz</option>
			<option value="07138" <?php echo ($districtKey=='07138')?'selected':''; ?>>Neuwied</option>
			<option value="07140" <?php echo ($districtKey=='07140')?'selected':''; ?>>Rhein-Hunsrück-Kreis</option>
			<option value="07141" <?php echo ($districtKey=='07141')?'selected':''; ?>>Rhein-Lahn-Kreis</option>
			<option value="07143" <?php echo ($districtKey=='07143')?'selected':''; ?>>Westerwaldkreis</option>
			<option value="07211" <?php echo ($districtKey=='07211')?'selected':''; ?>>Trier</option>
			<option value="07231" <?php echo ($districtKey=='07231')?'selected':''; ?>>Bernkastel-Wittlich</option>
			<option value="07232" <?php echo ($districtKey=='07232')?'selected':''; ?>>Bitburg-Prüm</option>
			<option value="07233" <?php echo ($districtKey=='07233')?'selected':''; ?>>Vulkaneifel</option>
			<option value="07235" <?php echo ($districtKey=='07235')?'selected':''; ?>>Trier-Saarburg</option>
			<option value="07311" <?php echo ($districtKey=='07311')?'selected':''; ?>>Frankenthal</option>
			<option value="07312" <?php echo ($districtKey=='07312')?'selected':''; ?>>Kaiserslautern</option>
			<option value="07314" <?php echo ($districtKey=='07314')?'selected':''; ?>>Ludwigshafen</option>
			<option value="07313" <?php echo ($districtKey=='07313')?'selected':''; ?>>Landau i.d.Pfalz</option>
			<option value="07315" <?php echo ($districtKey=='07315')?'selected':''; ?>>Mainz</option>
			<option value="07316" <?php echo ($districtKey=='07316')?'selected':''; ?>>Neustadt a.d.Weinstraße</option>
			<option value="07317" <?php echo ($districtKey=='07317')?'selected':''; ?>>Pirmasens</option>
			<option value="07318" <?php echo ($districtKey=='07318')?'selected':''; ?>>Speyer</option>
			<option value="07319" <?php echo ($districtKey=='07319')?'selected':''; ?>>Worms</option>
			<option value="07331" <?php echo ($districtKey=='07331')?'selected':''; ?>>Alzey-Worms</option>
			<option value="07320" <?php echo ($districtKey=='07320')?'selected':''; ?>>Zweibrücken</option>
			<option value="07332" <?php echo ($districtKey=='07332')?'selected':''; ?>>Bad Dürkheim</option>
			<option value="07333" <?php echo ($districtKey=='07333')?'selected':''; ?>>Donnersbergkreis</option>
			<option value="07334" <?php echo ($districtKey=='07334')?'selected':''; ?>>Germersheim</option>
			<option value="07335" <?php echo ($districtKey=='07335')?'selected':''; ?>>Kaiserslautern</option>
			<option value="07337" <?php echo ($districtKey=='07337')?'selected':''; ?>>Südliche Weinstraße</option>
			<option value="07336" <?php echo ($districtKey=='07336')?'selected':''; ?>>Kusel</option>
			<option value="07338" <?php echo ($districtKey=='07338')?'selected':''; ?>>Rhein-Pfalz-Kreis</option>
			<option value="07339" <?php echo ($districtKey=='07339')?'selected':''; ?>>Mainz-Bingen</option>
			<option value="07340" <?php echo ($districtKey=='07340')?'selected':''; ?>>Südwestpfalz</option>
			<option value="08111" <?php echo ($districtKey=='08111')?'selected':''; ?>>Stuttgart</option>
			<option value="08115" <?php echo ($districtKey=='08115')?'selected':''; ?>>Böblingen</option>
			<option value="08116" <?php echo ($districtKey=='08116')?'selected':''; ?>>Esslingen</option>
			<option value="08117" <?php echo ($districtKey=='08117')?'selected':''; ?>>Göppingen</option>
			<option value="08118" <?php echo ($districtKey=='08118')?'selected':''; ?>>Ludwigsburg</option>
			<option value="08119" <?php echo ($districtKey=='08119')?'selected':''; ?>>Rems-Murr-Kreis</option>
			<option value="08121" <?php echo ($districtKey=='08121')?'selected':''; ?>>Heilbronn</option>
			<option value="08125" <?php echo ($districtKey=='08125')?'selected':''; ?>>Heilbronn</option>
			<option value="08126" <?php echo ($districtKey=='08126')?'selected':''; ?>>Hohenlohekreis</option>
			<option value="08127" <?php echo ($districtKey=='08127')?'selected':''; ?>>Schwäbisch Hall</option>
			<option value="08128" <?php echo ($districtKey=='08128')?'selected':''; ?>>Main-Tauber-Kreis</option>
			<option value="08135" <?php echo ($districtKey=='08135')?'selected':''; ?>>Heidenheim</option>
			<option value="08136" <?php echo ($districtKey=='08136')?'selected':''; ?>>Ostalbkreis</option>
			<option value="08211" <?php echo ($districtKey=='08211')?'selected':''; ?>>Baden-Baden</option>
			<option value="08212" <?php echo ($districtKey=='08212')?'selected':''; ?>>Karlsruhe</option>
			<option value="08215" <?php echo ($districtKey=='08215')?'selected':''; ?>>Karlsruhe</option>
			<option value="08216" <?php echo ($districtKey=='08216')?'selected':''; ?>>Rastatt</option>
			<option value="08221" <?php echo ($districtKey=='08221')?'selected':''; ?>>Heidelberg</option>
			<option value="08222" <?php echo ($districtKey=='08222')?'selected':''; ?>>Mannheim</option>
			<option value="08225" <?php echo ($districtKey=='08225')?'selected':''; ?>>Neckar-Odenwald-Kreis</option>
			<option value="08226" <?php echo ($districtKey=='08226')?'selected':''; ?>>Rhein-Neckar-Kreis</option>
			<option value="08231" <?php echo ($districtKey=='08231')?'selected':''; ?>>Pforzheim</option>
			<option value="08235" <?php echo ($districtKey=='08235')?'selected':''; ?>>Calw</option>
			<option value="08236" <?php echo ($districtKey=='08236')?'selected':''; ?>>Enzkreis</option>
			<option value="08237" <?php echo ($districtKey=='08237')?'selected':''; ?>>Freudenstadt</option>
			<option value="08311" <?php echo ($districtKey=='08311')?'selected':''; ?>>Freiburg i.Breisgau</option>
			<option value="08315" <?php echo ($districtKey=='08315')?'selected':''; ?>>Breisgau-Hochschwarzwald</option>
			<option value="08316" <?php echo ($districtKey=='08316')?'selected':''; ?>>Emmendingen</option>
			<option value="08317" <?php echo ($districtKey=='08317')?'selected':''; ?>>Ortenaukreis</option>
			<option value="08325" <?php echo ($districtKey=='08325')?'selected':''; ?>>Rottweil</option>
			<option value="08326" <?php echo ($districtKey=='08326')?'selected':''; ?>>Schwarzwald-Baar-Kreis</option>
			<option value="08327" <?php echo ($districtKey=='08327')?'selected':''; ?>>Tuttlingen</option>
			<option value="08335" <?php echo ($districtKey=='08335')?'selected':''; ?>>Konstanz</option>
			<option value="08336" <?php echo ($districtKey=='08336')?'selected':''; ?>>Lörrach</option>
			<option value="08337" <?php echo ($districtKey=='08337')?'selected':''; ?>>Waldshut</option>
			<option value="08415" <?php echo ($districtKey=='08415')?'selected':''; ?>>Reutlingen</option>
			<option value="08416" <?php echo ($districtKey=='08416')?'selected':''; ?>>Tübingen</option>
			<option value="08417" <?php echo ($districtKey=='08417')?'selected':''; ?>>Zollernalbkreis</option>
			<option value="08421" <?php echo ($districtKey=='08421')?'selected':''; ?>>Ulm</option>
			<option value="08425" <?php echo ($districtKey=='08425')?'selected':''; ?>>Alb-Donau-Kreis</option>
			<option value="08426" <?php echo ($districtKey=='08426')?'selected':''; ?>>Biberach</option>
			<option value="08435" <?php echo ($districtKey=='08435')?'selected':''; ?>>Bodenseekreis</option>
			<option value="08436" <?php echo ($districtKey=='08436')?'selected':''; ?>>Ravensburg</option>
			<option value="08437" <?php echo ($districtKey=='08437')?'selected':''; ?>>Sigmaringen</option>
			<option value="09161" <?php echo ($districtKey=='09161')?'selected':''; ?>>Ingolstadt</option>
			<option value="09162" <?php echo ($districtKey=='09162')?'selected':''; ?>>München</option>
			<option value="09163" <?php echo ($districtKey=='09163')?'selected':''; ?>>Rosenheim</option>
			<option value="09171" <?php echo ($districtKey=='09171')?'selected':''; ?>>Altötting</option>
			<option value="09172" <?php echo ($districtKey=='09172')?'selected':''; ?>>Berchtesgadener Land</option>
			<option value="09173" <?php echo ($districtKey=='09173')?'selected':''; ?>>Bad Tölz-Wolfratshausen</option>
			<option value="09174" <?php echo ($districtKey=='09174')?'selected':''; ?>>Dachau</option>
			<option value="09175" <?php echo ($districtKey=='09175')?'selected':''; ?>>Ebersberg</option>
			<option value="09176" <?php echo ($districtKey=='09176')?'selected':''; ?>>Eichstätt</option>
			<option value="09177" <?php echo ($districtKey=='09177')?'selected':''; ?>>Erding</option>
			<option value="09178" <?php echo ($districtKey=='09178')?'selected':''; ?>>Freising</option>
			<option value="09179" <?php echo ($districtKey=='09179')?'selected':''; ?>>Fürstenfeldbruck</option>
			<option value="09180" <?php echo ($districtKey=='09180')?'selected':''; ?>>Garmisch-Partenkirchen</option>
			<option value="09181" <?php echo ($districtKey=='09181')?'selected':''; ?>>Landsberg a.Lech</option>
			<option value="09182" <?php echo ($districtKey=='09182')?'selected':''; ?>>Miesbach</option>
			<option value="09183" <?php echo ($districtKey=='09183')?'selected':''; ?>>Mühldorf a.Inn</option>
			<option value="09184" <?php echo ($districtKey=='09184')?'selected':''; ?>>München</option>
			<option value="09185" <?php echo ($districtKey=='09185')?'selected':''; ?>>Neuburg-Schrobenhausen</option>
			<option value="09186" <?php echo ($districtKey=='09186')?'selected':''; ?>>Pfaffenhofen a.d.Ilm</option>
			<option value="09187" <?php echo ($districtKey=='09187')?'selected':''; ?>>Rosenheim</option>
			<option value="09188" <?php echo ($districtKey=='09188')?'selected':''; ?>>Starnberg</option>
			<option value="09189" <?php echo ($districtKey=='09189')?'selected':''; ?>>Traunstein</option>
			<option value="09190" <?php echo ($districtKey=='09190')?'selected':''; ?>>Weilheim-Schongau</option>
			<option value="09261" <?php echo ($districtKey=='09261')?'selected':''; ?>>Landshut</option>
			<option value="09262" <?php echo ($districtKey=='09262')?'selected':''; ?>>Passau</option>
			<option value="09263" <?php echo ($districtKey=='09263')?'selected':''; ?>>Straubing</option>
			<option value="09271" <?php echo ($districtKey=='09271')?'selected':''; ?>>Deggendorf</option>
			<option value="09272" <?php echo ($districtKey=='09272')?'selected':''; ?>>Freyung-Grafenau</option>
			<option value="09273" <?php echo ($districtKey=='09273')?'selected':''; ?>>Kelheim</option>
			<option value="09274" <?php echo ($districtKey=='09274')?'selected':''; ?>>Landshut</option>
			<option value="09275" <?php echo ($districtKey=='09275')?'selected':''; ?>>Passau</option>
			<option value="09276" <?php echo ($districtKey=='09276')?'selected':''; ?>>Regen</option>
			<option value="09277" <?php echo ($districtKey=='09277')?'selected':''; ?>>Rottal-Inn</option>
			<option value="09278" <?php echo ($districtKey=='09278')?'selected':''; ?>>Straubing-Bogen</option>
			<option value="09279" <?php echo ($districtKey=='09279')?'selected':''; ?>>Dingolfing-Landau</option>
			<option value="09361" <?php echo ($districtKey=='09361')?'selected':''; ?>>Amberg</option>
			<option value="09362" <?php echo ($districtKey=='09362')?'selected':''; ?>>Regensburg</option>
			<option value="09363" <?php echo ($districtKey=='09363')?'selected':''; ?>>Weiden i.d.OPf.</option>
			<option value="09371" <?php echo ($districtKey=='09371')?'selected':''; ?>>Amberg-Sulzbach</option>
			<option value="09372" <?php echo ($districtKey=='09372')?'selected':''; ?>>Cham</option>
			<option value="09373" <?php echo ($districtKey=='09373')?'selected':''; ?>>Neumarkt i.d.OPf.</option>
			<option value="09374" <?php echo ($districtKey=='09374')?'selected':''; ?>>Neustadt a.d.Waldnaab</option>
			<option value="09375" <?php echo ($districtKey=='09375')?'selected':''; ?>>Regensburg</option>
			<option value="09376" <?php echo ($districtKey=='09376')?'selected':''; ?>>Schwandorf</option>
			<option value="09377" <?php echo ($districtKey=='09377')?'selected':''; ?>>Tirschenreuth</option>
			<option value="09461" <?php echo ($districtKey=='09461')?'selected':''; ?>>Bamberg</option>
			<option value="09462" <?php echo ($districtKey=='09462')?'selected':''; ?>>Bayreuth</option>
			<option value="09463" <?php echo ($districtKey=='09463')?'selected':''; ?>>Coburg</option>
			<option value="09464" <?php echo ($districtKey=='09464')?'selected':''; ?>>Hof</option>
			<option value="09471" <?php echo ($districtKey=='09471')?'selected':''; ?>>Bamberg</option>
			<option value="09472" <?php echo ($districtKey=='09472')?'selected':''; ?>>Bayreuth</option>
			<option value="09473" <?php echo ($districtKey=='09473')?'selected':''; ?>>Coburg</option>
			<option value="09474" <?php echo ($districtKey=='09474')?'selected':''; ?>>Forchheim</option>
			<option value="09475" <?php echo ($districtKey=='09475')?'selected':''; ?>>Hof</option>
			<option value="09476" <?php echo ($districtKey=='09476')?'selected':''; ?>>Kronach</option>
			<option value="09477" <?php echo ($districtKey=='09477')?'selected':''; ?>>Kulmbach</option>
			<option value="09478" <?php echo ($districtKey=='09478')?'selected':''; ?>>Lichtenfels</option>
			<option value="09479" <?php echo ($districtKey=='09479')?'selected':''; ?>>Wunsiedel i.Fichtelgebirge</option>
			<option value="09561" <?php echo ($districtKey=='09561')?'selected':''; ?>>Ansbach</option>
			<option value="09562" <?php echo ($districtKey=='09562')?'selected':''; ?>>Erlangen</option>
			<option value="09563" <?php echo ($districtKey=='09563')?'selected':''; ?>>Fürth</option>
			<option value="09564" <?php echo ($districtKey=='09564')?'selected':''; ?>>Nürnberg</option>
			<option value="09565" <?php echo ($districtKey=='09565')?'selected':''; ?>>Schwabach</option>
			<option value="09571" <?php echo ($districtKey=='09571')?'selected':''; ?>>Ansbach</option>
			<option value="09572" <?php echo ($districtKey=='09572')?'selected':''; ?>>Erlangen-Höchstadt</option>
			<option value="09573" <?php echo ($districtKey=='09573')?'selected':''; ?>>Fürth</option>
			<option value="09574" <?php echo ($districtKey=='09574')?'selected':''; ?>>Nürnberger Land</option>
			<option value="09575" <?php echo ($districtKey=='09575')?'selected':''; ?>>Neustadt a.d.Aisch-Bad Windsheim</option>
			<option value="09576" <?php echo ($districtKey=='09576')?'selected':''; ?>>Roth</option>
			<option value="09577" <?php echo ($districtKey=='09577')?'selected':''; ?>>Weißenburg-Gunzenhausen</option>
			<option value="09661" <?php echo ($districtKey=='09661')?'selected':''; ?>>Aschaffenburg</option>
			<option value="09663" <?php echo ($districtKey=='09663')?'selected':''; ?>>Würzburg</option>
			<option value="09662" <?php echo ($districtKey=='09662')?'selected':''; ?>>Schweinfurt</option>
			<option value="09671" <?php echo ($districtKey=='09671')?'selected':''; ?>>Aschaffenburg</option>
			<option value="09672" <?php echo ($districtKey=='09672')?'selected':''; ?>>Bad Kissingen</option>
			<option value="09673" <?php echo ($districtKey=='09673')?'selected':''; ?>>Rhön-Grabfeld</option>
			<option value="09674" <?php echo ($districtKey=='09674')?'selected':''; ?>>Haßberge</option>
			<option value="09675" <?php echo ($districtKey=='09675')?'selected':''; ?>>Kitzingen</option>
			<option value="09676" <?php echo ($districtKey=='09676')?'selected':''; ?>>Miltenberg</option>
			<option value="09677" <?php echo ($districtKey=='09677')?'selected':''; ?>>Main-Spessart</option>
			<option value="09678" <?php echo ($districtKey=='09678')?'selected':''; ?>>Schweinfurt</option>
			<option value="09679" <?php echo ($districtKey=='09679')?'selected':''; ?>>Würzburg</option>
			<option value="09761" <?php echo ($districtKey=='09761')?'selected':''; ?>>Augsburg</option>
			<option value="09762" <?php echo ($districtKey=='09762')?'selected':''; ?>>Kaufbeuren</option>
			<option value="09763" <?php echo ($districtKey=='09763')?'selected':''; ?>>Kempten</option>
			<option value="09764" <?php echo ($districtKey=='09764')?'selected':''; ?>>Memmingen</option>
			<option value="09771" <?php echo ($districtKey=='09771')?'selected':''; ?>>Aichach-Friedberg</option>
			<option value="09772" <?php echo ($districtKey=='09772')?'selected':''; ?>>Augsburg</option>
			<option value="09773" <?php echo ($districtKey=='09773')?'selected':''; ?>>Dillingen a.d.Donau</option>
			<option value="09774" <?php echo ($districtKey=='09774')?'selected':''; ?>>Günzburg</option>
			<option value="09775" <?php echo ($districtKey=='09775')?'selected':''; ?>>Neu-Ulm</option>
			<option value="09776" <?php echo ($districtKey=='09776')?'selected':''; ?>>Lindau</option>
			<option value="09777" <?php echo ($districtKey=='09777')?'selected':''; ?>>Ostallgäu</option>
			<option value="09778" <?php echo ($districtKey=='09778')?'selected':''; ?>>Unterallgäu</option>
			<option value="09779" <?php echo ($districtKey=='09779')?'selected':''; ?>>Donau-Ries</option>
			<option value="09780" <?php echo ($districtKey=='09780')?'selected':''; ?>>Oberallgäu</option>
			<option value="10041" <?php echo ($districtKey=='10041')?'selected':''; ?>>Stadtverband Saarbrücken</option>
			<option value="10042" <?php echo ($districtKey=='10042')?'selected':''; ?>>Merzig-Wadern</option>
			<option value="10043" <?php echo ($districtKey=='10043')?'selected':''; ?>>Neunkirchen</option>
			<option value="10044" <?php echo ($districtKey=='10044')?'selected':''; ?>>Saarlouis</option>
			<option value="10045" <?php echo ($districtKey=='10045')?'selected':''; ?>>Saarpfalz-Kreis</option>
			<option value="10046" <?php echo ($districtKey=='10046')?'selected':''; ?>>Sankt Wendel</option>
			<option value="11001" <?php echo ($districtKey=='11001')?'selected':''; ?>>Berlin Mitte</option>
			<option value="11002" <?php echo ($districtKey=='11002')?'selected':''; ?>>Berlin Friedrichshain-Kreuzberg</option>
			<option value="11003" <?php echo ($districtKey=='11003')?'selected':''; ?>>Berlin Pankow</option>
			<option value="11004" <?php echo ($districtKey=='11004')?'selected':''; ?>>Berlin Charlottenburg-Wilmersdorf</option>
			<option value="11005" <?php echo ($districtKey=='11005')?'selected':''; ?>>Berlin Spandau</option>
			<option value="11006" <?php echo ($districtKey=='11006')?'selected':''; ?>>Berlin Steglitz-Zehlendorf</option>
			<option value="11007" <?php echo ($districtKey=='11007')?'selected':''; ?>>Berlin Tempelhof-Schöneberg</option>
			<option value="11008" <?php echo ($districtKey=='11008')?'selected':''; ?>>Berlin Neukölln</option>
			<option value="11009" <?php echo ($districtKey=='11009')?'selected':''; ?>>Berlin Treptow-Köpenick</option>
			<option value="11010" <?php echo ($districtKey=='11010')?'selected':''; ?>>Berlin Marzahn-Hellersdorf</option>
			<option value="11011" <?php echo ($districtKey=='11011')?'selected':''; ?>>Berlin Lichtenberg</option>
			<option value="11012" <?php echo ($districtKey=='11012')?'selected':''; ?>>Berlin Reinickendorf</option>
			<option value="12052" <?php echo ($districtKey=='12052')?'selected':''; ?>>Cottbus</option>
			<option value="12051" <?php echo ($districtKey=='12051')?'selected':''; ?>>Brandenburg a.d.Havel</option>
			<option value="12053" <?php echo ($districtKey=='12053')?'selected':''; ?>>Frankfurt (Oder)</option>
			<option value="12054" <?php echo ($districtKey=='12054')?'selected':''; ?>>Potsdam</option>
			<option value="12060" <?php echo ($districtKey=='12060')?'selected':''; ?>>Barnim</option>
			<option value="12061" <?php echo ($districtKey=='12061')?'selected':''; ?>>Dahme-Spreewald</option>
			<option value="12062" <?php echo ($districtKey=='12062')?'selected':''; ?>>Elbe-Elster</option>
			<option value="12063" <?php echo ($districtKey=='12063')?'selected':''; ?>>Havelland</option>
			<option value="12064" <?php echo ($districtKey=='12064')?'selected':''; ?>>Märkisch-Oderland</option>
			<option value="12065" <?php echo ($districtKey=='12065')?'selected':''; ?>>Oberhavel</option>
			<option value="12066" <?php echo ($districtKey=='12066')?'selected':''; ?>>Oberspreewald-Lausitz</option>
			<option value="12067" <?php echo ($districtKey=='12067')?'selected':''; ?>>Oder-Spree</option>
			<option value="12068" <?php echo ($districtKey=='12068')?'selected':''; ?>>Ostprignitz-Ruppin</option>
			<option value="12069" <?php echo ($districtKey=='12069')?'selected':''; ?>>Potsdam-Mittelmark</option>
			<option value="12070" <?php echo ($districtKey=='12070')?'selected':''; ?>>Prignitz</option>
			<option value="12071" <?php echo ($districtKey=='12071')?'selected':''; ?>>Spree-Neiße</option>
			<option value="12072" <?php echo ($districtKey=='12072')?'selected':''; ?>>Teltow-Fläming</option>
			<option value="12073" <?php echo ($districtKey=='12073')?'selected':''; ?>>Uckermark</option>
			<option value="13003" <?php echo ($districtKey=='13003')?'selected':''; ?>>Rostock</option>
			<option value="13004" <?php echo ($districtKey=='13004')?'selected':''; ?>>Schwerin</option>
			<option value="13071" <?php echo ($districtKey=='13071')?'selected':''; ?>>Mecklenburgische Seenplatte</option>
			<option value="13072" <?php echo ($districtKey=='13072')?'selected':''; ?>>Rostock</option>
			<option value="13073" <?php echo ($districtKey=='13073')?'selected':''; ?>>Vorpommern-Rügen</option>
			<option value="13074" <?php echo ($districtKey=='13074')?'selected':''; ?>>Nordwestmecklenburg</option>
			<option value="13075" <?php echo ($districtKey=='13075')?'selected':''; ?>>Vorpommern-Greifswald</option>
			<option value="13076" <?php echo ($districtKey=='13076')?'selected':''; ?>>Ludwigslust-Parchim</option>
			<option value="14511" <?php echo ($districtKey=='14511')?'selected':''; ?>>Chemnitz</option>
			<option value="14521" <?php echo ($districtKey=='14521')?'selected':''; ?>>Erzgebirgskreis</option>
			<option value="14522" <?php echo ($districtKey=='14522')?'selected':''; ?>>Mittelsachsen</option>
			<option value="14523" <?php echo ($districtKey=='14523')?'selected':''; ?>>Vogtlandkreis</option>
			<option value="14524" <?php echo ($districtKey=='14524')?'selected':''; ?>>Zwickau</option>
			<option value="14612" <?php echo ($districtKey=='14612')?'selected':''; ?>>Dresden</option>
			<option value="14625" <?php echo ($districtKey=='14625')?'selected':''; ?>>Bautzen</option>
			<option value="14626" <?php echo ($districtKey=='14626')?'selected':''; ?>>Görlitz</option>
			<option value="14627" <?php echo ($districtKey=='14627')?'selected':''; ?>>Meißen</option>
			<option value="14628" <?php echo ($districtKey=='14628')?'selected':''; ?>>Sächsische Schweiz-Osterzgebirge</option>
			<option value="14713" <?php echo ($districtKey=='14713')?'selected':''; ?>>Leipzig</option>
			<option value="14729" <?php echo ($districtKey=='14729')?'selected':''; ?>>Leipzig</option>
			<option value="14730" <?php echo ($districtKey=='14730')?'selected':''; ?>>Nordsachsen</option>
			<option value="15001" <?php echo ($districtKey=='15001')?'selected':''; ?>>Dessau-Roßlau</option>
			<option value="15002" <?php echo ($districtKey=='15002')?'selected':''; ?>>Halle</option>
			<option value="15003" <?php echo ($districtKey=='15003')?'selected':''; ?>>Magdeburg</option>
			<option value="15081" <?php echo ($districtKey=='15081')?'selected':''; ?>>Altmarkkreis Salzwedel</option>
			<option value="15082" <?php echo ($districtKey=='15082')?'selected':''; ?>>Anhalt-Bitterfeld</option>
			<option value="15083" <?php echo ($districtKey=='15083')?'selected':''; ?>>Börde</option>
			<option value="15084" <?php echo ($districtKey=='15084')?'selected':''; ?>>Burgenlandkreis</option>
			<option value="15085" <?php echo ($districtKey=='15085')?'selected':''; ?>>Harz</option>
			<option value="15086" <?php echo ($districtKey=='15086')?'selected':''; ?>>Jerichower Land</option>
			<option value="15087" <?php echo ($districtKey=='15087')?'selected':''; ?>>Mansfeld-Südharz</option>
			<option value="15088" <?php echo ($districtKey=='15088')?'selected':''; ?>>Saalekreis</option>
			<option value="15089" <?php echo ($districtKey=='15089')?'selected':''; ?>>Salzlandkreis</option>
			<option value="15090" <?php echo ($districtKey=='15090')?'selected':''; ?>>Stendal</option>
			<option value="15091" <?php echo ($districtKey=='15091')?'selected':''; ?>>Wittenberg</option>
			<option value="16051" <?php echo ($districtKey=='16051')?'selected':''; ?>>Erfurt</option>
			<option value="16052" <?php echo ($districtKey=='16052')?'selected':''; ?>>Gera</option>
			<option value="16053" <?php echo ($districtKey=='16053')?'selected':''; ?>>Jena</option>
			<option value="16054" <?php echo ($districtKey=='16054')?'selected':''; ?>>Suhl</option>
			<option value="16055" <?php echo ($districtKey=='16055')?'selected':''; ?>>Weimar</option>
			<option value="16061" <?php echo ($districtKey=='16061')?'selected':''; ?>>Eichsfeld</option>
			<option value="16056" <?php echo ($districtKey=='16056')?'selected':''; ?>>Eisenach</option>
			<option value="16062" <?php echo ($districtKey=='16062')?'selected':''; ?>>Nordhausen</option>
			<option value="16063" <?php echo ($districtKey=='16063')?'selected':''; ?>>Wartburgkreis</option>
			<option value="16064" <?php echo ($districtKey=='16064')?'selected':''; ?>>Unstrut-Hainich-Kreis</option>
			<option value="16065" <?php echo ($districtKey=='16065')?'selected':''; ?>>Kyffhäuserkreis</option>
			<option value="16066" <?php echo ($districtKey=='16066')?'selected':''; ?>>Schmalkalden-Meiningen</option>
			<option value="16067" <?php echo ($districtKey=='16067')?'selected':''; ?>>Gotha</option>
			<option value="16068" <?php echo ($districtKey=='16068')?'selected':''; ?>>Sömmerda</option>
			<option value="16069" <?php echo ($districtKey=='16069')?'selected':''; ?>>Hildburghausen</option>
			<option value="16070" <?php echo ($districtKey=='16070')?'selected':''; ?>>Ilm-Kreis</option>
			<option value="16071" <?php echo ($districtKey=='16071')?'selected':''; ?>>Weimarer Land</option>
			<option value="16072" <?php echo ($districtKey=='16072')?'selected':''; ?>>Sonneberg</option>
			<option value="16073" <?php echo ($districtKey=='16073')?'selected':''; ?>>Saalfeld-Rudolstadt</option>
			<option value="16074" <?php echo ($districtKey=='16074')?'selected':''; ?>>Saale-Holzland-Kreis</option>
			<option value="16075" <?php echo ($districtKey=='16075')?'selected':''; ?>>Saale-Orla-Kreis</option>
			<option value="16076" <?php echo ($districtKey=='16076')?'selected':''; ?>>Greiz</option>
			<option value="16077" <?php echo ($districtKey=='16077')?'selected':''; ?>>Altenburger Land</option>
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

	// function to display the widget in the site
	function widget( $args, $instance ) {
		// read values from backend form
		$title = apply_filters( 'widget_title', $instance['title'] );
		$districtKey = $instance['districtKey'];

		// get incidences from API
		$weeklyInc = new WeeklyIncidence( trim($districtKey) );

		// handle result
		$jsonResponse = $weeklyInc->jsonResponse;
		//var_dump($jsonResponse);
		$districtName = $weeklyInc->districtName;
		$values = $weeklyInc->values;

		// output code to show widget
		echo $args['before_widget'];
		?>
	
		<div class="c197di">
		<?php if (!empty($title)) {
			echo $args['before_title'] . $title . $args['after_title'];
		};

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

// class containing last 3 weekly incidences for a district
class WeeklyIncidence {
	public $districtKey = "08111";	// Stuttgart as default
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
		//$i = 0;
		//foreach ($objArray as $obj) {
		for ($i=0; $i<3; $i++) {
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
			//$i++;
		} 

		// meta info
		$a = $results->meta->lastUpdate;
		$b = strtotime($a);
		$lastUpdateDateTime = date("d/m/Y H:i A", $b);
		$this->lastUpdate = $lastUpdateDateTime;

		$this->metaInfo = $results->meta->info;
	}

	function fetchJson() {
		// todo: use transient; think about timespan
		//if ( false === ( $request = get_transient( 'Cov19JSON-'.$this->districtKey ) ) ) {
			$uri = 'https://api.corona-zahlen.org/districts/'.$this->districtKey.'/history/incidence/3';
			$request = wp_remote_get($uri);
			//set_transient('Cov19JSON-'.$this->districtKey,$request,120);	// 120=2 Minuten?
		//}  

	   if( is_wp_error( $request ) ) {
		   return false; // Bail early
	   }

	   $body = wp_remote_retrieve_body($request);

	   $json = json_decode($body);

	   // TODO: error handling

	   return $json;	
	}
}