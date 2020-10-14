<?php
/**
* english.php
* @package BlastChat client
* @copyright 2004-2006 Peter Saitz
* @license Creative Commons Attribution-Noncommercial-Share Alike 3.0 United States License. http://creativecommons.org/licenses/by-nc-sa/3.0/us/
* @license Permissions beyond the scope of this license may be available at http://www.blastchat.com/client_license.html
* @version $Revision: 2.2 $
* @author Peter Saitz <support@blastchat.com>
* @HomePage <www.blastchat.com>
**/

/**
* Credit to translators
* Name:
* Contact email:
* URL: 
**/

//New in version 2.2
if (!defined("_BC_LICENSE_INFO_HEADER")) DEFINE("_BC_LICENSE_INFO_HEADER", "Hata");
if (!defined("_BC_MENU_CONFIG_SAVE")) DEFINE("_BC_MENU_CONFIG_SAVE", "Konfig&#252;rasyon kaydedildi");
if (!defined("_BC_DATABASE_UPDATED")) DEFINE("_BC_DATABASE_UPDATED","Database g&#252;ncellendi");
	//New for module 2.2
	if (!defined("_BC_JOINCHAT")) DEFINE("_BC_JOINCHAT", "Sohbete kat&#305;l");
	if (!defined("_BC_CHATLINK")) DEFINE("_BC_CHATLINK", "Sohbete kat&#305;l");
	if (!defined("_BC_CBLINK")) DEFINE("_BC_CBLINK", "Profili g&#241;ster");
	if (!defined("_BC_SMFLINK")) DEFINE("_BC_SMFLINK", "Profili g&#241;ster");
	if (!defined("_BC_MEMBER")) DEFINE("_BC_MEMBER", "&#220;ye &quot;%s&quot;");
	if (!defined("_BC_USER_INSIDE_CHAT")) DEFINE("_BC_USER_INSIDE_CHAT", "<br>Sohbette [%s idle].");
	if (!defined("_BC_USER_NOT_CHATTING")) DEFINE("_BC_USER_NOT_CHATTING", "<br>Sohbette de&#287;il.");
	if (!defined("_BC_USER_CHATTING_IN")) DEFINE("_BC_USER_CHATTING_IN", "<br>&#350;u odada: &quot;%s&quot; [%s idle].");
	if (!defined("_BC_CHATTING")) DEFINE("_BC_CHATTING", "konu&#351;uyor");
	if (!defined("_BC_USER_LASTLOGIN")) DEFINE("_BC_USER_LASTLOGIN", "<br>Son giri&#351;:<br>%s");
	if (!defined("_BC_GLOBALSTATUS")) DEFINE("_BC_GLOBALSTATUS", "global durum");
	if (!defined("_BC_LASTUPDATE")) DEFINE("_BC_LASTUPDATE", "<br><br>Son g&#252;ncelleme:<br>%s");
	if (!defined("_BC_GLOBALCOUNT")) DEFINE("_BC_GLOBALCOUNT", "&#350;u anda %s ki&#351;i sohbette.");


//New in version 2.1
if (!defined("_BC_DATABASE_UPDATE")) DEFINE("_BC_DATABASE_UPDATE","Veritaban&#305;n&#305; versiyondan g&#252;ncelle");
if (!defined("_BC_DATABASE_CURRENT")) DEFINE("_BC_DATABASE_CURRENT","Veritaban&#305; &#351;u andaki versiyonda");
if (!defined("_BC_DATABASE_WRONG")) DEFINE("_BC_DATABASE_WRONG","Hatal&#305; veritaban&#305; versiyonu");
if (!defined("_BC_INSTAL_FAIL")) DEFINE("_BC_INSTAL_FAIL","Yerle&#351;tirme ba&#351;ar&#305;s&#305;z");

//New in version 2.0
//component menus
if (!defined("_BC_MENU_USERS")) DEFINE("_BC_MENU_USERS","Kullan&#305;c&#305;lar");
if (!defined("_BC_MENU_CONFIG")) DEFINE("_BC_MENU_CONFIG","Konfig&#252;rasyon");
if (!defined("_BC_MENU_REG")) DEFINE("_BC_MENU_REG","Kay&#305;t");

