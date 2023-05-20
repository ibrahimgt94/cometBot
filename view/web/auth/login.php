<!DOCTYPE html>
<html lang="en" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title> login </title>
      <base href="http://comet.paranoftp.ir">
      <link rel="stylesheet" href="asset/css/master.css">
      <link rel="stylesheet" href="/asset/icon/css/all.css">
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script src="asset/js/auth.js"></script>
   </head>
   <body>
      <section class="main">
         <section class="content mclogin">
            <div class="row">
               <div class="co12">
                  <div class="wrap">
                     <span class="icon fas fa-meteor"></span>
                     <span class="label"> login page <span id="note"></span></span>
                  </div>
               </div>
               <div class="co12">
                  <div class="row pt10 pl10 pb10">
                     <div class="co10">
                        <div class="box">
                           <span class="icon fas fa-paw"></span>
                           <input type="text" id="user" class="inps" placeholder="username">
                           <input type="hidden" id="token" value="<?=$token;?>">
                        </div>
                     </div>
                  </div>
                  <div class="row pt10 pl10 pb10">
                     <div class="co10">
                        <div class="box">
                           <span class="icon fas fa-paw"></span>
                           <input type="text" id="pass" class="inps" placeholder="password">
                        </div>
                     </div>
                  </div>
                  <div class="row pt10 pl10 pb10">
                     <div class="co3">
                        <button class="btn btn-green" id="butn"> Login </button>
                     </div>
                  </div>
               </div>
            </div>
         </section>
      </section>
   </body>
</html>
