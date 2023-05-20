<?php

namespace Comet\Atom\Chest;

use Exception;
use ReflectionClass;
use ReflectionObject;
use ReflectionMethod;

class App
{
   private $path;

   private static $proxy;

   private array $samples = [],  $rules = [];

   private array $sheets = [], $aliases = [];

   public function __construct(string $path)
   {
      $this->setPath($path);

      $this->alpha();

      $this->loader($this->convert(
         $this->build("comet.atom.chest.cog")->get("app"), true)
      );
   }

   private function setPath(string $path)
   {
      $this->path = ltrim(str_replace("/", "_", $path), "_");
   }

   public function getPath()
   {
      return $this->path;
   }

   private function alpha()
   {
      $this->setProxy();

      $this->sample("comet.atom.chest.app", $this);

      $this->access("comet.atom.chest.cog", "file**comet.atom.chest.file");

      $this->sole("comet.atom.chest.cog");

      $this->access("comet.atom.chest.file", "app**comet.atom.chest.app");

      $this->sole("comet.atom.chest.file");
   }

   private function setProxy()
   {
      self::$proxy = $this;
   }

   public static function getProxy()
   {
      return self::$proxy;
   }

   private function loader(array $servs)
   {
      extract($servs);

      $this->regsCog($basis);

      $this->regsCog($share, true);

      $this->regsAlias($alias);

      $this->regsRule($rule);
   }

   private function regsCog(array $cogs, $share = false)
   {
      array_walk($cogs, function($row) use ($share){
         $alias = explode(".", $this->convertString($row));
         $alias = end($alias);
         $this->alias("als.{$alias}", $row);

         $this->sheet($row, null, $share);
      });
   }

   private function regsAlias(array $alias)
   {
      array_walk($alias, function($alias, $name){
         $this->alias($name, $alias);
      });
   }

   private function regsRule(array $rules)
   {
      array_walk($rules, function($rule, $object){
         array_walk($rule, function($alias) use ($object){
            $this->access($object, $alias);
         });
      });
   }

   private function shortName($clas)
   {
      return strtolower(
         (new ReflectionClass($this->convertSpace($clas)))->getShortName()
      );
   }

   private function shortNameShift($row)
   {
      $convert = explode(".", $this->convertString($row));

      array_shift($convert);

      return implode(".", $convert);
   }

   public function build(string $build): object
   {
      return $this->resolve($build);
   }

   public function builds(string ...$builds): array
   {
      return array_map(function($row){
         return $this->build($row);
      }, $builds);
   }

   public function access(string $obj, string ...$data)
   {
      $this->checkOlgo($obj);

      array_walk($data, function($alias) use ($obj){
         if(! preg_match("/^(([a-z][a-z_0-9]+)[*]{2}([a-z][a-z_0-9]+\.?)*)[^\W]$/", $alias)){
            throw new Exception("dastrese bayad az en olgo payrave konad e.x: app**comet.atom.chest.app");
         }

         [$key, $val] = explode("**", $alias);

         $this->rules[$obj][$key] = $val;
      });
   }

   public function sheet(string $sheet, $rock = null, $share = false)
   {
      $this->checkOlgo($sheet);

      $rock = $this->convertSpace(
         (is_null($rock) ? $sheet : $rock)
      );

      $this->sheets[$this->convertString($sheet)] = compact("rock", "share");
   }

   private function hasSheet(string $sheet): bool
   {
      return (key_exists($sheet, $this->sheets));
   }

   private function getSheet(string $sheet)
   {
      return (! $this->hasSheet($sheet) ?: $this->convert($this->sheets[$sheet]));
   }

   private function convert($sheet, $flag = false)
   {
      return json_decode(json_encode($sheet), $flag);
   }

   public function sole(string $sheet, $rock = null)
   {
      $this->checkOlgo($sheet);

      $this->sheet($sheet, $rock, true);
   }

