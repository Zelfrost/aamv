<?php

namespace AppBundle\Service\PasswordEncoder;

use Symfony\Component\PasswordHasher\Exception\InvalidPasswordException;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

class LegacyPasswordEncoder implements PasswordHasherInterface
{
    public function hash(string $plainPassword, ?string $salt = null): string
    {
        if (strlen($plainPassword) > 4096) {
            throw new InvalidPasswordException();
        }

        return $this->getEncodedPassword($plainPassword);
    }

    public function verify(string $hashedPassword, string $plainPassword, ?string $salt = null): bool
    {
        if (strlen($plainPassword) > 4096) {
            return false;
        }

        $pass2 = $this->getEncodedPassword($plainPassword);

        return hash_equals($hashedPassword, $pass2);
    }

    public function needsRehash(string $hashedPassword): bool
    {
        return false;
    }

    private function getEncodedPassword($raw)
    {
        $nr = 1345345333;
        $add = 7;
        $nr2 = 0x12345671;
        $tmp = null;
        $inlen = strlen($raw);

        for ($i = 0; $i < $inlen; $i++) {
            $byte = substr($raw, $i, 1);

            if ($byte == ' ' || $byte == "\t") {
                continue;
            }

            $tmp = ord($byte);
            $nr ^= ((($nr & 63) + $add) * $tmp) + (($nr << 8) & 0xFFFFFFFF);
            $nr2 += (($nr2 << 8) & 0xFFFFFFFF) ^ $nr;
            $add += $tmp;
        }

        $out_a = $nr & ((1 << 31) - 1);
        $out_b = $nr2 & ((1 << 31) - 1);
        $output = sprintf("%08x%08x", $out_a, $out_b);

        return $output;
    }
}
