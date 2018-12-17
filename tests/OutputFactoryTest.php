<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Tests;

use AndKom\Bitcoin\Address\Output\OutputFactory;
use AndKom\Bitcoin\Address\Output\Outputs\P2ms;
use AndKom\Bitcoin\Address\Output\Outputs\P2pk;
use AndKom\Bitcoin\Address\Output\Outputs\P2pkh;
use AndKom\Bitcoin\Address\Output\Outputs\P2sh;
use AndKom\Bitcoin\Address\Output\Outputs\P2wpkh;
use AndKom\Bitcoin\Address\Output\Outputs\P2wsh;
use PHPUnit\Framework\TestCase;

/**
 * Class OutputFactoryTest
 * @package AndKom\Bitcoin\Address\Tests
 */
class OutputFactoryTest extends TestCase
{
    /**
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    public function testFromHexP2PK()
    {
        $output = OutputFactory::fromHex('210279be667ef9dcbbac55a06295ce870b07029bfcdb2dce28d959f2815b16f81798ac');
        $this->assertInstanceOf(P2pk::class, $output);
    }

    /**
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    public function testFromHexP2PKH()
    {
        $output = OutputFactory::fromHex('76a914751e76e8199196d454941c45d1b3a323f1433bd688ac');
        $this->assertInstanceOf(P2pkh::class, $output);
    }

    /**
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    public function testFromHexP2MS()
    {
        $output = OutputFactory::fromHex('51210279be667ef9dcbbac55a06295ce870b07029bfcdb2dce28d959f2815b16f8179851ae');
        $this->assertInstanceOf(P2ms::class, $output);
    }

    /**
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    public function testFromHexP2SH()
    {
        $output = OutputFactory::fromHex('a91483eebb7d79aa1d388e3b0ac65b98ac580c4da01a87');
        $this->assertInstanceOf(P2sh::class, $output);
    }

    /**
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    public function testFromHexP2WPKH()
    {
        $output = OutputFactory::fromHex('0014751e76e8199196d454941c45d1b3a323f1433bd6');
        $this->assertInstanceOf(P2wpkh::class, $output);
    }

    /**
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    public function testFromHexP2WSH()
    {
        $output = OutputFactory::fromHex('002028205333db922f66e8a941b4a32d66de5cea03d9cda46e3e6658935272b9b24f');
        $this->assertInstanceOf(P2wsh::class, $output);
    }
}