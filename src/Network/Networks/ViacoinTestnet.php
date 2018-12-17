<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Network\Networks;

/**
 * Class ViacoinTestnet
 * @package AndKom\Bitcoin\Address\Network\Networks
 */
class ViacoinTestnet extends Viacoin
{
    /**
     * @var string
     */
    protected $prefixP2pkh = "\x7f";

    /**
     * @var string
     */
    protected $prefixP2sh = "\xc4";

    /**
     * @var string
     */
    protected $prefixBech32 = 'tvia';
}