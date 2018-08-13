<?php namespace Tests\Task4;

use Task4\BigInt;
use Task4\SumTwoNumbers;

use PHPUnit\Framework\TestCase;

final class SumTwoNumbersTest extends TestCase
{
    public function testSumPosPos()
    {
        $n1 = new BigInt('11111111111111111111111111111111111111111111111111');
        $n2 = new BigInt('22222222222222222222222222222222222222222222222222');
        $expectedResult = '33333333333333333333333333333333333333333333333333';

        $result = (new SumTwoNumbers($n1, $n2))->result();
        $this->assertEquals($expectedResult, $result);
    }

    public function testSumPosPosDifferentLength()
    {
        $n1 = new BigInt('111');
        $n2 = new BigInt('2');
        $expectedResult = '113';

        $result = (new SumTwoNumbers($n1, $n2))->result();
        $this->assertEquals($expectedResult, $result);
    }

    public function testSumNegNeg()
    {
        $n1 = new BigInt('-11111111111111111111111111111111111111111111111111');
        $n2 = new BigInt('-22222222222222222222222222222222222222222222222222');
        $expectedResult = '-33333333333333333333333333333333333333333333333333';

        $result = (new SumTwoNumbers($n1, $n2))->result();
        $this->assertEquals($expectedResult, $result);
    }

    public function testSumNegNegDifferentLength()
    {
        $n1 = new BigInt('-111');
        $n2 = new BigInt('-2');
        $expectedResult = '-113';

        $result = (new SumTwoNumbers($n1, $n2))->result();
        $this->assertEquals($expectedResult, $result);
    }

    public function testSumPosNegWherePosIsGreater()
    {
        $n1 = new BigInt('111');
        $n2 = new BigInt('-20');
        $expectedResult = '91';

        $result = (new SumTwoNumbers($n1, $n2))->result();
        $this->assertEquals($expectedResult, $result);

        $result = (new SumTwoNumbers($n2, $n1))->result();
        $this->assertEquals($expectedResult, $result);

        $n1 = new BigInt('00111');
        $n2 = new BigInt('-020');
        $expectedResult = '91';

        $result = (new SumTwoNumbers($n1, $n2))->result();
        $this->assertEquals($expectedResult, $result);

        $result = (new SumTwoNumbers($n2, $n1))->result();
        $this->assertEquals($expectedResult, $result);
    }

    public function testSumPosNegWhereNegIsGreater()
    {
        $n1 = new BigInt('111');
        $n2 = new BigInt('-211');
        $expectedResult = '-100';

        $result = (new SumTwoNumbers($n1, $n2))->result();
        $this->assertEquals($expectedResult, $result);

        $result = (new SumTwoNumbers($n2, $n1))->result();
        $this->assertEquals($expectedResult, $result);
    }


    public function testSumPosNegWherePosIsGreaterBigNumber()
    {
        $n1 = new BigInt('1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111');
        $n2 = new BigInt('-11111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111112');
        $expectedResult = '1099999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999';

        $result = (new SumTwoNumbers($n1, $n2))->result();
        $this->assertEquals($expectedResult, $result);

        $result = (new SumTwoNumbers($n2, $n1))->result();
        $this->assertEquals($expectedResult, $result);
    }

    public function testSumPosNegWhereNegIsGreaterBigNumber()
    {
        $n1 = new BigInt('-1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111');
        $n2 = new BigInt('11111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111112');
        $expectedResult = '-1099999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999';

        $result = (new SumTwoNumbers($n1, $n2))->result();
        $this->assertEquals($expectedResult, $result);

        $result = (new SumTwoNumbers($n2, $n1))->result();
        $this->assertEquals($expectedResult, $result);
    }
}
