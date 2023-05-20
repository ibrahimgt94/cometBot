<?php

namespace Comet\Atom\Route;

use Exception;
use ReflectionMethod;

class Bot
{
   private $app, $lesa, $file;

   private $user, $gram, $cog;

   private $node, $rules, $point, $role;

   private $perfixSpaceNode = "comet.app.bot";

   public function stream()
   {
      $this->gram->setWebHook();

      $this->file->write("log.gram.lesa;log", $this->lesa->string());

      $this->file->loader("map.bot;php");
   }

   public function role(string $role)
   {
      $this->role = $role;

      return $this;
   }

   public function node(string $node): self
   {
      $this->pregex("node", "not mathe node :: app.test", $node);

      $this->node = strtolower($node);

      return $this;
   }

   public function sole(string $rule, string $targ): self
   {
      $this->pregex("sole.rule", "not mathe rule :: app.test?;name:amin,family:amiri", $rule);

      $this->pregex("sole.targ", "not match targ :: appGold", $targ);

      $split = $this->split($rule);

      $this->attach($this->node, $split->rule, $targ, $split->args);

      return $this;
   }

   public function pack(string ...$rules): self
   {
      array_walk($rules, function($rule){
         $split = $this->split($rule);

         $this->attach($this->node, $split->rule, $split->rule, $split->args);
      });

      return $this;
   }

   public function common(string $targ, string ...$rules): self
   {
      array_walk($rules, function($rule) use ($targ){
         $this->sole($rule, $targ);
      });

      return $this;
   }

   public function among(string $rule, string $among, string $targ): self
   {
      $this->pregex("among", "not match e.g 5:8", $among);

      [$minimum, $maximum] = preg_split("/(?:[:])/", $among);

      if($maximum <= $minimum){
         throw new Exception("{$among} :: num2 kochektar ya mosave ast ba num2");
      }

      $ranges = range($minimum, $maximum);

      array_walk($ranges, function($range) use ($rule, $targ){
         $this->sole("{$rule}.num{$range};num:{$range}", $targ);
      });

      return $this;
   }

   public function query(string $mark, string $dbs, string $targ, string $args = null): self
   {
      $this->pregex("query.mark", "not match exp*exp2", $mark);

      $this->pregex("query.dbs", "not match dbs;cell", $dbs);

      [$table, $cell] = preg_split("/(?:[;])/", $dbs);

      if($this->user->match("mark", $mark)){
         $datas = $this->app->build("comet.angry.{$table}")->field($cell)->get($cell);

         array_walk($datas, function($data) use ($cell, $targ, $args){
            $this->attach($this->node, $data, $targ, $args);
         });
      }

      return $this;
   }

   public function bridge(string $bridge)
   {
      $this->pregex("bridge.type", "not match :: glass | base | line", $bridge);

      $this->point = $this->user->getPoint();

      ($this->cheking("cals.id") ? $this->taskGlass()
         : ($this->cheking("line.id") ? $this->taskLine() : $this->taskBaseData($bridge)));
   }

   private function lesaCalsData(): object
   {
      $calsData = $this->lesa->get("cals.data");

      $this->pregex("lesa.cals.data", "not match", $calsData);

      preg_match("/^{([\w]+)}:{([\w\.,:]+)?}$/", $calsData, $calsMatch);

      array_shift($calsMatch);

      [$rule, $args] = $calsMatch;

      return $this->convert(compact("rule", "args"));
   }

   private function hasRule(string $rule): bool
   {
      return (key_exists($rule, $this->rules));
   }

   private function matchRole(): bool
   {
      $admin = $this->cog->get("gram")->admin;

      $role = ($this->lesa->get("cals.from.id") == $admin) ? "admin" : "user";

      return (($this->role == $role) OR ($role == "admin"));
   }

   private function taskGlass()
   {
      $calsData = $this->lesaCalsData();

      if($this->hasRule($calsData->rule) AND $this->matchRole()){
         $this->calling($this->getTarg($calsData->rule),
            $this->getArgs($calsData->args), $this->getEars($calsData->rule));
      }
   }

   private function getRule(string $rule = null): object
   {
      return $this->convert(
         (key_exists($rule, $this->rules) ? $this->rules[$rule] : $this->rules)
      );
   }

