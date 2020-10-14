<?php
/*********************************************
* mXcomment - Component                      *
* Copyright (C) 2007-2008 by Bernard Gilly   *
* --------- All Rights Reserved ------------ *      
* Homepage   : www.visualclinic.fr           *
* Version    : 1.0.7                         *
* License    : Creative Commons              *
*********************************************/

// ensure this file is being included by a parent file
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require( $mosConfig_absolute_path.'/components/com_maxcomment/includes/common/wordwrap.php' );
require( $mosConfig_absolute_path.'/components/com_maxcomment/includes/common/maxcomment.parser.php' );

eval(stripslashes(base64_decode("ZnVuY3Rpb24gX2dldEFuY2hvcigpIHsNCglnbG9iYWwgJENPTU1FTlQ7DQoJZWNobyBcIm1heGNvbW1lbnRcIiAuICRDT01NRU5ULT5pZDsNCn0NCg0KZnVuY3Rpb24gX2dldElwQ29tbWVudCgpIHsNCglnbG9iYWwgJG1vc0NvbmZpZ19hYnNvbHV0ZV9wYXRoLCAkQ09NTUVOVDsNCgkNCglyZXF1aXJlKCRtb3NDb25maWdfYWJzb2x1dGVfcGF0aC5cJy9hZG1pbmlzdHJhdG9yL2NvbXBvbmVudHMvY29tX21heGNvbW1lbnQvbWF4Y29tbWVudF9jb25maWcucGhwXCcpOw0KCQ0KCWlmICggJG14Y19zaG93SXAgKSB7DQoJCWVjaG8gJENPTU1FTlQtPmlwOw0KCX0NCgkNCn0NCg0KZnVuY3Rpb24gX2dldFVzZXJSYXRpbmcoKSB7DQoJZ2xvYmFsICRtb3NDb25maWdfbGl2ZV9zaXRlLCAkbW9zQ29uZmlnX2Fic29sdXRlX3BhdGgsICRDT01NRU5UOw0KCQkNCglyZXF1aXJlKCRtb3NDb25maWdfYWJzb2x1dGVfcGF0aC5cJy9hZG1pbmlzdHJhdG9yL2NvbXBvbmVudHMvY29tX21heGNvbW1lbnQvbWF4Y29tbWVudF9jb25maWcucGhwXCcpOw0KCQ0KCSR1c2VyUmF0aW5nID0gXCJcIjsNCgkNCglpZiAoICRteGNfcmF0aW5ndXNlciApIHsNCgkNCgkJaWYgKCAkQ09NTUVOVC0+cmF0aW5nICkgJENPTU1FTlQtPnJhdGluZyA9IGNvbmZpcm1fZXZhbHVhdGUoICRDT01NRU5ULT5yYXRpbmcsICRDT01NRU5ULT5jdXJyZW50bGV2ZWxyYXRpbmcsICRteGNfbGV2ZWxyYXRpbmcgKTsJDQoJDQoJCXN3aXRjaCAoICRteGNfbGV2ZWxyYXRpbmcgKSB7DQoJCQljYXNlIFwiMjBcIjoJCQkJDQoJCQljYXNlIFwiMTBcIjoNCgkJCQkJJHVzZXJSYXRpbmcgPSAkQ09NTUVOVC0+cmF0aW5nIC4gXCIvXCIgLiAkbXhjX2xldmVscmF0aW5nOw0KCQkJCQlpZiAoICRDT01NRU5ULT5yYXRpbmcgPT0gMCApICR1c2VyUmF0aW5nID0gJG5vX3JhdGluZzsNCgkJCQlicmVhazsNCgkJCWNhc2UgXCI1XCI6DQoJCQlkZWZhdWx0OgkJCQkNCgkJCQkkdXNlclJhdGluZyA9IFwiPGltZyBzcmM9XCdcIiAuICRtb3NDb25maWdfbGl2ZV9zaXRlIC4gXCIvY29tcG9uZW50cy9jb21fbWF4Y29tbWVudC90ZW1wbGF0ZXMvXCIgLiAkbXhjX3RlbXBsYXRlIC4gXCIvaW1hZ2VzL3JhdGluZy91c2VyX3JhdGluZ19cIiAuICRDT01NRU5ULT5yYXRpbmcgLiBcIi5naWZcJyBhbGlnbj1cJ21pZGRsZVwnIGJvcmRlcj1cJzBcJyBhbHQ9XCdcJyAvPlwiOw0KCQl9DQoJCQ0KCX0NCgkNCgllY2hvICR1c2VyUmF0aW5nOw0KDQp9DQoNCmZ1bmN0aW9uIF9nZXRBdXRob3JDb21tZW50KCkgew0KCWdsb2JhbCAkZGF0YWJhc2UsICRtb3NDb25maWdfYWJzb2x1dGVfcGF0aCwgJG15LCAkQ09NTUVOVDsNCgkNCglyZXF1aXJlKCRtb3NDb25maWdfYWJzb2x1dGVfcGF0aC5cJy9hZG1pbmlzdHJhdG9yL2NvbXBvbmVudHMvY29tX21heGNvbW1lbnQvbWF4Y29tbWVudF9jb25maWcucGhwXCcpOwkNCgkNCgkkY2hlY2tDQmNvbXBvbmVudCA9IGNoZWNrQ0Jjb21wb25lbnQoKTsNCglpZiggJENPTU1FTlQtPmlkdXNlciAmJiAkbXhjX0xpbmtDQlByb2ZpbGUgJiYgJGNoZWNrQ0Jjb21wb25lbnQgKXsJDQoJCSRsaW5rYXV0aG9yY29tbWVudCA9IHNlZlJlbFRvQWJzKCBcJ2luZGV4LnBocD9vcHRpb249Y29tX2NvbXByb2ZpbGVyJmFtcDt0YXNrPXVzZXJQcm9maWxlJmFtcDt1c2VyPVwnIC4gJENPTU1FTlQtPmlkdXNlciAuIENCQXV0aG9ySXRlbWlkKCkgKTsNCgkJJGF1dGhvckNvbW1lbnQgPSBcIjxhIGhyZWY9XCdcIiAuICRsaW5rYXV0aG9yY29tbWVudCAuIFwiXCc+XCIgLiBzdHJpcHNsYXNoZXMoICRDT01NRU5ULT5uYW1lICkgLiBcIjwvYT5cIjsNCgl9IGVsc2UgewkNCgkJaWYgKCAkQ09NTUVOVC0+aWR1c2VyICkgew0KCQkJJHRoZW5hbWUgPSAoICRteGNfdXNlX25hbWUgKSA/IFwnbmFtZVwnIDogXCd1c2VybmFtZVwnOw0KCQkJJHF1ZXJ5ID0gXCJTRUxFQ1QgJHRoZW5hbWVcIg0KCQkJLiBcIlxcbiBGUk9NICNfX3VzZXJzXCINCgkJCS4gXCJcXG4gV0hFUkUgaWQgPSBcJyRDT01NRU5ULT5pZHVzZXJcJ1wiDQoJCQk7DQoJCQkkZGF0YWJhc2UtPnNldFF1ZXJ5KCAkcXVlcnkgKTsJDQoJCQkkYXV0aG9yQ29tbWVudCA9IHN0cmlwc2xhc2hlcyggJGRhdGFiYXNlLT5sb2FkUmVzdWx0KCkgKTsJDQoJCX0gZWxzZSB7DQoJCQkkYXV0aG9yQ29tbWVudCA9IHN0cmlwc2xhc2hlcyggJENPTU1FTlQtPm5hbWUgKTsNCgkJfQkJDQoJfQ0KCQ0KCS8vIEJhZCB3b3Jkcw0KCWlmICggJG14Y19iYWR3b3JkcyApew0KCQkkcXVlcnkgPSBcIlNFTEVDVCAqIEZST00gI19fbXhjX2JhZHdvcmRzIFdIRVJFIHB1Ymxpc2hlZD1cJzFcJ1wiOw0KCQkkZGF0YWJhc2UtPnNldFF1ZXJ5KCAkcXVlcnkgKTsNCgkJJHJvd3NiYWR3b3JkcyA9ICRkYXRhYmFzZS0+bG9hZE9iamVjdExpc3QoKTsNCgkJaWYgKCAkcm93c2JhZHdvcmRzICkgew0KCQkJZm9yZWFjaCAoICRyb3dzYmFkd29yZHMgYXMgJHJvd2JhZHdvcmQgKSB7DQoJCQkJJGJhZHdvcmQgPSB0cmltKCAkcm93YmFkd29yZC0+YmFkd29yZCApOw0KCQkJCSRyZXBsYWNlYmFkd29yZCA9IHN0cl9yZXBlYXQoIFwnKlwnLCBzdHJsZW4oICRiYWR3b3JkICkgKTsNCgkJCQkkcmVwbGFjZWJhZHdvcmQgPSBcIlxcJDFcIi4kcmVwbGFjZWJhZHdvcmQuXCJcXCQyXCI7DQoJCQkJJGF1dGhvckNvbW1lbnQgPSBwcmVnX3JlcGxhY2UoXCIvKFxcV3xeKSRiYWR3b3JkKFxcV3wkKS9pXCIsICRyZXBsYWNlYmFkd29yZCwgJGF1dGhvckNvbW1lbnQpOw0KCQkJfQkNCgkJfQ0KCX0NCgkNCgllY2hvICRhdXRob3JDb21tZW50Ow0KfQ0KDQpmdW5jdGlvbiBfZ2V0VGl0bGVDb21tZW50KCkgewkNCglnbG9iYWwgJG1vc0NvbmZpZ19saXZlX3NpdGUsICRtb3NDb25maWdfYWJzb2x1dGVfcGF0aCwgJGRhdGFiYXNlLCAkQ09NTUVOVDsJDQoNCglyZXF1aXJlKCRtb3NDb25maWdfYWJzb2x1dGVfcGF0aC5cJy9hZG1pbmlzdHJhdG9yL2NvbXBvbmVudHMvY29tX21heGNvbW1lbnQvbWF4Y29tbWVudF9jb25maWcucGhwXCcpOw0KCQ0KCWlmICggJENPTU1FTlQtPnRpdGxlICkgewkNCgkJLy8gQmFkIHdvcmRzDQoJCWlmICggJG14Y19iYWR3b3JkcyApew0KCQkJJHF1ZXJ5ID0gXCJTRUxFQ1QgKiBGUk9NICNfX214Y19iYWR3b3JkcyBXSEVSRSBwdWJsaXNoZWQ9XCcxXCdcIjsNCgkJCSRkYXRhYmFzZS0+c2V0UXVlcnkoICRxdWVyeSApOw0KCQkJJHJvd3NiYWR3b3JkcyA9ICRkYXRhYmFzZS0+bG9hZE9iamVjdExpc3QoKTsNCgkJCWlmICggJHJvd3NiYWR3b3JkcyApIHsNCgkJCQlmb3JlYWNoICggJHJvd3NiYWR3b3JkcyBhcyAkcm93YmFkd29yZCApIHsNCgkJCQkJJGJhZHdvcmQgPSB0cmltKCAkcm93YmFkd29yZC0+YmFkd29yZCApOw0KCQkJCQkkcmVwbGFjZWJhZHdvcmQgPSBzdHJfcmVwZWF0KCBcJypcJywgc3RybGVuKCAkYmFkd29yZCApICk7DQoJCQkJCSRyZXBsYWNlYmFkd29yZCA9IFwiXFwkMVwiLiRyZXBsYWNlYmFkd29yZC5cIlxcJDJcIjsNCgkJCQkJJENPTU1FTlQtPnRpdGxlID0gcHJlZ19yZXBsYWNlKFwiLyhcXFd8XikkYmFkd29yZChcXFd8JCkvaVwiLCAkcmVwbGFjZWJhZHdvcmQsICRDT01NRU5ULT50aXRsZSk7DQoJCQkJfQkNCgkJCX0NCgkJfQ0KCQllY2hvIHN0cmlwc2xhc2hlcyggJENPTU1FTlQtPnRpdGxlICk7DQoJCQ0KCX0gZWxzZSBlY2hvIFwiLi4uXCI7CQ0KfQ0KDQpmdW5jdGlvbiBfZ2V0Q29tbWVudFRleHQoKSB7DQoJZ2xvYmFsICRtb3NDb25maWdfbGl2ZV9zaXRlLCAkbW9zQ29uZmlnX2Fic29sdXRlX3BhdGgsICRkYXRhYmFzZSwgJENPTU1FTlQ7DQoJDQoJcmVxdWlyZSgkbW9zQ29uZmlnX2Fic29sdXRlX3BhdGguXCcvYWRtaW5pc3RyYXRvci9jb21wb25lbnRzL2NvbV9tYXhjb21tZW50L21heGNvbW1lbnRfY29uZmlnLnBocFwnKTsNCgkNCgkvLyBQcmVwYXJlIHNtaWxleSBhcnJheQ0KCSRzbWlsZXlbXCc6KVwnXSAgICAgPSBcInNtX3NtaWxlLmdpZlwiOyAgICAkc21pbGV5W1wnOmdyaW5cJ10gID0gXCJzbV9iaWdncmluLmdpZlwiOw0KCSRzbWlsZXlbXCc7KVwnXSAgICAgPSBcInNtX3dpbmsuZ2lmXCI7ICAgICAkc21pbGV5W1wnOClcJ10gICAgID0gXCJzbV9jb29sLmdpZlwiOw0KCSRzbWlsZXlbXCc6cFwnXSAgICAgPSBcInNtX3JhenouZ2lmXCI7ICAgICAkc21pbGV5W1wnOnJvbGxcJ10gID0gXCJzbV9yb2xsZXllcy5naWZcIjsNCgkkc21pbGV5W1wnOmVla1wnXSAgID0gXCJzbV9iaWdlZWsuZ2lmXCI7ICAgJHNtaWxleVtcJzp1cHNldFwnXSA9IFwic21fdXBzZXQuZ2lmXCI7DQoJJHNtaWxleVtcJzp6enpcJ10gICA9IFwic21fc2xlZXAuZ2lmXCI7ICAgICRzbWlsZXlbXCc6c2lnaFwnXSAgPSBcInNtX3NpZ2guZ2lmXCI7DQoJJHNtaWxleVtcJzo/XCddICAgICA9IFwic21fY29uZnVzZWQuZ2lmXCI7ICRzbWlsZXlbXCc6Y3J5XCddICAgPSBcInNtX2NyeS5naWZcIjsNCgkkc21pbGV5W1wnOihcJ10gICAgID0gXCJzbV9tYWQuZ2lmXCI7ICAgICAgJHNtaWxleVtcJzp4XCddICAgICA9IFwic21fZGVhZC5naWZcIjsNCg0KCSRjb21tZW50VGV4dCA9IHN0cmlwc2xhc2hlcyggJENPTU1FTlQtPmNvbW1lbnQgKTsNCgkvLyBCYWQgd29yZHMNCglpZiAoICRteGNfYmFkd29yZHMgKXsNCgkJJHF1ZXJ5ID0gXCJTRUxFQ1QgKiBGUk9NICNfX214Y19iYWR3b3JkcyBXSEVSRSBwdWJsaXNoZWQ9XCcxXCdcIjsNCgkJJGRhdGFiYXNlLT5zZXRRdWVyeSggJHF1ZXJ5ICk7DQoJCSRyb3dzYmFkd29yZHMgPSAkZGF0YWJhc2UtPmxvYWRPYmplY3RMaXN0KCk7DQoJCWlmICggJHJvd3NiYWR3b3JkcyApIHsNCgkJCWZvcmVhY2ggKCAkcm93c2JhZHdvcmRzIGFzICRyb3diYWR3b3JkICkgew0KCQkJCSRiYWR3b3JkID0gdHJpbSggJHJvd2JhZHdvcmQtPmJhZHdvcmQgKTsNCgkJCQkkcmVwbGFjZWJhZHdvcmQgPSBzdHJfcmVwZWF0KCBcJypcJywgc3RybGVuKCAkYmFkd29yZCApICk7DQoJCQkJJHJlcGxhY2ViYWR3b3JkID0gXCJcXCQxXCIuJHJlcGxhY2ViYWR3b3JkLlwiXFwkMlwiOw0KCQkJCSRjb21tZW50VGV4dCA9IHByZWdfcmVwbGFjZShcIi8oXFxXfF4pJGJhZHdvcmQoXFxXfCQpL2lcIiwgJHJlcGxhY2ViYWR3b3JkLCAkY29tbWVudFRleHQpOw0KCQkJfQkNCgkJfQ0KCX0NCgkkY29tbWVudFRleHQgPSBteGNQYXJzZSggJGNvbW1lbnRUZXh0LCAkc21pbGV5LCAkbXhjX2JiY29kZXN1cHBvcnQsICRteGNfcGljdHVyZXN1cHBvcnQsICRteGNfc21pbGllc3VwcG9ydCwgJG1vc0NvbmZpZ19saXZlX3NpdGUgKTsNCgkkY29tbWVudFRleHQgPSBodG1sd3JhcCggJGNvbW1lbnRUZXh0LCAkbXhjX2xlbmd0aHdyYXAgKTsNCgkNCgllY2hvICRjb21tZW50VGV4dDsNCn0NCg0KZnVuY3Rpb24gX2dldE5vdGljZUNvcHlyaWdodCgpew0KCWdsb2JhbCAkbW9zQ29uZmlnX2Fic29sdXRlX3BhdGgsICRDT01NRU5UOw0KCQ0KCXJlcXVpcmUoJG1vc0NvbmZpZ19hYnNvbHV0ZV9wYXRoLlwnL2FkbWluaXN0cmF0b3IvY29tcG9uZW50cy9jb21fbWF4Y29tbWVudC92ZXJzaW9uLnBocFwnKTsNCg0KCSRjb3B5U3RhcnQgPSAyMDA3OyANCgkkY29weU5vdyA9IGRhdGUoXCdZXCcpOw0KCWlmICgkY29weVN0YXJ0ID09ICRjb3B5Tm93KSB7IA0KCQkkY29weVNpdGUgPSAkY29weVN0YXJ0Ow0KCX0gZWxzZSB7DQoJCSRjb3B5U2l0ZSA9ICRjb3B5U3RhcnQuXCItXCIuJGNvcHlOb3cgOw0KCX0JDQoJDQoJJG5vdGljZUNvcHlyaWdodCA9IFwiPGJyIC8+PGRpdiBzdHlsZT1cXFwiY2xlYXI6Ym90aDt0ZXh0LWFsaWduOmNlbnRlcjtcXFwiPjxzcGFuIGNsYXNzPVxcXCJzbWFsbFxcXCI+PGJyIC8+bVhjb21tZW50IFwiIC4gX01BWENPTU1FTlRfTlVNX1ZFUlNJT04gLiBcIiZuYnNwOyZjb3B5OyZuYnNwO1wiOw0KCSRub3RpY2VDb3B5cmlnaHQgLj0gJGNvcHlTaXRlIC4gXCIgLSA8YSBocmVmPVxcXCJodHRwOi8vd3d3LnZpc3VhbGNsaW5pYy5mclxcXCIgdGFyZ2V0PVxcXCJfYmxhbmtcXFwiPnZpc3VhbGNsaW5pYy5mcjwvYT48YnIgLz5cIjsNCgkkbm90aWNlQ29weXJpZ2h0IC49IFwiTGljZW5zZSA8YSByZWw9XFxcImxpY2Vuc2VcXFwiIGhyZWY9XFxcImh0dHA6Ly9jcmVhdGl2ZWNvbW1vbnMub3JnL2xpY2Vuc2VzL2J5LW5jLW5kLzMuMC9cXFwiPkNyZWF0aXZlIENvbW1vbnM8L2E+IC0gU29tZSByaWdodHMgcmVzZXJ2ZWQ8L3NwYW4+PC9kaXY+XCI7DQoJDQoJZWNobyAkbm90aWNlQ29weXJpZ2h0Ow0KfQ0KDQpmdW5jdGlvbiBfZ2V0RGF0ZUNvbW1lbnQoKSB7DQoJZ2xvYmFsICRtb3NDb25maWdfYWJzb2x1dGVfcGF0aCwgJENPTU1FTlQ7CQ0KDQoJcmVxdWlyZSgkbW9zQ29uZmlnX2Fic29sdXRlX3BhdGguXCcvYWRtaW5pc3RyYXRvci9jb21wb25lbnRzL2NvbV9tYXhjb21tZW50L21heGNvbW1lbnRfY29uZmlnLnBocFwnKTsNCgkkZGF0ZWNvbW1lbnQgPSBcIlwiOw0KCQ0KCWlmICggaW50dmFsKCAkQ09NTUVOVC0+ZGF0ZSApICE9IDAgKSB7DQoJCSRkYXRlY29tbWVudCA9IG1vc0Zvcm1hdERhdGUoICRDT01NRU5ULT5kYXRlLCAkbXhjX2ZkYXRlICk7DQoJfQ0KCWVjaG8gJGRhdGVjb21tZW50Ow0KfQ0K")));

