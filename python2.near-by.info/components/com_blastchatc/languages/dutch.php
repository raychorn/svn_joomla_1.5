<?php
/**
* dutch.php
* @package BlastChat client
* @copyright 2004-2006 Peter Saitz
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @version $Revision: 2.0 $
* @author Peter Saitz <support@blastchat.com>
* @HomePage <www.blastchat.com>
**/

/** Credit to translators
* Name: Atlas
* Contact email: webmaster@scipioland.nl
* URL: http://www.scipioland.nl 

* Name: Vancanneyt Sander - Lesley Scipio - Dutchjoomla
* Contact email: info@dutchjoomla.com
* URL: http://www.dutchjoomla.com

* Name: Rik
* Contact email: rik_dragon@hotmail.com
* URL: http://www.blastchat.com
**/
//New in version 2.2
if (!defined("_BC_LICENSE_INFO_HEADER")) DEFINE("_BC_LICENSE_INFO_HEADER", "Uitzondering");
if (!defined("_BC_MENU_CONFIG_SAVE")) DEFINE("_BC_MENU_CONFIG_SAVE", "Configuratie opgeslagen");
if (!defined("_BC_DATABASE_UPDATED")) DEFINE("_BC_DATABASE_UPDATED","Database geupdate");
	//New for module 2.2
	if (!defined("_BC_JOINCHAT")) DEFINE("_BC_JOINCHAT", "Join chat");
	if (!defined("_BC_CHATLINK")) DEFINE("_BC_CHATLINK", "Join chat");
	if (!defined("_BC_CBLINK")) DEFINE("_BC_CBLINK", "Laat profile zien");
	if (!defined("_BC_SMFLINK")) DEFINE("_BC_SMFLINK", "Laat profile zien");
	if (!defined("_BC_MEMBER")) DEFINE("_BC_MEMBER", "Gebruiker &quot;%s&quot;");
	if (!defined("_BC_USER_INSIDE_CHAT")) DEFINE("_BC_USER_INSIDE_CHAT", "<br>In Chat [%s idle].");
	if (!defined("_BC_USER_NOT_CHATTING")) DEFINE("_BC_USER_NOT_CHATTING", "<br>Niet aan het chatten.");
	if (!defined("_BC_USER_CHATTING_IN")) DEFINE("_BC_USER_CHATTING_IN", "<br>aan het chatten in kamer &quot;%s&quot; [%s idle].");
	if (!defined("_BC_CHATTING")) DEFINE("_BC_CHATTING", "aan het chatten");
	if (!defined("_BC_USER_LASTLOGIN")) DEFINE("_BC_USER_LASTLOGIN", "<br>Laatste login:<br>%s");
	if (!defined("_BC_GLOBALSTATUS")) DEFINE("_BC_GLOBALSTATUS", "globale status");
	if (!defined("_BC_LASTUPDATE")) DEFINE("_BC_LASTUPDATE", "<br><br>Laatste update:<br>%s");
	if (!defined("_BC_GLOBALCOUNT")) DEFINE("_BC_GLOBALCOUNT", "Er zijn %s chatters online.");



//New in version 2.1
if (!defined('_BC_DATABASE_UPDATE')) DEFINE("_BC_DATABASE_UPDATE","Update database van versie");
if (!defined('_BC_DATABASE_CURRENT')) DEFINE("_BC_DATABASE_CURRENT","Database op huidige versie");
if (!defined('_BC_DATABASE_WRONG')) DEFINE("_BC_DATABASE_WRONG","Foutieve databaseversie");
if (!defined('_BC_INSTAL_FAIL')) DEFINE("_BC_INSTAL_FAIL","Installatie mislukt");

//component menus
if (!defined('_BC_MENU_USERS')) DEFINE("_BC_MENU_USERS","Gebruikers");
if (!defined('_BC_MENU_CONFIG')) DEFINE("_BC_MENU_CONFIG","Configuratie");
if (!defined('_BC_MENU_REG')) DEFINE("_BC_MENU_REG","Registratie");

