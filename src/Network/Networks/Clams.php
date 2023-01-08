<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Network\Networks;

/**
 * Class Clams
 * @package AndKom\Bitcoin\Address\Network\Networks
 */
class Clams extends Bitcoin
{
    /**
     * @var string
     */
    protected $prefixP2pkh = "\x89";

    /**
     * @var string
     */
    protected $prefixP2sh = "\x0D";

    /**
     * @var string
     */
    protected $prefixBech32 = null;
}
