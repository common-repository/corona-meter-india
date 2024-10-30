<?php
/**
 * @package corona-meter-india
 * @version 1.0
 */
/*
Plugin Name: Corona Meter India
Plugin URI: 
Description: Corona Cases Tracking Widget that gives you Covid case numbers in India, all Indian states Covid case numbers and Covid helpline numbers for all Indian States & Union Territories. The coronavirus pugin relies on the API for all it's data. The api has been featured on POSTMAN. API Homepage: https://covid-19india-api.herokuapp.com/ . The API Github page:(https://github.com/iSumitBanik/COVID19-India-Data-API) .API Licence Policy:https://github.com/iSumitBanik/COVID19-India-Data-API/blob/master/LICENSE . The API that is used in this plugin collects the data using an official gov website. This free plugin will benefit all healthcare & any general website which wants to update its users about the current covid-19 senario in India. As this plugin uses the just the API, I do not have any domain or hosting, thus I may not be able to solve any server error issues.
Author: Rashmi Sonawane
Version: 1.0
Author URI: https://rashmisworld.wordpress.com
Text Domain:corona-meter-india
Domain Path: /languages
*/


defined( 'ABSPATH' ) or exit( 'No Popping in !' );

function cmi_load_plugin_textdomain() {

	$domain = 'corona-meter-india';
	$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

	// wp-content/languages/plugin-name/plugin-name-de.mo
	load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
	
	// wp-content/plugins/plugin-name/languages/plugin-name-de.mo
	load_plugin_textdomain( $domain, FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );

}
add_action( 'init', 'cmi_load_plugin_textdomain' );


//Register plugin stylesheet
add_action('wp_enqueue_scripts','coronameterindia_style');

function coronameterindia_style(){
	wp_register_style('cmi_style',plugins_url( 'css/corona-meter-india.css', __FILE__ ));
	wp_enqueue_style('cmi_style');

}

require plugin_dir_path( __FILE__ ).'includes/class-coronameterindia.php';
require plugin_dir_path( __FILE__ ).'includes/class-cmiwidget.php';
require plugin_dir_path( __FILE__ ).'includes/class-cmiwidget-state.php';
require plugin_dir_path( __FILE__ ).'includes/class-cmiwidget-helpline.php';


function run_mycoronameter() {

	new Coronameterindia();
}
run_mycoronameter();