<?php

namespace Comet\Atom\Chest;

use Exception;

final class File
{
   private $app;

   private $types = ["php", "text", "log", "tem"];

   public function loader(string $path, array $data = null)
   {
      $this->analys($path);

      $this->alphaCase($path);

      $this->exists($path);

      is_null($data) ?: extract($data);

      return require($this->getPath($path));
   }

   public function loaders(string ...$paths)
   {
      array_walk($paths, function($path) use (&$trace){
         $this->analys($path);

         $this->checkType($path);

         $this->exists($path);

         $file = $this->alphaCase($path);

         $trace[$file] = require_once($this->getPath($path));
      });

      return $this->convert($trace);
   }

   private function convert($data)
   {
      return json_decode(json_encode($data));
   }

   private function alphaCase($path)
   {
      [$file] = explode(";", $path);

      return lcfirst(str_replace(".", "", ucwords($file, ".")));
   }

   private function exists(string $path)
   {
      if(! file_exists($getPath = $this->getPath($path))){
         throw new Exception("{$getPath} file vojod nadarad");
      }
   }

   public function existsbool(string $path)
   {
      return file_exists($this->getPath($path));
   }

   public function getPath($path)
   {
      [$file, $type] = explode(";", $path);

      $appPath = str_replace("_", "/", $this->app->getPath());

      $filePath = str_replace(".", "/", $file);

      return "/{$appPath}/{$filePath}.{$type}";
   }

   private function existsDir(string $path)
   {
      if(! is_dir($getPath = $this->getPathDir($path))){
         throw new Exception("{$getPath} poshe vojod nadarad");
      }
   }

   private function getPathDir(string $path)
   {
      $appPath = str_replace("_", "/", $this->app->getPath());

      $basePath = str_replace(".", "/", $path);

      return "/{$appPath}/{$basePath}";
   }

   private function checkType($path)
   {
      [$file, $type] = explode(";", $path);

      if(! in_array($type, $this->types)){
         $types = implode(" ** ", $this->types);
         throw new Exception("{$type} in type mored pazeresh ma nest lotfan yeke az type hae robero ra entchab koned : {{$types}}");
      }
   }

   private function analys($path)
   {
      if(! preg_match("/^(([a-z][\w]+\.?)*[^.];([a-z]{2,4}))$/", $path)){
         throw new Exception("{$path} az en olgo astafade namekonad e.x : {tmp.app.go_ld9.gram;php {2,4}}");
      }
   }

   private function analysDir($path)
   {
      if(! preg_match("/^(([a-z][\w]*\.?)*)[^.]$/", $path)){
         throw new Exception("{$path} az en olgo astafade namekonad e.x : {tmp.app.gold.gram}");
      }
   }

   public function move(string $old, string $new)
   {
      $this->exists($old);

      [$old, $new] = [$this->getPath($old), $this->getPath($new)];

      if(! rename($old, $new)){
         throw new Exception("file {$old} be {$new} taghire nam navaft");
      }

      return true;
   }

   public function delete(string $file)
   {
      $this->exists($file);

      if(! unlink($file = $this->getPath($file))){
         throw new Exception("file {$file} hazf nashod");
      }

      return true;
   }

   public function copy(string $source, string $dest)
   {
      $this->exists($source);

      if(! copy($source = $this->getPath($source), $dest = $this->getPath($dest))){
         throw new Exception("copy file {$source} be {$dest} anjam nashod");
      }

      return true;
   }

   public function scan(string $path)
   {
      $this->analysDir($path);

      $this->existsDir($path);

      $getPath = $this->getPathDir($path);

      if(($files = scandir($getPath)) === false){
         throw new Exception("{$getPath} scan in poshe ba moshkel movajeh shod");
      }

      $files = array_map(function($file) use ($path){
         if($file != "." && $file != ".."){

            $pth = str_replace("_", "/", "{$this->app->getPath()}_{$path}");

            if(filetype("/{$pth}/{$file}") == "dir"){

               $file = str_replace(".", "_", $file);

               return "{$path}.{$file}";
            }

            [$file, $type] = explode(".", $file);

            return "{$path}.{$file};{$type}";
         }
      }, $files);

      return array_values(array_filter($files));
   }

   public function getScanFile(string $path)
   {
      $this->analys($path);

      [$dir, $type] = explode(";", $path);

      $scans = $this->scan($dir);

      $files = array_filter($scans, function($file) use ($type){
         if(strpos($file, ";")){
            [$file2, $type2] = explode(";", $file);

            return ($type2 == $type);
         }
      });

      return array_values(array_filter($files));
   }

   public function size(string $path)
   {
      $this->analys($path);

      $this->exists($path);

      $size = filesize($this->getPath($path));

      $types = [
         "gigabyte" => pow(1024, 3),
         "megabyte" => pow(1024, 2),
         "kilobyte" => 1024,
         "byte" => 1,
      ];

      array_walk($types, function($val, $key) use ($size, &$total){
         if($size == 0){
            $total["empty"] = "empty";
         }else{
            if($size >= $val and $size >= 1){
               $result = number_format(round(($size / $val)));
               $total[$key] = "{$result} {$key}";
            }
         }
      });

      return $this->convert($total);
   }

   public function touche(string $path)
   {
      $this->analys($path);

      return touch($this->getPath($path));
   }

   public function write(string $path, string $data, bool $flag = false)
   {
      $this->analys($path);

      return file_put_contents($this->getPath($path), $data, ((! $flag) ?: FILE_APPEND));
   }

   public function read(string $path)
   {
      $this->analys($path);

      $this->exists($path);

      return file_get_contents($this->getPath($path));
   }
}
