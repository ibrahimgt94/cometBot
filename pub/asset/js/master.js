
$( document ).ready(function() {

   $("#local").change(function(){
      $(".hpes-remote").removeClass("active");
      $(".hpes-upload").removeClass("active");
      $(".hpes-local").addClass("active");
   });

   $("#remote").change(function(){
      $(".hpes-local").addClass("inactive").removeClass("active");
      $(".hpes-upload").removeClass("active");
      $(".hpes-remote").addClass("active");
   });

   $("#upload").change(function(){
      $(".hpes-local").addClass("inactive").removeClass("active");
      $(".hpes-remote").removeClass("active");
      $(".hpes-upload").addClass("active");
   });
});
