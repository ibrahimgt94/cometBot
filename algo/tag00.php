<?php

use Comet\Face\Atom\Angry\Schema;

Schema::destroy("session");

Schema::table("session")
   ->string("uniqid", 9)->charset()
   ->string("name", 9)->charset()
   ->string("data", 60)->charset()
   ->time("life")->default(0)
   ->primary("uniqid", "name")
   ->engine("memory")
->create();
