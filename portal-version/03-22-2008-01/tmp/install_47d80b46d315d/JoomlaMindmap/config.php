<?php
// Joomla Mindmap Generator
//
// Please upload the files sitemap.php, visorFreemind.swf, index.php (the main file), flashobject.js into a directory of
// your Webspace with a Joomla installation and edit the config section below.
//
// This tool retreives sections, categories and content items which are published directly from Joomla database
// and creates a nice flash based Mindmap. Note that users need macromedia flash player 7 or 8 to see the mind map.
//
// You may create menu link in Joomla to the index.php as the sitemap of your website. Google is able to index it.
//
// Created by (C) Dipl-Ing. Mustafa Görmezer
// http://www.goermezer.de ( mail@goermezer.de )
//
// CONFIG SECTION -------------------------------------------------------------------

// Please specify the absolute path to the joomla configuration file (configuration.php)
// Usually located in the root of your site:
$joomla_config_file = '/var/www/vhosts/goermezer.de/httpdocs/configuration.php';

// Character encoding. Depends on your mysql character set. You can get it either via phpmyadmin or
// by this sql statement: SHOW CHARACTER SET; 
$character_set = 'utf8';

// Node styles, possible values: [fork, bubble]
$section_style = 'fork';
$category_style = 'fork';
$content_style = 'fork';

// Main node style in index.php. Possible values "rectangle" and "ellipse"
// fo.addVariable("mainNodeShape","rectangle");

// Line thickness, possible values: Numbers [1, 2, 3, ...] or [thin]
$line_thickness = 'thin';

// Main node Style [bubble, fork]
$index_style = 'bubble';

// Line style, possible values: [bezier, sharp_bezier, linear, sharp_linear, rectangular]
$line_style ='bezier';


// Node background colors
$main_node_bgcolor = 'f0f0f0';
$section_bgcolor = 'ffffff'; // for content module only
$category_bgcolor = 'ffffff';
$content_bgcolor = ''; # no value is possible too for bg-color

// Font Colors
$main_font_color = '000000';
$section_font_color = '000000';
$category_font_color = '000000';
$content_font_color = '000000';

// Installed modules (filename of module without .php)
$modules = array('content', 'static', 'archived', 'weblinks', 'newsfeeds', 'Menu-Components');

// END CONFIG SECTION ---------------------------------------------------------------


if (isset($main_node_bgcolor) && $main_node_bgcolor != ''){
	$main_node_bgcolor = 'BACKGROUND_COLOR="#'.$main_node_bgcolor.'"';
	}
if (isset($section_bgcolor) && $section_bgcolor != ''){
	$section_bgcolor = 'BACKGROUND_COLOR="#'.$section_bgcolor.'"';
	}
if (isset($category_bgcolor) && $category_bgcolor != ''){
	$category_bgcolor = 'BACKGROUND_COLOR="#'.$category_bgcolor.'"';
	}
if (isset($content_bgcolor) && $content_bgcolor != ''){
	$content_bgcolor = 'BACKGROUND_COLOR="#'.$content_bgcolor.'"';
	}
	
if (isset($main_font_color) && $main_font_color != ''){
	$main_font_color = 'COLOR="#'.$main_font_color.'"';
	}
if (isset($section_font_color) && $section_font_color != ''){
	$section_font_color = 'COLOR="#'.$section_font_color.'"';
	}
if (isset($category_font_color) && $category_font_color != ''){
	$category_font_color = 'COLOR="#'.$category_font_color.'"';
	}
if (isset($content_font_color) && $content_font_color != ''){
	$content_font_color = 'COLOR="#'.$content_font_color.'"';
	}
include($joomla_config_file);
?>
