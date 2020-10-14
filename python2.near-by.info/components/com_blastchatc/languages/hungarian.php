<?php
/**
* hungarian.php
* @package BlastChat client
* @copyright 2004-2007 BlastChat
* @license Creative Commons Attribution-Noncommercial-Share Alike 3.0 United States License. http://creativecommons.org/licenses/by-nc-sa/3.0/us/
* @license Permissions beyond the scope of this license may be available at http://www.blastchat.com/client_license.html
* @version $Revision: 2.2 $
* @author Peter Saitz <support@blastchat.com>
* @HomePage <www.blastchat.com>
**/

/**
* Credit to translators
* Name: Kiwi
* Contact email: Kiwi <kiwi@kiwisoft.hu>
* URL: www.kiwisoft.hu
**/

//New in version 2.2
if (!defined("_BC_LICENSE_INFO_HEADER")) DEFINE("_BC_LICENSE_INFO_HEADER", "Kiv&eacute;tel");
if (!defined("_BC_MENU_CONFIG_SAVE")) DEFINE("_BC_MENU_CONFIG_SAVE", "Be&aacute;ll&iacute;t&aacute;sok elmentve");
if (!defined("_BC_DATABASE_UPDATED")) DEFINE("_BC_DATABASE_UPDATED","Adatb&aacute;zis friss&iacute;tve");
	//New for module 2.2
	if (!defined("_BC_JOINCHAT")) DEFINE("_BC_JOINCHAT", "Bel&eacute;p&eacute;s");
	if (!defined("_BC_CHATLINK")) DEFINE("_BC_CHATLINK", "Bel&eacute;p&eacute;s");
	if (!defined("_BC_CBLINK")) DEFINE("_BC_CBLINK", "Profil mutat&aacute;sa");
	if (!defined("_BC_SMFLINK")) DEFINE("_BC_SMFLINK", "Profil mutat&aacute;sa");
	if (!defined("_BC_MEMBER")) DEFINE("_BC_MEMBER", "Member &quot;%s&quot;");
	if (!defined("_BC_USER_INSIDE_CHAT")) DEFINE("_BC_USER_INSIDE_CHAT", "<br>Bel&eacute;pve: [%s idle].");
	if (!defined("_BC_USER_NOT_CHATTING")) DEFINE("_BC_USER_NOT_CHATTING", "<br>Nem csetel.");
	if (!defined("_BC_USER_CHATTING_IN")) DEFINE("_BC_USER_CHATTING_IN", "<br>Csetel&otilde;k a szob&aacute;ban: &quot;%s&quot; [%s idle].");
	if (!defined("_BC_CHATTING")) DEFINE("_BC_CHATTING", "csetel");
	if (!defined("_BC_USER_LASTLOGIN")) DEFINE("_BC_USER_LASTLOGIN", "<br>Utols&oacute; bel&eacute;p&eacute;s:<br>%s");
	if (!defined("_BC_GLOBALSTATUS")) DEFINE("_BC_GLOBALSTATUS", "global status");
	if (!defined("_BC_LASTUPDATE")) DEFINE("_BC_LASTUPDATE", "<br><br>Utols&oacute; friss&iacute;t&eacute;s:<br>%s");
	if (!defined("_BC_GLOBALCOUNT")) DEFINE("_BC_GLOBALCOUNT", "%s csetel&otilde; online.");


//New in version 2.1
if (!defined("_BC_DATABASE_UPDATE")) DEFINE("_BC_DATABASE_UPDATE","Update database from version");
if (!defined("_BC_DATABASE_CURRENT")) DEFINE("_BC_DATABASE_CURRENT","Database at current version");
if (!defined("_BC_DATABASE_WRONG")) DEFINE("_BC_DATABASE_WRONG","Hib&aacute;s adatb&aacute;zis verzi&oacute;");
if (!defined("_BC_INSTAL_FAIL")) DEFINE("_BC_INSTAL_FAIL","Sikertelen telep&iacute;t&eacute;s");

//New in version 2.0
//component menus
if (!defined("_BC_MENU_USERS")) DEFINE("_BC_MENU_USERS","Felhaszn&aacute;l&oacute;k");
if (!defined("_BC_MENU_CONFIG")) DEFINE("_BC_MENU_CONFIG","Be&aacute;ll&iacute;t&aacute;sok");
if (!defined("_BC_MENU_REG")) DEFINE("_BC_MENU_REG","Regisztr&aacute;ci&oacute;");

