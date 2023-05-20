<?php

namespace Comet\Atom\Route;

use Comet\App\Web\Main;

use Exception;
use ReflectionMethod;

class Web
{
   private $reqs, $resp, $app;

   private $file, $session;

   private $bridges, $algos = [];

   private $cipher, $prefix = "nls";

   private $homePageAction = "home_index";

   public function guard()
   {
      $this->algo("int", "([\d]{1,11}).opt.")
         ->algo("str", "([a-z]{1,20}).opt.")
         ->algo("bigint", "([\d]{1,20}).opt.")
         ->algo("bool", "([0|1]{1}).opt.")
         ->algo("time", "([\d]{1,10}).opt.")
         ->algo("float", "(!\d+(?:\.\d+)?!).opt.");
   }

   public function stream()
   {
      $this->session->init($this->reqs->remote());

      $router = $this->app->build("comet.atom.route.web");

      $this->file->loader("map.web;php", ["router" => $router]);

      $router->handle();
   }

   public function prefix(string $prefix)
   {
      $this->prefix = strtolower($prefix);

      return $this;
   }

   public function any(string $action, string $target)
   {
      return $this->bridge($action, $target, "any");
   }

   public function get(string $action, string $target)
   {
      return $this->bridge($action, $target, "get");
   }

   public function post(string $action, string $target)
   {
      return $this->bridge($action, $target, "post");
   }

   public function put(string $action, string $target)
   {
      return $this->bridge($action, $target, "put");
   }

   public function delete(string $action, string $target)
   {
      return $this->bridge($action, $target, "delete");
   }

   public function default(string $target)
   {
      return $this->bridge("home_index", $target, "get");
   }

   private function getAction(string $action): array
   {
      preg_match("/^([a-z]{2,})\_([a-z]{2,})(?<!\_)/", $action, $action);

      array_shift($action);

      [$pxone, $pxtwo] = $action;

      return compact("pxone", "pxtwo");
   }

   private function getParams(string $action): array
   {
      preg_match_all("/(?!\_)(\{[?a-z]{2,}\})+/", $action, $params);

      $paramopt = array_map(function($param){
         return (stripos($param, "?", 1) !== false) ? "?" : "";
      }, $params[0]);

      $paramtwo = str_replace(["}", "{", "?"], "", array_values($params[0]));

      return array_combine($paramtwo, $paramopt);
   }

   private function getTarget(string $target)
   {
      [$tgone, $tgtwo] = explode(";", $target);

      $tgone = str_replace("_", "", $tgone);

      $tgtwo = strtolower(str_replace("_", "", $tgtwo));

      return compact("tgone", "tgtwo");
   }

   public function bridge(string $action, string $target, string $method)
   {
      $this->pregex("bridge.action", "not match", $action);

      $this->pregex("bridge.target", "not match", $target);

      extract($this->getAction($action));

      $param = $this->getParams($action);

      extract($this->getTarget($target));

      $prefix = $this->prefix;

      $this->cipher = $this->cipher(
         ($prefix == "nls") ? "{$pxone}_{$pxtwo}"
            : "{$prefix}_{$pxone}_{$pxtwo}"
      );

      $this->bridges[$this->cipher] = compact(
         "pxone", "pxtwo", "param", "tgone", "tgtwo", "method", "prefix"
      );

      return $this;
   }

   public function redirect(string $old, string $new, int $code = 200)
   {

   }

   public function where(string $param, string $algo)
   {
      $this->pregex("where.param", "not match", $param);

      $this->pregex("where.algo", "not match", $algo);

      $params = $this->bridges[$this->cipher]["param"];

      if(key_exists($param, $params)){
         $algo = str_replace(".opt.", $params[$param], $this->algos[$algo]);

         $this->bridges[$this->cipher]["algo"][$param] = $algo;
      }

      return $this;
   }

   private function algo(string $alias, string $algo)
   {
      $this->algos[$alias] = $algo;

      return $this;
   }

   public function alias(string $name)
   {
      $this->bridges[$this->cipher]["alias"] = $name;

      return $this;
   }

   private function checkParam($action, $params)
   {
      $patern = array_values($this->bridges[$action]["algo"]);

      return preg_match("/^".implode("\_", $patern)."$/", $params);
   }

   private function getRequesAction()
   {
      $request = (empty($this->reqs->addres()))
         ? $this->homePageAction : $this->reqs->addres();

      $slice = (substr_count($request, "_") + 1);

      $slice = ($slice >= 3) ? "3" : "2";

      $request = explode("_", $request);

      $action = $this->cipher(implode("_", array_slice($request, 0, $slice)));

      $params = implode("_", array_slice($request, $slice));

      return compact("request", "action", "params");
   }

   private function handle()
   {
      extract($this->getRequesAction());

      (key_exists($action, $this->bridges))
         ?: exit($this->view("other.notaction;php"));

      ($this->bridges[$action]["method"] == $this->reqs->method())
         ?: exit($this->view("other.notmethod;php"));

      if(! empty($params)){
         ($this->checkParam($action, $params))
            ?: exit($this->view("other.notparam;php"));
      }

      exit($this->calling($action, array_filter(explode("_", $params))));
   }

   private function calling(string $action, array $params)
   {
      $bridge = $this->convert($this->bridges[$action]);

      $this->app->sheet($space = "comet.app.web.{$bridge->tgone}");

      $class = $this->app->build($space, [$this->reqs, $this->resp]);

      $reflector = new ReflectionMethod($class, $bridge->tgtwo);

      $this->reqs->setParam($params);

      return $reflector->invokeArgs($class, [$this->reqs, $this->resp]);
   }

   private function view(string $view)
   {
      $this->file->loader("view.web.{$view}");
   }

   public function getRouteList()
   {
      return $this->convert($this->bridges);
   }

   public function cipher(string $space)
   {
      $sha1 = sha1("wienf{$space}ofneb");

      $replace = str_replace([0,1,2,3,4,5,6,7,8,9], "", $sha1);

      return substr($replace, 0, 9);
   }

   private function convert($data, $flag = 0)
   {
      return json_decode(json_encode($data), $flag);
   }

   private function pregs(string $alias): string
   {
      $pregs = [
         "bridge.target" => "/^([a-z]{2,}\_?)+(?<![_])\;([a-z]{2,}\_?)+(?<![_])$/",
         "bridge.action" => "/^([a-z]{2,})\_([a-z]{2,}(?<!\_))((?=\_)\_\{[?]?[a-z]{2,}\})*$/",
         "where.param" => "/^([a-z]{2,})$/",
         "where.algo" => "/^(int|bigint|bool|time|str|float)$/",
         "where.count" => "/^([1-9][0-9]{1,2}|[1-9])[,]?([1-9][0-9]{1,2}|[1-9])?$/",
      ];

      return $pregs[$alias];
   }

   protected function pregex(string $olgo, string $mesg, string $data)
   {
      if(! preg_match($this->pregs($olgo), $data)){ throw new Exception("{$data} :: {$mesg}"); }
   }
}
