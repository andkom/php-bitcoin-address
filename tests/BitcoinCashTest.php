<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Tests;

use AndKom\Bitcoin\Address\Network\NetworkFactory;
use AndKom\Bitcoin\Address\Output\Outputs\P2pkh;
use AndKom\Bitcoin\Address\Output\Outputs\P2sh;
use PHPUnit\Framework\TestCase;

/**
 * Class BitcoinCashTest
 * @package AndKom\Bitcoin\Address\Tests
 */
class BitcoinCashTest extends TestCase
{
    public function testDecodeP2PKH()
    {
        $this->assertInstanceOf(P2pkh::class, NetworkFactory::bitcoinCash()->decodeAddress('bitcoincash:qp63uahgrxged4z5jswyt5dn5v3lzsem6cy4spdc2h'));
    }

    public function testDecodeP2SH()
    {
        $this->assertInstanceOf(P2sh::class, NetworkFactory::bitcoinCash()->decodeAddress('bitcoincash:pzp7awma0x4p6wyw8v9vvkuc43vqcndqrg9umkmd8g'));
    }
}