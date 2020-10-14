<?php
/**
* traditional_chinese.php
* @package BlastChat client
* @copyright 2004-2007 BlastChat
* @license Creative Commons Attribution-Noncommercial-Share Alike 3.0 United States License. http://creativecommons.org/licenses/by-nc-sa/3.0/us/
* @license Permissions beyond the scope of this license may be available at http://www.blastchat.com/client_license.html
* @version $Revision: 2.0 $
* @author Peter Saitz <support@blastchat.com>
* @HomePage <www.blastchat.com>
**/

/**
* Credit to translators
* Name: Mike Ho
* Contact email: mikeho1980@hotmail.com
* URL: http://www.dogneighbor.com
**/

//New in version 2.2
if (!defined("_BC_LICENSE_INFO_HEADER")) DEFINE("_BC_LICENSE_INFO_HEADER", "例外");
if (!defined("_BC_MENU_CONFIG_SAVE")) DEFINE("_BC_MENU_CONFIG_SAVE", "設定已儲存");
if (!defined("_BC_DATABASE_UPDATED")) DEFINE("_BC_DATABASE_UPDATED","資料庫已更新");
	//New for module 2.2
	if (!defined("_BC_JOINCHAT")) DEFINE("_BC_JOINCHAT", "加入�?�天");
	if (!defined("_BC_CHATLINK")) DEFINE("_BC_CHATLINK", "加入�?�天");
	if (!defined("_BC_CBLINK")) DEFINE("_BC_CBLINK", "顯示個人檔案");
	if (!defined("_BC_SMFLINK")) DEFINE("_BC_SMFLINK", "顯示個人檔案");
	if (!defined("_BC_MEMBER")) DEFINE("_BC_MEMBER", "會員 &quot;%s&quot;");
	if (!defined("_BC_USER_INSIDE_CHAT")) DEFINE("_BC_USER_INSIDE_CHAT", "<br>於�?�天室 [%s 閒置].");
	if (!defined("_BC_USER_NOT_CHATTING")) DEFINE("_BC_USER_NOT_CHATTING", "<br>�?在�?�天室.");
	if (!defined("_BC_USER_CHATTING_IN")) DEFINE("_BC_USER_CHATTING_IN", "<br>正在�?�天於 &quot;%s&quot; [%s 閒置].");
	if (!defined("_BC_CHATTING")) DEFINE("_BC_CHATTING", "�?�天");
	if (!defined("_BC_USER_LASTLOGIN")) DEFINE("_BC_USER_LASTLOGIN", "<br>最後登入:<br>%s");
	if (!defined("_BC_GLOBALSTATUS")) DEFINE("_BC_GLOBALSTATUS", "全域狀�?");
	if (!defined("_BC_LASTUPDATE")) DEFINE("_BC_LASTUPDATE", "<br><br>最後更新:<br>%s");
	if (!defined("_BC_GLOBALCOUNT")) DEFINE("_BC_GLOBALCOUNT", "有 %s �?�?�客在線上.");


//New in version 2.1
if (!defined("_BC_DATABASE_UPDATE")) DEFINE("_BC_DATABASE_UPDATE","更新資料庫自版本");
if (!defined("_BC_DATABASE_CURRENT")) DEFINE("_BC_DATABASE_CURRENT","資料庫�?�時版本");
if (!defined("_BC_DATABASE_WRONG")) DEFINE("_BC_DATABASE_WRONG","�?正確資料庫版本");
if (!defined("_BC_INSTAL_FAIL")) DEFINE("_BC_INSTAL_FAIL","安�?失敗");

//New in version 2.0
//component menus
if (!defined("_BC_MENU_USERS")) DEFINE("_BC_MENU_USERS","用戶");
if (!defined("_BC_MENU_CONFIG")) DEFINE("_BC_MENU_CONFIG","設定");
if (!defined("_BC_MENU_REG")) DEFINE("_BC_MENU_REG","註冊");

