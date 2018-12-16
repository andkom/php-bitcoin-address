<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Tests;

use AndKom\Bitcoin\Address\Network\NetworkFactory;
use AndKom\Bitcoin\Address\Output\OutputFactory;
use AndKom\Bitcoin\Address\Output\OutputInterface;
use PHPUnit\Framework\TestCase;

class P2pkTest extends TestCase
{
    protected function getOutput(): OutputInterface
    {
        return OutputFactory::p2pk(hex2bin('0279be667ef9dcbbac55a06295ce870b07029bfcdb2dce28d959f2815b16f81798'));
    }

    public function testHex()
    {
        $this->assertEquals('210279be667ef9dcbbac55a06295ce870b07029bfcdb2dce28d959f2815b16f81798ac', $this->getOutput()->hex());
    }

    public function testAsm()
    {
        $this->assertEquals('PUSHDATA(33)[0279be667ef9dcbbac55a06295ce870b07029bfcdb2dce28d959f2815b16f81798] CHECKSIG', $this->getOutput()->asm());
    }

    public function testAddress()
    {
        $this->assertEquals('1BgGZ9tcN4rm9KBzDn7KprQz87SZ26SAMH', $this->getOutput()->address());
        $this->assertEquals('mrCDrCybB6J1vRfbwM5hemdJz73FwDBC8r', $this->getOutput()->address(NetworkFactory::bitcoinTest()));
        $this->assertEquals('mrCDrCybB6J1vRfbwM5hemdJz73FwDBC8r', $this->getOutput()->address(NetworkFactory::bitcoinRegtest()));
    }
}