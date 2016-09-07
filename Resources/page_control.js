var duringTransition = false;
var errorOn = false;
var annotationOn = false;

$(window).load(function(){
  setPage("block-login.php");
});

function setPage(path){
  if(!duringTransition){
    duringTransition = true;
    $("#Page").animate({
      opacity:0,
    },400,function(){
      $("#Page").html("");
      $("#Page").load(path);
      $("#Page").animate({
        opacity:1,
      },400,function(){
        duringTransition = false;

      });
    });
  }
}

function loadErrorBox(msg){
  if(!errorOn){
    errorOn = true;
    $('.underBox').load("block-errorbox.php",function(){
      $('.underBox .text').html(msg);
      $(".underBox").animate({
        opacity:1,
      },300,function(){
        setTimeout(function(){
          $(".underBox").animate({
            opacity:0,
          },300,function(){
            $('.underBox').html("");
            errorOn = false;
          });
        },3000);
      });
    });
  }
}

function loadAnnotationBox(msg){
  if(!annotationOn){
    $('#Page').load("block-annotation.php",function(){
      $('#AnnotationBox .text').html(msg);
      $("#AnnotationBox").animate({
        opacity:1,
      },500,function(){
        setTimeout(function(){
          $("#AnnotationBox").animate({
            opacity:0,
          },500,function(){
            $('#AnnotationBox').remove();
            annotationOn = false;
          });
        },3000);
      });
    });
  }
}
