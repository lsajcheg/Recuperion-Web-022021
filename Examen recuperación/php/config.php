<?php

return [
  'db' => [
    'host' => 'db',
    'user' => 'root',
    'pass' => 'MYSQL_ROOT_PASSWORD',
    'name' => 'examen',
    'options' => [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]
  ]
];