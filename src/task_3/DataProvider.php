<?php namespace Task3;

use Exception;

use GuzzleHttp\ClientInterface;

use GuzzleHttp\Stream\StreamInterface;

class DataProvider implements DataInterface
{
    /**
     * Client instance
     *
     * @var ClientInterface
     */
    protected $_client;

    /**
     * Remote URL to get external data
     *
     * @var string
     */
    protected $_url;

    /**
     * @param ClientInterface $client
     * @param string $url
     */
    public function __construct(ClientInterface $client, string $url)
    {
        $this->_client = $client;
        $this->_url = $url;
    }

    /**
     * Get some data from external service
     *
     * @param array $opt Request options
     *
     * @return array
     */
    public function get(array $opt): array
    {
        $response = $this->getClient()->createRequest('GET', $this->getURL(), $opt);
        if ($response->getStatusCode() == 200) {
            $result = $this->responseToArray($response->getBody());
        } else {
            throw new CoundNotGetDataException();
        }

        return $result;
    }

    /**
     * Returns client instance
     *
     * @return ClientInterface
     */
    protected function getClient(): ClientInterface
    {
        return $this->_client;
    }

    /**
     * Returns request URL
     *
     * @return string
     */
    protected function getURL(): string
    {
        return $this->_url;
    }

    /**
     * Convert response body to array
     *
     * @param StreamInterface $body
     *
     * @return array
     */
    protected function responseToArray(StreamInterface $body): array
    {
        $content = $body->getContents();
        $result = [];
        if (!empty($content)) {
            $result = json_decode($content, true);
        }

        return $result;
    }
}
