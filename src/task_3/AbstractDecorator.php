<?php namespace Task3;

abstract class AbstractDecorator implements DataInterface
{
    /**
     * Data provider instance
     *
     * @var DataInterface
     */
    private $_provider;

    /**
     * @param DataInterface $provider
     */
    public function __construct(DataInterface $provider)
    {
        $this->_provider = $provider;
    }

    /**
     * Get data provider instance
     *
     * @return DataInterface
     */
    protected function getProvider(): DataInterface
    {
        return $this->_provider;
    }
}
