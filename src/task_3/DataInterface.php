<?php namespace Task3;

interface DataInterface
{
    /**
     * Get some data
     *
     * @param array $opt
     *
     * @return array
     */
    public function get(array $opt): array;
}
