<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Network\Networks;

/**
 * Class Dash
 * @package AndKom\Bitcoin\Address\Network\Networks
 */
class Dash extends Bitcoin
{
    /**
     * @var string
     */
    protected $prefixP2pkh = "\x4c";

    /**
     * @var string
     */
    protected $prefixP2sh = "\x10";

    /**
     * @var null
     */
    protected $prefixBech32 = null;
}