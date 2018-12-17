<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Tests;

use AndKom\Bitcoin\Address\Network\NetworkFactory;
use AndKom\Bitcoin\Address\Output\Outputs\P2pkh;
use AndKom\Bitcoin\Address\Output\Outputs\P2sh;
use AndKom\Bitcoin\Address\Output\Outputs\P2wpkh;
use AndKom\Bitcoin\Address\Output\Outputs\P2wsh;
use PHPUnit\Framework\TestCase;

/**
 * Class BitcoinTest
 * @package AndKom\Bitcoin\Address\Tests
 */
class BitcoinTest extends TestCase
{
    public function testDecodeP2PKH()
    {
        $this->assertInstanceOf(P2pkh::class, NetworkFactory::bitcoin()->decodeAddress('1BgGZ9tcN4rm9KBzDn7KprQz87SZ26SAMH'));
    }

    public function testDecodeP2SH()
    {
        $this->assertInstanceOf(P2sh::class, NetworkFactory::bitcoin()->decodeAddress('3DicS6C8JZm59RsrgXr56iVHzYdQngiehV'));
    }

    public function testDecodeP2WPKH()
    {
        $this->assertInstanceOf(P2wpkh::class, NetworkFactory::bitcoin()->decodeAddress('bc1qw508d6qejxtdg4y5r3zarvary0c5xw7kv8f3t4'));
    }

    public function testDecodeP2WSH()
    {
        $this->assertInstanceOf(P2wsh::class, NetworkFactory::bitcoin()->decodeAddress('bc1q9qs9xv7mjghkd69fgx62xttxmeww5q7eekjxu0nxtzf4yu4ekf8s4plngs'));
    }
}