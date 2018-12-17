<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Network\Networks;

/**
 * Class Viacoin
 * @package AndKom\Bitcoin\Address\Network\Networks
 */
class Viacoin extends Bitcoin
{
    /**
     * @var string
     */
    protected $prefixP2pkh = "\x47";

    /**
     * @var string
     */
    protected $prefixP2sh = "\x21";

    /**
     * @var string
     */
    protected $prefixBech32 = 'via';
}