function _getReportComment() {
	global $mosConfig_live_site, $mosConfig_absolute_path, $mosConfig_lang, $Itemid, $task, $COMMENT, $_MXC;
	
	// Get the right language if it exists
	if (file_exists($mosConfig_absolute_path."/administrator/components/com_maxcomment/languages/".$mosConfig_lang.".php")){
		include_once($mosConfig_absolute_path."/administrator/components/com_maxcomment/languages/".$mosConfig_lang.".php");
	}else{
		include_once($mosConfig_absolute_path."/administrator/components/com_maxcomment/languages/english.php");
	}

	require($mosConfig_absolute_path.'/administrator/components/com_maxcomment/maxcomment_config.php');
	$report = "";
	if( $mxc_report ){
		$link = sefRelToAbs( "index.php?option=com_maxcomment&task=report&id=" . $COMMENT->id . "&cid=" . $COMMENT->contentid . "&Itemid=" . $Itemid );
		if ( $_MXC->CHECKJVERSION ) $link = JRoute::_("index.php?option=com_maxcomment&task=report&id=" . $COMMENT->id . "&cid=" . $COMMENT->contentid);		
		$report = "<a href=\"" . $link . "\">" . _MXC_REPORTTHISCOMMENT . "</a>";
		if ( $task=='report' ) $report = _MXC_REPORTTHISCOMMENT;
	}	
	echo $report;	
}

