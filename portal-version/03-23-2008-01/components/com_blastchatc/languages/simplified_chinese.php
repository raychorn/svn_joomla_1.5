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
if (!defined("_BC_MENU_CONFIG_SAVE")) DEFINE("_BC_MENU_CONFIG_SAVE", "设定已储存");
if (!defined("_BC_DATABASE_UPDATED")) DEFINE("_BC_DATABASE_UPDATED","数�?�库已更新");
	//New for module 2.2
	if (!defined("_BC_JOINCHAT")) DEFINE("_BC_JOINCHAT", "加入�?�天");
	if (!defined("_BC_CHATLINK")) DEFINE("_BC_CHATLINK", "加入�?�天");
	if (!defined("_BC_CBLINK")) DEFINE("_BC_CBLINK", "显示个人档案");
	if (!defined("_BC_SMFLINK")) DEFINE("_BC_SMFLINK", "显示个人档案");
	if (!defined("_BC_MEMBER")) DEFINE("_BC_MEMBER", "会员 &quot;%s&quot;");
	if (!defined("_BC_USER_INSIDE_CHAT")) DEFINE("_BC_USER_INSIDE_CHAT", "<br>于�?�天室 [%s 闲置].");
	if (!defined("_BC_USER_NOT_CHATTING")) DEFINE("_BC_USER_NOT_CHATTING", "<br>�?在�?�天室.");
	if (!defined("_BC_USER_CHATTING_IN")) DEFINE("_BC_USER_CHATTING_IN", "<br>正在�?�天于 &quot;%s&quot; [%s 闲置].");
	if (!defined("_BC_CHATTING")) DEFINE("_BC_CHATTING", "�?�天");
	if (!defined("_BC_USER_LASTLOGIN")) DEFINE("_BC_USER_LASTLOGIN", "<br>最�?�登入:<br>%s");
	if (!defined("_BC_GLOBALSTATUS")) DEFINE("_BC_GLOBALSTATUS", "全域状况");
	if (!defined("_BC_LASTUPDATE")) DEFINE("_BC_LASTUPDATE", "<br><br>最�?�更新:<br>%s");
	if (!defined("_BC_GLOBALCOUNT")) DEFINE("_BC_GLOBALCOUNT", "有 %s �?�?�客在在线.");


//New in version 2.1
if (!defined("_BC_DATABASE_UPDATE")) DEFINE("_BC_DATABASE_UPDATE","更新数�?�库自版本");
if (!defined("_BC_DATABASE_CURRENT")) DEFINE("_BC_DATABASE_CURRENT","数�?�库现时版本");
if (!defined("_BC_DATABASE_WRONG")) DEFINE("_BC_DATABASE_WRONG","�?正确数�?�库版本");
if (!defined("_BC_INSTAL_FAIL")) DEFINE("_BC_INSTAL_FAIL","安装失败");

//New in version 2.0
//component menus
if (!defined("_BC_MENU_USERS")) DEFINE("_BC_MENU_USERS","用户");
if (!defined("_BC_MENU_CONFIG")) DEFINE("_BC_MENU_CONFIG","设定");
if (!defined("_BC_MENU_REG")) DEFINE("_BC_MENU_REG","注册");

//registration
if (!defined("_BC_DETACHED")) DEFINE("_BC_DETACHED","分离");
if (!defined("_BC_DETACHED_DES")) DEFINE("_BC_DETACHED_DES","预设连结组件到选�?�会以分离样�?开�?� BlastChat 客端");
if (!defined("_BC_WIDTH")) DEFINE("_BC_WIDTH","宽度");
if (!defined("_BC_WIDTH_DES")) DEFINE("_BC_WIDTH_DES","预设框架宽度");
if (!defined("_BC_HEIGHT")) DEFINE("_BC_HEIGHT","高度");
if (!defined("_BC_HEIGHT_DES")) DEFINE("_BC_HEIGHT_DES","预设框架高度");
if (!defined("_BC_DWIDTH")) DEFINE("_BC_DWIDTH","分离框架宽度");
if (!defined("_BC_DWIDTH_DES")) DEFINE("_BC_DWIDTH_DES","预设分离样�?框架宽度");
if (!defined("_BC_DHEIGHT")) DEFINE("_BC_DHEIGHT","分离框架高度");
if (!defined("_BC_DHEIGHT_DES")) DEFINE("_BC_DHEIGHT_DES","预设分离样�?框架高度");
if (!defined("_BC_FRAMEBORDER")) DEFINE("_BC_FRAMEBORDER","框架边线");
if (!defined("_BC_FRAMEBORDER_DES")) DEFINE("_BC_FRAMEBORDER_DES","预设框架边线");
if (!defined("_BC_MWIDTH")) DEFINE("_BC_MWIDTH","边界宽度");
if (!defined("_BC_MWIDTH_DES")) DEFINE("_BC_MWIDTH_DES","预设框架边界宽度");
if (!defined("_BC_MHEIGHT")) DEFINE("_BC_MHEIGHT","边界高度");
if (!defined("_BC_MHEIGHT_DES")) DEFINE("_BC_MHEIGHT_DES","预设边界高度");

if (!defined("_BC_INSTAL")) DEFINE("_BC_INSTAL","安装�?功");
if (!defined("_BC_UNINSTAL")) DEFINE("_BC_UNINSTAL","�?功移除");
if (!defined("_BC_MUSTREG")) DEFINE("_BC_MUSTREG","首先, 您必须注册您的�?务器");
if (!defined("_BC_REGNOW")) DEFINE("_BC_REGNOW","立�?�注册您的�?务器");

if (!defined("_BC_NEXT")) DEFINE("_BC_NEXT","下页");
if (!defined("_BC_RESULT")) DEFINE("_BC_RESULT","结果");
if (!defined("_BC_UPDATE")) DEFINE("_BC_UPDATE","更新");

if (!defined("_BC_CONTACTWEBMASTER")) DEFINE("_BC_CONTACTWEBMASTER", "�?�生错误, �?�络您的网站管�?�员");
if (!defined("_BC_NOT_IMPLEMENTED")) DEFINE("_BC_NOT_IMPLEMENTED", "尚未�?�用");

if (!defined("_BC_ERROR_MOSCONFIG")) DEFINE("_BC_ERROR_MOSCONFIG", "无效的数值, 请更正问题或�?�络 blastchat 支�?�??助");
if (!defined("_BC_ERROR_TABLE")) DEFINE("_BC_ERROR_TABLE", "表格");
if (!defined("_BC_ERROR_NOPOPUP")) DEFINE("_BC_ERROR_NOPOPUP", "�?能分离�?�天窗�?�, 您的�?览器�?�?了快显窗�?�");
if (!defined("_BC_ERROR_0002")) DEFINE("_BC_ERROR_0002", "�?正确数�?�于");
if (!defined("_BC_ERROR_0003")) DEFINE("_BC_ERROR_0003", "�?一致资料于");

if (!defined("_BC_LICENSE_INFO")) DEFINE("_BC_LICENSE_INFO", "你�?�以安装�?�使用此组件于商业性网站上, 但其它商业用途则被�?止, 譬如以收费方�?�??供本组件的安装 (例如作为网站寄存套件一部分).");
?>
