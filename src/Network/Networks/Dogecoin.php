<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Network\Networks;

/**
 * Class Dogecoin
 * @package AndKom\Bitcoin\Address\Network\Networks
 */
class Dogecoin extends BitcoinAbstract
{
    /**
     * @var string
     */
    protected $prefixP2pkh = "\x1e";

    /**
     * @var string
     */
    protected $prefixP2sh = "\x16";
}
