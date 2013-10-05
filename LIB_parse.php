<?php

class http_parse
{
	/*
	*	This library is for parsing pages that have been received using the Metafid LIB_http core. Most of it is just basic parsing code that's been better adapter for the Metafid code generator.
	*
	*	This core library was created by Matthew Bryant (mandat0ry), contact me via email at "mandatory@gmail.com"
	*
	*/
	
	/*
	*	Description:
	*	Returns the value between two specified strings.
	*
	*	@param $input		The string that you want to parse
	*	@param $start_tag	The start tag
	*	@param $end_tag		The end tag
	*	@param $keep_tags	Boolean, keep the start/end tags or not?
	*
	*	Returns the parsed string, else returns nothing if errors occur.
	*/
	
	public function return_between($input, $start_tag, $end_tag, $keep_tags = FALSE)
	{
		// Legacy code for older versions of Metafid
		if($keep_tags === "FALSE")
			$keep_tags = false;
		if($keep_tags === "TRUE")
			$keep_tags = true;

		$start_pos = strpos($input, $start_tag);
		
		if($start_pos != FALSE)
		{
			if(!$keep_tags)
			{
				$tmp_String = substr($input, ($start_pos + strlen($start_tag)));
			} else {
				$tmp_String = substr($input, $start_pos);
			}

			$end_pos = strpos($tmp_String, $end_tag);
			
			if($end_pos != FALSE)
			{
				if(!$keep_tags)
				{
					return substr($tmp_String, 0, $end_pos);
				} else {
					return substr($tmp_String, 0, ($end_pos + strlen($end_tag)));
				}
			} else {
				return "";
			}
		} else {
			return "";
		}	
	}
		
	/*
	*	Description:
	*	A function that parses out HTML contents and returns and array of strings found between the two specified delimters.
	*
	*	@param 	$string 		The string you're parsing
	*	@param 	$start_tag 		The starting tag, ie "<h1>"
	*	@param 	$end_tag 		The ending tag, ie "<h1>"
	*	@param 	$keep_tags 		Boolean to specify if we're keeping the tags
	*
	* 	Returns an array of parsed strings from input string
	*
	*/
	public function parse_html($string, $start_tag, $end_tag, $keep_tags = FALSE)
	{
		// Legacy code for older versions of Metafid
		if($keep_tags === "FALSE")
			$keep_tags = false;
		if($keep_tags === "TRUE")
			$keep_tags = true;
		
		$start_tag = preg_quote($start_tag);
		$end_tag = preg_quote($end_tag);
		preg_match_all("($start_tag(.*)$end_tag)siU", $string, $matching_data);
		
		$matching_data = $matching_data[1];
		
		foreach ($matching_data as $value) {
			$value = $this->return_between($value, $start_tag, $end_tag, "TRUE");
		}
		
		return $matching_data;
	}

	/*
	*	Description:
	*	Get's a form value for a specified form input name
	*
	*	@param $input_string 	The HTML/String that you want to parse for the input value
	*	@param $input_name 		The form input's name that you want the value of
	*	@param $id 				The ID of what you're looking for, for example "name" by default for <input type="text" name="example" value="extract_me">
	*	@param $value_id 		The ID of what you're extracting, for example <input type="text" name="example" id="extract_me">
	*
	*	Returns the value of the form input specified.
	*/
	public function get_formvalue($input_string, $inputname, $id = "name", $value_id = "value")
	{
		$id = preg_quote($id);
		$inputname = preg_quote($inputname);
		if (preg_match('/<input.*'.$id.'="'.$inputname.'".*>/', $input_string, $regs)) 
		{
			$input = $regs[0];
		} else {
			$input = "";
		}
		$value = $this->return_between($input, $value_id."=\"", "\"", "TRUE");

		return $value;
	}

	/*
	*	Description:
	*	Removes a single character from a string (not sure why this is in the Metafid base)
	*
	*	@param 	$input_string 	The input string
	*	@param 	$removed_char 	The character you're removing
	*
	*	Return's the input string with the specified characters removed
	*/
	public function delete_character($input_string, $removedcharacter)
	{
		return str_replace($removedcharacter, "", $input_string);
	}
}
?>