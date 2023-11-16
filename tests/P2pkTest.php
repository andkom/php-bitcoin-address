<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Tests;

use AndKom\Bitcoin\Address\Exception;
use AndKom\Bitcoin\Address\Output\OutputFactory;
use AndKom\Bitcoin\Address\Output\OutputInterface;
use AndKom\Bitcoin\Address\Output\Outputs\P2pk;

/**
 * Class P2pkTest
 * @package AndKom\Bitcoin\Address\Tests
 */
class P2pkTest extends P2pkhTest
{
    /**
     * @return OutputInterface
     * @throws Exception
     */
    protected function getOutput(): OutputInterface
    {
        return OutputFactory::p2pk(hex2bin('0279be667ef9dcbbac55a06295ce870b07029bfcdb2dce28d959f2815b16f81798') ?: '');
    }

    /**
     * @throws Exception
     */
    public function testHex(): void
    {
        $this->assertEquals(
            '210279be667ef9dcbbac55a06295ce870b07029bfcdb2dce28d959f2815b16f81798ac',
            $this->getOutput()->hex()
        );
    }

    /**
     * @throws Exception
     */
    public function testAsm(): void
    {
        $this->assertEquals(
            'PUSHDATA(33)[0279be667ef9dcbbac55a06295ce870b07029bfcdb2dce28d959f2815b16f81798] CHECKSIG',
            $this->getOutput()->asm()
        );
    }

    /**
     * @throws Exception
     */
    public function testFromScript(): void
    {
        $output = $this->getOutput();
        $this->assertEquals($output->script(), P2pk::fromScript($output->script())->script());
    }
}
