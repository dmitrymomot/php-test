<?php namespace Task3;

use Exception;
use Throwable;

class CoundNotGetDataException extends Exception
{
    /**
     * Exception message text
     *
     * @var string
     */
    protected $_defaultMessage = 'Could not get requested data by reason: ';

    /**
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 500, Throwable $previous = null)
    {
        parent::__construct($this->_defaultMessage.$message, $code, $previous);
    }
}
