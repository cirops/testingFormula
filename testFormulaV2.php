<?php

/**
 * Function that tests formulas
 *
 * This function receives a string which represents the filename
 * of the formulaes to be tested, and returns 1 (true) in case it
 * is a well-formed formula, and 0 otherwise.
 * Example:
 * Input:
 *  [{<>}]
 *  (}{>)
 *  ()
 *  {}
 * Output:
 *  1
 *  0
 *  1
 *  1

 * @author     	    Ciro G. P. da Silva <cirops@gmail.com>
 * @created    	    05/11/2012 - 16:20
 * @last modified   05/11/2012 - 20:47
 */

function testFormula($fileName)
{
    //The file which contsins the formulae
    $fileIn = fopen($fileName,"r");

    //Reads a single line from the input file
    $formula = fgets($fileIn);
    
    //These numbers represent the pairing of symbols on a given time,
    //such that by the end, the 4 of them must be 0 for the formula
    //to be considered well-formed
    $numberOfCurly  = 0; // '{' or '}'
    $numberOfParent = 0; // '(' or ')'
    $numberOfSquare = 0; // '[' or ']' 
    $numberOfPointy = 0; // '<' or '>'
    
	
    //Browses through all of the input file
    while (!feof($fileIn)) {
		
        //To start with, all of the formulae are considered
        //well-formed unless some inconsistencies are found
        $badFormula = false;
		
        //Reads one symbol at a time per formula
        for ($i = 0 ; $i < strlen($formula)-1; $i++) {
            
            //If it is an opening symbol
            if (   $formula[$i] == '{' ) {
                //Which means "One opening curly is available"
                $numberOfCurly++;
            }
            else if ($formula[$i] == '[') {
                $numberOfSquare++;
            }
            else if ($formula[$i] == '(') {
                $numberOfParent++;
            }
            else if ($formula[$i] == '<') {
                $numberOfPointy++;
            }
            
            //If it is a closing symbol
            else if ($formula[$i] == '}') {
                //If there is still an opening curly available
                if($numberOfCurly > 0) {
                    //Match this closing symbol with it
                    $numberOfCurly--;
                }
                //If no opening curlies are available
                else {
                    //Then the formula is considered bad-formed
                    $badFormula = true;
                    
                    //and there is no need to continue the search
                    break;
                }
            }
            else if ($formula[$i] == ']') {
                if($numberOfSquare > 0) {
                    $numberOfSquare--;
                }
                else {
                    $badFormula = true;
                    break;
                }
            }
            else if ($formula[$i] == ')') {
                if($numberOfParent > 0) {
                    $numberOfParent--;
                }
                else {
                    $badFormula = true;
                    break;
                }
            }
            else if ($formula[$i] == '>') {
                if($numberOfPointy > 0) {
                    $numberOfPointy--;
                }
                else {
                    $badFormula = true;
                    break;
                }
            }
            
            //If any other symbol appears on the formula
			else {
                //It is considered a bad-formed formula
                $badFormula = true;
            }
        }
	
        //If there are any leftovers in the counters of symbols
        if (   $numberOfCurly > 0
            || $numberOfParent > 0
            || $numberOfSquare > 0
            || $numberOfPointy > 0
        ) {
            //the formula is also considered not well-formed
            $badFormula = true;
        }
        
        //If the formula is bad
        if ($badFormula) {
            //Prints 0 (false) in the output
            echo "0\n";
            $badFormula = false;
        }
        else {
            echo "1\n";
        }
        
        //the counters must be cleared, and a new formula is read
        $numberOfCurly  = 0;
        $numberOfParent = 0;
        $numberOfSquare = 0;
        $numberOfPointy = 0;
        
        $formula = fgets($fileIn);
    }
}

?>
