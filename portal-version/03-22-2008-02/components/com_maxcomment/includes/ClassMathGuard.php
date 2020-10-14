<?php

/**
 * @author Matej Koval 
 * http://www.codegravity.com/projects/mathguard
 *  
 * MathGuard is a PHP class that inserts a small piece of HTML code into your HTML form which requires the user to evaluate an expression consisting of two random numbers. When user submits the form with the answer, the answer is hashed and compared to the security code that has been submitted as well. This way you can easily protect your forms from spambots.
 *
 *
 * Modified on 07/09/2007 by Bernard Gilly for integration in mXcomment
 */


/** SETTINGS - you can easily modify these constants **/
DEFINE('COLOR', "red");
DEFINE('SIZE', 5);
DEFINE('LINEHEIGHT', 4);
/** SETTINGS - you can easily modify these constants **/

class MathGuard {

	/** you can also modify $output to your needs **/
	function produceOutput($prime) {
		$a = rand() % 10; // generates the random number
		$b = rand() % 10; // generates the random number
		$code = MathGuard :: generateCode($a, $b, $prime);

		$output = _MXC_MATHGUARD_SECURITY_QUESTION .
		"<table border='0'><tr><td></td></tr><tr><td><pre style='font-size:" . SIZE . "px; font-weight: bold; color: " . COLOR . "; padding:0px; margin: 0px; line-height:" . LINEHEIGHT . "px;'>\n" . MathGuard :: renderExpression($a, $b) . "</pre></td>
				<td><input type='input' name='mathguard_answer' size='3' maxlength='2' class='inputbox' /><input type='hidden' name='mathguard_code' value='$code' /></td>
				</tr>
				</table>
				";

		return $output;
	}

	/** function that converts the decimal number to line of 3 random characters 
	 * @param $dec		decimal number that is being converted to line of 3 random characters
	 * */
	function decToBin($dec) {
		$pattern = "123456789ABCDEFGHIJKLMNOPQRTSTUWXYZ"; //without zero, it was interpreted as an empty space
		$output = "   ";
		$i = 0;
		do {
			if ($dec % 2) {
				$rand = rand() % 34;
				$output {
					2 - $i }
				= $pattern {
					$rand };
			} else {
				$output {
					2 - $i }
				= " ";
			}
			$dec = (int) ($dec / 2);
			$i++;
		} while ($dec > 0);
		return $output;
	}

	/** function that renders a final 3x5 matrix consisting of random characters 
	 * @param $a		random number a that renders to the 3x5 matrix consisting of random characters 
	 * @param $b		random number b that renders to the 3x5 matrix consisting of random characters 
	 * */
	function renderExpression($a, $b) {
		$output2 = "";
		$number = array (
			array (
				7,
				5,
				5,
				5,
				7
			),
			array (
				2,
				6,
				2,
				2,
				7
			),
			array (
				7,
				1,
				7,
				4,
				7
			),
			array (
				7,
				1,
				7,
				1,
				7
			),
			array (
				4,
				5,
				7,
				1,
				1
			),
			array (
				7,
				4,
				7,
				1,
				7
			),
			array (
				7,
				4,
				7,
				5,
				7
			),
			array (
				7,
				1,
				1,
				1,
				1
			),
			array (
				7,
				5,
				7,
				5,
				7
			),
			array (
				7,
				5,
				7,
				1,
				7
			)
		);

		$plus = array (
			0,
			2,
			7,
			2,
			0
		);
		$eq = array (
			0,
			7,
			0,
			7,
			0
		);

		for ($line = 0; $line < 5; $line++) {

			$output2 .= MathGuard :: decToBin($number[$a][$line]) . "   " . MathGuard :: decToBin($plus[$line]) . "   " . MathGuard :: decToBin($number[$b][$line]) . "   " . MathGuard :: decToBin($eq[$line]) . "\n";

			$output2 = str_replace("0", " ", $output2);

		}

		return $output2;
	}

	/** A main hashing function: concat of user's answer, hour and the additional prime number (default 37) */
	function encode($input, $prime) {
		return md5($input . date("H") . $prime);
	}

	/** This function generates the hash code from the two numbers 
	 * @param $a 	first number
	 * @param $b	second sumber
	 * @param $prime	additional number to encode with
	 * */
	function generateCode($a, $b, $prime) {
		$code = MathGuard :: encode($a + $b, $prime);
		return $code;
	}

	/** This function checks whether the answer and generated security code match 
	 * @param $mathguard_answer		answer the user has entered
	 * @param $mathguard_code		hashcode the mathguard has generated
	 */
	function checkResult($mathguard_answer, $mathguard_code, $prime = 37) {

		//		echo("prime; $prime, $mathguard_answer");
		$result_encoded = MathGuard :: encode($mathguard_answer, $prime);

		if ($result_encoded == $mathguard_code)
			return true;
		else
			return false;

	}

	/** this function inserts the two math term into your form, the parameter is optional */
	function insertQuestion($prime = 37) { //default prime is 37, you can change it when specifying the different parameter

		$output = MathGuard :: produceOutput($prime);

		echo $output;

	}
	
	/** this function inserts the two math term into your form, the parameter is optional */
	function insertQuestion2($prime = 37) { //default prime is 37, you can change it when specifying the different parameter

		$output = MathGuard :: produceOutput($prime);

		return $output;

	}


	/** this function returns math expression into your form, the parameter is optional 
	 * quite simmilar to insertQuestion, but returns the output as a text instead of echoing
	 */
	function returnQuestion($prime = 37) { //default prime is 37, you can change it when specifying the different parameter

		$output = MathGuard :: produceOutput($prime);

		return $output;

	}

}
?>