   private function getTarg(string $rule): string
   {
      return lcfirst(str_replace(".", "", ucwords($this->getRule($rule)->targ, ".")));
   }

   private function getArgs(string $args = null): array
   {
      $args = (is_null($args) ? [] : explode(",", $args));

      array_walk($args, function($row) use (&$params){
         [$key, $val] = explode(":", $row);

         $params[$key] = $val;
      });

      return (is_null($params) ? [] : $params);
   }

   private function getEars(string $ears): array
   {
      return $this->getArgs($this->rules[$ears]["args"]);
   }

   private function getSpaceNode(): string
   {
      $spaceNode = str_replace(".", "_", $this->node);

      return "{$this->perfixSpaceNode}.{$spaceNode}";
   }

   private function calling(string $func, array $args = [], array $ears = [])
   {
      $this->app->sheet(
         $space = $this->getSpaceNode()
      );

      $this->app->access($space, "app**comet.atom.chest.app", "cog**comet.atom.chest.cog",
         "gram**comet.atom.chest.gram", "lesa**comet.atom.chest.lesa", "rebase**comet.atom.reply.rebase",
         "reglass**comet.atom.reply.reglass", "reline**comet.atom.reply.reline");

      $clasNode = $this->app->build($space);

      $reflector = new ReflectionMethod($clasNode, $func);

      $reflector->invokeArgs($clasNode, [$this->convert(
            array_filter(compact("args", "ears"))
      )]);
   }

   private function taskLine()
   {

   }

   private function taskBase()
   {
      $mesg = explode(" ", $this->lesa->get("mesg.text"));

      $crypt = $this->crypt("{$this->node}.{$mesg}");

      (! $this->hasRule($crypt)) ?: $this->calling(
         $this->getTarg($crypt), $this->getArgs(), $this->getEars($crypt)
      );
   }

   private function taskData()
   {
      (! $this->hasRule($this->point)) ?: $this->calling(
         $this->getTarg($this->point), [], $this->getEars($this->point)
      );
   }

   private function taskBaseData($type)
   {
      ($this->isPointNull() AND ($type == "data"))
         ? $this->taskData() : (($this->cheking("mesg.id") AND ($type == "base"))
            ? $this->taskBase() : null);
   }

   public function command(string $rule, string $targ, string $args = null)
   {
      $this->attach($this->node, $rule, $targ, $args);

      return $this;
   }

   private function cheking(string $task): bool
   {
      $this->pregex("cheking", "not match :: mesg.id | cals.id | line.id", $task);

      return $this->lesa->exists($task);
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

   private function attach(string $node, string $rule, string $targ = null, string $args = null): void
   {
      $this->rules[$this->crypt("{$node}.{$rule}")] = compact("node", "rule", "targ", "args");
   }

   private function isPointNull(): bool
   {
      return ($this->point != "62ac721c9");
   }

   private function crypt(string $alias)
   {
      return substr(sha1("kcymtx{$alias}hvkzqu"), 19, 9);
   }

   private function pregs(string $alias): string
   {
      $pregs = [
         "node" => "/^([a-z]{2,}\.?)*(?![.])[a-z]{2,}$/",
         "sole.rule" => "/^(([a-z0-9]{2,}[.]?)*[^,\W_])([;]([a-z_]{1,}[:][a-z_0-9]*[,]?)*[^,\W_])?$/",
         "sole.targ" => "/^([a-zA-z_]{2,})[^\W\d_]$/",
         "among" => "/^([0-9][0-9]|[1-9])[:]([0-9][0-9]|[1-9])$/",
         "query.mark" => "/^([a-z*0-9]+)$/",
         "query.dbs" => "/^[a-z]{2,9}[;][a-z]{2,9}$/",
         "bridge.type" => "/^(glass|base|line)$/",
         "cheking" => "/^(mesg.id|cals.id|line.id)$/",
         "lesa.cals.data" => "/^{([a-z0-9]{9})}:{(([a-z]+:[a-z0-9_.]+)|(,([a-z]+:[a-z0-9_.]+)))*}$/",
      ];

      return $pregs[$alias];
   }

   private function pregex(string $olgo, string $mesg, string $data)
   {
      if(! preg_match($this->pregs($olgo), $data)){ throw new Exception("{$data} :: {$mesg}"); }
   }

   public function getRuleTwp()
   {
      return $this->rules;
   }
}
