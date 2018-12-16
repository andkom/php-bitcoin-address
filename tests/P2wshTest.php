<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Tests;

use AndKom\Bitcoin\Address\Network\NetworkFactory;
use AndKom\Bitcoin\Address\Output\OutputFactory;
use AndKom\Bitcoin\Address\Output\OutputInterface;
use PHPUnit\Framework\TestCase;

class P2wshTest extends TestCase
{
    protected function getOutput(): OutputInterface
    {
        $factory = new OutputFactory();
        $p2ms = $factory->p2ms(1, [hex2bin('0279be667ef9dcbbac55a06295ce870b07029bfcdb2dce28d959f2815b16f81798')]);
        return $factory->p2wsh($p2ms);
    }

    public function testHex()
    {
        $this->assertEquals('002028205333db922f66e8a941b4a32d66de5cea03d9cda46e3e6658935272b9b24f', $this->getOutput()->hex());
    }

    public function testAsm()
    {
        $this->assertEquals('0 PUSHDATA(32)[28205333db922f66e8a941b4a32d66de5cea03d9cda46e3e6658935272b9b24f]', $this->getOutput()->asm());
    }

    public function testAddress()
    {
        $this->assertEquals('bc1q9qs9xv7mjghkd69fgx62xttxmeww5q7eekjxu0nxtzf4yu4ekf8s4plngs', $this->getOutput()->address());
        $this->assertEquals('tb1q9qs9xv7mjghkd69fgx62xttxmeww5q7eekjxu0nxtzf4yu4ekf8szffujl', $this->getOutput()->address(NetworkFactory::bitcoinTest()));
        $this->assertEquals('tb1q9qs9xv7mjghkd69fgx62xttxmeww5q7eekjxu0nxtzf4yu4ekf8szffujl', $this->getOutput()->address(NetworkFactory::bitcoinRegtest()));
    }
}