   public function alias(string $alias, string $sheet)
   {
      $this->checkOlgo($alias);

      if($alias == $sheet){ throw new Exception("{$sheet} ba name mostar chod yake ast"); }

      $this->aliases[$alias] = $sheet;
   }

   private function getAlias(string $sheet): string
   {
      return (key_exists($sheet, $this->aliases) ? $this->aliases[$sheet] : $sheet);
   }

   private function checkOlgo($sheet)
   {
      if(! preg_match("/^(([a-z][a-z_0-9_]+\.?)*)[^\WA-Z]$/", $sheet)){
         throw new Exception("{$sheet} bayad az aedad, horof englise, anderline, astfade koend va shoroe kalame bayad do harf beshtar bashad e.x app.gold.test");
      }
   }

   public function sample(string $sheet, object $rock)
   {
      $this->checkOlgo($sheet);

      $this->samples[$sheet] = $rock;
   }

   private function attachSample(string $sheet, string $rock)
   {
      $this->sample($sheet, $this->cover($rock));
   }

   private function hasSample(string $sheet): bool
   {
      return (key_exists($sheet, $this->samples));
   }

   private function getSample(string $sheet): object
   {
      if(! $this->hasSample($sheet)){ throw new Exception("{$sheet} dar sampel vojod nadarad"); }

      return $this->samples[$sheet];
   }

   private function convertSpace(string $path): string
   {
      $asset = array_map(function($row){
         return (strpos($row, "_") != 0) ? str_replace("_", "", ucwords($row, "_"))
            : ((strpos($row, "_") === false) ? ucwords($row) : strtoupper(str_replace("_", "", $row)));
      }, explode(".", $path));

      return str_replace(".", "\\", implode(".", $asset));
   }

   private function convertString(string $path): string
   {
      $asset = array_map(function($row){
         return strtolower((ctype_upper($row)) ? "_{$row}"
            : ltrim(implode("_", preg_split("/(?=[A-Z])/", $row)), "_"));
      }, explode("\\", $path));

      return implode(".", $asset);
   }

   private function cover(string $sheet)
   {
      $sheet = $this->convertSpace($sheet);

      $cloud = (new ReflectionClass($sheet))->newInstanceWithoutConstructor();

      $this->checkRuleProprty($cloud, $sheet);

      $this->invokeStorm($cloud, $sheet);

      return $cloud;
   }

   private function checkRuleProprty($cloud, $sheet)
   {
      $sheetString = $this->convertString($sheet);

      array_walk($this->rules, function($val, $key) use ($cloud, $sheetString){
         if($key == $sheetString){
            array_walk($val, function($clas, $alias) use ($cloud){
               (! (new ReflectionObject($cloud))->hasProperty($alias))
                  ?: $this->stream($cloud, $alias, $this->convertSpace($clas));
            });
         }
      });
   }

   private function invokeStorm($cloud, $sheet)
   {
      if((new ReflectionClass($cloud))->hasMethod("guard")){
         $params = (new ReflectionClass($sheet))
            ->getMethod("guard")->getParameters();

         $getDeps = array_map(function($deps){
            return $this->build("als.{$deps->getName()}");
         }, $params);

         $guard = new ReflectionMethod($cloud, "guard");

         $guard->setAccessible(true);

         $guard->invokeArgs($cloud, array_filter($getDeps));
      }
   }

   private function stream($cloud, $sheet, $clas)
   {
      $property = (new ReflectionObject($cloud))->getProperty($sheet);

      $property->setAccessible(true);

      $property->setValue($cloud, $this->build($clas));

      return $cloud;
   }

   private function resolve($sheet)
   {
      $sheet = $this->convertString(
         $this->getAlias($sheet)
      );

      if(! $this->hasSample($sheet)){

         if(! $this->hasSheet($sheet)){
            throw new Exception("{$sheet} dar sheets vojod nadarad");
         }

         if(! $this->getSheet($sheet)->share){
            return $this->cover($sheet);
         }

         $this->attachSample($sheet, $this->getSheet($sheet)->rock);
      }

      return $this->getSample($sheet);
   }
}
