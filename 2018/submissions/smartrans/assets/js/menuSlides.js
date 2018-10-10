$(".createToken").on("click",function() {
  $(".holder2").css("display","none");
  $(".holder").animate({width:'toggle'},300).delay(300);
})
$(".viewer").on("click",function() {
  $(".holder").css("display","none");
  $(".holder2").animate({width:'toggle'},500).delay(500);
})
$(".div-bar").on("click",function() {
  $(".holder").animate({width:'toggle'},500).delay(500);
  $(".holder2").animate({width:'toggle'},500).delay(500);
});