function _getReplyComment() {
	global $mainframe, $mosConfig_live_site, $mosConfig_absolute_path, $mosConfig_lang, $Itemid, $task, $COMMENT, $_MXC;
	
	// Get the right language if it exists
	if (file_exists($mosConfig_absolute_path."/administrator/components/com_maxcomment/languages/".$mosConfig_lang.".php")){
		include_once($mosConfig_absolute_path."/administrator/components/com_maxcomment/languages/".$mosConfig_lang.".php");
	}else{
		include_once($mosConfig_absolute_path."/administrator/components/com_maxcomment/languages/english.php");
	}

	require($mosConfig_absolute_path.'/administrator/components/com_maxcomment/maxcomment_config.php');	
	
	$width_popup  = ( intval($mxc_width_popup)>0 )? $mxc_width_popup : '420' ;
	$height_popup = ( intval($mxc_height_popup)>0 )? $mxc_height_popup : '450' ;

	$reply = "";
	if( $mxc_reply ){	
		switch ( $mxc_openingmode ) {		
		
			case 0 :
				$link = sefRelToAbs( "index.php?option=com_maxcomment&task=reply&id=" . $COMMENT->id . "&Itemid=" . $Itemid );
				if ( $_MXC->CHECKJVERSION ) $link = JRoute::_("index.php?option=com_maxcomment&task=reply&id=" . $COMMENT->id);
				$reply = "<a href=\"" . $link . "\">" . _MXC_REPLYTOTHISCOMMENT . "</a>";				
				break;
			case 1 :
				$status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width='.$width_popup.',height='.$height_popup.',directories=no,location=no';
				$link = $mosConfig_live_site . "/index2.php?option=com_maxcomment&amp;task=reply&amp;id=" . $COMMENT->id . "&amp;Itemid=" . $Itemid;
				$reply = "<a href=\"" . $link . "\" target=\"_blank\" onclick=\"window.open('" . $link . "','win2','" . $status . "'); return false;\">" . _MXC_REPLYTOTHISCOMMENT . "</a>";
				break;		
						
		}
	}	
	
	if ( $task=='report' || $task=='viewallreplies' && $COMMENT->parentid > 0 || $_MXC->COMMENTCLOSED==true ) $reply = _MXC_REPLYTOTHISCOMMENT;	
	echo $reply;
		
}

