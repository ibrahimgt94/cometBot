<?php

namespace Comet\Atom\Reply;

use Exception;

abstract class ReglassPer
{
   private $node;

   private $bridges = [];

   private $transSheet = ["15761cb67" => "welcome"];

   private $transAddress = [
      "payment" => ["text" => "pay ment", "url" => "http://nioh.ir/{id}/{name}/{gold}"],
   ];

   public function node(string $node): self
   {
      $this->pregex("node", "not match", $node);

      $this->node = strtolower($node);

      return $this;
   }

   public function sheet(string ...$sheets): self
   {
      $sheets = array_map(function($sheet){
         $this->pregex("sheet", "not match", $sheet);

         return $this->translate(
            $this->split($sheet)
         );

      }, array_filter($sheets));

      array_push($this->bridges, $sheets);

      return $this;
   }

   private function translate(object $sheet)
   {
      $alias = $this->crypt("{$this->node}.{$sheet->rule}");

      return (key_exists($alias, $this->transSheet))
         ? $this->buildSheet($this->transSheet[$alias], $alias, $sheet->args)
         : $this->buildSheet($alias, $alias, $sheet->args);
   }

   private function buildSheet($trans, $rule, $args = null)
   {
      return ["text" => $trans, "callback_data" => "{{$rule}}:{{$args}}"];
   }

   public function address(string ...$addresses): self
   {
      $addresses = array_map(function($address){
         $this->pregex("address", "not match", $address);

         $splite = $this->split($address);

         if(! is_null($splite->args)){

            $params = $this->replaceArgs($splite->args);

            $paths = $this->transAddress[$splite->rule];

            $addr = str_replace(array_keys($params), array_values($params), $paths["url"]);

            return ["text" => $paths["text"], "url" => $addr];
         }

         $paths = $this->transAddress[$splite->rule];

         return ["text" => $paths["text"], "url" => $paths["url"]];

      }, array_filter($addresses));

      array_push($this->bridges, $addresses);

      return $this;
   }

   private function replaceArgs($args)
   {
      $args = preg_replace("/([a-z]+(?=[:]))/", '{$1}', $args);

      preg_match_all("/(?<key>[a-z}{]+)[:](?<val>[a-z]+)[,]?/", $args, $matchs);

      return array_combine($matchs["key"], $matchs["val"]);
   }

   private function split(string $rule): object
   {
      [$rule, $args] = array_pad(preg_split("/(?:[;])/", $rule), 2, null);

      return $this->convert(compact("rule", "args"));
   }

   private function convert(array $data): object
   {
      return json_decode(json_encode($data));
   }

   public function get()
   {
      return json_encode(["inline_keyboard" => $this->bridges]);
   }

   private function crypt(string $alias)
   {
      return substr(sha1("kcymtx{$alias}hvkzqu"), 19, 9);
   }

   private function pregs(string $alias): string
   {
      $pregs = [
         "node" => "/^([a-z]{2,}\.?)*(?![.])[a-z]{2,}$/",
         "sheet" => "/^(([a-z0-9]{2,}[.]?)*[^,\W_])([;]([a-z_]{1,}[:][a-z_0-9]*[,]?)*[^,\W_])?$/",
         "address" => "/^(([a-z0-9]{2,}[.]?)*[^,\W_])([;]([a-z_]{1,}[:][a-z_0-9]*[,]?)*[^,\W_])?$/",
      ];

      return $pregs[$alias];
   }

   protected function pregex(string $olgo, string $mesg, string $data)
   {
      if(! preg_match($this->pregs($olgo), $data)){ throw new Exception("{$data} :: {$mesg}"); }
   }
}
