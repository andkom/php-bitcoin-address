<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address;

use AndKom\Bitcoin\Address\Ecc\Point;
use Mdanter\Ecc\EccFactory;
use Mdanter\Ecc\Primitives\PointInterface;

/**
 * Class Taproot
 * @package AndKom\Bitcoin\Address
 */
class Taproot
{
    /**
     * @param string $pubKey
     * @param string $merkleRoot
     * @throws Exception
     */
    public static function construct(string $pubKey, string $merkleRoot = ''): string
    {
        $generator = EccFactory::getSecgCurves()->generator256k1();
        $adapter = $generator->getAdapter();
        $curve = $generator->getCurve();

        $point = Point::fromPubKey($adapter, $curve, $pubKey)->liftX();

        $x = $adapter->intToString($point->getX());
        $tweak = gmp_init(bin2hex(Utils::taggedHash('TapTweak', $x . $merkleRoot)), 16);

        if ($adapter->cmp($tweak, $generator->getOrder()) > 0) {
            throw new Exception('Invalid tweak.');
        }

        $G = new Point($adapter, $curve, $generator->getX(), $generator->getY());
        $Q = $point->add($G->mul($tweak));
        
        return $adapter->intToString($Q->getX());
    }
}