function _getCountAllReplies() {
	global $database, $mosConfig_live_site, $mosConfig_absolute_path, $COMMENT;	
	
	$query = "SELECT COUNT(*) FROM #__mxc_comments"
	. "\n WHERE parentid=$COMMENT->id"
	. "\n AND published='1'"
	;
	$database->setQuery( $query );	
	$totalreplies = $database->loadResult();	
	return $totalreplies;
}

function _getSeeAllReplies() {
	global $database, $mosConfig_live_site, $mosConfig_absolute_path, $mosConfig_lang, $Itemid, $task, $COMMENT, $_MXC;
	
	$totalreplies = _getCountAllReplies( $COMMENT->id );
	//Get the right language if it exists
	if (file_exists($mosConfig_absolute_path."/administrator/components/com_maxcomment/languages/".$mosConfig_lang.".php")){
		include_once($mosConfig_absolute_path."/administrator/components/com_maxcomment/languages/".$mosConfig_lang.".php");
	}else{
		include_once($mosConfig_absolute_path."/administrator/components/com_maxcomment/languages/english.php");
	}

	require($mosConfig_absolute_path.'/administrator/components/com_maxcomment/maxcomment_config.php');
	
	$seeallreplies = "";	
	$label = sprintf( _MXC_SEEALLREPLIES, $totalreplies );
	if( $mxc_reply && $totalreplies ){
		$link = sefRelToAbs( "index.php?option=com_maxcomment&task=viewallreplies&id=" . $COMMENT->id . "&Itemid=" . $Itemid );
		if ( $_MXC->CHECKJVERSION ) $link = JRoute::_("index.php?option=com_maxcomment&task=viewallreplies&id=" . $COMMENT->id);
		$seeallreplies = "<a href=\"" . $link . "\">" . $label . "</a>";
		if ( $task=='report' || $task=='viewallreplies' ) $seeallreplies = $label;
	}	
	echo $seeallreplies;
	
}

