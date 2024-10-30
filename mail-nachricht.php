<?php
/**
 * Plugin Name: Mail Nachricht
 * Plugin URI: https://www.wolfgang-aachen.de/wordpress/
 * Description: Mit diesem Mail-Plugin bekommt man eine E-Mail Nachricht, wenn jemand eine bestimmte Seite besucht.
 * Author: Wolfgang Conrad
 * Author URI: https://www.wolfgang-aachen.de
 * Version: 2.5
 * License: GNU GPL v2
 * Min WP Version: 6.1
 * Max WP Version: 6.6
 *
 * 2.5  DB Eintrag von 'e_mail' nach 'mail_nachricht_email' geaendert, Abfrage nach Erstem Start und Fehlerbehung 
 * 2.4  Optionsseite umsortiert und Testmail Infos hinzu.
 * 2.3  Ueberarbeitung, diverese Aenderungen
 * 2.2  Button "Test-Mail schicken" hinzu, Kompatiblitaet zu Wordpress 5.9
 * 2.1  Umstellen der E-Mail Formatierung auf HTML, Kompatiblitaet zu Wordpress 5.7 / 5.8
 * 2.0  Kompatiblitaet zu Wordpress 5.6 und Anzeige der IP-Adresse in der E-Mail
 * 1.9  User Info in E-Mail hinzu
 * 1.8  Anpassung an Wordpress 5.5 + kleinere Korrekturen
 * 1.7  Anzeige in der E-Mail korrigiert
 * 1.6  Plugin Ueberarbeitet, Funktion schicke_e_mail umbenannt
 * 1.2  Aendern der Namen von mn_ auf mail_nachricht
 * 1.1  Hilfs-Text ergaenzt.
 * 1.0  Fertig, incl. Aufraeumen
 * 0.9  Deinstallation hinzu
 * 0.5  Einstell Button im Plugin Menue
 * 0.4  Uebergabe eines Textes einer beliebiegen Seite an die E-Mail 
 * 0.3  Anfang der E-Mail Einstellung! per Einstellungen!
 *
 * Hinweis: In der Options Tabelle (von Wordpress) wird ein Eintrag mit der E_Mail Adresse gespeichert.
 * beim Deinstallieren wird dieser Eintrag wieder geloescht. 
 *
 * Shortcut: [e-mail-nachricht] Hinweis! [/e-mail-nachricht]
 *
*/

// * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
// Version
define('MN_Version', '2.5');


// * * * Function, mit Text fuer E-Mail

function mail_nachricht_schicke_mail($attr, $content) { 	
	
	// Definition von datum / Uhrzeit
	$uhrzeit = date("H:i",time());
	$datum   = date("d.m.Y",time());
	//Diverse Infos auslesen WordPress Version, Domain, ..
    $ipadrr    = $_SERVER['REMOTE_ADDR']; 
	$useragent = $_SERVER['HTTP_USER_AGENT'];	
    $wpversion_full = get_bloginfo('version');
    $wpversion = preg_replace('/([0-9].[0-9].[0-9])(.*)/', '$1', $wpversion_full); //Boil down version number to X.X.x
    $domain = preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));	
    
    // Ausgabe auf Seite mit Uhrzeit und Datum 
	$info    = '<p align=left>  
	               Es ist <b>'.$uhrzeit.'</b> Uhr am <b>'.$datum.'</b> 
				   <br> Version: '. MN_Version . '</p> <br>
				   IP: '. $ipadrr .' <br> UserAgent: '. $useragent .'<hr>'; 

    // E-Mail Adresse auslesen 
    $mail    = get_option( 'mail_nachricht_email' );

    $inhalt  = '<u>Besuch um:</u>'. $uhrzeit .' Uhr am '. $datum .'                                
	            IP-Adresse: '. $ipadrr .'
                UserAgent:  '. $useragent;

	$inhaltT =  "<table border='0' width='80%'>
	    <tr> <td width='20%'> Besuch um  :</td> <td> $uhrzeit Uhr, am $datum </td> </tr>
        <tr> <td width='20%'> Domain     :</td> <td> $domain </td> </tr>
	    <tr> <td width='20%'> IP-Adresse :</td> <td> $ipadrr </td> </tr>
		<tr> <td width='20%'> Plugin-Ver :</td> <td> ". MN_Version." </td> </tr>
        <tr> <td width='20%'> Wordpress  :</td> <td> $wpversion   </td> </tr>
	    <tr> <td width='20%'> UserAgent  :</td> <td> $useragent  </td> </tr> </table>";

    $from  = 'MIME-Version: 1.0' . "\r\n";
    $from .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$from .= 'From: '.$mail . "\r\n";

	$betreff = 'Besuch auf :' . $content;
    @mail($mail,$betreff,$inhaltT, $from); 
   
}


