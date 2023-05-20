<?php

namespace Comet\Atom\Chest;

use ReflectionMethod;

class Gram
{
   private $config;

   private $app, $curl, $lesa, $cog;

   private $view, $reply;

   private $perfixSpaceView = "comet.view.bot";

   private string $urapi = "https://api.telegram.org";

   private function guard()
   {
      $this->config = $this->cog->get("gram");

      $this->setMode("HTML");
   }

   private function getUriPath(string $token, string $func): string
   {
      return "{$this->urapi}/bot{$token}/{$func}?";
   }

   private function requestUri(string $func, array $params = null)
   {
      return $this->curl->post(
         $this->getUriPath($this->config->token, $func), $params
      )->stream();
   }

   public function getInfo()
   {
      return $this->requestUri("getWebhookInfo");
   }

   public function setWebHook()
   {
      if($this->config->status){
         return $this->requestUri("setWebhook", ["url" => $this->config->hook,
            "max_connections" => $this->config->cons]);
      }
   }

   private function getSpaceView(string $view)
   {
      [$clas, $func] = explode("**", $view);

      $spaceView = str_replace(".", "_", $clas);

      return ["{$this->perfixSpaceView}.{$spaceView}", $func];
   }

   public function view(string $view, array $params = []): self
   {
      [$space, $func] = $this->getSpaceView($view);

      $this->app->sheet($space);

      # $this->app->access($space, "app**comet.atom.chest.app");

      $clasView = $this->app->build($space);

      $reflector = new ReflectionMethod($clasView, $func);

      $this->view = $reflector->invokeArgs($clasView, [$this->convert($params)]);

      return $this;
   }

   public function reply(string $reply): self
   {
      $this->reply = $reply;

      return $this;
   }

   public function sendMesg($chatid = null)
   {
      return $this->requestUri("sendMessage", ["text" => $this->view,
         "chat_id" => (is_null($chatid) ? $this->lesa->chatid : $chatid),
         "reply_markup" => $this->reply, "parse_mode" => $this->mode]);
   }

   public function forwardMesg($fromid, $mesgid)
   {
      return $this->requestUri("forwardMessage", [ "from_chat_id" => $fromid,
         "chat_id" => $this->lesa->chatid , "message_id" => $mesgid]);
   }

   public function sendPhoto($photo)
   {
      return $this->requestUri("sendPhoto", ["reply_markup" => $this->reply,
         "chat_id" => $this->lesa->chatid, "photo" => $photo,
         "caption" => $this->view, "parse_mode" => $this->mode]);
   }

   public function sendAudio($audio, $thumb = null)
   {
      return $this->requestUri("sendAudio", ["reply_markup" => $this->reply,
         "chat_id" => $this->lesa->chatid, "audio" => $audio,
         "caption" => $this->view, "parse_mode" => $this->mode]);
   }

   public function sendDocument($document, $replymesgid = null)
   {
      return $this->requestUri("sendDocument", ["reply_markup" => $this->reply,
         "chat_id" => $this->lesa->chatid, "document" => $document,
         "reply_to_message_id" => $replymesgid]);
   }

   public function sendVideo($video, $duration = null, $replymesgid)
   {
      return $this->requestUri("sendDocument", ["reply_markup" => $this->reply,
         "chat_id" => $this->lesa->chatid, "video" => $video, "caption" => $caption,
         "reply_to_message_id" => $replymesgid, "reply_markup" => $this->reply]);
   }

   public function getProfilePhoto($chatid = null, $offset = null, $limit = null)
   {
      return $this->requestUri("getUserProfilePhotos", ["offset" => $offset,
         "chat_id" => (is_null($chatid) ? $this->lesa->chatid : $chatid),
         "limit" => $limit]);
   }

   public function kick($userid, $date = 1)
   {
      return $this->requestUri("getUserProfilePhotos", ["user_id" => $userid,
         "until_date" => $date, "chat_id" => $this->lesa->chatid]);
   }

   public function getFile($fileid)
   {
      return $this->requestUri("getFile", ["file_id" => $fileid]);
   }

   public function getMember($userid)
   {
      return $this->requestUri("getChatMember", ["user_id" => $userid,
         "chat_id" => $this->lesa->chatid]);
   }

   public function getAdmin()
   {
      return $this->requestUri("getChatAdministrators", ["chat_id" => $this->lesa->chatid]);
   }

   public function getMe()
   {
      return $this->requestUri("getMe", ["chat_id" => $this->lesa->chatid]);
   }

   public function getMemberCount()
   {
      return $this->requestUri("getMembersCount", ["chat_id" => $this->lesa->chatid]);
   }

   public function leave($userid)
   {
      return $this->requestUri("leaveChat", ["chat_id" => $userid]);
   }

   private function setMode(string $mode)
   {
      $this->mode = in_array($mode, ["HTML", "Markdown", "Markdown2"]) ? $mode : "HTML";
   }

   public function editeMesg($chatid, $mesgid, $alert = null, $show = false)
   {
      $edite = $this->requestUri("editMessageText", ["chat_id" => $chatid,
         "message_id" => $mesgid, "text" => $this->view, "reply_markup" => $this->reply,
         "disable_web_page_preview" => true, "parse_mode" => $this->mode]);

      $answer = $this->answer($alert, $show);

      return $this->convert(compact("edite", "answer"));
   }

   public function editeMesgOne($mesgid, $alert = null, $show = false)
   {
      return $this->editeMesg($this->lesa->chatid, $mesgid, $alert, $show);
   }

   public function editeMesgTwo($chatid, $alert = null, $show = false)
   {
      return $this->editeMesg($chatid, $this->lesa->mesgid, $alert, $show);
   }

   private function convert($data, $flag = false)
   {
      return json_decode(json_encode($data), $flag);
   }

   public function deleteMesg($chatid, $mesgid)
   {
      $this->requestUri("deleteMessage", ["message_id" => $mesgid, "chat_id" => $chatid]);
   }

   public function deleteMesgOne($mesgid)
   {
      $this->requestUri("deleteMessage", ["message_id" => $mesgid, "chat_id" => $this->lesa->chatid]);
   }

   public function clasId(int $clasid)
   {
      $this->lesa->clasid = $clasid;

      return $this;
   }

   private function answer($alert = null, $show = false)
   {
      $this->requestUri("deleteMessage", ["show_alert" => $alert,
         "callback_query_id" => $this->lesa->clasid, "text" => $this->view]);
   }
}
