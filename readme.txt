=== Mail Nachricht ===
Contributors: wolfgangac
Donate link: https://www.wolfgang-aachen.de/wordpress
Tags: E-Mail, Benachrichtigung, Besuch auf Seite
Requires at least: 6.4.5
Tested up to: 6.6
Stable tag: 2.5
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html


== Description ==

*   Mit diesem Plugin kann man sich Benachrichtigen lassen, wenn jemand eine (bestimmte) Seite aufruft.
*   Ueber den Text im Shortcut kann man sich einen beliebigen Text auf einer beliebigen Seite eintragen.
*   z.b. auf der Seite Impressum: [e-mail-nachricht] Besuch auf Impressum [/e-mail-nachricht]
*        oder von der Seite Kontakt z.b: [e-mail-nachricht] Besuch auf Kontakt [/e-mail-nachricht]

== Installation ==

1. Installiere (lade) den Ordner `mail-nachricht` in das `/wp-content/plugins/` Verzeichnis
2. Aktiviere das Plugin ueber das 'Plugins' Menue in WordPress
3. Gebe eine (vorhandene) E-Mail Adresse in den Einstellungen ein.
4. Test Mail schicken lassen, um zu sehen, ob diese funktioniert?
5. Benuze den Shortcode auf jeder beliebiger Seite: [e-mail-nachricht] Text von beliebiger Seite [/e-mail-nachricht] 
6. Nach Speichern und Besuch dieser o.g. Seite muesste eine E-Mail kommen.

== Achtung ==

Wenn das Plugin geloescht wird, bleibt der Shortcode in den Beitraegen bzw. Seiten erhalten.
Der muss dann noch manuell geloescht bzw. entfernt werden.
(Der Datenbank Eintrag wird automatisch geloescht)

== Frequently Asked Questions ==
- Falls mal KEINE E-Mail Nachricht kommt, sollte eine andere E-Mail Adresse probiert werden.


== Screenshots ==

1. Hier die Einstellungs Seite
2. Hier sieht man die E-Mail


== Changelog ==

= Version 2.5 =
* MySQL Eintrag von 'e_mail' nach 'mail_nachricht_email' geaendert
* Aufruf der Einstellungsseite im Plugin Menue geaendert.
* Fehlerbehung beim loeschen des Plugins beseitigt (DB Eintrag wurde nicht geloescht)

= Version 2.4 =
* Options Seite und Test-Mail angepasst

= Version 2.3 =
* Filter and Action ans Ende verschoben, Kompatiblitaet zu Wordpress 6.xx und PHP 8.0 
* Fehler in Zeile 125 bei PHP 8.0 beseitigt / Input Feld vergroessert
* Domain Name, Wordpress Version, PHP Version und Plugin Version auf Options Seite hinzu

= Version 2.2 =
* Button "Test-Mail schicken" hinzu, Kompatiblitaet zu Wordpress 5.9

= Version 2.1 =
* Umstellen der E-Mail Formatierung auf HTML, Kompatiblitaet zu Wordpress 5.7/5.8

= Version 2.0 =
* Kompatiblitaet zu Wordpress 5.6 und Anzeige der IP Adresse in der Mail

= Version 1.9 =
* User Info mit in E-Mail hinzugefuegt (Browser, Betriebssystem, ..)

= Version 1.8 =
* Anpassung an Wordpress 5.5 + kleinere Korrekturen

= Version 1.7 =
* Anzeige in der E-Mail korrigiert

= Version 1.6 =
* Plugin Ueberarbeitet

= Version 1.2 =
* Aendern der Namen von 'mn_' auf 'mail_nachricht_'

= Version 1.1 =
* Hilfs-Text ergaenzt
	
= Version 1.0 =
* Fertigstellen incl. uninstall
 

== Upgrade Notice ==
= 1.6 = Plugin Ueberarbeitet

