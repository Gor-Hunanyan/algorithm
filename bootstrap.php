<?php


require 'vendor/autoload.php';
require 'routes.php';

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$config = Setup::createAnnotationMetadataConfiguration([__DIR__ . '/src/Entity'], false, null, null, false);
$entityManager = EntityManager::create(['url' => 'mysql://root:123456789@127.0.0.1/algorithm'], $config);