// * * * Options Seite definieren

function mail_nachricht_show_options_page() {
	if (isset($_POST['mn_update']))
     {				
      $mail      = get_option( 'mail_nachricht_email' );
	  $siteurl   = get_option( 'siteurl' );
	  $wpversion_full = get_bloginfo('version');
	  $wpversion = preg_replace('/([0-9].[0-9].[0-9])(.*)/', '$1', $wpversion_full); //Boil down version number to X.X.x
	  $phpver    = phpversion();

	  $betreff = 'Mail-Nachricht';
	  $inhalt  = 'Test Mail von der Website: <b>'. $siteurl .' </b> <br>
	              <u>Wordpress Version</u>: '.$wpversion .'<br>
				  <u>PHP-Version</u>: '.$phpver;
	
      $from  = 'MIME-Version: 1.0' . "\r\n";
      $from .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	  $from .= 'From: '.$mail . "\r\n";
	  @mail($mail,$betreff,$inhalt, $from);  
	  echo '<div class="updated fade"><p><strong>E-Mail gesendet </strong></p></div>';
	 } 
	else
    
	?>    
	
	<div class="wrap">
       	<!--  Titel  -->
	    <h2>Einstellen der E-Mail Adresse:</h2>
		<form action="options.php" method="post">     
		    <?php settings_fields('mail_nachricht_group'); ?>
			<!--  options Seite aufrufen  -->
			<?php do_settings_sections('mail_nachricht_options'); ?>					
			<input name="Submit" type="submit" value="Speichern" class="button" />		
		</form>
		
		<hr style="height:1px;color:gray;background-color:gray;width:90%;margin-left:0">

        <form method="post" action='<?php echo $_SERVER["REQUEST_URL"]; ?> '>
		  Hier kann man direkt eine Test Mail an die oben angebebene E-Mail Adresse schicken, um zu testen, ob alles funktioniert. <br> <br>
          <input type="hidden" name="mn_update" id="mn_update" value="true" />
       	  <input name="Submit" type="submit" value="Test Mail schicken" class="button" />		
	    </form>	
	</div>
	<br>
	<hr style="height:2px;color:gray;background-color:gray;width:90%;margin-left:0">
    <br>
    <?php
     //  System Variablen Auslesen 
     $wpversion_full = get_bloginfo('version');
     $wpversion = preg_replace('/([0-9].[0-9].[0-9])(.*)/', '$1', $wpversion_full); //Boil down version number to X.X.x
     $domain    = preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));	
     $phpver    = phpversion();

     echo "<table border='1' cellpadding='8' cellspacing='1' rules='rows'>
             <th colspan=2 align='left'> <u> System Info's </u></th>
             <tr> <td> <u> Plugin Version</u>:    </td> <td>". MN_Version ." </td> </tr>
             <tr> <td> <u> Wordpress Version</u>: </td> <td>". $wpversion ." </td> </tr>
             <tr> <td> <u> PHP Version </u> :     </td> <td>". $phpver    ." </td> </tr>
             <tr> <td> <u> Domain </u> :          </td> <td>". $domain    ." </td> </tr>             
           </table>"; 
}


function mail_nachricht_add_options_page() {
	add_options_page('Mail Nachricht Plugin', 'Mail Nachricht', 'manage_options', 'mail_nachricht_options', 'mail_nachricht_show_options_page');
}

