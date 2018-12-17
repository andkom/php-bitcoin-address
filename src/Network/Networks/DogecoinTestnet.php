<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Network\Networks;

/**
 * Class Dogecoin
 * @package AndKom\Bitcoin\Address\Network\Networks
 */
class DogecoinTestnet extends Dogecoin
{
    /**
     * @var string
     */
    protected $prefixP2pkh = "\x71";

    /**
     * @var string
     */
    protected $prefixP2sh = "\xc4";

    /**
     * @var null
     */
    protected $prefixBech32 = null;
}