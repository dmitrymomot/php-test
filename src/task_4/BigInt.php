<?php namespace Task4;

use Exception;

class BigInt
{
    /**
     * @var string
     */
    protected $_number;

    /**
     * @param string $number
     */
    public function __construct(string $number)
    {
        $this->_number = trim($number);
    }

    /**
     * Get number
     *
     * @param bool $trimMinus
     *
     * @return string
     */
    public function getNumberStr($trimMinus = false): string
    {
        return $trimMinus ? ltrim($this->_number, '-') : $this->_number;
    }

    /**
     * Determine whether a number is positive
     *
     * @return bool
     */
    public function isPositive(): bool
    {
        return strpos($this->getNumberStr(), '-') === false;
    }

    /**
     * Determine whether a number is positive
     *
     * @return bool
     */
    public function isNegative(): bool
    {
        return strpos($this->getNumberStr(), '-') === 0;
    }

    /**
     * Get length of number
     *
     * @return int
     */
    public function length(): int
    {
        return strlen($this->getNumberStr(true));
    }

    /**
     * @param int $offset
     *
     * @return bool
     */
    public function offsetExists(int $offset): bool
    {
        $n = $this->getNumberStr(true);
        return isset($n[$offset]);
    }

    /**
     * @param int $offset
     *
     * @return int
     */
    public function offsetGet(int $offset): int
    {
        $n = $this->getNumberStr(true);
        if (!isset($n[$offset])) {
            throw new Exception('Unexisted offset', 1);
        }

        return intval($n[$offset]);
    }

    /**
     * Adds leading zeros to make needed length
     *
     * @param int $mustBeLength
     *
     * @return string
     */
    public function makeLength(int $mustBeLength): string
    {
        $number = $this->getNumberStr(true);
        $length = $this->length();
        if ($length < $mustBeLength) {
            $zerosAdded = 0;
            $zerosMissed = $mustBeLength - $length;
            for ($zerosAdded = 0; $zerosAdded < $zerosMissed; $zerosAdded++) {
                $number = '0'.$number;
            }
        }

        return $this->isNegative() ? '-'.$number : $number;
    }
}
