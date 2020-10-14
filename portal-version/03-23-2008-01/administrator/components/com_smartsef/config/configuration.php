<?php
class smartsef_configuration {
	var $mode = '0';
	var $url_lowercase = '1';
	var $url_suffix_page = '.html';
	var $url_suffix_pdf = '.pdf';
	var $url_part_print = 'print';
	var $url_part_page = 'page%d';
	var $url_part_showall = 'showall';
	var $url_remove_chars = 'Ã¯Â¿Â½!$%Ã¯Â¿Â½@?#&()+*';
	var $character_space = '-';
	var $page_not_found_id = '-1';
	var $log_404_errors = '0';
	var $log_404_path = '/home/nearbyin/public_html/python2/logs/smartsef_404.log';
	var $enable_sefurl_lookup = '1';
	var $append_itemid_to_sefurl = '0';
	var $append_itemid_to_rawurl = '1';
	var $section_url_part = 'alias';
	var $category_url_part = 'alias';
	var $article_url_part = 'alias';
	var $url_paths_section = '2';
	var $url_paths_category = '3';
	var $url_paths_article = '2';
	var $check_for_unique_article_urls = '1';
	var $unique_seperator = '-';
	var $replace_joomla_space_char = '1';
	var $valid_regular_expresion = '';
	var $use_title_alias_for_menus = '1';
	var $use_title_alias_fullpath = '1';
	var $char_replacements = 'Å |S, Å|O, Å½|Z, Å¡|s, Å|oe, Å¾|z, Å¸|Y, Â¥|Y, Âµ|u, Ã|A, Ã|A, Ã|A, Ã|A, Ã|A, Ã|A, Ã|A, Ã|C, Ã|E, Ã|E, Ã|E, Ã|E, Ã|I, Ã|I, Ã|I, Ã|I, Ã|D, Ã|N, Ã|O, Ã|O, Ã|O, Ã|O, Ã|O, Ã|O, Ã|U, Ã|U, Ã|U, Ã|U, Ã|Y, Ã|s, Ã |a, Ã¡|a, Ã¢|a, Ã£|a, Ã¤|a, Ã¥|a, Ã¦|a, Ã§|c, Ã¨|e, Ã©|e, Ãª|e, Ã«|e, Ã¬|i, Ã­|i, Ã®|i, Ã¯|i, Ã°|o, Ã±|n, Ã²|o, Ã³|o, Ã´|o, Ãµ|o, Ã¶|o, Ã¸|o, Ã¹|u, Ãº|u, Ã»|u, Ã¼|u, Ã½|y, Ã¿|y, Ã|ss';
	var $additional_parameter_check = '';
}
?>