//registration
if (!defined("_BC_DETACHED")) DEFINE("_BC_DETACHED","K&uuml;l&ouml;n ablak");
if (!defined("_BC_DETACHED_DES")) DEFINE("_BC_DETACHED_DES","Az alap&eacute;rtelmezett men&uuml; hivatkoz&aacute;s k&uuml;l&ouml;n&aacute;ll&oacute; ablakk&eacute;nt nyitja meg a csetet!");
if (!defined("_BC_WIDTH")) DEFINE("_BC_WIDTH","Sz&eacute;less&eacute;g");
if (!defined("_BC_WIDTH_DES")) DEFINE("_BC_WIDTH_DES","Alap&eacute;rtelmezett keret sz&eacute;less&eacute;g");
if (!defined("_BC_HEIGHT")) DEFINE("_BC_HEIGHT","Magass&aacute;g");
if (!defined("_BC_HEIGHT_DES")) DEFINE("_BC_HEIGHT_DES","Alap&eacute;rtelmezett keret magass&aacute;g");
if (!defined("_BC_DWIDTH")) DEFINE("_BC_DWIDTH","Ablak sz&eacute;less&eacute;g (k&uuml;l&ouml;n&aacute;ll&oacute; ablak)");
if (!defined("_BC_DWIDTH_DES")) DEFINE("_BC_DWIDTH_DES","Alap&eacute;rtelmezett ablak sz&eacute;less&eacute;g (k&uuml;l&ouml;n&aacute;ll&oacute; ablak)");
if (!defined("_BC_DHEIGHT")) DEFINE("_BC_DHEIGHT","Ablak magass&aacute;g (k&uuml;l&ouml;n&aacute;ll&oacute; ablak)");
if (!defined("_BC_DHEIGHT_DES")) DEFINE("_BC_DHEIGHT_DES","Alap&eacute;rtelmezett ablak magass&aacute;g (k&uuml;l&ouml;n&aacute;ll&oacute; ablak)");
if (!defined("_BC_FRAMEBORDER")) DEFINE("_BC_FRAMEBORDER","Keret vastags&aacute;g");
if (!defined("_BC_FRAMEBORDER_DES")) DEFINE("_BC_FRAMEBORDER_DES","Alap&eacute;rtelmezett keret vastags&aacute;g");
if (!defined("_BC_MWIDTH")) DEFINE("_BC_MWIDTH","Marg&oacute; sz&eacute;less&eacute;ge");
if (!defined("_BC_MWIDTH_DES")) DEFINE("_BC_MWIDTH_DES","Alap&eacute;rtelmezett marg&oacute; sz&eacute;less&eacute;g");
if (!defined("_BC_MHEIGHT")) DEFINE("_BC_MHEIGHT","Marg&oacute; magass&aacute;ga");
if (!defined("_BC_MHEIGHT_DES")) DEFINE("_BC_MHEIGHT_DES","Alap&eacute;rtelmezett marg&oacute; magass&aacute;g");

if (!defined("_BC_INSTAL")) DEFINE("_BC_INSTAL","Sikeres telep&iacute;t&eacute;s");
if (!defined("_BC_UNINSTAL")) DEFINE("_BC_UNINSTAL","Sikeres elt&aacute;vol&iacute;t&aacute;s");
if (!defined("_BC_MUSTREG")) DEFINE("_BC_MUSTREG","El&otilde;sz&ouml;r regisztr&aacute;lnod kell a szervered");
if (!defined("_BC_REGNOW")) DEFINE("_BC_REGNOW","REGISZTR&Aacute;LJ most!");

if (!defined("_BC_NEXT")) DEFINE("_BC_NEXT","K&ouml;vetkez&otilde;");
if (!defined("_BC_RESULT")) DEFINE("_BC_RESULT","Eredm&eacute;ny");
if (!defined("_BC_UPDATE")) DEFINE("_BC_UPDATE","Friss&iacute;t");

if (!defined("_BC_CONTACTWEBMASTER")) DEFINE("_BC_CONTACTWEBMASTER", "Hiba, l&eacute;pj kapcsolatba a rendszergazd&aacute;val!");
if (!defined("_BC_NOT_IMPLEMENTED")) DEFINE("_BC_NOT_IMPLEMENTED", "M&eacute;g nincs be&eacute;p&iacute;tve!");

if (!defined("_BC_ERROR_MOSCONFIG")) DEFINE("_BC_ERROR_MOSCONFIG", "&eacute;rt&eacute;ke hib&aacute;s, jav&iacute;tsd a probl&eacute;m&aacute;t vagy k&eacute;rj seg&iacute;ts&eacute;get a \"Blastchat t&aacute;mogat&aacute;son\"");
if (!defined("_BC_ERROR_TABLE")) DEFINE("_BC_ERROR_TABLE", "t&aacute;bla");
if (!defined("_BC_ERROR_NOPOPUP")) DEFINE("_BC_ERROR_NOPOPUP", "Nem nyithat&oacute; &uacute;j ablak, a b&ouml;ng&eacute;sz&otilde;d blokkolja az el&otilde;ugr&oacute; ablakokat!");
if (!defined("_BC_ERROR_0002")) DEFINE("_BC_ERROR_0002", "Hib&aacute;s adat:");
if (!defined("_BC_ERROR_0003")) DEFINE("_BC_ERROR_0003", "&Ouml;sszeegyeztethetetlen adat:");

if (!defined("_BC_LICENSE_INFO")) DEFINE("_BC_LICENSE_INFO", "Telep&iacute;theted &eacute;s haszn&aacute;lhatod ezt a komponens-t b&aacute;rmilyen kereskedelmi oldalon, b&aacute;rmilyen egy&eacute;b jelleg&ucirc; kereskedelmi felhaszn&aacute;l&aacute;s TILOS, mint p&eacute;ld&aacute;ul a komponens telep&iacute;t&eacute;se p&eacute;nz&eacute;rt (pl. &eacute;rt&eacute;kes&iacute;t&eacute;s szolg&aacute;ltat&aacute;si csomagban).");
?>
