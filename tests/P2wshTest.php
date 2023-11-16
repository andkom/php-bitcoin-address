<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Tests;

use AndKom\Bitcoin\Address\Exception;
use AndKom\Bitcoin\Address\Network\NetworkFactory;
use AndKom\Bitcoin\Address\Output\OutputFactory;
use AndKom\Bitcoin\Address\Output\OutputInterface;
use AndKom\Bitcoin\Address\Output\Outputs\P2wsh;
use PHPUnit\Framework\TestCase;

/**
 * Class P2wshTest
 * @package AndKom\Bitcoin\Address\Tests
 */
class P2wshTest extends TestCase
{
    /**
     * @return OutputInterface
     * @throws Exception
     */
    protected function getOutput(): OutputInterface
    {
        $factory = new OutputFactory();
        $p2ms = $factory->p2ms(
            1,
            [hex2bin('0279be667ef9dcbbac55a06295ce870b07029bfcdb2dce28d959f2815b16f81798') ?: '']
        );
        return $factory->p2wsh($p2ms);
    }

    /**
     * @throws Exception
     */
    public function testHex(): void
    {
        $this->assertEquals(
            '002028205333db922f66e8a941b4a32d66de5cea03d9cda46e3e6658935272b9b24f',
            $this->getOutput()->hex()
        );
    }

    /**
     * @throws Exception
     */
    public function testAsm(): void
    {
        $this->assertEquals(
            '0 PUSHDATA(32)[28205333db922f66e8a941b4a32d66de5cea03d9cda46e3e6658935272b9b24f]',
            $this->getOutput()->asm()
        );
    }

    /**
     * @throws Exception
     */
    public function testAddressBitcoin(): void
    {
        $this->assertEquals(
            'bc1q9qs9xv7mjghkd69fgx62xttxmeww5q7eekjxu0nxtzf4yu4ekf8s4plngs',
            $this->getOutput()->address()
        );
    }

    /**
     * @throws Exception
     */
    public function testAddressBitcoinTestnet(): void
    {
        $this->assertEquals(
            'tb1q9qs9xv7mjghkd69fgx62xttxmeww5q7eekjxu0nxtzf4yu4ekf8szffujl',
            $this->getOutput()->address(NetworkFactory::bitcoinTestnet())
        );
    }

    /**
     * @throws Exception
     */
    public function testAddressLitecoin(): void
    {
        $this->assertEquals(
            'ltc1q9qs9xv7mjghkd69fgx62xttxmeww5q7eekjxu0nxtzf4yu4ekf8sk93rj4',
            $this->getOutput()->address(NetworkFactory::litecoin())
        );
    }

    /**
     * @throws Exception
     */
    public function testAddressLitecoinTestnet(): void
    {
        $this->assertEquals(
            'tltc1q9qs9xv7mjghkd69fgx62xttxmeww5q7eekjxu0nxtzf4yu4ekf8sa24adq',
            $this->getOutput()->address(NetworkFactory::litecoinTestnet())
        );
    }

    /**
     * @throws Exception
     */
    public function testAddressViacoin(): void
    {
        $this->assertEquals(
            'via1q9qs9xv7mjghkd69fgx62xttxmeww5q7eekjxu0nxtzf4yu4ekf8s7ulzpx',
            $this->getOutput()->address(NetworkFactory::viacoin())
        );
    }

    /**
     * @throws Exception
     */
    public function testAddressViacoinTestnet(): void
    {
        $this->assertEquals(
            'tvia1q9qs9xv7mjghkd69fgx62xttxmeww5q7eekjxu0nxtzf4yu4ekf8s4nmu7n',
            $this->getOutput()->address(NetworkFactory::viacoinTestnet())
        );
    }

    /**
     * @throws Exception
     */
    public function testFromScript(): void
    {
        $output = $this->getOutput();
        $this->assertEquals($output->script(), P2wsh::fromScript($output->script())->script());
    }
}
