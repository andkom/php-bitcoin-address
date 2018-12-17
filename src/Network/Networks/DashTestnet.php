<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Network\Networks;

/**
 * Class DashTestnet
 * @package AndKom\Bitcoin\Address\Network\Networks
 */
class DashTestnet extends Dash
{
    /**
     * @var string
     */
    protected $prefixP2pkh = "\x8b";

    /**
     * @var string
     */
    protected $prefixP2sh = "\x13";
}