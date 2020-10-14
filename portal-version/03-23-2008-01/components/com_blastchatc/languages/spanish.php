<?php
/**
* spanish.php
* @package BlastChat client
* @copyright 2004-2007 BlastChat
* @license Creative Commons Attribution-Noncommercial-Share Alike 3.0 United States License. http://creativecommons.org/licenses/by-nc-sa/3.0/us/
* @license Permissions beyond the scope of this license may be available at http://www.blastchat.com/client_license.html
* @version $Revision: 2.1 $
* @author Peter Saitz <support@blastchat.com>
* @HomePage <www.blastchat.com>
**/

/**
* Credit to translators
* Version 2.2
* Name: Alcor
* Contact email:<webmaster@cosasagapornis.com>
* URL:<www.cosasagapornis.com>
* The other versions
* Name: Renoir
* Contact email:<webmaster@gruposvulnerables.org>
* URL:<www.gruposvulnerables.org>
**/
//New in version 2.2
if (!defined("_BC_LICENSE_INFO_HEADER")) DEFINE("_BC_LICENSE_INFO_HEADER", "Excepción");
if (!defined("_BC_MENU_CONFIG_SAVE")) DEFINE("_BC_MENU_CONFIG_SAVE", "Configuración guardada");
if (!defined("_BC_DATABASE_UPDATED")) DEFINE("_BC_DATABASE_UPDATED","Base de datos actualizada");
	//New for module 2.2
	if (!defined("_BC_JOINCHAT")) DEFINE("_BC_JOINCHAT", "Entrar al chat");
	if (!defined("_BC_CHATLINK")) DEFINE("_BC_CHATLINK", "Entrar al chat");
	if (!defined("_BC_CBLINK")) DEFINE("_BC_CBLINK", "Mostrar perfil");
	if (!defined("_BC_SMFLINK")) DEFINE("_BC_SMFLINK", "Mostrar perfil");
	if (!defined("_BC_MEMBER")) DEFINE("_BC_MEMBER", "Miembro &quot;%s&quot;");
	if (!defined("_BC_USER_INSIDE_CHAT")) DEFINE("_BC_USER_INSIDE_CHAT", "<br>Dentro del chat [%s idle].");
	if (!defined("_BC_USER_NOT_CHATTING")) DEFINE("_BC_USER_NOT_CHATTING", "<br>No está chateando.");
	if (!defined("_BC_USER_CHATTING_IN")) DEFINE("_BC_USER_CHATTING_IN", "<br>Chateando en el room &quot;%s&quot; [%s idle].");
	if (!defined("_BC_CHATTING")) DEFINE("_BC_CHATTING", "chateando");
	if (!defined("_BC_USER_LASTLOGIN")) DEFINE("_BC_USER_LASTLOGIN", "<br>Último login:<br>%s");
	if (!defined("_BC_GLOBALSTATUS")) DEFINE("_BC_GLOBALSTATUS", "estado global");
	if (!defined("_BC_LASTUPDATE")) DEFINE("_BC_LASTUPDATE", "<br><br>Última actualización:<br>%s");
	if (!defined("_BC_GLOBALCOUNT")) DEFINE("_BC_GLOBALCOUNT", "Hay %s chatters en línea.");

//New in version 2.1
if (!defined('_BC_DATABASE_UPDATE')) DEFINE("_BC_DATABASE_UPDATE","Actualizar Base de Datos de version");
if (!defined('_BC_DATABASE_CURRENT')) DEFINE("_BC_DATABASE_CURRENT","Versión de Base de datos");
if (!defined('_BC_DATABASE_WRONG')) DEFINE("_BC_DATABASE_WRONG","Versión de Base de Datos incorrecta");
if (!defined('_BC_INSTAL_FAIL')) DEFINE("_BC_INSTAL_FAIL","Falló la Instalación");

//New in version 2.0
//component menus
if (!defined('_BC_MENU_USERS')) DEFINE("_BC_MENU_USERS","Usuarios");
if (!defined('_BC_MENU_CONFIG')) DEFINE("_BC_MENU_CONFIG","Configuración");
if (!defined('_BC_MENU_REG')) DEFINE("_BC_MENU_REG","Registro");

