<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Tests;

use AndKom\Bitcoin\Address\Exception;
use AndKom\Bitcoin\Address\Output\OutputFactory;
use AndKom\Bitcoin\Address\Output\OutputInterface;
use AndKom\Bitcoin\Address\Output\Outputs\P2ms;
use PHPUnit\Framework\TestCase;

/**
 * Class P2msTest
 * @package AndKom\Bitcoin\Address\Tests
 */
class P2msTest extends TestCase
{
    /**
     * @return OutputInterface
     * @throws Exception
     */
    protected function getOutput(): OutputInterface
    {
        return OutputFactory::p2ms(
            1,
            [hex2bin('0279be667ef9dcbbac55a06295ce870b07029bfcdb2dce28d959f2815b16f81798') ?: '']
        );
    }

    /**
     * @throws Exception
     */
    public function testHex(): void
    {
        $this->assertEquals(
            '51210279be667ef9dcbbac55a06295ce870b07029bfcdb2dce28d959f2815b16f8179851ae',
            $this->getOutput()->hex()
        );
    }

    /**
     * @throws Exception
     */
    public function testAsm(): void
    {
        $this->assertEquals(
            '1 PUSHDATA(33)[0279be667ef9dcbbac55a06295ce870b07029bfcdb2dce28d959f2815b16f81798] 1 CHECKMULTISIG',
            $this->getOutput()->asm()
        );
    }

    /**
     * @throws Exception
     */
    public function testFromScript(): void
    {
        $output = $this->getOutput();
        $this->assertEquals($output->script(), P2ms::fromScript($output->script())->script());
    }
}
