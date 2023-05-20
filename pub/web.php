<?php

require_once("../vendor/autoload.php");

$app = new Comet\Atom\Chest\App(dirname(__DIR__));

$app->sheet("comet.atom.route.web");

$app->build("comet.atom.route.web")->stream();