function _getStatusUserComment() {
	global $mosConfig_absolute_path, $COMMENT;	
	
	require($mosConfig_absolute_path.'/administrator/components/com_maxcomment/maxcomment_config.php');
	
	if ( $mxc_showstatus && $COMMENT->iduser ) {
		$status = _MXC_REGISTERED;
	} else if ( $mxc_showstatus && !$COMMENT->iduser ) {
		$status = _MXC_GUEST;
	} else {
		$status = "";
	}

	echo $status;
}

function _getAuthorAvatar() { 
    global $database, $mosConfig_live_site, $mosConfig_absolute_path, $COMMENT;
	
	require($mosConfig_absolute_path.'/administrator/components/com_maxcomment/maxcomment_config.php');

	$avatarCB  = "";
	$avatarIMG = "";
	$avatarIMG2 = "";
	$checkCBcomponent = checkCBcomponent();	
	
	if ( $checkCBcomponent ){
		$database->setQuery( "SELECT avatar FROM #__comprofiler WHERE user_id = '$COMMENT->iduser' AND confirmed = '1' AND approved = '1' AND avatarapproved = '1'" );
		$rowAvatar = $database->loadResult();
		if ( $rowAvatar ) {
			$avatarIMG = "images/comprofiler/tn" . $rowAvatar;		
		} else {
			$avatarIMG = "components/com_comprofiler/plugin/language/default_language/images/tnnophoto.jpg";		
		}
		$avatarIMG2 = $mosConfig_live_site . "/" . $avatarIMG;
	}
	
	$mxc_maxavatarwidth = reducIMG( $mxc_maxavatarwidth, $avatarIMG2 );	
	
	if ( $avatarIMG && $mxc_ShowAvatarCBProfile ){
		$avatarCB = "<img style=\"border:none;padding:4px;width:".$mxc_maxavatarwidth."px\" src='" . $avatarIMG2 . "' align='left' alt='' />";
	}	

	$gravatar = "";
	if ( $mxc_use_gravatar ) {
		$email   = $COMMENT->email ;
		$default = $mosConfig_live_site . "/components/com_maxcomment/images/gravatar/" . $mxc_default_gravatar;
		$size    = ( is_numeric($mxc_maxgravatarwidth) )? $mxc_maxgravatarwidth : 60 ;
		
		$gravatar_url = "http://www.gravatar.com/avatar.php?gravatar_id=";
		$gravatar_url .= md5( $COMMENT->email );
		$gravatar_url .= "&amp;default=" . urlencode($default);		
		$gravatar_url .= "&amp;size=" . $size;
		
		$gravatar = "<img src=\"$gravatar_url\" alt=\"\" />";
	}
	
	if ( $mxc_ShowAvatarCBProfile && $mxc_use_gravatar && $mxc_replaceCBavatar ) {		
		$test = 1;
	} elseif ( $mxc_ShowAvatarCBProfile && $mxc_use_gravatar && !$mxc_replaceCBavatar ) {
		$test = 2;
	}elseif ( $mxc_ShowAvatarCBProfile && !$mxc_use_gravatar ) {
		$test = 3;
	}elseif ( !$mxc_ShowAvatarCBProfile && $mxc_use_gravatar ) {
		$test = 4;
	}elseif ( !$mxc_ShowAvatarCBProfile && !$mxc_use_gravatar ) {
		$test = 5;
	} else $test = 0;
		
	switch( $test ) {
		case 1:
		case 4:
			echo $gravatar;
			break;
		case 2:
		case 3:
			echo $avatarCB;
			break;
		case 0:
		default:
			echo "";
	}
	
}

