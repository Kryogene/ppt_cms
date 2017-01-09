<?PHP

class Player_Exception extends Exception
{

	const ID_NOT_NUMERIC = 4000;
	const NO_ASSOCIATED_ID = 4001;
	const NO_GUESTS = 4003;

	public function errorMessage()
	{

		switch( $this->code )
		{
			Case self::ID_NOT_NUMERIC:
				return "ERROR: Player ID Must Be A Numerical Value!";
			Case self::NO_ASSOCIATED_ID:
				return "ERROR: Player  ID Was Not Found!";
			Case self::NO_GUESTS:
				return "ERROR: Guests Cannot Be Instantiated Through A Player Class!";
		}
	
	}
	
	public function __toString()
	{
		return $this->errorMessage();
	}
}