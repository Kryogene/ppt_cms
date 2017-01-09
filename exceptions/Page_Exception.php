<?PHP

class Page_Exception extends Exception
{

	const GET_DATA_EXCEPTION_CODE = 3000;
	const GET_HANDLER_EXCEPTION_CODE = 3001;

	public function errorMessage()
	{

		switch( $this->code )
		{
			Case self::GET_DATA_EXCEPTION_CODE:
				return "ERROR: Page Data Was Not Successfully Set!";
			Case self::GET_HANDLER_EXCEPTION_CODE:
				return "ERROR: Page Handlers Were Not Successfully Set!";
		}
	
	}
	
	public function __toString()
	{
		return $this->errorMessage();
	}
}