//registration
if (!defined("_BC_DETACHED")) DEFINE("_BC_DETACHED","分離");
if (!defined("_BC_DETACHED_DES")) DEFINE("_BC_DETACHED_DES","�?設連�?元件到�?�單會以分離樣�?開啟 BlastChat 客端");
if (!defined("_BC_WIDTH")) DEFINE("_BC_WIDTH","寬度");
if (!defined("_BC_WIDTH_DES")) DEFINE("_BC_WIDTH_DES","�?設框架寬度");
if (!defined("_BC_HEIGHT")) DEFINE("_BC_HEIGHT","高度");
if (!defined("_BC_HEIGHT_DES")) DEFINE("_BC_HEIGHT_DES","�?設框架高度");
if (!defined("_BC_DWIDTH")) DEFINE("_BC_DWIDTH","分離框架寬度");
if (!defined("_BC_DWIDTH_DES")) DEFINE("_BC_DWIDTH_DES","�?設分離樣�?框架寬度");
if (!defined("_BC_DHEIGHT")) DEFINE("_BC_DHEIGHT","分離框架高度");
if (!defined("_BC_DHEIGHT_DES")) DEFINE("_BC_DHEIGHT_DES","�?設分離樣�?框架高度");
if (!defined("_BC_FRAMEBORDER")) DEFINE("_BC_FRAMEBORDER","框架邊線");
if (!defined("_BC_FRAMEBORDER_DES")) DEFINE("_BC_FRAMEBORDER_DES","�?設框架邊線");
if (!defined("_BC_MWIDTH")) DEFINE("_BC_MWIDTH","邊界寬度");
if (!defined("_BC_MWIDTH_DES")) DEFINE("_BC_MWIDTH_DES","�?設框架邊界寬度");
if (!defined("_BC_MHEIGHT")) DEFINE("_BC_MHEIGHT","邊界高度");
if (!defined("_BC_MHEIGHT_DES")) DEFINE("_BC_MHEIGHT_DES","�?設邊界高度");

if (!defined("_BC_INSTAL")) DEFINE("_BC_INSTAL","安�?�?功");
if (!defined("_BC_UNINSTAL")) DEFINE("_BC_UNINSTAL","�?功移除");
if (!defined("_BC_MUSTREG")) DEFINE("_BC_MUSTREG","首先, 您必須註冊您的伺�?器");
if (!defined("_BC_REGNOW")) DEFINE("_BC_REGNOW","立�?�註冊您的伺�?器");

if (!defined("_BC_NEXT")) DEFINE("_BC_NEXT","下�?");
if (!defined("_BC_RESULT")) DEFINE("_BC_RESULT","�?果");
if (!defined("_BC_UPDATE")) DEFINE("_BC_UPDATE","更新");

if (!defined("_BC_CONTACTWEBMASTER")) DEFINE("_BC_CONTACTWEBMASTER", "發生錯誤, �?�絡您的網站管�?�員");
if (!defined("_BC_NOT_IMPLEMENTED")) DEFINE("_BC_NOT_IMPLEMENTED", "尚未啟用");

if (!defined("_BC_ERROR_MOSCONFIG")) DEFINE("_BC_ERROR_MOSCONFIG", "無效的數值, 請更正�?題或�?�絡 blastchat 支�?��?�助");
if (!defined("_BC_ERROR_TABLE")) DEFINE("_BC_ERROR_TABLE", "表格");
if (!defined("_BC_ERROR_NOPOPUP")) DEFINE("_BC_ERROR_NOPOPUP", "�?能分離�?�天視窗, 您的�?覽器�?鎖了快顯視窗");
if (!defined("_BC_ERROR_0002")) DEFINE("_BC_ERROR_0002", "�?正確資料於");
if (!defined("_BC_ERROR_0003")) DEFINE("_BC_ERROR_0003", "�?一致資料於");

if (!defined("_BC_LICENSE_INFO")) DEFINE("_BC_LICENSE_INFO", "你�?�以安�?�?�使用此元件於商業性網站上, 但其他商業用途則被�?止, 譬如以收費方�?�??供本元件的安�? (例如作為網站寄存套件一部分).");
?>