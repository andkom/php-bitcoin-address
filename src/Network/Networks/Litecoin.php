<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Network\Networks;

/**
 * Class Litecoin
 * @package AndKom\Bitcoin\Address\Network\Networks
 */
class Litecoin extends Bitcoin
{
    /**
     * @var string
     */
    protected $prefixP2pkh = "\x30";

    /**
     * @var string
     */
    protected $prefixP2sh = "\x32"; // "\x05"

    /**
     * @var string
     */
    protected $prefixBech32 = 'ltc';
}