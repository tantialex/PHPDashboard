var duringTransition = false;
$(window).load(function(){
  setPage("block-login.php");
});

function setPage(path){
  console.log(duringTransition);
  if(!duringTransition){
    duringTransition = true;
    $("#Page").animate({
      opacity:0,
    },500,function(){
      $("#Page").html("");
      $("#Page").load(path);
      $("#Page").animate({
        opacity:1,
      },500,function(){
        duringTransition = false;  
      });
    });
  }

}
