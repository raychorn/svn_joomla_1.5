<?php
// ensure this file is being included by a parent file
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/* **************************************************************
* htmlwrap() function - v1.1
* Copyright (c) 2004 Brian Huisman AKA GreyWyvern
*
* This program may be distributed under the terms of the GPL
*   - http://www.gnu.org/licenses/gpl.txt
*
*
* htmlwrap -- Safely wraps a string containing HTML formatted text (not
* a full HTML document) to a specified width
*
* See the inline comments and http://www.greywyvern.com/php.php
* for more info
******************************************************************** */

function htmlwrap( $str, $width = 60, $break = "\n", $nobreak = "", $nobr = "pre", $utf = false ) {

  // Split HTML content into an array delimited by < and >
  // The flags save the delimeters and remove empty variables

  $content = preg_split("/([<>])/", $str, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

  // Transform protected element lists into arrays
  $nobreak = explode(" ", $nobreak);
  $nobr = explode(" ", $nobr);

  // Variable setup
  $intag = false;
  $innbk = array();
  $innbr = array();
  $drain = "";
  $utf = ($utf) ? "u" : "";

  // List of characters it is "safe" to insert line-breaks at
  // Do not add ampersand (&) as it will mess up HTML Entities
  // It is not necessary to add < and >
  $lbrks = "/?!%)-}]\\\"':;";
  
  // We use \r for adding <br /> in the right spots so just switch to \n
  if ($break == "\r") $break = "\n";
  
  while (list(, $value) = each($content)) {

    switch ($value) {

      // If a < is encountered, set the "in-tag" flag

      case "<": $intag = true; break;
	  
      // If a > is encountered, remove the flag

      case ">": $intag = false; break;

      default:
	  
        // If we are currently within a tag...

        if ($intag) {

          // If the first character is not a / then this is an opening tag

          if ($value{0} != "/") {

            // Collect the tag name   
            preg_match("/^(.*?)(\s|$)/$utf", $value, $t);

            // If this is a protected element, activate the associated protection flag

            if ((!count($innbk) && in_array($t[1], $nobreak)) || in_array($t[1], $innbk)) $innbk[] = $t[1];
            if ((!count($innbr) && in_array($t[1], $nobr)) || in_array($t[1], $innbr)) $innbr[] = $t[1];

          // Otherwise this is a closing tag
          } else {

            // If this is a closing tag for a protected element, unset the flag
            if (in_array(substr($value, 1), $innbk)) unset($innbk[count($innbk)]);
            if (in_array(substr($value, 1), $innbr)) unset($innbr[count($innbr)]);
			
          }

        // Else if we're outside any tags...
        } else if ($value) {

          // If unprotected, remove all existing \r, replace all existing \n with \r
          if (!count($innbr)) $value = str_replace("\n", "\r", str_replace("\r", "", $value));

          // If unprotected, enter the line-break loop
          if (!count($innbk)) {

            do {

              $store = $value;

              // Find the first stretch of characters over the $width limit
              if (preg_match("/^(.*?\s|^)(([^\s&]|&(\w{2,5}|#\d{2,4});){".$width."})(?!(".preg_quote($break, "/")."|\s))(.*)$/s$utf", $value, $match)) {

                // Determine the last "safe line-break" character within this match
                for ($x = 0, $ledge = 0; $x < strlen($lbrks); $x++) $ledge = max($ledge, strrpos($match[2], $lbrks{$x}));
                if (!$ledge) $ledge = strlen($match[2]) - 1;

                // Insert the modified string
                $value = $match[1].substr($match[2], 0, $ledge + 1).$break.substr($match[2], $ledge + 1).$match[6];

              }

            // Loop while overlimit strings are still being found
            } while ($store != $value);

          }

          // If unprotected, replace all \r with <br />\n to finish
          if (!count($innbr)) $value = str_replace("\r", "<br />\n", $value);

        }

    }

    // Send the modified segment down the drain
    $drain .= $value;

  }

  // Return contents of the drain
  return $drain;

}


?>