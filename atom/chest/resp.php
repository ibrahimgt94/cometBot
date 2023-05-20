<?php

namespace Comet\Atom\Chest;

class Resp
{
   private $file;

   public function view(string $path, $data = null)
   {
      $this->file->loader("view.web.{$path};php", $data);
   }

   public function redirect(string $path)
   {
      exit(header("Location: {$path}"));
   }
}
