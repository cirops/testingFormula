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

    //Structure used to represent the stack of opening symbols
    //to match them with the closing ones
    $fStack = array();

    //Reads a single line from the input file
    $formula = fgets($fileIn);
	
    //Browses through all of the input file
    while (!feof($fileIn)) {
		
        //To start with, all of the formulae are considered
        //well-formed unless some inconsistencies are found
        $badFormula = false;
		
        //Reads one symbol at a time per formula
        for ($i = 0 ; $i < strlen($formula)-1; $i++) {
            //In case it is an opening symbol
            if (   $formula[$i] == '{'
                || $formula[$i] == '[' 
                || $formula[$i] == '('
                || $formula[$i] == '<'
            ) {
                //Store it in the stack
                array_push( $fStack , $formula[$i] );
            }
            //If it is a closing symbol
            else if ($formula[$i] == '}')	{
                //If the head of the stack is NOT the matching closing symbol
                if (array_pop($fStack) != '{') {
                    //Then the formula is not well-formed
                    $badFormula = true;
                }
            }
            else if ($formula[$i] == ']') {
                if(array_pop($fStack) != '[') {
                    $badFormula = true;
                }
            }
            else if ($formula[$i] == ')') {
                if(array_pop($fStack) != '(') {
                    $badFormula = true;
                }
            }
            else if ($formula[$i] == '>') {
                if(array_pop($fStack) != '<') {
                    $badFormula = true;
                }
            }
			else {
                $badFormula = true;
            }
        }
	
        //If there are any leftovers in the stack
        if (count($fStack) > 0) {
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
        
        //The array must be emptied each turn, and a new formula is read
        $fStack  = array();
        $formula = fgets($fileIn);
    }
}

?>
