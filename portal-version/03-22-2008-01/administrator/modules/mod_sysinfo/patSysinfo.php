<?php
/***************************************************************
 *	$RCSfile: patSysinfo.php,v $
 *	$Revision: 1.1 $
 * 	$Id: patSysinfo.php,v 1.1 2001/10/23 21:10:58 schst Exp $
/***************************************************************/

/* Constants */

/**
 * whether chars should be convertet to html-entities
 * @const patSYSINFO_USE_HTMLCHARS
 * @see useHtmlChars, useHtmlChars()
 */
define("patSYSINFO_USE_HTMLCHARS", "1");
/**
 * the fill string for empty fields
 * @const patSYSINFO_FILL_STRING 
 * @see USE_FILL_SRTING, useFillString, fillString, setUseFillString(), setFillString()
 */
define("patSYSINFO_FILL_STRING", "NA");
/**
 * whether empty fields should be filled with patSYSINFO_FILL_STRING
 * @const USE_patSYSINFO_FILL_STRING
 * @see patSYSINFO_FILL_STRING, useFillString, fillString, setFillString(), setUseFillString()
 */
define("USE_patSYSINFO_FILL_STRING", "1");
/**
 * whether numbers and units should be converted 
 * @const patSYSINFO_USE_UNIT_CALCA
 * @see unitCalcDiv, unitCalcUnits, unitCalc()
 */
define("patSYSINFO_USE_UNIT_CALC", "1");
/**
 * the program reading hardware-sensors: lm_sensors (http://www.netroedge.com/~lm78/)
 * @const patSYSINFO_SENSOR_PROG
 */ 
define("patSYSINFO_SENSOR_PROG", "/usr/local/bin/sensors");
/**
 * name of the "info"-field of the return hash-array
 * @const patSYSINFO_SENSOR_INFO
 * @see patSYSINFO_SENSOR_DATA
 */
define("patSYSINFO_SENSOR_INFO", "info");
/**
 * name of the "data"-field of the return hash-array
 * @const patSYSINFO_SENSOR_DATA
 * @see patSYSINFO_SENSOR_INFO
 */
define("patSYSINFO_SENSOR_DATA", "data");


/***************************************************************/
/* Class: patSysinfo */

/**
 * patSysinfo
 * 
 * Class to get a lot of information about the system. Very easy to use but 
 * powerful and configurable. Now this class supports: 
 *
 * - Hardware sensors (uses lm_sensors http://www.netroedge.com/~lm78/ )
 * - Kernel Version
 * - Hostname and IP, number of users, 
 * - System uptime and CPU-load
 * - Networking devices
 * - PCI devices
 * - IDE devices
 * - SCSI devices
 * - Momory information
 * - Mountpoint information
 *
 * @package		patSysinfo
 * @version		1.1 - $Revision: 1.1 $
 * @author  	Gerd Schaufelberger <gerd@php-tools.de>
 * @access		public
 * 
 * $Date: 2001/10/23 21:10:58 $
 *	
 * $Source: /var/cvs/master//pat/patSite/include/patSysinfo.php,v $
 * $State: Exp $
 * 
 * $Log: patSysinfo.php,v 
 * Revision 1.7  2001/05/19 11:23:06  ger
 * some minor bug-fixes in outpu
 *
 * Revision 1.2  2001/05/18 15:15:24  schst
 * Command Struktur definiert
 *
 * Revision 1.1  2001/05/17 13:56:44  schst
 * Verzeichnisstrukturen für Befehle und PlugIns geändert
 *
 * Revision 1.6  2001/05/16 17:52:12  gerd
 * Some changes in earlier code and examples, and feature "Mountpoints" added.
 *
 * Revision 1.5  2001/05/16 00:26:07  gerd
 * Added:
 * 	-Memory Information
 * 	-Hardware Information
 *
 * Revision 1.4  2001/05/13 19:16:52  gerd
 * A lot of changes and new features, but stil under heavy development...
 * Added: Uptime, Number of Users, CPU-load, Kernel-Version, Hostname and IP,
 * network interfaces
 *
 * Revision 1.3  2001/05/12 18:59:53  gerd
 * Bugfix: Fixed Error on ALARM
 * New feature: auto-convert chars to html-entities
 *
 * Revision 1.2  2001/05/12 18:05:24  gerd
 * Some minor buggs fixed, some code optimized.
 * phpDoc-style documentation added
 *
 * Revision 1.1.1.1  2001/05/12 16:08:02  gerd
 * patSysinfo:
 * 	php-Class to get Information about the running system.
 *
 *
 ****************************************************/