function _getItemid( &$row ){
	global $mainframe;
	
	if (is_callable( array( $mainframe, "getItemid" ) ) ) {
		$_Itemid = $mainframe->getItemid( $row->id );
	} elseif (is_callable( "JApplicationHelper::getItemid" ) ) {
		$_Itemid = JApplicationHelper::getItemid( $row->id );
	} else {
		$_Itemid = '';
	}

	return $_Itemid;
}

function checkCBcomponent() {
	global $mosConfig_absolute_path;
	
	// Check if CB component exist
	$pathFileCB = $mosConfig_absolute_path . "/components/com_comprofiler/comprofiler.php";		
	if ( file_exists( $pathFileCB ) ) {
		$checkCBcomponent = 1;	
	} else $checkCBcomponent = 0;		
	return $checkCBcomponent;
}

function CBAuthorItemid() {
	global $_CBAuthorbot__Cache_ProfileItemid, $database;
	
	if ( !$_CBAuthorbot__Cache_ProfileItemid ) {
		if ( !isset( $_REQUEST['Itemid'] ) ) {
			$database->setQuery( "SELECT id FROM #__menu WHERE link = 'index.php?option=com_comprofiler' AND published=1" );
			$Itemid = (int) $database->loadResult();
		} else {
			$Itemid = (int) $_REQUEST['Itemid'];
		}
		if ( ! $Itemid ) {
			/** Nope, just use the homepage then. */
			$query = "SELECT id"
			. "\n FROM #__menu"
			. "\n WHERE menutype = 'mainmenu'"
			. "\n AND published = 1"
			. "\n ORDER BY parent, ordering"
			. "\n LIMIT 1"
			;
			$database->setQuery( $query );
			$Itemid = (int) $database->loadResult();
		}
		$_CBAuthorbot__Cache_ProfileItemid = $Itemid;
	}
	if ($_CBAuthorbot__Cache_ProfileItemid) {
		return "&amp;Itemid=" . $_CBAuthorbot__Cache_ProfileItemid;
	} else {
		return null;
	}
}

function reducIMG( $mxc_maxavatarwidth, $image ) {
	$dim       = @getimagesize( $image ); 
	$largeur   = $dim[0];
	
	if  ( $largeur > $mxc_maxavatarwidth ) {	
		$mxc_maxavatarwidth = $mxc_maxavatarwidth;
	} else  $mxc_maxavatarwidth = $largeur;

	return $mxc_maxavatarwidth;
}
?>