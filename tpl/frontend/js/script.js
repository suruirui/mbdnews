$(function(){
    var i=0;
    var t=setInterval(move,1500);

    function move(){
        i++;
        if(i==3){
            i=0;
        }
        $(".con-ol li").eq(i).addClass("cur").siblings().removeClass("cur");
        $(".con-img1 li").eq(i).fadeIn(300).siblings().fadeOut(300);

    }
});



