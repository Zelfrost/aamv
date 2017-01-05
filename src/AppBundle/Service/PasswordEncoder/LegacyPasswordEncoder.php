<?php

namespace AppBundle\Service\PasswordEncoder;

use Symfony\Component\Security\Core\Encoder\BasePasswordEncoder;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class LegacyPasswordEncoder extends BasePasswordEncoder
{
    public function encodePassword($raw, $salt)
    {
        if ($this->isPasswordTooLong($raw)) {
            throw new BadCredentialsException('Invalid password.');
        }
 
        return $this->getEncodedPassword($raw);
    }

    public function isPasswordValid($encoded, $raw, $salt)
    {
        if ($this->isPasswordTooLong($raw)) {
            return false;
        }

        $pass2 = $this->getEncodedPassword($raw);

        return $this->comparePasswords($encoded, $pass2);
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
