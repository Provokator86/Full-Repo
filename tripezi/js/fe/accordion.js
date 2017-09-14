$(document).ready(function()
{
 $('.menu-body').css('display','none');
 $(".menu-head").click(function() {
  if( $(this).next("div.menu-body").css("display") == 'none' ) {         
   $("div.menu-body").slideUp("slow");
   $('div.menu-head').removeClass('select');
                  $(this).addClass('select');
   $(this).next("div.menu-body").animate({height : 'toggle'}, 500);   
  }
  else  {
   $("div.menu-body").slideUp("slow");
   $('div.menu-head').removeClass('select');
  }
 });
});