//registration
if (!defined('_BC_DETACHED')) DEFINE("_BC_DETACHED","Pop-up");
if (!defined('_BC_DETACHED_DES')) DEFINE("_BC_DETACHED_DES","Standaard menulink naar het component zal mos-chat openen in een pop-up venster");
if (!defined('_BC_WIDTH')) DEFINE("_BC_WIDTH","Breedte");
if (!defined('_BC_WIDTH_DES')) DEFINE("_BC_WIDTH_DES","Standaard frame breedte");
if (!defined('_BC_HEIGHT')) DEFINE("_BC_HEIGHT","Hoogte");
if (!defined('_BC_HEIGHT_DES')) DEFINE("_BC_HEIGHT_DES","Standaard frame hoogte");
if (!defined('_BC_DWIDTH')) DEFINE("_BC_DWIDTH","Pop-up vensterbreedte");
if (!defined('_BC_DWIDTH_DES')) DEFINE("_BC_DWIDTH_DES","Standaard pop-up framebreedte");
if (!defined('_BC_DHEIGHT')) DEFINE("_BC_DHEIGHT","Pop-up vensterhoogte");
if (!defined('_BC_DHEIGHT_DES')) DEFINE("_BC_DHEIGHT_DES","Standaard pop-up framehoogte");
if (!defined('_BC_FRAMEBORDER')) DEFINE("_BC_FRAMEBORDER","Rand frame");
if (!defined('_BC_FRAMEBORDER_DES')) DEFINE("_BC_FRAMEBORDER_DES","Standaard framerand");
if (!defined('_BC_MWIDTH')) DEFINE("_BC_MWIDTH","Breedte marge");
if (!defined('_BC_MWIDTH_DES')) DEFINE("_BC_MWIDTH_DES","Standaardbreedte van de marge");
if (!defined('_BC_MHEIGHT')) DEFINE("_BC_MHEIGHT","Hoogte marge");
if (!defined('_BC_MHEIGHT_DES')) DEFINE("_BC_MHEIGHT_DES","Standaardhoogte van de marge");

if (!defined('_BC_INSTAL')) DEFINE("_BC_INSTAL","Installatie succesvol");
if (!defined('_BC_UNINSTAL')) DEFINE("_BC_UNINSTAL","De&iuml;nstallatie succesvol");
if (!defined('_BC_MUSTREG')) DEFINE("_BC_MUSTREG","Eerst dient u de server te registreren");
if (!defined('_BC_REGNOW')) DEFINE("_BC_REGNOW","REGISTREER uw server nu");

if (!defined('_BC_NEXT')) DEFINE("_BC_NEXT","Volgende");
if (!defined('_BC_RESULT')) DEFINE("_BC_RESULT","Result");
if (!defined('_BC_UPDATE')) DEFINE("_BC_UPDATE","Update");

if (!defined('_BC_CONTACTWEBMASTER')) DEFINE("_BC_CONTACTWEBMASTER", "Er deed zich een error voor, contacteer de webmaster");
if (!defined('_BC_NOT_IMPLEMENTED')) DEFINE("_BC_NOT_IMPLEMENTED", "Nog niet in werking");

if (!defined('_BC_ERROR_MOSCONFIG')) DEFINE("_BC_ERROR_MOSCONFIG", "ongeldige waarde, los dit probleem op of contacteer BlastChat ondersteuning voor hulp");
if (!defined('_BC_ERROR_TABLE')) DEFINE("_BC_ERROR_TABLE", "tabel");
if (!defined('_BC_ERROR_NOPOPUP')) DEFINE("_BC_ERROR_NOPOPUP", "kan chatvenster niet in een pop-up venster openen, uw browser blokkeert pop-up vensters");
if (!defined('_BC_ERROR_0002')) DEFINE("_BC_ERROR_0002", "Foutieve data in");
if (!defined('_BC_ERROR_0003')) DEFINE("_BC_ERROR_0003", "Niet consistente waarde in");

if (!defined('_BC_LICENSE_INFO')) DEFINE("_BC_LICENSE_INFO", "Uitzondering: U mag deze extensie installeren en gebruiken op een commerci&euml;le website, enig ander commercieel gebruik is verboden zoals het aanbieden van deze installatie voor een bepaald bedrag.");
?>