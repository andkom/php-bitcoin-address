<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Network\Networks;

/**
 * Class Bitcoin
 * @package AndKom\Bitcoin\Address\Network\Networks
 */
class Bitcoin extends BitcoinAbstract
{
    /**
     * @var bool
     */
    protected $hasSegwit = true;

    /**
     * @var bool
     */
    protected $hasTaproot = true;
}
