<?php
/**
* english.php
* @package BlastChat client 2.3
* @copyright 2004-2007 BlastChat
* @license Creative Commons Attribution-Noncommercial-Share Alike 3.0 United States License. http://creativecommons.org/licenses/by-nc-sa/3.0/us/
* @license Permissions beyond the scope of this license may be available at http://www.blastchat.com/client_license.html
* @version $Revision: 2.3 $
* @author Peter Saitz <support@blastchat.com>
* @encoding UTF-8
* @HomePage <www.blastchat.com>
**/

/**
* Credit to translators
* Name: Francesco Corrado aka CyberSalsero
* Email:webmaster@portalesalsero.it
* URL: www.joomlatopten.com /www.portalesalsero.it
**/

/**
1. Please, adjust file name and revision in top section in your language file
2. Please, use UTF-8 encoding of your language file, othervice specifically mention what encoding is used and mark it in file name as well. (i.e. english_WIN.php or something similar)
3. Feel free to fill in your credentials in "Credit to translators" section. If that is already filled, keep previous translator's data in and copy/paste new section for yourself.
4. Please, submit your new translated file to support [at] blastchat.com
**/

//New in version 2.3
if (!defined('_BC_NAME')) DEFINE('_BC_NAME','Nome');
if (!defined('_BC_USERNAME')) DEFINE('_BC_USERNAME','Username');
if (!defined('_BC_EMAIL')) DEFINE('_BC_EMAIL','Email');
if (!defined('_BC_NOUSERS')) DEFINE('_BC_NOUSERS','Gli utenti vengono creati nel sistema Blastchat quando un utente registrato al tuo sito entra in chat dal tuo frontend (non dal backend).');
if (!defined('_BC_LOGGEDIN')) DEFINE('_BC_LOGGEDIN','Loggato');
if (!defined('_BC_INCHAT')) DEFINE('_BC_INCHAT','In Chat');
if (!defined('_BC_ENABLED')) DEFINE('_BC_ENABLED','Abilitato');
if (!defined('_BC_CHATTING_U')) DEFINE('_BC_CHATTING_U','In chat');
if (!defined('_BC_ID')) DEFINE('_BC_ID','ID');
if (!defined('_BC_INROOM')) DEFINE('_BC_INROOM','Nella&nbsp;stanza');
if (!defined('_BC_GROUP')) DEFINE('_BC_GROUP','Gruppo');
if (!defined('_BC_ROOMNAME')) DEFINE('_BC_ROOMNAME','Nome Stanza');
if (!defined('_BC_SECURITYCODE')) DEFINE('_BC_SECURITYCODE','Codice&nbsp;di&nbsp;sicurezza');
if (!defined('_BC_LASTVISIT')) DEFINE('_BC_LASTVISIT','Ultima&nbsp;Visita');
if (!defined('_BC_LASTCHATENTRY')) DEFINE('_BC_LASTCHATENTRY','Ultimo&nbsp;Inserimento');
if (!defined('_BC_LASTCHATACTIVITY')) DEFINE('_BC_LASTCHATACTIVITY','Ultima attività in chat');
if (!defined('_BC_FILTER')) DEFINE('_BC_FILTER','Filtro');
if (!defined('_BC_DETACH')) DEFINE('_BC_DETACH','Stacca');
if (!defined('_BC_DETACH_DESC')) DEFINE('_BC_DETACH_DESC','Stacca la finestra di configurazione server');
if (!defined('_BC_UNDETACH')) DEFINE('_BC_UNDETACH','Ingloba');
if (!defined('_BC_UNDETACH_DESC')) DEFINE('_BC_UNDETACH_DESC','Ingloba la finestra di configurazione server');
if (!defined('_BC_EXPAND')) DEFINE('_BC_EXPAND','Espandi');
if (!defined('_BC_EXPAND_DESC')) DEFINE('_BC_EXPAND_DESC','Espande la finestra di configurazione server');
if (!defined('_BC_COLLAPSE')) DEFINE('_BC_COLLAPSE','Riduci');
if (!defined('_BC_COLLAPSE_DESC')) DEFINE('_BC_COLLAPSE_DESC','Riduce la finestra di configurazione server');
if (!defined("_BC_WEBSITE")) DEFINE("_BC_WEBSITE", "Sito Web");
if (!defined("_BC_DELETEWEBSITE")) DEFINE("_BC_DELETEWEBSITE", "(Questo cancellerà tutti i dati dalle tabelle blastchatc e blastchatc_users connesse a questo sito Web, e ivaliderà la tua registrazione al servizio BlastChat.)");
if (!defined("_BC_DELETEUSER")) DEFINE("_BC_DELETEUSER", "(Questo cancellerà l'utente(i) selezionato(i).)");
if (!defined("_BC_OLDBROWSER")) DEFINE("_BC_OLDBROWSER", "Questo sito usa DHTML. Ti raccomandiamo di aggiornare il tuo browser.");
if (!defined("_BC_OPENUNDETACHED")) DEFINE("_BC_OPENUNDETACHED", "Clicca %s per caricare la chat all\'interno dele tue pagine.");
if (!defined("_BC_OPENUNDETACHED_HERE")) DEFINE("_BC_OPENUNDETACHED_HERE", "qui"); //filling %s in previous definition
if (!defined("_BC_ERROR_0004")) DEFINE("_BC_ERROR_0004", "Errore dureante l\'aggiornamento del database");
if (!defined("_BC_MENU_CONFIG_C")) DEFINE("_BC_MENU_CONFIG_C","Configurazione lato Client(locale - admin backend)");
if (!defined("_BC_MENU_CONFIG_S")) DEFINE("_BC_MENU_CONFIG_S","Configurazione lato Server(remoto - account blastchat)");
if (!defined("_BC_MUSTREG")) DEFINE("_BC_MUSTREG","Innanzitutto, devi registrare il tuo sito");
if (!defined("_BC_REGNOW")) DEFINE("_BC_REGNOW","REGISTRA ora il tuo sito, &egrave; gratuito");
if (!defined("_BC_MENU_USERS_DELETE")) DEFINE("_BC_MENU_USERS_DELETE", "Utente(i) eliminato(i)");
if (!defined("_BC_MENU_WEBSITE_DELETE")) DEFINE("_BC_MENU_WEBSITE_DELETE", "Sito eliminato");
if (!defined("_BC_MENU_CREDITS")) DEFINE("_BC_MENU_CREDITS","Ringraziamenti");
//for Mambo sites which ar emissing this definition
if (!defined("_CURRENT_SERVER_TIME_FORMAT")) DEFINE( '_CURRENT_SERVER_TIME_FORMAT', '%d-%m-%Y %H:%M:%S' );

	/** new for module  */
	if (!defined('_BC_NEVER')) DEFINE('_BC_NEVER','Mai');
	if (!defined("_BC_USER_LASTCHATENTRY")) DEFINE("_BC_USER_LASTCHATENTRY", "<br><br><b>Visto in chat il:</b><br>%s");
	if (!defined('_BC_WE_HAVE')) DEFINE('_BC_WE_HAVE', 'Abbiamo ');
	if (!defined('_BC_AND')) DEFINE('_BC_AND', ' e ');
	if (!defined('_BC_GUEST_COUNT')) DEFINE('_BC_GUEST_COUNT','%s ospite');
	if (!defined('_BC_GUESTS_COUNT')) DEFINE('_BC_GUESTS_COUNT','%s ospiti');
	if (!defined('_BC_MEMBER_COUNT')) DEFINE('_BC_MEMBER_COUNT','%s registrato');
	if (!defined('_BC_MEMBERS_COUNT')) DEFINE('_BC_MEMBERS_COUNT','%s registrati');
	if (!defined('_BC_ONLINE')) DEFINE('_BC_ONLINE',' online');
	if (!defined('_BC_NONE')) DEFINE('_BC_NONE','Nessun Utente Online');
	/**change in module **/
	if (!defined("_BC_USER_LASTLOGIN")) DEFINE("_BC_USER_LASTLOGIN", "<br><b>On-line dal:</b><br>%s");
	if (!defined("_BC_MEMBER")) DEFINE("_BC_MEMBER", "<b>L\' utente &quot;%s&quot;</b>");

