<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title> panel </title>
    <base href="http://comet.paranoftp.ir">
    <link rel="stylesheet" href="/asset/css/master.css">
    <link rel="stylesheet" href="/asset/icon/css/all.css">
  </head>
  <body>
    <section class="main">
      <?php
          require_once(__DIR__."/../layer/mone.php");
          require_once(__DIR__."/../layer/mtwo.php");
      ?>
      <section class="content">
        <div class="row">
         <div class="co12">
            <div class="wrap">
               <span class="icon fas fa-meteor"></span>
               <span class="label"> Manage Files </span>
            </div>
         </div>
         <div class="co12">
            <div class="row pt10 pl10 pb10">
               <div class="co12">
                  <div class="group">
                  <section class="check">
                     <input type="radio" class="radio" name="file-name" id="file-name-01" checked>
                     <label for="file-name-01"><span class="fas fa-fire"></span> barareh_nights_56 </label>
                  </section>
                  <section class="check">
                     <input type="radio" class="radio" name="file-name" id="file-name-02">
                     <label for="file-name-02"><span class="fas fa-fire"></span> barareh_nights_50 </label>
                  </section>
                  <section class="check">
                     <input type="radio" class="radio" name="file-name" id="file-name-03">
                     <label for="file-name-03"><span class="fas fa-fire"></span> barareh_nights_16 </label>
                  </section>
                  <section class="check">
                     <input type="radio" class="radio" name="file-name" id="file-name-04">
                     <label for="file-name-04"><span class="fas fa-fire"></span> barareh_nights_16 </label>
                  </section>
                  </div>
               </div>
            </div>
         </div>
         <div class="co9">
            <div class="row pt10 pl10 pb10">
               <div class="co7">
                 <div class="group">
                    <section class="check">
                       <input type="radio" class="radio" name="move" id="local" checked>
                       <label for="local"><span class="fas fa-fire"></span> local </label>
                    </section>
                    <section class="check">
                       <input type="radio" class="radio" name="move" id="remote">
                       <label for="remote"><span class="fas fa-fire"></span> remote </label>
                    </section>
                    <section class="check">
                       <input type="radio" class="radio" name="move" id="upload">
                       <label for="upload"><span class="fas fa-fire"></span> upload </label>
                    </section>
                 </div>
             </div>
            </div>
            <div class="row pt10 pl10 pb10">
               <div class="co12">
                  <div class="row pt10 pl10 pb10 hpes-local">
                     <div class="co12">
                        <div class="group">
                          <section class="check">
                             <input type="radio" class="radio" name="efefef" id="format-mp4s">
                             <label for="format-mp4s"><span class="fas fa-fire"></span> barareh_audio_50 </label>
                          </section>
                          <section class="check">
                             <input type="radio" class="radio" name="efefef" id="format-mkvs">
                             <label for="format-mkvs"><span class="fas fa-fire"></span> barareh_audio_10 </label>
                          </section>
                       </div>
                     </div>
                  </div>
                  <div class="row pt10 pl10 pb10 hpes-remote inactive">
                     <div class="co8">
                       <div class="box">
                        <span class="icon fas fa-paw"></span>
                        <input type="text" name="audio" class="inps" placeholder="remote audio file">
                       </div>
                     </div>
                  </div>
                  <div class="row pt10 pl10 pb10 hpes-upload inactive">
                     <div class="co8">
                        <div class="ups">
                           <input type="file" name="" value="" id="file-ups">
                           <label for="file-ups">
                              <span class="fab fa-google-wallet" aria-hidden="true"></span> Upload Audio File
                           </label>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="row pt10 pl10 pb10">
               <div class="co7">
                 <div class="group">
                    <section class="check">
                       <input type="radio" class="radio" name="help" id="format-mp4" checked>
                       <label for="format-mp4"><span class="fas fa-fire"></span> format mp4 </label>
                    </section>
                    <section class="check">
                       <input type="radio" class="radio" name="help" id="format-mkv">
                       <label for="format-mkv"><span class="fas fa-fire"></span> format mkv </label>
                    </section>
                    <section class="check">
                       <input type="radio" class="radio" name="help" id="format-mp3">
                       <label for="format-mp3"><span class="fas fa-fire"></span> format mp3 </label>
                    </section>
                 </div>
             </div>
            </div>
            <div class="row pt10 pl10 pb10">
               <div class="co8">
                  <div class="box">
                     <span class="icon fas fa-anchor"></span>
                     <input type="text" name="uri" class="inps" placeholder="download link" value="" disabled>
                     <span class="icon icreq fas fa-copy" id="youtubedl"></span>
                  </div>
             </div>
             <div class="co4">
                 <div class="info" id="bwd">
                    <label for="bwd">
                       <span class="fas fas fa-bell" aria-hidden="true"></span> File Size 1024 MB
                    </label>
                 </div>
             </div>
            </div>
            <div class="row pt10 pl10">
               <button class="btn btn-green"> Convert </button>
            </div>
         </div>
        </div>
      </section>
    </section>
  </body>
</html>
