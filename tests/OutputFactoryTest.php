<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Tests;

use AndKom\Bitcoin\Address\Exception;
use AndKom\Bitcoin\Address\Output\OutputFactory;
use AndKom\Bitcoin\Address\Output\Outputs\P2ms;
use AndKom\Bitcoin\Address\Output\Outputs\P2pk;
use AndKom\Bitcoin\Address\Output\Outputs\P2pkh;
use AndKom\Bitcoin\Address\Output\Outputs\P2sh;
use AndKom\Bitcoin\Address\Output\Outputs\P2tr;
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
     * @throws Exception
     */
    public function testFromHexP2PK(): void
    {
        $output = OutputFactory::fromHex('210279be667ef9dcbbac55a06295ce870b07029bfcdb2dce28d959f2815b16f81798ac');
        $this->assertInstanceOf(P2pk::class, $output);
        $this->assertEquals($output->getPubKey(), hex2bin('0279be667ef9dcbbac55a06295ce870b07029bfcdb2dce28d959f2815b16f81798'));
        $this->assertEquals($output->type(), 'p2pk');
    }

    /**
     * @throws Exception
     */
    public function testFromHexP2PKH(): void
    {
        $output = OutputFactory::fromHex('76a914751e76e8199196d454941c45d1b3a323f1433bd688ac');
        $this->assertInstanceOf(P2pkh::class, $output);
        $this->assertEquals($output->getPubKeyHash(), hex2bin('751e76e8199196d454941c45d1b3a323f1433bd6'));
        $this->assertEquals($output->type(), 'p2pkh');
    }

    /**
     * @throws Exception
     */
    public function testFromHexP2MS(): void
    {
        $output = OutputFactory::fromHex('51210279be667ef9dcbbac55a06295ce870b07029bfcdb2dce28d959f2815b16f8179851ae');
        $this->assertInstanceOf(P2ms::class, $output);
        $this->assertEquals($output->getPubKeys(), [hex2bin('0279be667ef9dcbbac55a06295ce870b07029bfcdb2dce28d959f2815b16f81798')]);
        $this->assertEquals($output->getSigCount(), 1);
        $this->assertEquals($output->type(), 'p2ms');
    }

    /**
     * @throws Exception
     */
    public function testFromHexP2SH(): void
    {
        $output = OutputFactory::fromHex('a91483eebb7d79aa1d388e3b0ac65b98ac580c4da01a87');
        $this->assertInstanceOf(P2sh::class, $output);
        $this->assertEquals($output->getScriptHash(), hex2bin('83eebb7d79aa1d388e3b0ac65b98ac580c4da01a'));
        $this->assertEquals($output->type(), 'p2sh');
    }

    /**
     * @throws Exception
     */
    public function testFromHexP2WPKH(): void
    {
        $output = OutputFactory::fromHex('0014751e76e8199196d454941c45d1b3a323f1433bd6');
        $this->assertInstanceOf(P2wpkh::class, $output);
        $this->assertEquals($output->getPubKeyHash(), hex2bin('751e76e8199196d454941c45d1b3a323f1433bd6'));
        $this->assertEquals($output->type(), 'p2wpkh');
    }

    /**
     * @throws Exception
     */
    public function testFromHexP2WSH(): void
    {
        $output = OutputFactory::fromHex('002028205333db922f66e8a941b4a32d66de5cea03d9cda46e3e6658935272b9b24f');
        $this->assertInstanceOf(P2wsh::class, $output);
        $this->assertEquals($output->getWitnessHash(), hex2bin('28205333db922f66e8a941b4a32d66de5cea03d9cda46e3e6658935272b9b24f'));
        $this->assertEquals($output->type(), 'p2wsh');
    }

    /**
     * @throws Exception
     */
    public function testFromHexP2TR()
    {
        $output = OutputFactory::fromHex('5120a60869f0dbcf1dc659c9cecbaf8050135ea9e8cdc487053f1dc6880949dc684c');
        $this->assertInstanceOf(P2tr::class, $output);
        $this->assertEquals($output->getTaprootPubKey(), hex2bin('a60869f0dbcf1dc659c9cecbaf8050135ea9e8cdc487053f1dc6880949dc684c'));
        $this->assertEquals($output->type(), 'p2tr');
    }
}