//New in version 2.2
if (!defined("_BC_LICENSE_INFO_HEADER")) DEFINE("_BC_LICENSE_INFO_HEADER", "Licenza");
if (!defined("_BC_MENU_CONFIG_SAVE")) DEFINE("_BC_MENU_CONFIG_SAVE", "Configurazione salvata");
if (!defined("_BC_DATABASE_UPDATED")) DEFINE("_BC_DATABASE_UPDATED","Database aggiornato");
	//New for module 2.2
	if (!defined("_BC_JOINCHAT")) DEFINE("_BC_JOINCHAT", "Entra in chat!");
	if (!defined("_BC_CHATLINK")) DEFINE("_BC_CHATLINK", "Clicca per entrare in chat!");
	if (!defined("_BC_CBLINK")) DEFINE("_BC_CBLINK", "Clicca per visitare il profilo");
	if (!defined("_BC_SMFLINK")) DEFINE("_BC_SMFLINK", "Mostra profilo");
	if (!defined("_BC_USER_INSIDE_CHAT")) DEFINE("_BC_USER_INSIDE_CHAT", "<br>In chat [%s idle].");
	if (!defined("_BC_USER_NOT_CHATTING")) DEFINE("_BC_USER_NOT_CHATTING", "<br>Non &egrave; in chat.");
	if (!defined("_BC_USER_CHATTING_IN")) DEFINE("_BC_USER_CHATTING_IN", "<br>Sta chattando nella stanza &quot;%s&quot; [%s idle].");
	if (!defined("_BC_CHATTING")) DEFINE("_BC_CHATTING", "in chat");
	if (!defined("_BC_GLOBALSTATUS")) DEFINE("_BC_GLOBALSTATUS", "status globale");
	if (!defined("_BC_LASTUPDATE")) DEFINE("_BC_LASTUPDATE", "<br><br>Ultimo aggiornamento:<br>%s");
	if (!defined("_BC_GLOBALCOUNT")) DEFINE("_BC_GLOBALCOUNT", "Abbiamo %s-users in chat.");


