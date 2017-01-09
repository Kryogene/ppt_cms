<?PHP

class Template_Exception extends Exception
{

	const INCLUDE_SKIN_EXCEPTION_CODE = 2000;
	const SEARCH_SKIN_EXCEPTION_CODE = 2001;
	const NO_ALERT_SENT = 2002;

	public function errorMessage()
	{

		switch( $this->code )
		{
			Case self::INCLUDE_SKIN_EXCEPTION_CODE:
				return "ERROR: Skin \"". $this->message . "\" Could Not Be Included!";
			Case self::SEARCH_SKIN_EXCEPTION_CODE:
				return "Skin \"" . $this->message . "\" Was Not Found!";
			Case self::NO_ALERT_SENT:
				return "No Alert Type Was Detected!";
		}
	
	}
	
	public function __toString()
	{
		return $this->errorMessage();
	}
}