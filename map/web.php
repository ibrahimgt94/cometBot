<?php

$router->default("home;index");

$router->get("auth_login_{id}_{name}", "auth;login");

$router->get("auth_logout", "auth;logout");

$router->post("auth_lgproc", "auth;login_proc");

$router->prefix("panel")
   ->get("youtube_index", "youtube;index")
   ->get("convert_manoto", "convert;manoto")
   ->get("convert_watermark", "convert;watermark")
   ->get("convert_format", "convert;format")
   ->get("convert_screenshot", "convert;screenshot")
   ->get("convert_delete", "convert;delete")
   ->get("convert_audio", "convert;audio")
   ->get("convert_quality", "convert;quality")
   ->get("dashbord_index", "dashbord;index")
   ->get("config_index", "config;index")
   ->get("aparat_index", "aparat;index")
   ->get("telegram_index", "telegram;index")
   ->get("upload_index", "upload;index")
   ->get("instagram_index", "instagram;index");
