<?php

class Hasher
{
  public static function Verify(string $password, string $hashAndSalt): bool
  {
      $parts = explode('-', $hashAndSalt);
      $hash = hex2bin($parts[0]);
      $salt = hex2bin($parts[1]);
      $computedHash = hash_pbkdf2("sha512", $password, $salt, 300000, 32, true);

      return hash_equals($hash, $computedHash);
  }
}