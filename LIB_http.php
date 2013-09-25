<?php
class http_request
{
	/*
	*	These are the default settings for the bot to operate with, chosen because they are the most generally useful settings.
	*	This core library was created by Matthew Bryant (mandatory), contact me via email at "mandatory@gmail.com"
	*
	*	Please ensure that you'd read the proper licensing before using this software.
	*/

	private $ch; // Channel variable that we will use
	private $debugArray = array(); // Array for storing debug information about the library's request(s) preformed
	private $counter = -1; // Counter for the debug array - set to '-1' so that it'll be zero with the first counter increment
	private $cookieFile = "cookies.txt"; // Default cookie file

	function __construct() // Automatically runs when initializing
	{
		try {
			if(function_exists('curl_version')) // Ensure that cURL is installed, if it isn't throw an error and exit!
			{
				$this->ch = curl_init();
				$this->counter = 0; // Set counter to zero
				curl_setopt($this->ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.8; rv:24.0) Gecko/20100101 Firefox/24.0');
				curl_setopt($this->ch, CURLOPT_AUTOREFERER, TRUE);
				curl_setopt($this->ch, CURLOPT_COOKIESESSION, FALSE);
				curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, 1);
				curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, TRUE);
				curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, FALSE);
				curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, FALSE);
				curl_setopt($this->ch, CURLOPT_VERBOSE, FALSE);
				curl_setopt($this->ch, CURLOPT_MAXREDIRS, 10);
				curl_setopt($this->ch, CURLOPT_POST, FALSE);
				curl_setopt($this->ch, CURLOPT_COOKIEFILE, $this->cookieFile);
				curl_setopt($this->ch, CURLOPT_COOKIEJAR, $this->cookieFile);
			}
			else 
			{
				echo "Fatal Error: The needed PHP module cURL is not installed! Please install before using this library!\n";
				exit();
			}
		} catch (Exception $e) {
			throw new Exception("Fatal Error: An error occured while initializing the library!\n", 0, $e);
			exit();
		}
	}

	/********************************************************
	*														*
	*	Main function that does the action of the request 	*
	*														*
	********************************************************/ 

	public function run()
	{
		try {
			$this->counter++; // Increment the counter
			$this->debugArray[$this->counter]['body'] = curl_exec($this->ch);
			$this->debugArray[$this->counter]['info'] = curl_getinfo($this->ch);
			$this->debugArray[$this->counter]['error'] = curl_error($this->ch);

			return $this->debugArray[$this->counter];
		} catch (Exception $e) {
			throw new Exception("Error: An error occured while try to preform the request!\n", 0, $e);
			return FALSE;
		}
	}

	public function reset() // Close an reopen the connection
	{
		try {
			if(gettype($this->ch) !== "curl")
			{
				curl_close($this->ch);
				$this->ch = curl_init();
			}
			return TRUE;
		} catch (Exception $e) {
			throw new Exception("Error: An error occured when trying to reset the connection!\n", 0, $e);
			return FALSE;
		}

	}

	public function close() // Close the $ch handle that's been used
	{
		try {
			if(gettype($this->ch) !== "curl")
			{
				curl_close($this->ch);
			}
			return TRUE;
		} catch (Exception $e) {
			throw new Exception("Error: An error occured while trying to close the connection!\n", 0, $e);
			return FALSE;
		}
	}

	/********************************************************
	*														*
	*	   Functions below this line are boolean based 		*
	*														*
	********************************************************/ 

	public function use_auto_referer($set) // Tell cURL to automatically fill the "referer" header 
	{
		try {
			if($set == TRUE){
				curl_setopt($this->ch, CURLOPT_AUTOREFERER, TRUE);
				return TRUE;
			} elseif ($set == FALSE) {
				curl_setopt($this->ch, CURLOPT_AUTOREFERER, FALSE);
			} else {
				return FALSE; // User didn't pass a boolean value, so return an error
			}
		} catch (Exception $e) {
			throw new Exception("Error: An error occured while trying to change the auto referer setting!\n", 0, $e);
			return FALSE;
		}
	}

	public function ignore_cookies($set) // Tell cURL to ignore session cookies that it has stored to force a new session
	{
		try {
			if($set == TRUE){
				curl_setopt($this->ch, CURLOPT_COOKIESESSION, TRUE);
				return TRUE;
			} else if($set == FALSE){
				curl_setopt($this->ch, CURLOPT_COOKIESESSION, FALSE);
				return TRUE;
			} else {
				return FALSE;
			}
		} catch (Exception $e) {
			throw new Exception("Error: An error occured while trying to change the ignore cookies setting!\n", 0, $e);
			return FALSE;
		}
	}

	public function show_ssl_cert_info($set) // Outputs SSL certificate information to the screen if verbosity is turned on for cURL
	{
		try {
			if($set == TRUE){
				curl_setopt($this->ch, CURLOPT_CERTINFO, TRUE);
				return TRUE;
			} else if($set == FALSE){
				curl_setopt($this->ch, CURLOPT_CERTINFO, FALSE);
				return TRUE;
			} else {
				return FALSE;
			}
		} catch (Exception $e) {
			throw new Exception("Error: An error occured while changing the verbosity of SSL certificate information!\n", 0, $e);
			return FALSE;
		}
	}

	public function convert_unix_to_win_line_breaks($set) // Changes the HTTP format from just \n (line feed) to \r\n (carriage return & line feed) for Windows compatibility
	{
		try {
			if($set == TRUE){
				curl_setopt($this->ch, CURLOPT_CRLF, TRUE);
				return TRUE;
			} else if($set == FALSE){
				curl_setopt($this->ch, CURLOPT_CRLF, FALSE);
				return TRUE;
			} else {
				return FALSE;
			}
		} catch (Exception $e) {
			throw new Exception("Error: An error occured while changing the http line break format from unix to windows!\n", 0, $e);
			return FALSE;
		}
	}

	public function use_dns_cache($set) // TRUE by default. This is whether or not the script should consult the local DNS cache for domains
	{
		try {
			if($set == TRUE){
				curl_setopt($this->ch, CURLOPT_DNS_USE_GLOBAL_CACHE, TRUE);
				return TRUE;
			} else if($set == FALSE){
				curl_setopt($this->ch, CURLOPT_DNS_USE_GLOBAL_CACHE, FALSE);
				return TRUE;
			} else {
				return FALSE;
			}
		} catch (Exception $e) {
			throw new Exception("Error: An error occured while changing the DNS cache settings!\n", 0, $e);
			return FALSE;
		}
	}

	public function quit_on_error($set) // FALSE by default. Should cURL stop the script if it encounters a server error greater than 400? (ie. 500 Internal Server Error)
	{
		try {
			if($set == TRUE){
				curl_setopt($this->ch, CURLOPT_FAILONERROR, TRUE);
				return TRUE;
			} else if($set == FALSE){
				curl_setopt($this->ch, CURLOPT_FAILONERROR, FALSE);
				return TRUE;
			} else {
				return FALSE;
			}
		} catch (Exception $e) {
			throw new Exception("Error: An error occured while changing the cURL setting to quit on errors!\n", 0, $e);
			return FALSE;
		}
	}

	public function gather_remote_file_date($set) // This is used in conjunction with another cURL function to attempt to retrieve the remove file's last modification time
	{
		try {
			if($set == TRUE){
				curl_setopt($this->ch, CURLOPT_FILETIME, TRUE);
				return TRUE;
			} else if($set == FALSE){
				curl_setopt($this->ch, CURLOPT_FILETIME, FALSE);
				return TRUE;
			} else {
				return FALSE;
			}
		} catch (Exception $e) {
			throw new Exception("Error: An error occured while changing the setting to gather the remote file date!\n", 0, $e);
			return FALSE;
		}
	}

	public function follow_location_redirects($set) // Follow any "Location: " HTTP headers the server sends, be sure to set the max redirects or the bot could be caught in a loop!
	{
		try {
			if($set == TRUE){
				curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, TRUE);
				return TRUE;
			} else if($set == FALSE){
				curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, FALSE);
				return TRUE;
			} else {
				return FALSE;
			}
		} catch (Exception $e) {
			throw new Exception("Error: An error occured while changing the setting for following locational redirects!\n", 0, $e);
			return FALSE;
		}
	}

	public function force_fresh_connection($set) // FALSE by default. Force a new TCP connection for each request (this is incase you're using a limited proxy or if the web server is setup badly)
	{
		try {
			if($set == TRUE){
				curl_setopt($this->ch, CURLOPT_FORBID_REUSE, TRUE);
				return TRUE;
			} else if($set == FALSE){
				curl_setopt($this->ch, CURLOPT_FORBID_REUSE, FALSE);
				return TRUE;
			} else {
				return FALSE;
			}
		} catch (Exception $e) {
			throw new Exception("Error: An error occured while changing the settings for forcing new connections on each request!\n", 0, $e);
			return FALSE;
		}
	}

	public function show_headers($set) // Show all of the HTTP headers while the bot is running (used primarily for debugging)
	{
		try {
			if($set == TRUE){
				curl_setopt($this->ch, CURLOPT_HEADER, TRUE);
				return TRUE;
			} else if($set == FALSE){
				curl_setopt($this->ch, CURLOPT_HEADER, FALSE);
				return TRUE;
			} else {
				return FALSE;
			}
		} catch (Exception $e) {
			throw new Exception("Error: An error occured while changing the settings for showing headers!\n", 0, $e);
			return FALSE;
		}
	}

	public function gather_raw_headers($set) // Gather the raw headers for debugging - to be used in conjection with cURL getinfo stuff
	{
		try {
			if($set == TRUE){
				curl_setopt($this->ch, CURLINFO_HEADER_OUT, TRUE);
				return TRUE;
			} else if($set == FALSE){
				curl_setopt($this->ch, CURLINFO_HEADER_OUT, FALSE);
				return TRUE;
			} else {
				return FALSE;
			}
		} catch (Exception $e) {
			throw new Exception("Error: An error occured while changing the settings for gathering raw headers!\n", 0, $e);
			return FALSE;
		}
	}

	public function show_no_output($set) // Set the bot to show zero output to the screen, effectively muting it
	{
		try {
			if($set == TRUE){
				curl_setopt($this->ch, CURLOPT_MUTE, TRUE);
				return TRUE;
			} else if($set == FALSE){
				curl_setopt($this->ch, CURLOPT_MUTE, FALSE);
				return TRUE;
			} else {
				return FALSE;
			}
		} catch (Exception $e) {
			throw new Exception("Error: An error occured while changing the setting for showing cURL output!\n", 0, $e);
			return FALSE;
		}
	}

	public function get_return_data($set) // TRUE by default. Get the data the server sends back to you, if you don't need it then why grab it?
	{
		try {
			if($set == TRUE){
				curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, TRUE);
				return TRUE;
			} else if($set == FALSE){
				curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, FALSE);
				return TRUE;
			} else {
				return FALSE;
			}
		} catch (Exception $e) {
			throw new Exception("Error: An error occured while changing the setting for getting the server response data!\n", 0, $e);
			return FALSE;
		}
	}

	public function verify_ssl($set) // Default is FALSE. Verify that everything is good with the SSL peer/host
	{
		try {
			if($set == TRUE){
				curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, TRUE);
				curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, TRUE);
				return TRUE;
			} else if($set == FALSE){
				curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, FALSE);
				curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, FALSE);
				return TRUE;
			} else {
				return FALSE;
			}
		} catch (Exception $e) {
			throw new Exception("Error: An error occured while changing the settings for verifying SSL!\n", 0, $e);
			return FALSE;
		}
	}

	public function send_auth_to_redirect($set) // Send the authorization header even when the redirect is to a different hostname
	{
		try {
			if($set == TRUE){
				curl_setopt($this->ch, CURLOPT_UNRESTRICTED_AUTH, TRUE);
				return TRUE;
			} else if($set == FALSE){
				curl_setopt($this->ch, CURLOPT_UNRESTRICTED_AUTH, FALSE);
				return TRUE;
			} else {
				return FALSE;
			}
		} catch (Exception $e) {
			throw new Exception("Error: An error occured while changing the setting for sending an authorization header with requests!\n", 0, $e);
			return FALSE;
		}
	}

	public function be_verbose($set) // Default is TRUE. Tell cURL to output lots of debugging information
	{
		try {
			if($set == TRUE){
				curl_setopt($this->ch, CURLOPT_VERBOSE, TRUE);
				return TRUE;
			} else if($set == FALSE){
				curl_setopt($this->ch, CURLOPT_VERBOSE, FALSE);
				return TRUE;
			} else {
				return FALSE;
			}
		} catch (Exception $e) {
			throw new Exception("Error: An error occured while changing the cURL verbosity!\n", 0, $e);
			return FALSE;
		}
	}

	/********************************************************
	*														*
	*	Functions below this line are not boolean based 	*
	*														*
	********************************************************/ 

	public function set_url($URL) // The URL cURL will be working with
	{
		try {
			curl_setopt($this->ch, CURLOPT_URL, $URL); 
			return TRUE;
		} catch (Exception $e) {
			throw new Exception("Error: An error occured while setting the URL!\n", 0, $e);
			return FALSE;
		}
	}

	public function set_get() // Set method type to GET
	{
		try {
			curl_setopt($this->ch, CURLOPT_POST, false);
			return TRUE;
		} catch (Exception $e) {
			throw new Exception("Error: An error occured while changing the method type to GET!\n", 0, $e);
			return FALSE;
		}
	}

	public function set_post($fieldsArray) // Set method type to POST
	{
		try {
			if(is_array($fieldsArray)) // Ensure it's an array before processing through it, if it isn't then ignore it (in the case of a manual string query string being passed)
			{
				$query = "";
				foreach($fieldsArray as $key => &$value)
				{
					$tmpKey = $key;
					$tmpKey = preg_replace('/\[DUP:\d+\]/', '', $tmpKey); // Replace the added on stuff to make the array keys unique
					$query .= urlencode($tmpKey)."=".urlencode($value)."&";
					unset($tmpKey);
				}
			}

			curl_setopt($this->ch, CURLOPT_POST, true);
			if (is_array($fieldsArray)){
				curl_setopt($this->ch, CURLOPT_POSTFIELDS, $query); // key => name gets turned into &key=name
			} else {
				curl_setopt($this->ch, CURLOPT_POSTFIELDS, $fieldsArray); // &key=name passed in
			}
			return TRUE;
		} catch (Exception $e) {
			throw new Exception("Error: An error occured while setting the method type to POST!\n", 0, $e);
			return FALSE;
		}
	}

	public function get_debug() // Get debug array 
	{
		try {
			return $this->debugArray;
		} catch (Exception $e) {
			throw new Exception("Error: An error occured while getting the debug information!\n", 0, $e);
			return FALSE;
		}
	}

	public function get_body() // Get request body 
	{
		try {
			return $this->debugArray[$this->counter]['body'];
		} catch (Exception $e) {
			throw new Exception("Error: An error occured while getting the request body!\n", 0, $e);
			return FALSE;
		}
	}

	public function get_info() // Get connection info
	{
		try {
			return $this->debugArray[$this->counter]['info'];
		} catch (Exception $e) {
			throw new Exception("Error: An error occured while getting the request body!\n", 0, $e);
			return FALSE;
		}
	}

	public function get_error() // Get request body 
	{
		try {
			return $this->debugArray[$this->counter]['error'];
		} catch (Exception $e) {
			throw new Exception("Error: An error occured while getting the request body!\n", 0, $e);
			return FALSE;
		}
	}

	public function get_phpversion() // Return the current version of PHP
	{
		try {
			$phpInfoArray = array();
			$phpInfoArray = explode("-", phpversion());

			return $phpInfoArray[0];
		} catch (Exception $e) {
			throw new Exception("Error: An error occured while getting the PHP version!\n", 0, $e);
			return FALSE;
		}
	}

	public function set_user_agent($userAgent) // Set user agent 
	{
		try {
			curl_setopt($this->ch, CURLOPT_USERAGENT, $userAgent);
			return TRUE;
		} catch (Exception $e) {
			throw new Exception("Error: An error occured while setting the user agent!\n", 0, $e);
			return FALSE;
		}
	}

	public function set_max_wait($seconds) // Default wait time is in seconds
	{
		try {
			curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, $seconds);
			return TRUE;
		} catch (Exception $e) {
			throw new Exception("Error: An error occured while setting the max response wait time!\n", 0, $e);
			return FALSE;
		}
	}

	public function set_max_wait_forever() // Wait indefinetally until the server returns something
	{
		try {
			curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, 0);			
			return TRUE;
		} catch (Exception $e) {
			throw new Exception("Error: An error occured while setting the indefinte wait setting for the server response!\n", 0, $e);
			return FALSE;
		}
	}

	public function set_max_wait_minutes($minutes) // Maximum connection wait time in minutes
	{
		try {
			$minutes = ($minutes * 60);
			curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, $seconds);
			return TRUE;
		} catch (Exception $e) {
			throw new Exception("Error: An error occured while setting the maximum amount of minutes to wait for a server response!\n", 0, $e);
			return FALSE;
		}
	}

	public function set_max_wait_seconds($seconds) // Maximum wait time in seconds
	{
		try {
			curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, $seconds);
			return TRUE;
		} catch (Exception $e) {
			throw new Exception("Error: An error occured while setting the maximum wait amount of seconds to wait for the server response!\n", 0, $e);
			return FALSE;
		}
	}

	public function set_max_wait_milliseconds($milliseconds) // Maximum wait time in milliseconds
	{
		try {
			curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT_MS, $milliseconds);
			return TRUE;
		} catch (Exception $e) {
			throw new Exception("Error: An error occured while setting the maximum amount of millseconds to wait for the server response!\n", 0, $e);
			return FALSE;
		}
	}

	public function set_max_store_dns($minutes) // Amount of time to store DNS records for
	{
		try {
			$minutes = ($minutes * 60);
			curl_setopt($this->ch, CURLOPT_DNS_CACHE_TIMEOUT, $minutes);
			return TRUE;
		} catch (Exception $e) {
			throw new Exception("Error: An error occured while setting the maximum amount of time to store DNS records!\n", 0, $e);
			return FALSE;
		}
	}

	public function set_basic_auth($username, $password) // Set basic auth information
	{
		try {
			curl_setopt($this->ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($this->ch, CURLOPT_USERPWD, $username.":".$password);
			return TRUE;
		} catch (Exception $e) {
			throw new Exception("Error: An error occured while setting the HTTP auth credentials!\n", 0, $e);
			return FALSE;
		}
	}

	public function set_max_redirects($number) // Default is 10. Maximum amount of times that the bot will follow the server's redirects (so we don't get caught in a loop)
	{
		try {
			curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, TRUE);
			curl_setopt($this->ch, CURLOPT_MAXREDIRS, $number);
			return TRUE;
		} catch (Exception $e) {
			throw new Exception("Error: An error occured while settings the maximum number of redirects!\n", 0, $e);
			return FALSE;
		}
	}

	public function set_port($port) // Default is dynamic. Normally shouldn't be changed, unless the port isn't in the URL etc.
	{
		try {
			curl_setopt($this->ch, CURLOPT_PORT, $port);
			return TRUE;
		} catch (Exception $e) {
			throw new Exception("Error: An error occured while settings the server port!\n", 0, $e);
			return FALSE;
		}
	}

	public function set_sock_proxy($address, $username, $password) // Use a proxy for requests to go through (SOCK5)
	{
		try {
			if(!empty($address))
			{
				curl_setopt($this->ch, CURLOPT_PROXY, $address);
				curl_setopt($this->ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);

				if(!empty($username) && !empty($password))
				{
					curl_setopt($this->ch, CURLOPT_PROXYAUTH, CURLAUTH_BASIC);
					curl_setopt($this->ch, CURLOPT_PROXYUSERPWD, $username.":".$password);
					return TRUE;
				}

				return TRUE;

			} else {
				return FALSE;
			}
		} catch (Exception $e) {
			throw new Exception("Error: An error occured while setting the SOCK5 proxy!\n", 0, $e);
			return FALSE;
		}
	}

	public function set_http_proxy($address, $username, $password) // Use a proxy for requests to go through (SOCK5)
	{
		try {
			if(!empty($address))
			{
				curl_setopt($this->ch, CURLOPT_PROXY, $address);
				curl_setopt($this->ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);

				if(!empty($username) && !empty($password))
				{
					curl_setopt($this->ch, CURLOPT_PROXYAUTH, CURLAUTH_BASIC);
					curl_setopt($this->ch, CURLOPT_PROXYUSERPWD, $username.":".$password);
					return TRUE;
				}

				return TRUE;

			} else {
				return FALSE;
			}
		} catch (Exception $e) {
			throw new Exception("Error: An error occured while setting the HTTP proxy!\n", 0, $e);
			return FALSE;
		}
	}

	public function set_no_proxy() // Remove proxy
	{
		try {
			curl_setopt($this->ch, CURLOPT_PROXY, null);
			return TRUE;
		} catch (Exception $e) {
			throw new Exception("Error: An error occured while removing the proxy setting!\n", 0, $e);
			return FALSE;
		}
	}

	public function clear_proxy() // Remove proxy
	{
		try {
			curl_setopt($this->ch, CURLOPT_PROXY, null);
			return TRUE;
		} catch (Exception $e) {
			throw new Exception("Error: An error occured while removing the proxy setting!\n", 0, $e);
			return FALSE;
		}
	}

	public function set_ssl_version($number) // Set SSL version
	{
		try {
			if($number == 2){
				curl_setopt($this->ch, CURLOPT_SSLVERSION, 2);
				return TRUE;
			} else if ($number == 3) {
				curl_setopt($this->ch, CURLOPT_SSLVERSION, 3);
				return TRUE;
			} else {
				return FALSE;
			}
		} catch (Exception $e) {
			throw new Exception("Error: An error occured while setting the SSL version!\n", 0, $e);
			return FALSE;
		}
	}

	public function set_cookie_file($filename) // File to save/read cookies to
	{
		try {
			curl_setopt($this->ch, CURLOPT_COOKIEJAR, $cookieFile); // File to save cookies in
			curl_setopt($this->ch, CURLOPT_COOKIEFILE, $cookieFile); // File to read cookies from
			return TRUE;
		} catch (Exception $e) {
			throw new Exception("Error: An error occured while setting the cookie file!\n", 0, $e);
			return FALSE;
		}
	}

	public function set_cookie_value($cookie_name, $new_cookie_value)
	{
		try {
			// Should be modified later, for now this will do
			$cookie_file_String = file_get_contents($this->cookieFile);
			$value_to_replace = $this->return_between($cookie_file_String, $cookie_name."\t", "\n", FALSE);
			$cookie_file_String = str_replace($value_to_replace, $new_cookie_value, $cookie_file_String);
			file_put_contents($this->cookieFile, $cookie_file_String);
			return TRUE;
		} catch (Exception $e) {
			throw new Exception("Error: An error occured while modifying the cookie file\n", 0, $e);
			return FALSE;
		}
	}

	public function clear_cookies() // Wipe all cookies 
	{
		try {
			// Test to see if writing to files is possible in this directory
			file_put_contents($this->cookieFile, "");
			$filecontents = file_get_contents($this->cookieFile);
			if($filecontents == "")
			{
				return TRUE;
			} else {
				return FALSE;
			}
		} catch (Exception $e) {
			throw new Exception("Error: An error occured while setting the cookie file!\n", 0, $e);
			return FALSE;
		}
	}

	public function set_referer($url) // URL to set the referer to
	{
		try {
			curl_setopt($this->ch, CURLOPT_REFERER, $url);
			return TRUE;
		} catch (Exception $e) {
			throw new Exception("Error: An error occured while setting the referer!\n", 0, $e);
			return FALSE;
		}
	}

	public function set_header_array($headerArray) // Set an array of headers to be sent for the request
	{
		try {
			curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headerArray);
			return TRUE;
		} catch (Exception $e) {
			throw new Exception("Error: An error occured while setting the request headers!\n", 0, $e);
			return FALSE;
		}
	}

	public function return_between($input, $start_tag, $end_tag, $keep_tags = FALSE) // included for cookie parsing functions
	{
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
}



?>