class patSysinfo
{

/**
 * patSysinfo
 *
 * the constructor
 *
 * @access public
 */
function patSysinfo()
{
/**
 * useHtmlChars
 * whether chars should be convertet to html-entities
 * 
 * @var bool useHtmlChars
 * @see patSYSINFO_USE_HTMLCHARS, setUseHtmlChars()
 */
 $this->useHtmlChars = patSYSINFO_USE_HTMLCHARS;
/**
 * fillString
 * @var string fillString The default String to replace empty values/strings
 * @access	private
 * @see patSYSINFO_FILL_STRING, USE_patSYSINFO_FILL_STRING, useFillString, setFillString(), setUseFillString()
 */
$this->fillString = patSYSINFO_FILL_STRING;
/**
 * useFillString
 * @var bool useFillString Should empty values replaced? 
 * @access	private
 * @see patSYSINFO_FILL_STRING, USE_patSYSINFO_FILL_STRING, fillString, setFillString(), setUseFillString()
 */
$this->useFillString = USE_patSYSINFO_FILL_STRING;
/**
 * useUnitCalc
 * @var bool useFillString Should empty values replaced? 
 * @access	private
 * @see patSYSINFO_USE_UNIT_CALC, setUnitCalcConfig, 
 */
$this->useUnitCalc = patSYSINFO_USE_UNIT_CALC;
/**
 * unitCalcDiv
 * @var int calcDiv 
 * @access	private
 * @see setUnitCalcConfig(), unitCalc(), unitCalcUnits
 */
$this->unitCalcDiv = 1024;
/**
 * UnitCalcUnits
 * @var array calcUnits
 * @access	private
 * @see setUnitCalcConfig(), unitCalc(), unitCalcDiv
 */
$this->unitCalcUnits = array( "Byte", "kByte", "MByte", "GByte" );
/**
 * sensorParam
 * @var array sensorParam The name of each sensor-parameter
 * @access	private
 * @see getSensot()
 */
$this->sensorParam = array("min","max","limit","hysteresis","div");
/**
 * sensorHideLabel
 * @var array sensorHideLabel A list of labels which were removed from output
 * @access	private
 * @see setHideLabel(), addHideLabel()
 */ 
$this->sensorHideLabel = array();
/**
 * sensorReplace
 * @var mixed sensorReplace A list of regular expressions to replace any field
 * @access	private
 * @see setSensorReplace(), addSensorReplace()
 */ 
$this->sensorReplace= array(array());
}

/***************************************************************/
/* Class-functions: config */

/**
 * setUseHtmlChars
 * 
 * whether chars should be convertet to html-entities, switch feature on or off
 * 
 * @access	public
 * @param bool useHtmlChars
 * @see patSYSINFO_USE_HTMLCHARS, useHtmlChars
 */
 function setUseHtmlChars($on = 1)
 {
 $this->useHtmlChars = $on;
 return 1;
 }

/**
 * setFillString
 * 
 * This function sets the String in order to replace emtpy values.
 * 
 * @access public
 * @return bool
 * @param string fillString The replace-string
 * @param bool useFillString Switch replacement on or off.
 * @see setUseFillString(), fillString, useFillString
 */
function setFillString($fillString = patSYSINFO_FILL_STRING, $useFillString = 1)
{
$this->fillString = $fillString;
$this->useFillString = $useFillString;
return 1;
}

/**
 * useFillString
 * 
 * This function switches replacement on or off
 * 
 * @access public
 * @return bool
 * @param bool useFillString Switch replacement on or off.
 * @see setFillString(), fillString, useFillString
 */
function setUseFillString($useFillString = 1)
{
$this->useFillString = $useFillString;
return 1;
}
/**
 * setUnitCalcConfig
 * 
 * Configure the calcUnits function in order to format numbers
 * 
 * @access	public
 * @return bool
 * @param int unitCalcDiv
 * @param mixed unitCalcDiv
 * @param bool unitCalcOn
 * @see setCalcConfig(), calcUnits(), calcDiv, calcUnits
 */
function setUnitCalcConfig($on = 1 , $div = 1024, $units = array("Byte", "kByte", "MByte", "GByte"))
{
if ( !(is_array($units) & is_int($div)) ) { return 0; }
$this->useUnitCalc = $on;
$this->unitCalcDiv = $div;
$this->unitCalcUnits = $units;
return 1;
}
/**
 * setUseUnitCalc
 * 
 * Just an alias of "setUnitCalcConfig()", in order to be compatible to other
 * configuration-functions
 * 
 * @access	public
 * @return bool
 * @param int unitCalcDiv
 * @param mixed unitCalcDiv
 * @param bool unitCalcOn
 * @see setUnitCalcConfig(), setCalcConfig(), calcUnits(), calcDiv, calcUnits
 */
function setUseUnitCalc($on = 1 , $div = 1024, $units = array("Byte", "kByte", "MByte", "GByte"))
{
$this->setUnitCalcConfig($on, $div, $units);
return 1;
}

/***************************************************************/
/* Class-functions: general */

/**
 * getKernelVersion
 * 
 * Same as "uname --release"
 * 
 * @access public
 * @return string Kernel-Version
 */
function getKernelVersion()
{
if ( $fh = fopen("/proc/version", "r") ) 
	{
	$buffer = fgets( $fh, 4096 );
	fclose( $fh );

	// search and grep the kernel-version
	if ( preg_match("/version (.*?) /", $buffer, $matches)) 
		{
		$result = $matches[1];
		if ( preg_match("/SMP/", $buffer) ) { $result .= " (SMP)"; }
		} 
		else 
			{
			if ( $this->useFillString ) { $result = $this->fillString; }
			else { $result = ""; }
			}
	} 
else 
	{
	if ( $this->useFillString ) { $result = $this->fillString; }
	else { $result = ""; }
	}

return $result;
}

/**
 * getLoadAvg
 * 
 * Returns average CPU-load,  like Unix-Command "uptime"
 * 
 * @access public
 * @param string fillString Use alternative fillString
 * @return array CPU-load average
 */
function getLoadAvg( $fillString = "" )
{

if ( $fh = fopen("/proc/loadavg", "r") ) 
	{
	$result = split( " ", fgets( $fh, 4096 ), 4 );
	fclose( $fh );
	unset($result[3]);
	} 
else 
	{
	if ( $this->useFillString) 
		{ 
		if ( $fillString == "" ) { $fillString = $this->fillString;}
		$result = array("$fillString","$fillString","$fillString");
		}
	else { $result = array("","","");}
	}

return $result;
}


/**
 * getUptime
 * 
 * Returns system uptime, like Unix-Command "uptime"
 * 
 * @access public
 * @param boolean $digit set true in order to prepend leading "0" before minutes
 * @return array uptime uptime in days, hours and minutes
 */
function getUptime( $digit = false )
{
$result = array();

$fh = fopen("/proc/uptime", "r");
$buffer = split( " ", fgets( $fh, 4096 ) );
fclose( $fh );

$sys_ticks = trim( $buffer[0] );

$mins   = $sys_ticks / 60;
$hours = $mins / 60;
$days  = floor( $hours / 24 );
$hours = floor( $hours - ($days * 24) );
$mins   = floor( $mins - ($days * 60 * 24) - ($hours * 60) );

if ( $digit && ($mins < 10) ) { $mins = "0$mins"; }

// array_push($result, $days, $hours, $min);
$result["days"] = $days;
$result["hours"] = $hours;
$result["mins"] = $mins;

return $result;
}

/**
 * getNumberUser
 * 
 * Returns number of current users
 * 
 * @access public
 * @return int users
 */
function getNumberUser()
{
$result = trim(`who | wc -l`);

return $result;
}

/**
 * getTopProcesses
 * 
 * Returns process information, ordered by CPU-usage
 * Emulates the behavior of "top". This function uses "getProcesses" 
 * and sorts by CPU-usage.
 * 
 * @access public
 * @param string $mode normal|wide|command
 * @param int $number number of processes in result
 * @return array $result The most CPU-consuming processes
 * @see getProcesses() 
 */
function getTopProcesses( $mode = "NORMAL", $number = 10 )
{
$result = array();

$proc = $this->getProcesses( $mode );

for( $i = 0; $i < $number; $i++ )
	{
	$max = array("key" => 0 , "value" => 0);
	for( $j = 0; $j < count( $proc ) ; $j++ )
		{
		if ( $proc[$j]["cpu"] >= $max["value"] )
			{
			$max["value"] = $proc[$j]["cpu"];
			$max["key"] = $j;
			}
		}
	$tmp = array_splice( $proc, $max["key"], 1 );
	array_push( $result, $tmp[0]);
	}
return $result;
}

/**
 * getProcesses
 * 
 * Returns process information about all processes
 * Uses the wellknown Unix-command "ps"
 * 
 * @access public
 * @param string $mode normal|wide|command
 * @return array All running processes
 * @see getTopProcesses() 
 */
function getProcesses( $mode = "normal" )
{
$ps = "ps aux";

switch ( strtoupper( $mode ) ) 
	{
	case "WIDE":
		$ps .= "w";
		break;

	case "COMMAND":
		$ps .= "c";
		break;

	case "NORMAL":
	default:
		break;
	}


$result = array();
$buffer = array();

if ( !($fh = popen( $ps , "r")) ) { return 0; }

$fields = array( 
	"user", "pid", "cpu", "mem", "vsz", "rss", "tty", "stat", "start", "time", "command");

// throw away the first line
fgets( $fh, 4096 );
while( $line = fgets( $fh, 4096 ) )
	{
	$buffer = preg_split( "/\s+/" , trim( $line ), count($fields) );
	for ( $i = 0; $i < count( $fields ); $i++)
		{
		$tmp[$fields[$i]] = $buffer[$i];
		}
	array_push( $result, $tmp);
	}

return $result;
}



/***************************************************************/
/* Class-functions: hardware */

/**
 * getCpu
 * 
 * Get CPU info, see /proc/spuinfo
 * 
 * @access public
 * @return array 
 */
function getCpu()
{
$results = array();
$buffer = array();

if ( !($fh = fopen("/proc/cpuinfo", "r")) ) { return 0; }
	
$processors = -1;

while ( $buffer = fgets( $fh, 4096 ) ) 
	{
	list($key, $value) = preg_split("/\s+:\s+/", trim($buffer), 2);

	// Maybe you need some other tags if you run this on another architecture.
	// If you find or miss one, please tell me.
	switch ( $key ) 
		{
		case "model name":	// for ix86
			$results[$processors]['model'] = $value;
			break;
		case "cpu MHz":
			$results[$processors]['mhz'] = sprintf("%.2f", $value );
			break;
		case "clock": // for PPC
			$results[$processors]['mhz'] = sprintf("%.2f", $value );
			break;
		case "cpu": // for PPC
			$results[$processors]['model'] = $value;
			break;
		case "revision": // for PPC arch
			$results[$processors]['model'] .= " ( rev: " . $value . ")";
			break;
		case "cache size":
			$results[$processors]['cache'] = $value;
			break;
		case "bogomips":
			$results[$processors]['bogomips'] += $value;
			break;
		case "processor":
			$processors++;
			$results[$processors]['processor'] = $value;
			break;
		}	
	}
fclose($fh);

return $results;
}

/**
 * getPciDevs
 * 
 * Get a list of importand devices
 * 
 * @access public
 * @return array Array of importand devices
 */
function getPciDevs()
{
$results = array();

if ( ! ($fh = @fopen("/proc/pci", "r")) ) { return 0; }

while ( $buffer = fgets($fh, 4096)) 
	{
	if ( preg_match( "/Bus/", $buffer ) ) 
		{
		$device = 1;
		continue;
		} 

	if ( $device ) 
		{ 
		list($key, $value) = split(": ", $buffer, 2);
	
		if ( !preg_match( "/bridge/i", $key ) && !preg_match( "/USB/i", $key ) ) 
			{
			$value = chop($value);
			$value = preg_replace("/\([^\)]+\)\.$/", "", trim($value)) ;
			if ( strlen($value) > 2 )
				{
				$count = array_push( $results, $value ) - 1;

				if ( $this->useHtmlChars )
					{ $results[$count] = htmlentities( $results[$count]); }
				}
			}
		$device = 0;
		}
	}

fclose($fh);

return $results;
}

/**
 * getIdeDevs
 * 
 * Get a list of IDE-devices
 * 
 * @access public
 * @return array Array of IDE-Devices
 */
function getIdeDevs()
{
$results = array();

if ( ! ($dir = @opendir("/proc/ide")) ) { return 0; }

while ( $file = readdir($dir) ) 
	{
	if ( preg_match( "/^hd/", $file ) ) 
		{ 
 		 $count = array_push($results , array()) - 1 ;

		if ( $fd = fopen("/proc/ide/$file/model", "r") ) 
			{
			$results[$count]["model"] = trim( fgets($fd, 4096) );
			fclose( $fd );

			if ( $this->useHtmlChars )
				{ $results[$count]["model"] = htmlentities( $results[$count]["model"]); }

			}
		if ( $fd = fopen("/proc/ide/$file/capacity", "r") ) 
			{
			$results[$count]["capacity"] =  trim( fgets($fd, 4096));
			if ( $this->useUnitCalc ) 
				{ $results[$count]["capacity"] = $this->unitCalc( (512 * $results[$count]["capacity"])); } 
			fclose( $fd );

			if ( $this->useHtmlChars )
				{ $results[$count]["capacity"] = htmlentities( $results[$count]["capacity"]); }
			}
		}
	}

closedir($dir); 

return $results;
}

/**
 * getScsiDevs
 * 
 * Get a list of SCSI-devices
 * 
 * @access public
 * @return array Array of SCSI-Devices
 */
function getScsiDevs() 
{
$results = array();

if ( !($fh = @fopen("/proc/scsi/scsi", "r")) ) { return 0; }

if ( $this->useFillString ) 
	{
	$dev_vendor = $this->fillString;
	$dev_model = $this->fillString;
	$dev_rev = $this->fillString;
	$dev_type = $this->fillString;
	}
else 
	{ 
	$dev_vendor = "";
	$dev_model = "";
	$dev_rev = "";
	$dev_type = "";
	}

$device = array( "vendor" => $dev_vendor,
			"model" => $dev_model,
			"revision" => $dev_rev,
			"type" => $dev_type );

while ( $buffer = fgets($fh, 4096)) 
	{
	// first line... 
	if ( preg_match( "/Vendor/", $buffer ) ) 
		{
		preg_match("/Vendor: (.*) Model: (.*) Rev: (.*)/i", $buffer, $matches );
		$device["vendor"] = $matches[1];
		$device["model"] = $matches[2];
		$device["revision"] = $matches[3];

		#list($key, $value) = split(": ", $buffer, 2);
		#$dev_str = $value;
		$get_type = 1;
		continue;
		} 
	// ...second line
	if ( $get_type ) 
		{ 
		preg_match("/Type:\s+(\S+)/i", $buffer, $matches );
		$device["type"] = $matches[1];

		// save data in result
		$count = array_push($results, $device) - 1 ;
			
		if ( $this->useHtmlChar ) 
			{ 
			$results[$count]["vendor"] = htmlentities( $results[$count]["vendor"]); 
			$results[$count]["model"] = htmlentities( $results[$count]["model"]); 
			$results[$count]["revision"] = htmlentities( $results[$count]["revision"]); 
			$results[$count]["type"] = htmlentities( $results[$count]["type"]); 
			}

		$get_type = 0;
		}
	}
fclose($fh);

return $results;
}

/***************************************************************/
/* Class-functions: memory */

/**
 * getMem
 * 
 * Get a memory information
 * 
 * @access public
 * @return array
 */
function getMem()
{
$result = array();
$index = array( "type", "total", "used", "free", "shared", "buffers", "cached" );

if ( ! ($fh = @fopen("/proc/meminfo", "r")) ) { return 0; }

$match = array();
while ( $buffer = fgets($fh, 4096)) 
	{
	if ( !preg_match("/(Mem|Swap)/", $buffer, $match) ) {  continue; }
	$match[1] = strtolower($match[1]);	
	$count = array_push($result, array($index[0] => $match[1])) - 1;
	
	
	$split = preg_split("/\s+/", $buffer, (count($index) + 1));
	
	// save data in $result
	for ( $i=1; $i < count($index); $i++ )
		{
		if ( $this->useFillString && (strlen($split[$i]) < 1) )
			{ $result[$count][ $index[$i] ] = $this->fillString; }
		else if ( $this->useUnitCalc )
			{ $result[$count][ $index[$i] ] = $this->unitCalc($split[$i]); }
		else
			{ $result[$count][ $index[$i] ] = $split[$i]; }
		}
	
	// calc percentage
	if ( ($split[1] > 0) && ($split[2] > 0) )
		{
		$percentage = 100 * ( $split[2] - $split[5] - $split[6] ) / ( $split[1]  ); 
		$result[$count]["percent"] = sprintf("%01.0f", $percentage);
		}
	/* pooh, I thing, it is not neccessary
	else if ( $this->useFillString )
		{ $result[$count]["percentage"] =  $this->fillString; }
	*/
	else 
		{ $result[$count]["percent"] = 0;  }
	}

return $result;
}

/***************************************************************/
/* Class-functions: disk */

/**
 * getMount
 * 
 * Returns mounted devices with a lot of information
 * 
 * @access public
 * @param array $hide Which mountpoints to hide (reguler-expression)
 * @return string
 */
function getMount( $hide = array() )
{
if ( !($ph = popen("/bin/df --block-size=1 -P", "r") )) { return 0; }
if ( !($fh = fopen("/proc/mounts", "r") )) { return 0; }

if ( !is_array( $hide) )
	$hide	=	array();

$result = array();

$index = array( "disk", "size", "used", "free", "percent", "mount", "type" ); 
$device = array();

// get all devices
while ( ! feof($ph) )
	{
	$buffer = fgets( $ph, 4096 ); 
	if ( !preg_match("/\/\w*$/", $buffer) ) { continue; }

	$split = preg_split( "/\s+/", $buffer);

	// hide this one? 
	for ( $i = 0; $i < count($hide); $i++ )
		{
		if ( preg_match( $hide[$i], $split[5]) ) { continue(2); }
		}
	
	for ( $i = 0; $i < count($index); $i ++ )
		{
		$device[ $index[$i] ] = $split[$i]; 
		}
	array_push( $result, $device ); 
	}

pclose($ph);
	
// which filesystem type?
while ( ! feof($fh) )
	{
	$buffer = fgets( $fh, 4096 ); 
	list ($disk, $mount, $type) = preg_split( "/\s+/", $buffer);

	for ( $i = 0; $i < count($result); $i ++ )
		{
		if ( $result[$i]["mount"] == $mount ) { $result[$i]["type"] = $type; }
		}
	}

// modify "percent"
for ( $i = 0; $i < count($result); $i ++ )
	{
	if ( preg_match("/(\d+)/", $result[$i]["percent"], $match) ) 
		{ $result[$i]["percent"] = $match[1]; }
	}

// use unitCalc?
if ( $this->useUnitCalc )
	{
	for ( $i = 0; $i < count($result); $i ++ )
		{
		$result[$i]["size"] = $this->unitCalc($result[$i]["size"]); 
		$result[$i]["used"] = $this->unitCalc($result[$i]["used"]); 
		$result[$i]["free"] = $this->unitCalc($result[$i]["free"]); 
		}
	}
return $result;

}


/***************************************************************/
/* Class-functions: network */

/**
 * getHostName
 * 
 * Returns system hostname or name of "virtual-server"
 * 
 * @access public
 * @return string
 * @param bool virtual
 * @see getHostIp
 */
function getHostName($virtual = 0)
{
if ( !$virtual )
	{
	if ( $fp = fopen("/proc/sys/kernel/hostname","r") ) 
		{
		$result = trim( fgets( $fp, 4096 ) );
		fclose( $fp );
		$result = gethostbyaddr( gethostbyname( $result ) );
		}
	}
else
	{
	if ( !($result = getenv("HTTP_HOST")) ) 
		{
		if ( $this->useFillString ) { $result = $this->fillString; }
		else { $result = ""; }
		}
	}
	
return $result;
}

/**
 * getHostIp
 * 
 * Returns system hostname or name of "virtual-server"
 * 
 * @access public
 * @return string
 * @param bool virtual
 * @see getHostName
 */
function getHostIp($virtual = 0)
{
if ( !$virtual )
	{
	$result = $this->getHostName(0);
	$result = gethostbyname( $result );
	}
else
	{
	$result = getenv("SERVER_ADDR");
	}

return $result;
}

/**
 * getNetDevs
 * 
 * 
 * 
 * @access public
 * @return mixed
 * @param array hide Devices to hide from return value (regular-expression)
 * @see getHostName
 */

function getNetDevs( $hide = array() )
{
if (!is_array( $hide )) { $hide = array(); }

// the list of all available data fields
$index = array(
	"rxByte", "rxPacket", "rxErr", "rxDrop", "rxFifo", "rxFrame", "rxCompressed", "rxMulticast",
	"txByte", "txPacket", "txErr", "txDrop", "txFifo", "txColls", "txCarrier", "txCompressed");

// init the result array, add a virtual sum interface
$result = array();
array_push($result, array("name" => "sum"));
for ( $i = 0; $i < count($index); $i++ ) 
	{
	$result[0][$index[$i]] = 0;
	}


if ( !($fh = fopen("/proc/net/dev", "r")) ) { return 0;}

while ( $buffer = fgets($fh, 4096)) 
	{
	// find lines which look like interfaces
	if ( preg_match("/^\s*\w+\d:/", $buffer) )
		{
		// get name and data
		list( $name, $buffer ) = explode(":", $buffer, 2);
		$name = trim($name);

		// should we hide this interface? 
		$hideIt = false; 
		for ( $i=0; $i < count($hide); $i++)
			{
			if ( preg_match( $hide[$i], $name) )	{ $hideIt = true; }
			}

		if ( !$hideIt )
			{
			// maybe need to convert chars
			if ( $this->useHtmlChars ) { $name = htmlentities( $name ); }
		
			$buffer = trim($buffer);
			// split into data fields
			$data  = preg_split("/\s+/", $buffer, count($index));

			// save data in result
			$resultIndex =  array_push($result, array("name" => $name)) - 1 ;
			for ( $i = 0; $i < count($index); $i++ ) 
				{
				// calculate sum (on virtual sum interface)
				$result[0][$index[$i]] += $data[$i];

				if ($this->useUnitCalc && preg_match("/byte/i", $index[$i]) ) 
					{ $data[$i] = $this->unitCalc($data[$i]); }
				$result[$resultIndex][$index[$i]] = $data[$i];
				}
			}
		}
	}

fclose($fh);

// unitCalc for the virtual sum interface
if ( $this->useUnitCalc ) 
	{ 
	for ( $i = 0; $i < count($index); $i++ ) 
		{
		if ( preg_match("/byte/i", $index[$i]) ) 
				{ 
				$result[0][ $index[$i] ] = $this->unitCalc($result[0][ $index[$i] ]);
				}
		}
	}
return $result;
}
/***************************************************************/
/* Class-functions: sensors */

/**
 * setSensorParam
 * 
 * Set the names of each sensor parameter. (Names are like "max", "min", "limit" etc.)
 * 
 * @access public
 * @return bool
 * @param array Names of parameters.
 * @see addSensorParam(), sensorParam, getSensor()
 */
function setSensorParam($param = array())
{
$this->sensorParam = $param;
return 1;
}

/**
 * addSensorParam
 * 
 * Like setSensorParam, but adds names of parameters.
 * 
 * @access public
 * @return bool
 * @param array Names of parameters.
 * @see setSensorParam(), sensorParam, getSensor()
 */
function addSensorParam($param = array())
{
for ($i = 0; $i < count($param); $i++)
	{
	array_push($this->sensorParam,$param[$i]);
	}
return 1;
}

/**
 * setSensorHideLabel
 * 
 * Set the names of sensor-label to remove from output
 * 
 * @access public
 * @return bool
 * @param array Names of labels
 * @see addSensorHideLabel(), sensorHideLabel, getSensor()
 */
function setSensorHideLabel($label = array())
{
$this->sensorHideLabel = $label;
return 1;
}

/**
 * addSensorHideLabel
 * 
 * Like setSensorParam, but adds names of labels.
 * 
 * @access public
 * @return bool
 * @param array Names of labels
 * @see setSensorHideLabel(), sensorHideLabel, getSensor()
 */
function addSensorHideLabel($label = array())
{
for ($i = 0; $i < count($label); $i++)
	{
	array_push($this->sensorHideLabel, $label[$i]);
	}
return 1;
}

/**
 * setSensorReplace
 * 
 * Set values to replace any field use regular expressions. Each replacement is
 * controlled by three fields: The name of the field which should be parsed, the
 * regular expression to find and, of course the replace string. So the function
 * parameter is an array of replacements (an array of arrays). 
 * e.g.
 * setSensorReplace(array(array("name","/foo/","bar"), array("name","/bar/","foo")));
 * 
 * 
 * @access public
 * @return bool
 * @param mixed An array of replacements
 * @see addSensorReplace() , getSensor()
 */
function setSensorReplace($replace = array(array()))
{
$this->sensorReplace= $replace;
return 1;
}

/**
 * addSensorHideLabel
 * 
 * Like setSensorReplace, but adds replacements
 * 
 * @access public
 * @return bool
 * @param mixed An array of replacements
 * @see setSensorReplace(), getSensor()
 */
function addSensorReplace($replace = array(array()))
{
for ($i = 0; $i < count($replace); $i++)
	{
	array_push($this->sensorReplace, $replace[$i]);
	}
return 1;
}

/**
 * getSensor
 * 
 * This Funktion does real work: getSensor() gets the hardware-sensor
 * information, maybe modifys and return it. The return value looks similar to
 * the returns of database-select-queries, so you can easy display data using
 * patTemplates. 
 * 
 * @access public
 * @return mixed An array containung information and data
 * @see setFillString(), useFillString(), setSensorParam(), setSensorHideLabel(), setSensorReplace()
 */
function getSensor() 
{
// name the indices of the return data (assiociative array)
$index = array( "label", "value", "unit","alarm" );

// init the result value: $sensor
$sensor = array( patSYSINFO_SENSOR_INFO => "", patSYSINFO_SENSOR_DATA => array() );

// runs sensor-program and read from pipe
$sensorStdin = popen(patSYSINFO_SENSOR_PROG, "r");

while ( !feof($sensorStdin) )
	{
	$buffer = fgets($sensorStdin, 4096);
	if (strlen($buffer) > 1)
		{
		// split the label from the rest
		list( ${$index[0]}, $buffer ) = explode(":", $buffer,2);

		// convert chars -> html
		if ( $this->useHtmlChars ) 
			{ 
			${$index[0]} = htmlentities( ${$index[0]} );
			}
		
		// find Chip-Info-Id; only set first chip!
		if ( $buffer == "" && !$sensor[patSYSINFO_SENSOR_INFO] ) { $sensor[patSYSINFO_SENSOR_INFO] = ${$index[0]}; } 
		else
			{
			// should we skip this label? 
			$skipLabel = 0;
			for ( $i = 0; $i < count($this->sensorHideLabel); $i++ )
				{
				if (preg_match( $this->sensorHideLabel[$i], ${$index[0]})) 
					{ 
					$skipLabel = 1;
					break;
					}
				}
			if ( !$skipLabel )
				{
				// find fields in string:  value, unit, param and alarm
				if (preg_match("/^\s*([+-]{0,1}\d+\.*\d*)(.\w+)\s*\((.*)\)\s*(\w*)\s*$/" ,$buffer, $matches))
					{
					${$index[1]} = trim($matches[1]);
					${$index[2]} = trim($matches[2]);
					$tmpParam = trim($matches[3]);
					${$index[3]} = trim($matches[4]);

				// replace fields, replacement rules are defined in $this->sensorReplace
				for ($i = 0; $i < count($index); $i++)
					{
					for ($j = 0; $j < count($this->sensorReplace); $j++)
						{
						if ( !strcmp($index[$i], $this->sensorReplace[$j][0]) )
							{
							${$index[$i]} = preg_replace( $this->sensorReplace[$j][1], 
								$this->sensorReplace[$j][2], ${$index[$i]} );
							}
						}
					}
				
				// convert chars -> html
				if ( $this->useHtmlChars ) 
					{ 
					${$index[1]} = htmlentities( ${$index[1]} );
					${$index[2]} = htmlentities( ${$index[2]} );
					${$index[3]} = htmlentities( ${$index[3]} );
					}

				// fill emtpy strings (expect of first field, the label)
				if ( $this->useFillString )
					{
					for ($i = 1; $i < count($index); $i++)
						if ( strlen( ${$index[$i]}) == 0 )
							{ 
							 ${$index[$i]} = $this->fillString;
							}
						}

					// save data in sensor array
					$dataCount = array_push($sensor[patSYSINFO_SENSOR_DATA], 
						array( 	$index[0] => ${$index[0]},
								$index[1] => ${$index[1]},
								$index[2] => ${$index[2]},
								$index[3] => ${$index[3]},
								)
						);
	
					// find values of $sensorParam in $tmpParam, ...
					for ($i = 0; $i < count($this->sensorParam); $i++ )
						{
						if (preg_match("/". $this->sensorParam[$i] ."\s*=\s*([+-]{0,1}\d+\.*\d*)/i", $tmpParam, $matches)) 
							{ 
							${$this->sensorParam[$i]} = $matches[1]; 
							// convert chars -> html
							if ( $this->useHtmlChars ) 
								{ 
								${$this->sensorParam[$i]} = htmlentities( ${$this->sensorParam[$i]} );
								}
							}
						// ... maybe fill emty values and ...
						else if ( $this->useFillString )
								{ ${$this->sensorParam[$i]} = $this->fillString; }
							else 
								{ ${$this->sensorParam[$i]} = ""; }
						
						// ... save in $sensor
						$sensor[patSYSINFO_SENSOR_DATA][ $dataCount - 1 ][$this->sensorParam[$i]] = ${$this->sensorParam[$i]};
						}
					}
				}
			}
		}
	}
pclose($sensorStdin);
return $sensor;
}

/***************************************************************/
/* Class-functions: help */


/**
 * unitCalc 
 * 
 * A helper function to format number and units.
 * 
 * @access public
 * @param int	number
 * @param int	div
 * @param array	units
 * @return array number,unit 
 */
function unitCalc( $number = 0, $div = "", $units = array() )
{
if ( $div == "") { $div = $this->unitCalcDiv; }
if ( !count($units) ) { $units = $this->unitCalcUnits; }

$calc = pow($div, (count($units) - 1));

$unit = "";
do
	{
	$unit = array_pop($units);
	if ( $number >= $calc ) 
		{
		$number = $number / $calc;
		break;
		}
	$calc = $calc / $div;
	} while ( $calc >= 1 ) ;

$number = sprintf("%.2f", $number);
$result = "$number $unit";

return $result;
}


}

?>
