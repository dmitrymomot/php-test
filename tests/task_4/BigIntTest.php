<?php namespace Tests\Task4;

use Task4\BigInt;

use PHPUnit\Framework\TestCase;

final class BigIntTest extends TestCase
{
    public function testGetNumberStr()
    {
        $numberStr = '-231242142342342342353534';
        $this->assertEquals($numberStr, (new BigInt($numberStr))->getNumberStr());
        $this->assertNotEquals($numberStr, (new BigInt($numberStr))->getNumberStr(true));
        $this->assertEquals(trim($numberStr, '-'), (new BigInt($numberStr))->getNumberStr(true));
    }

    public function testPositiveNumber()
    {
        $numberStr = '231242142342342342353534';
        $this->assertEquals(true, (new BigInt($numberStr))->isPositive());
        $this->assertEquals(false, (new BigInt($numberStr))->isNegative());
    }

    public function testNegativeNumber()
    {
        $numberStr = '-231242142342342342353534';
        $this->assertEquals(true, (new BigInt($numberStr))->isNegative());
        $this->assertEquals(false, (new BigInt($numberStr))->isPositive());
    }

    public function testLengthNumber()
    {
        $numberStr = '-1234567890';
        $numberStr2 = '1234567890';
        $this->assertEquals(10, (new BigInt($numberStr))->length());
        $this->assertEquals(10, (new BigInt($numberStr2))->isPositive());
    }

    public function testOffsetExistsPositiveNumber()
    {
        $numberStr = '1234567890';
        $this->assertEquals(true, (new BigInt($numberStr))->offsetExists(9));
        $this->assertEquals(false, (new BigInt($numberStr))->offsetExists(10));
        $this->assertEquals(true, (new BigInt($numberStr))->offsetExists(-1));
    }

    public function testOffsetExistsNegativeNumber()
    {
        $numberStr = '-1234567890';
        $this->assertEquals(true, (new BigInt($numberStr))->offsetExists(9));
        $this->assertEquals(false, (new BigInt($numberStr))->offsetExists(10));
        $this->assertEquals(true, (new BigInt($numberStr))->offsetExists(-1));
    }

    public function testOffsetGetPositiveNumber()
    {
        $numberStr = '1234567890';
        $this->assertEquals(0, (new BigInt($numberStr))->offsetGet(9));
        $this->assertEquals(1, (new BigInt($numberStr))->offsetGet(0));
        $this->assertEquals(0, (new BigInt($numberStr))->offsetGet(-1));
    }

    public function testOffsetGetNegativeNumber()
    {
        $numberStr = '-1234567890';
        $this->assertEquals(0, (new BigInt($numberStr))->offsetGet(9));
        $this->assertEquals(1, (new BigInt($numberStr))->offsetGet(0));
        $this->assertEquals(0, (new BigInt($numberStr))->offsetGet(-1));
    }

    public function testAddLeadZeroPositiveNumber()
    {
        $numberStr = '123';
        $this->assertEquals('00'.$numberStr, (new BigInt($numberStr))->makeLength(5));
        $this->assertEquals('0000000'.$numberStr, (new BigInt($numberStr))->makeLength(10));
        $this->assertEquals($numberStr, (new BigInt($numberStr))->makeLength(3));
        $this->assertEquals($numberStr, (new BigInt($numberStr))->makeLength(1));
        $this->assertEquals($numberStr, (new BigInt($numberStr))->makeLength(0));
    }

    public function testAddLeadZeroNegativeNumber()
    {
        $numberStr = '-123';
        $this->assertEquals('-00'.ltrim($numberStr, '-'), (new BigInt($numberStr))->makeLength(5));
        $this->assertEquals('-0000000'.ltrim($numberStr, '-'), (new BigInt($numberStr))->makeLength(10));
        $this->assertEquals($numberStr, (new BigInt($numberStr))->makeLength(3));
        $this->assertEquals($numberStr, (new BigInt($numberStr))->makeLength(1));
        $this->assertEquals($numberStr, (new BigInt($numberStr))->makeLength(0));
    }
}
