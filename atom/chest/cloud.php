<?php

namespace Comet\Atom\Chest;

use Exception;

final class Cloud
{
   private $config;

   private $file, $cog;

   private array $custom = [];

   private $updateType = false;

   private $jsondata, $stringdata;

   private function guard()
   {
      $this->replace();

      $this->restore();
   }

   private function getUpdate()
   {
      return ($this->updateType) ? file_get_contents("php://input")
         : $this->file->read("log.gram.ups;log");
   }

   private function alias()
   {
      return [
         '/"(message)":/'         => '"mesg":',
         '/"(message_id)":/'      => '"id":',
         '/"(first_name)":/'      => '"fname":',
         '/"(entities)":/'        => '"ents":',
         '/"(language_code)":/'   => '"lang":',
         '/"(is_bot)":/'          => '"bot":',
         '/"(update_id)":/'       => '"ups":',
         '/"(chat_instance)":/'   => '"inst":',
         '/"(last_name)":/'       => '"lname":',
         '/"(callback_query)":/'  => '"cals":',
         '/"(inline_query)":/'    => '"line":',
         '/"(callback_data)":/'   => '"data":',
         '/"(reply_markup)":/'    => '"markup":',
         '/"(inline_keyboard)":/' => '"inline":',
         '/"(mime_type)":/'       => '"mime":',
         '/"(file_id)":/'         => '"fid":',
         '/"(file_size)":/'       => '"fsize":',
         '/"(media_group_id)":/'  => '"media":',
      ];
   }

   private function convert(string $data, bool $flag = false): object
   {
      return json_decode($data, $flag);
   }

   private function replace()
   {
      $alias = $this->alias();

      [$key, $val] = [array_keys($alias), array_values($alias)];

      $this->jsondata = $this->convert(
         preg_replace($key, $val, $this->getUpdate())
      );
   }

   private function restore()
   {
      array_walk($this->jsondata, function($val, $key){
         (is_object($val)) ? $this->related($val, $key) : $this->attach($val, $key);
      });

      return $this->itemPull();
   }

   private function related($val, $key)
   {
      array_walk($val, function($one, $two) use ($key){
         (is_object($one) OR is_array($one))
            ? $this->related($one, "{$key}.{$two}")
            : $this->attach("{$key}.{$two}", $one);
      });
   }

   private function attach(string $key, $val)
   {
      $this->stringdata[$key] = $val;
   }

   private function itemPull()
   {
      return $this->stringdata;
   }

   public function get(string $alias)
   {
      $this->exists($alias);

      return $this->stringdata[$alias];
   }

   public function exists(string $alias)
   {
      if(! key_exists($alias, $this->stringdata)){
         throw new Exception("{$alias} vojod nadarad");
      }
   }

   public function existsTwo(string $alias)
   {
      return (key_exists($alias, $this->stringdata));
   }

   public function match(string $alias, $data): bool
   {
      return ($this->get($alias) == $data);
   }

   public function getJson()
   {
      return $this->jsondata;
   }

   public function getString()
   {
      return json_encode($this->stringdata);
   }
}
