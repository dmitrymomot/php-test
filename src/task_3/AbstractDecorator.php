<?php namespace Task3;

abstract class AbstractDecorator implements DataInterface
{
    /**
     * Data provider instance
     *
     * @var DataInterface
     */
    protected $_provider;

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

    /**
     * Get some data
     *
     * @param array $opt
     *
     * @return array
     */
    public function get(array $opt): array
    {
        return $this->getProvider()->get($opt);
    }
}
