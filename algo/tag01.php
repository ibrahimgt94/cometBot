<?php

use Comet\Face\Atom\Angry\Schema;

Schema::table("user")
   ->integer("id")->increment()->unsigned()
   ->string("name", 20)->default("amin")->nullable()->charset()
   ->primary("id")
   ->engine("innodb")
->create();
