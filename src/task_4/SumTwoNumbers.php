<?php namespace Task4;

class SumTwoNumbers
{
    /**
     * @param BigInt $n1
     * @param BigInt $n2
     */
    public function __construct(BigInt $n1, BigInt $n2)
    {
        $this->_n1 = $n1;
        $this->_n2 = $n2;
    }

    /**
     * Get result of sum two numbers
     *
     * @return string
     */
    public function result(): string
    {
        $result = '';
        if ($this->_n1->isPositive() && $this->_n2->isPositive()) {
            $result = $this->sumPosPos($this->_n1, $this->_n2);
        } elseif ($this->_n1->isNegative() && $this->_n2->isNegative()) {
            $result = $this->sumNegNeg($this->_n1, $this->_n2);
        } elseif ($this->_n1->isPositive() && $this->_n2->isNegative()) {
            $result = $this->sumPosNeg($this->_n1, $this->_n2);
        } elseif ($this->_n1->isNegative() && $this->_n2->isPositive()) {
            $result = $this->sumNegPos($this->_n1, $this->_n2);
        }

        return $result;
    }

    /**
     * Sum two positive numbers
     *
     * @param BigInt $n1
     * @param BigInt $n2
     *
     * @return string
     */
    protected function sumPosPos(BigInt $n1, BigInt $n2): string
    {
        $n1 = new BigInt($n1->makeLength($n2->length()));
        $n2 = new BigInt($n2->makeLength($n1->length()));

        $result = '';
        $rest = 0;
        $cycles = $n1->length();
        for ($i = $cycles; $i > 0; $i--) {
            $res = $n1->offsetGet($i-1) + $n2->offsetGet($i-1) + $rest;
            $res = new BigInt((string) $res);
            if ($res->length() > 1) {
                $rest = $res->offsetGet(0);
                $result = $res->offsetGet(1).$result;
            } else {
                $rest = 0;
                $result = $res->getNumberStr(true).$result;
            }
        }

        if ($rest > 0) {
            $result = $rest.$result;
        }

        return $result;
    }

    /**
     * Sum two negative numbers
     *
     * @param BigInt $n1
     * @param BigInt $n2
     *
     * @return string
     */
    protected function sumNegNeg(BigInt $n1, BigInt $n2): string
    {
        $result = $this->sumPosPos(new BigInt($n1->getNumberStr(true)), new BigInt($n2->getNumberStr(true)));
        return '-'.$result;
    }

    /**
     * Sum negative and positive numbers
     *
     * @param BigInt $n1
     * @param BigInt $n2
     *
     * @return string
     */
    protected function sumNegPos(BigInt $n1, BigInt $n2): string
    {
        $sign = '';
        $result = '0';
        if ($n1->length() > $n2->length()) {
            $sign = '-';
            $result = $this->sub($n1, $n2);
        } elseif ($n1->length() < $n2->length()) {
            $result = $this->sub($n2, $n1);
        } elseif ($n1->getNumberStr(true) == $n2->getNumberStr(true)) {
            $result = '0';
        } elseif ($n1->length() == $n2->length() && $n1->getNumberStr(true) != '0') {
            $cycles = $n1->length();
            for ($i = 0; $i < $cycles; $i++) {
                if ($n1->offsetGet($i) > $n2->offsetGet($i)) {
                    $sign = '-';
                    $result = $this->sub($n1, $n2);
                    break;
                } elseif ($n1->offsetGet($i) < $n2->offsetGet($i)) {
                    $result = $this->sub($n2, $n1);
                    break;
                }
            }
        }

        return $sign.$result;
    }

    /**
     * Sum positive and negative numbers
     *
     * @param BigInt $n1
     * @param BigInt $n2
     *
     * @return string
     */
    protected function sumPosNeg(BigInt $n1, BigInt $n2): string
    {
        return $this->sumNegPos($n2, $n1);
    }

    /**
     * Sub tho numbers
     *
     * @param BigInt $n1
     * @param BigInt $n2
     *
     * @return string
     */
    protected function sub(BigInt $n1, BigInt $n2): string
    {
        $n1 = new BigInt($n1->makeLength($n2->length()));
        $n2 = new BigInt($n2->makeLength($n1->length()));

        $result = '';
        $rest = 0;
        $cycles = $n1->length();
        for ($i = $cycles; $i > 0; $i--) {
            $n1n = $n1->offsetGet($i-1);
            $n2n = $n2->offsetGet($i-1) + $rest;
            $res = $n1n - $n2n;
            if ($res < 0) {
                $rest = 1;
                $res = (string) (($n1n+10) - $n2n);
                $result = $res.$result;
            } else {
                $rest = 0;
                $res = (string) $res;
                $result = $res.$result;
            }
        }

        // return $result;
        return $this->trimLeadingZero($result);
    }

    /**
     * Trip leading zeros
     *
     * @param string $n
     *
     * @return string
     */
    protected function trimLeadingZero(string $n): string
    {
        if (strpos($n, '0') === 0) {
            return $this->trimLeadingZero(ltrim($n, '0'));
        }

        return $n;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->result();
    }
}
