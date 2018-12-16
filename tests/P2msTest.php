<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Tests;

use AndKom\Bitcoin\Address\Output\OutputFactory;
use AndKom\Bitcoin\Address\Output\OutputInterface;
use PHPUnit\Framework\TestCase;

class P2msTest extends TestCase
{
    protected function getOutput(): OutputInterface
    {
        return OutputFactory::p2ms(1, [hex2bin('0279be667ef9dcbbac55a06295ce870b07029bfcdb2dce28d959f2815b16f81798')]);
    }

    public function testHex()
    {
        $this->assertEquals('51210279be667ef9dcbbac55a06295ce870b07029bfcdb2dce28d959f2815b16f8179851ae', $this->getOutput()->hex());
    }

    public function testAsm()
    {
        $this->assertEquals('1 PUSHDATA(33)[0279be667ef9dcbbac55a06295ce870b07029bfcdb2dce28d959f2815b16f81798] 1 CHECKMULTISIG', $this->getOutput()->asm());
    }
}