<?php namespace Task3;

use Exception;
use Psr\Log\LoggerInterface;

class LoggerDecorator extends AbstractDecorator
{
    /**
     * Logger instance
     *
     * @var LoggerInterface
     */
    protected $_logger;

    /**
     * @param DataInterface $provider
     * @param LoggerInterface $logger
     */
    public function __construct(DataInterface $provider, LoggerInterface $logger)
    {
        $this->_logger = $logger;
        parent::__construct($provider);
    }

    /**
     * Log errors
     *
     * @param array $opt Request options
     *
     * @return array
     */
    public function get(array $opt): array
    {
        try {
            $result = $this->getProvider()->get($opt);
        } catch (Exception $e) {
            $this->getLogger()->error($e->getMessage(), $e->getTrace());
            throw $e;
        }

        return $result;
    }

    /**
     * Returnds logger instance
     *
     * @return LoggerInterface
     */
    protected function getLogger(): LoggerInterface
    {
        return $this->_logger;
    }
}