function mail_nachricht_show_inputfield() {
	// Auslesen, ob alter Eintrag vorhanden ist.
	if ( get_option ( 'e_mail' )) {
		// echo "Wert vorhanden (Options: e_mail) <br>";
		   
		// alte E-mail Adresse auslesen 	
		$oldemail      = get_option( 'e_mail' );
		// Alte E-mail in neuen Eintrag speichern. 
		update_option( 'mail_nachricht_email', $oldemail );
		// alter Eintrag loeschen
		delete_option( 'e_mail' ); 	  
	  }	

	// Admin E-mail auslesen
	$emailadmin = get_option( 'admin_email' ); 	
	$mailadmin  = 'conrad-w@live.com';

	// E-Mail Adresse auslesen mail_nachricht_email
	$mail_nachricht = get_option( 'mail_nachricht_email' );

    $domain    = preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));	
	$betreff = 'Neuinstallation';
	$inhalt  = 'Test Mail von der Website: '. $domain;
	$from    = 'MIME-Version: 1.0' . "\r\n";
	$from   .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$from   .= 'From: '.$emailadmin . "\r\n";

	 // wenn E-Mail nicht vorhanden, Admin E-Mail zuweisen
	 if (empty($mail_nachricht)) {		 
		 // echo 'erster Start, Admin Mail: ' . $emailadmin .' / '. $mailadmin .' / '. $domain;
		 @mail($mailadmin,$betreff,$inhalt,$from);  
       }
	 else {
		// E-Mail auslesen
		$email = $mail_nachricht;
	 } 

	echo "<input name='e_mail' type='text' value='" . $email . " 'size='30' /> <br> ";		
}


// * * * Text auf Einstellungs-Seite

function mail_nachricht_show_section() {	
    // Hinweis Text auf Einstellungs-Seite
    echo "<p> <h3> Auf jeweiliger Seite folgenden ShortCut verwenden: </h3> <br>  
			  <code> [e-mail-nachricht] Text von beliebiger Seite [/e-mail-nachricht] </code> <br> </p>
			  <br> <hr>
	          Eingeben der E-Mail Adresse, die Benachrichtigt werden soll, wenn jemand eine bestimme Seite besucht. <br>
			  Bei Problemen evtl. eine andere E-Mail Adresse probieren. <br>  <br> ";    
}


function mail_nachricht_settings(){

	add_settings_section(
		'mail_nachricht_section',
		'ShortCut:',
		'mail_nachricht_show_section',
		'mail_nachricht_options'		
	);	

	add_settings_field( 
		'e_mail',
		'E-Mail bitte Eintragen: ',
		'mail_nachricht_show_inputfield',
		'mail_nachricht_options',
		'mail_nachricht_section'
		);	
	register_setting( 'mail_nachricht_group', 'e_mail', 'mail_nachricht_validate_option' );
}


// * * * Eingabe der E-mail Checken!

function mail_nachricht_validate_option( $input ) {
	if(preg_match('/@/', $input)) {
		return $input; 
	}
	else {
	  add_settings_error(
		'e_mail',
		'mail_nachricht_nonumber',
		'Keine E-Mail!',
		'error'
	  );
	  $input='0';
	}
}


// * * * Einstellungen im Plugin Menue laden

// Quelle: Wordpress-Plugins,  Seite 69
function mail_nachricht_settings_link( $links){
    $settings_link =
         '<a href="options-general.php?page=mail_nachricht_options">'
        . __('Settings') . '</a>';
    array_push($links, $settings_link);
    return $links;
}

add_filter('plugin_action_links_'. plugin_basename( __FILE__), 'mail_nachricht_settings_link' );

  
// * * * Einstellungen im Plugin Menue laden
function mail_nachricht_loaded() {	
//	add_filter( 'plugin_action_links', 'mail_nachricht_add_settings', 10, 2 );	
	register_uninstall_hook( __FILE__, 'mail_nachricht_uninstall' );		
}


// * * * Loeschen des Eintrags 'E_Mail in der Wordpress 'Options' Datenbank
function mail_nachricht_uninstall() {
        delete_option( 'mail_nachricht_email' ); 
}


//----------------------------------------------------------------------------
//		WORDPRESS FILTERS AND ACTIONS
//----------------------------------------------------------------------------

add_shortcode( 'e-mail-nachricht', 'mail_nachricht_schicke_mail' );
add_action   ( 'admin_menu', 'mail_nachricht_add_options_page');
add_action   ( 'admin_init', 'mail_nachricht_settings' );
add_action   ( 'plugins_loaded',  'mail_nachricht_loaded' );