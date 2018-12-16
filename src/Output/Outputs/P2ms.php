<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Output\Outputs;

use AndKom\Bitcoin\Address\Exception;
use AndKom\Bitcoin\Address\Network\NetworkInterface;
use AndKom\Bitcoin\Address\Output\AbstractOutput;
use AndKom\Bitcoin\Address\Output\Op;
use AndKom\Bitcoin\Address\Validate;

/**
 * Class P2ms
 * Pay-To-Multisig output.
 * @package AndKom\Bitcoin\Address\Output\Outputs
 */
class P2ms extends AbstractOutput
{
    /**
     * Number of signatures
     * @var int
     */
    protected $m;

    /**
     * Public keys
     * @var string[]
     */
    protected $pubKeys;

    /**
     * P2ms constructor.
     * @param int $m Number of signatures
     * @param array $pubKeys
     * @throws Exception
     */
    public function __construct(int $m, array $pubKeys)
    {
        if ($m < 1 || $m > 16) {
            throw new Exception('Number of signatures must be from 1 to 16.');
        }

        $pubKeysLen = count($pubKeys);

        if ($pubKeysLen < 1 || $pubKeysLen > 16) {
            throw new Exception('Number of pubkeys must be from 1 to 16.');
        }

        if ($m > count($pubKeys)) {
            throw new Exception('Number of signatures must be less or equal to number of pubkeys.');
        }

        $this->m = $m;
        $this->pubKeys = array_map([Validate::class, 'pubKey'], $pubKeys);
    }

    /**
     * @return string
     */
    public function script(): string
    {
        $script = chr(0x50 + $this->m);
        foreach ($this->pubKeys as $pubKey) {
            $script .= chr(strlen($pubKey)) . $pubKey;
        }
        $script .= chr(0x50 + count($this->pubKeys)) . Op::CHECKMULTISIG;
        return $script;
    }

    /**
     * @return string
     */
    public function asm(): string
    {
        $script = $this->m . ' ';
        foreach ($this->pubKeys as $pubKey) {
            $script .= sprintf('PUSHDATA(%d)[%s] ', strlen($pubKey), bin2hex($pubKey));
        }
        $script .= count($this->pubKeys) . ' CHECKMULTISIG';
        return $script;
    }

    /**
     * @param NetworkInterface|null $network
     * @return string
     * @throws Exception
     */
    public function address(NetworkInterface $network = null): string
    {
        throw new Exception('Pay-To-Multisig output cannot have address.');
    }
}