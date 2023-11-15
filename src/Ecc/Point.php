<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Ecc;

use AndKom\Bitcoin\Address\Exception;
use AndKom\Bitcoin\Address\Validate;
use Mdanter\Ecc\Math\GmpMathInterface;
use Mdanter\Ecc\Primitives\CurveFpInterface;

/**
 * Class Point
 * @package AndKom\Bitcoin\Address\Ecc
 */
class Point extends \Mdanter\Ecc\Primitives\Point
{
    /**
     * @return $this
     * @throws Exception
     */
    public function liftX(): self
    {
        $adapter = $this->getAdapter();
        $curve = $this->getCurve();

        $x = $this->getX();

        if ($adapter->cmp($x, $curve->getPrime()) > 0) {
            throw new Exception('Invalid point X.');
        }

        $c = $adapter->mod(
            $adapter->add(
                $adapter->pow($x, 3),
                gmp_init(7, 10)
            ),
            $curve->getPrime()
        );

        $y = $adapter->powmod(
            $c,
            $adapter->div(
                $adapter->add(
                    $curve->getPrime(),
                    gmp_init(1, 10)
                ),
                gmp_init(4, 10)
            ),
            $curve->getPrime()
        );

        if ($adapter->cmp(
                $c,
                $adapter->powmod(
                    $y,
                    gmp_init(2, 10),
                    $curve->getPrime()
                )
            ) !== 0) {
            throw new Exception('C is not equal to point Y^2.');
        }

        if ($adapter->cmp(
                $adapter->mod(
                    $y,
                    gmp_init(2, 10)
                ),
                gmp_init(0, 10)
            ) === 0) {
            $point = new Point($adapter, $curve, $x, $y);
        } else {
            $point = new Point($adapter, $curve, $x, $adapter->sub($curve->getPrime(), $y));
        }

        return $point;
    }

    static function fromPubKey(GmpMathInterface $adapter, CurveFpInterface $curve, string $pubKey): self
    {
        $pubKey = Validate::pubKey($pubKey);

        $pubKeyHex = bin2hex($pubKey);
        $prefix = substr($pubKeyHex, 0, 2);

        if ($prefix === '04') {
            $x = gmp_init(substr($pubKeyHex, 2, 64), 16);
            $y = gmp_init(substr($pubKeyHex, 66, 64), 16);
        } else {
            $x = gmp_init(substr($pubKeyHex, 2, 64), 16);
            $y = $curve->recoverYfromX($prefix === '03', $x);
        }

        return new static($adapter, $curve, $x, $y);
    }
}
