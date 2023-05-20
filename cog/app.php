<?php

return [
   "basis" => [
      "comet.atom.chest.curl",
      "comet.atom.chest.gram",
      "comet.atom.chest.cog",
      "comet.atom.chest.file",
      "comet.atom.chest.bash",
      "comet.atom.chest.lesa",
      "comet.atom.chest.reqs",
      "comet.atom.chest.resp",
      "comet.atom.chest.session",
      "comet.atom.chest.view",
      "comet.atom.reply.rebase",
      "comet.atom.reply.reglass",
      "comet.atom.reply.reglass_per",
      "comet.atom.reply.reline",
      "comet.atom.angry.query",
      "comet.algo.user",
      "comet.atom.angry.schema",
   ],
   "share" => [
      "comet.angry.user",
      "comet.angry.session",
      "comet.atom.chest.cloud",
      "comet.atom.angry.mysql",
      "comet.atom.route.web",
      "comet.atom.chest.session",
   ],
   "alias" => [

   ],
   "rule" => [
      "comet.atom.chest.gram" => [
         "app**comet.atom.chest.app",
         "curl**comet.atom.chest.curl",
         "cog**comet.atom.chest.cog",
         "lesa**comet.atom.chest.lesa",
      ],
      "comet.atom.route.bot" => [
         "app**comet.atom.chest.app",
         "gram**comet.atom.chest.gram",
         "lesa**comet.atom.chest.lesa",
         "file**comet.atom.chest.file",
         "cog**comet.atom.chest.cog",
         "user**comet.angry.user",
      ],
      "comet.atom.chest.cloud" => [
         "file**comet.atom.chest.file",
      ],
      "comet.atom.chest.lesa" => [
         "cloud**comet.atom.chest.cloud",
      ],
      "comet.atom.angry.mysql" => [
         "cog**comet.atom.chest.cog",
         "file**comet.atom.chest.file",
      ],
      "comet.atom.angry.schema" => [
         "mysql**comet.atom.angry.mysql",
         "cog**comet.atom.chest.cog",
         "bash**comet.atom.chest.bash",
      ],
      "comet.atom.route.web" => [
         "reqs**comet.atom.chest.reqs",
         "resp**comet.atom.chest.resp",
         "file**comet.atom.chest.file",
         "session**comet.atom.chest.session",
         "app**comet.atom.chest.app",
      ],
      "comet.atom.chest.session" => [
         "dbs**comet.angry.session",
      ],
      "comet.atom.chest.resp" => [
         "file**comet.atom.chest.file",
      ],
      "comet.atom.chest.reqs" => [
         "session**comet.atom.chest.session",
      ]
   ]
];
