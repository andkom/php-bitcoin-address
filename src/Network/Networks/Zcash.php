<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Network\Networks;

/**
 * Class Zcash
 * @package AndKom\Bitcoin\Address\Network\Networks
 */
class Zcash extends Bitcoin
{
    /**
     * @var string
     */
    protected $prefixP2pkh = "\x1c\xb8";

    /**
     * @var string
     */
    protected $prefixP2sh = "\x1c\xbd";

    /**
     * @var null
     */
    protected $prefixBech32 = null;
}