//New in version 2.1
if (!defined("_BC_DATABASE_UPDATE")) DEFINE("_BC_DATABASE_UPDATE","Aggiorna il database dalla versione");
if (!defined("_BC_DATABASE_CURRENT")) DEFINE("_BC_DATABASE_CURRENT","Database aggiornato alla versione corrente");
if (!defined("_BC_DATABASE_WRONG")) DEFINE("_BC_DATABASE_WRONG","Incorrect database version");
if (!defined("_BC_INSTAL_FAIL")) DEFINE("_BC_INSTAL_FAIL","Installazione fallita");

//New in version 2.0
//component menus
if (!defined("_BC_MENU_USERS")) DEFINE("_BC_MENU_USERS","Utenti");
if (!defined("_BC_MENU_CONFIG")) DEFINE("_BC_MENU_CONFIG","Configurazione");
if (!defined("_BC_MENU_REG")) DEFINE("_BC_MENU_REG","Registrazione");

//registration
if (!defined("_BC_DETACHED")) DEFINE("_BC_DETACHED","Staccato");
if (!defined("_BC_DETACHED_DES")) DEFINE("_BC_DETACHED_DES","I link predefiniti al componente apriranno il client BlastChat come una finestra staccata");
if (!defined("_BC_WIDTH")) DEFINE("_BC_WIDTH","Larghezza");
if (!defined("_BC_WIDTH_DES")) DEFINE("_BC_WIDTH_DES","Larghezza predefinita della cornice");
if (!defined("_BC_HEIGHT")) DEFINE("_BC_HEIGHT","Altezza");
if (!defined("_BC_HEIGHT_DES")) DEFINE("_BC_HEIGHT_DES","Altezza predefinita della cornice");
if (!defined("_BC_DWIDTH")) DEFINE("_BC_DWIDTH","Larghezza finestra staccata");
if (!defined("_BC_DWIDTH_DES")) DEFINE("_BC_DWIDTH_DES","Larghezza predefinita della finestra staccata");
if (!defined("_BC_DHEIGHT")) DEFINE("_BC_DHEIGHT","Altezza finestra staccata");
if (!defined("_BC_DHEIGHT_DES")) DEFINE("_BC_DHEIGHT_DES","Altezza predefinita della finestra staccata");
if (!defined("_BC_FRAMEBORDER")) DEFINE("_BC_FRAMEBORDER","Bordo cornice");
if (!defined("_BC_FRAMEBORDER_DES")) DEFINE("_BC_FRAMEBORDER_DES","Bordo predefinito della cornice");
if (!defined("_BC_MWIDTH")) DEFINE("_BC_MWIDTH","Spessore margine");
if (!defined("_BC_MWIDTH_DES")) DEFINE("_BC_MWIDTH_DES","Spessore predefinito del margine della cornice");
if (!defined("_BC_MHEIGHT")) DEFINE("_BC_MHEIGHT","Altezza margine");
if (!defined("_BC_MHEIGHT_DES")) DEFINE("_BC_MHEIGHT_DES","Altezza predefinita del margine della cornice");

if (!defined("_BC_INSTAL")) DEFINE("_BC_INSTAL","Installazione riuscita");
if (!defined("_BC_UNINSTAL")) DEFINE("_BC_UNINSTAL","disinstallazione riuscita");

if (!defined("_BC_NEXT")) DEFINE("_BC_NEXT","Avanti");
if (!defined("_BC_RESULT")) DEFINE("_BC_RESULT","Risultato");
if (!defined("_BC_UPDATE")) DEFINE("_BC_UPDATE","Aggiorna");

if (!defined("_BC_CONTACTWEBMASTER")) DEFINE("_BC_CONTACTWEBMASTER", "C\'&egrave; stato un errore, contatta il tuo webmaster");
if (!defined("_BC_NOT_IMPLEMENTED")) DEFINE("_BC_NOT_IMPLEMENTED", "Non ancora implementato");

if (!defined("_BC_ERROR_MOSCONFIG")) DEFINE("_BC_ERROR_MOSCONFIG", "volore non valido, correggi il problema o contatta il support di Blastchat per un aiuto");
if (!defined("_BC_ERROR_TABLE")) DEFINE("_BC_ERROR_TABLE", "tabella");
if (!defined("_BC_ERROR_NOPOPUP")) DEFINE("_BC_ERROR_NOPOPUP", "Non posso aprire una nuova finestra, il tuo browser sta bloccando i pop-up.");
if (!defined("_BC_ERROR_0002")) DEFINE("_BC_ERROR_0002", "Inserimento non corretto");
if (!defined("_BC_ERROR_0003")) DEFINE("_BC_ERROR_0003", "Dati non sufficienti");

if (!defined("_BC_LICENSE_INFO")) DEFINE("_BC_LICENSE_INFO", ": Puoi installare e usare questo componente su siti commerciali, ogni altro uso commerciale &egrave; proibito, come offrire l'istallazione di questo componente a pagamento(per esempio come parte di pacchetti forniti da web hosting).");
?>