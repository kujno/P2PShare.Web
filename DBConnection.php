<?php

class DBConnection
{
  public $PDO;

  public function __construct()
  {
    $this->PDO = new PDO("mysql:host=localhost;dbname=p2psharedb;charset=utf8mb4", "P2PShareServer", 'Pa$$w0rd', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
  }
}