//registration
if (!defined("_BC_DETACHED")) DEFINE("_BC_DETACHED","Ayr&#305;ld&#305;");
if (!defined("_BC_DETACHED_DES")) DEFINE("_BC_DETACHED_DES","Standart men&#252; linki BlastChat'i Ayr&#305;lm&#305;&#351; olarak a&#231;ar");
if (!defined("_BC_WIDTH")) DEFINE("_BC_WIDTH","Width");
if (!defined("_BC_WIDTH_DES")) DEFINE("_BC_WIDTH_DES","Standart frame geni&#351;li&#287;i");
if (!defined("_BC_HEIGHT")) DEFINE("_BC_HEIGHT","Height");
if (!defined("_BC_HEIGHT_DES")) DEFINE("_BC_HEIGHT_DES","Standart frame y&#252;ksekli&#287;i");
if (!defined("_BC_DWIDTH")) DEFINE("_BC_DWIDTH","Detached Width");
if (!defined("_BC_DWIDTH_DES")) DEFINE("_BC_DWIDTH_DES","Standart Ayr&#305;lm&#305;&#351; frame geni&#351;li&#287;i");
if (!defined("_BC_DHEIGHT")) DEFINE("_BC_DHEIGHT","Detached Height");
if (!defined("_BC_DHEIGHT_DES")) DEFINE("_BC_DHEIGHT_DES","Standart Ayr&#305;lm&#305;&#351; frame y&#252;ksekli&#287;i");
if (!defined("_BC_FRAMEBORDER")) DEFINE("_BC_FRAMEBORDER","Frame border");
if (!defined("_BC_FRAMEBORDER_DES")) DEFINE("_BC_FRAMEBORDER_DES","Standart frame &#231;er&#231;evesi");
if (!defined("_BC_MWIDTH")) DEFINE("_BC_MWIDTH","Margin width");
if (!defined("_BC_MWIDTH_DES")) DEFINE("_BC_MWIDTH_DES","Standart frame marjin geni&#351;li&#287;i");
if (!defined("_BC_MHEIGHT")) DEFINE("_BC_MHEIGHT","Margin height");
if (!defined("_BC_MHEIGHT_DES")) DEFINE("_BC_MHEIGHT_DES","Standart frame marjin y&#252;ksekli&#287;i");

if (!defined("_BC_INSTAL")) DEFINE("_BC_INSTAL","Yerle&#351;tirme ba&#351;ar&#305;l&#305;");
if (!defined("_BC_UNINSTAL")) DEFINE("_BC_UNINSTAL","kald&#305;rma ba&#351;ar&#305;l&#305;");
if (!defined("_BC_MUSTREG")) DEFINE("_BC_MUSTREG","&#214;nce sunucunuzu kaydetmelisiniz");
if (!defined("_BC_REGNOW")) DEFINE("_BC_REGNOW","Sunucunuzu &#351;imdi KAYDED&#304;N");

if (!defined("_BC_NEXT")) DEFINE("_BC_NEXT","Sonraki");
if (!defined("_BC_RESULT")) DEFINE("_BC_RESULT","Sonu&#231;");
if (!defined("_BC_UPDATE")) DEFINE("_BC_UPDATE","G&#252;ncelle");

if (!defined("_BC_CONTACTWEBMASTER")) DEFINE("_BC_CONTACTWEBMASTER", "Bir hata oldu, site y&#241;neticiniz ile g&#241;r&#252;&#351;&#252;n");
if (!defined("_BC_NOT_IMPLEMENTED")) DEFINE("_BC_NOT_IMPLEMENTED", "Hen&#252;z uygulanmam&#305;&#351;");

if (!defined("_BC_ERROR_MOSCONFIG")) DEFINE("_BC_ERROR_MOSCONFIG", "de&#287;er ge&#231;ersiz, sorunu d&#252;zeltin veya yard&#305;m i&#231;in BlastChat destek birimi ile g&#241;r&#252;&#351;&#252;n");
if (!defined("_BC_ERROR_TABLE")) DEFINE("_BC_ERROR_TABLE", "table");
if (!defined("_BC_ERROR_NOPOPUP")) DEFINE("_BC_ERROR_NOPOPUP", "Sohbet penceresini ay&#305;ram&#305;yorum, taray&#305;c&#305;n&#305;z pop-up pencerelere izin vermiyor");
if (!defined("_BC_ERROR_0002")) DEFINE("_BC_ERROR_0002", "Yanl&#305;&#351; veri");
if (!defined("_BC_ERROR_0003")) DEFINE("_BC_ERROR_0003", "Ge&#231;ersiz veri");

if (!defined("_BC_LICENSE_INFO")) DEFINE("_BC_LICENSE_INFO", "Bu bile&#351;eni ticari bir sitede kullanabilirsiniz. Bunun d&#305;&#351;&#305;nda bu bile&#351;eni (bir hosting paketinin par&#231;as&#305; gibi g&#241;stermek gibi yollar ile) &#252;cretsiz kurmak yasakt&#305;r.");
?>