//registration
if (!defined('_BC_DETACHED')) DEFINE("_BC_DETACHED","Separado");
if (!defined('_BC_DETACHED_DES')) DEFINE("_BC_DETACHED_DES","El link al componente abrirá el cliente BlastChat en ventana separada");
if (!defined('_BC_WIDTH')) DEFINE("_BC_WIDTH","Ancho");
if (!defined('_BC_WIDTH_DES')) DEFINE("_BC_WIDTH_DES","Ancho por defecto");
if (!defined('_BC_HEIGHT')) DEFINE("_BC_HEIGHT","Alto");
if (!defined('_BC_HEIGHT_DES')) DEFINE("_BC_HEIGHT_DES","Alto por defecto");
if (!defined('_BC_DWIDTH')) DEFINE("_BC_DWIDTH","Ancho separado");
if (!defined('_BC_DWIDTH_DES')) DEFINE("_BC_DWIDTH_DES","Ancho por defecto separado");
if (!defined('_BC_DHEIGHT')) DEFINE("_BC_DHEIGHT","Alto separado");
if (!defined('_BC_DHEIGHT_DES')) DEFINE("_BC_DHEIGHT_DES","Alto por defecto separado");
if (!defined('_BC_FRAMEBORDER')) DEFINE("_BC_FRAMEBORDER","Borde del marco");
if (!defined('_BC_FRAMEBORDER_DES')) DEFINE("_BC_FRAMEBORDER_DES","Borde del marco por defecto");
if (!defined('_BC_MWIDTH')) DEFINE("_BC_MWIDTH","Ancho de margen");
if (!defined('_BC_MWIDTH_DES')) DEFINE("_BC_MWIDTH_DES","Ancho de margen del marco por defecto");
if (!defined('_BC_MHEIGHT')) DEFINE("_BC_MHEIGHT","Alto de margen");
if (!defined('_BC_MHEIGHT_DES')) DEFINE("_BC_MHEIGHT_DES","Alto de margen del marco por defecto");

if (!defined('_BC_INSTAL')) DEFINE("_BC_INSTAL","Instalación exitosa");
if (!defined('_BC_UNINSTAL')) DEFINE("_BC_UNINSTAL","Desinstalación exitosa");
if (!defined('_BC_MUSTREG')) DEFINE("_BC_MUSTREG","Primero debe registrar su servidor");
if (!defined('_BC_REGNOW')) DEFINE("_BC_REGNOW","REGISTRE su servidor ahora");

if (!defined('_BC_NEXT')) DEFINE("_BC_NEXT","Siguiente");
if (!defined('_BC_RESULT')) DEFINE("_BC_RESULT","Resultado");
if (!defined('_BC_UPDATE')) DEFINE("_BC_UPDATE","Actualizar");

if (!defined('_BC_CONTACTWEBMASTER')) DEFINE("_BC_CONTACTWEBMASTER", "Un error ha occurrido, contacte al webmaster");
if (!defined('_BC_NOT_IMPLEMENTED')) DEFINE("_BC_NOT_IMPLEMENTED", "No implementado aún");

if (!defined('_BC_ERROR_MOSCONFIG')) DEFINE("_BC_ERROR_MOSCONFIG", "valor inválido, corrija el problema o contacte al soporte de BlastChat para ayuda");
if (!defined('_BC_ERROR_TABLE')) DEFINE("_BC_ERROR_TABLE", "tabla");
if (!defined('_BC_ERROR_NOPOPUP')) DEFINE("_BC_ERROR_NOPOPUP", "No se puede separar la ventana de chat, su navegador bloquea las pop-up");
if (!defined('_BC_ERROR_0002')) DEFINE("_BC_ERROR_0002", "Dato incorrecto en");
if (!defined('_BC_ERROR_0003')) DEFINE("_BC_ERROR_0003", "Dato inconsistente en");

if (!defined('_BC_LICENSE_INFO')) DEFINE("_BC_LICENSE_INFO", "Exepciones: puede instalar y usar este componente en un sitio comercial, cualquier otro uso comercial está prohibido, como ofrecer la instalación de este producto por una tarifa (por ejemplo, como parte de un paquete de hospedaje web).");
?>