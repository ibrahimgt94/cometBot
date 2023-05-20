<?php

require_once("../vendor/autoload.php");

$app = new Comet\Atom\Chest\App(dirname(__DIR__));

$app->sheet("comet.atom.route.api");

$app->build("comet.atom.route.api")->stream();
