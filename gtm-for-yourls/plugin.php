<?php
/*
Plugin Name: GoogleTagManager for YOURLS
Plugin URI: https://github.com/jhlassen17/GTM-for-YOURLS
Description: Adds google tag manager tracking to every clicked link, as well as tracking to admin and stats pages.
Version: 2.1
Author: Jeff Lassen
Author URI: https://jhl.me/
*/

if( !defined( 'YOURLS_ABSPATH' ) ) die();

/*
*	Prints the GTM header code
*/
function print_gtm_head( $tagid ) {
	echo "<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','$tagid');</script>
	<!-- End Google Tag Manager -->";
}

/*
*	Prints the GTM body code
*/
function print_gtm_body( $tagid ) {
	echo "<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src=\"https://www.googletagmanager.com/ns.html?id=$tagid\"
	height=\"0\" width=\"0\" style=\"display:none;visibility:hidden;\"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->";
}

//Add hook for pre-redirect event
yourls_add_action( 'pre_redirect', 'gtm_add_tracking' );

/*
*	Handles the pre-redirect action and adds our GTM code
*/
function gtm_add_tracking( $args ) {
    //Set up vars
	$url = $args[0];
    $code = $args[1];
    $tagid = "GTM-MK8CJ8Z"; // SET TAGID HERE

	//Output head tag
    echo "<html>";
    echo "<head>";
	
	//Ouput GTM head
	print_gtm_head( $tagid );
	
    echo "</head>";

	//Output body tag
    echo "<body>";
	
	//Output GTM body
    print_gtm_body( $tagid );
    
	//Output redirect message
	echo "<p>Please <a href='$url'>click here</a> if you are not automatically redirected.</p>";
	
	//Close out
    echo "</body>";
    echo "</html>";
	
	//Set up redirect
    yourls_redirect_javascript( $url );

	//Get out
    exit;
}

//Add header hook
yourls_add_action( 'html_head', 'gtm_add_tracking_header' );

/*
*	Add GTM tracking to header hook
*/
function gtm_add_tracking_header( ) {
    $tagid = "GTM-MK8CJ8Z"; // SET TAGID HERE

	//Call the other function
	print_gtm_head( $tagid );
}

//Add footer hook
yourls_add_action( 'html_footer', 'gtm_add_tracking_footer' );

/*
*	Add GTM tracking to body hook
*/
function gtm_add_tracking_footer( ) {
	$tagid = "GTM-MK8CJ8Z"; // SET TAGID HERE
	
	//Call the other function
	print_gtm_body( $tagid );
}
