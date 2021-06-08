var slip = document.getElementsByClassName('slipper')[0];
var test = 'ajaxpost';
var index = 0 ;//页面索引
//监听变量值变化，判断是否进入下一步
var Next = {}, data=0;
Object.defineProperty(Next,'data', {
    get: function () {
        return data;
    },
    set: function (newValue) {
        data = newValue;
        index = data;
        pageSwitch();
    }
});
//安装确认滑块
slip.onmousedown=function () {
    document.onmousedown=function (e) {
        let isPressed = true;
        let downX = e.clientX;
        slip.onmousemove = function (e) {
            let moveoffset = e.clientX - downX ;
            if(moveoffset<0){
            }
            else if(isPressed===true&&0!== slip.offsetLeft && moveoffset<150) {
                slip.style.left = moveoffset + 'px';
                if(moveoffset >=147 ){
                    //when installing.......
                    Next.data=1;//切换到第二个页面-数据库配置
                }
            }
            document.onmouseup=function(){
                isPressed = false;
            }
            addEventListener("mouseup", function () {
                slip.style.left = 0 + 'px';
            })
            addEventListener("mouseleave", function () {
                slip.style.left = 0 + 'px';
            })
        }
    }
}
//卡片上下滚动,页面切换
var pageSwitch = function(){
    var pageposY = index * (-100);
    $(":root").css("--page-posY",pageposY+"%");
}
//表单submit
// var Formid ;//表单id
// $('#DB').on('click', function (){
//     console.log(1111);
// })
// MySQlConfig-Page
$($('#DB').click(function() {
    var isRight = 0;//填写错误数
    $('.sqlInput').each(
        function () {
            if ($(this).val() !== '') {
                console.log('Right')//sql填写正确（调试用）
            } else {
                var inputclass ='.'+ $(this).attr("class").substr(22)//获得input输入框类名
                console.log(inputclass)
                $(inputclass).css("border", "1px solid #ff4b4b")
                $(".errorAlert").css("display", "block")//检查提示
                isRight++;
            }
        }
    )
        Formid = "#MySQLForm";//设置提交表单的类名
        if(isRight === 0){
            $(".sqlform").css("border", "1px solid var(--input-border)")
            $(".errorAlert").css("display", "none")//检查提示
            submitSQL();//填写内容正确 提交
        }
})
)

var submitSQL = function() {
    //特殊字符编码formdata
    var formData  = "module=mysql&"+decodeURIComponent($(Formid).serialize().toString())
    console.log(formData)
    $.ajax({
        type: "POST",//方法类型
        dataType: "json",//预期服务器返回的数据类型
        url: "/install" ,//url
        data:formData,
        // data:{
        //     module: "mysql"
        // },
        // contentType: "multipart/form-data; charset=utf-8",
        success: function (result) {
            console.log(result);//打印服务端返回的数据(调试用)
            Next.data = 2;
        },
        error : function(result) {
            // $(".errorAlert").css("display", "block")//检查提示
            $(".errorAlert").fadeIn();
            setTimeout(function(){
                $(".errorAlert").fadeOut();
            }, 3000);
        }
    });
}
//URLConfig-Page
$($('#UR').click(function() {
        var isRight = 0;//填写错误数
        $('.urlInput').each(
            function () {
                if ($(this).val() !== '') {
                    console.log('Right')//url填写正确（调试用）
                } else {
                    var inputclass ='.'+ $(this).attr("class").substr(22)//获得input输入框类名
                    console.log(inputclass)
                    $(inputclass).css("border", "1px solid #ff4b4b")
                    $(".errorAlert").css("display", "block")//检查提示
                    isRight++;
                }
            }
        )
        Formid = "#URLForm";//设置提交表单的类名
        if(isRight === 0){
            $(".urlInput").css("border", "1px solid var(--input-border)")
            $(".errorAlert").css("display", "none")//检查提示
            submitURL();//填写内容正确 提交
        }
    })
)
var submitURL = function() {
    //特殊字符编码formdata
    var formData  = "module=url&"+decodeURIComponent($(Formid).serialize().toString())
    console.log(formData)
    $.ajax({
        type: "POST",//方法类型
        dataType: "json",//预期服务器返回的数据类型
        url: "/install" ,//url
        data:formData,
        // contentType: "multipart/form-data; charset=utf-8",
        success: function (result) {
            console.log(result);//打印服务端返回的数据(调试用)
            Next.data = 3;
        },
        error : function() {
            $(".errorAlert").fadeIn();
            setTimeout(function(){
                $(".errorAlert").fadeOut();
            }, 3000);
        }
    });
}
//SMTPConfig-Page
$($('#SMTP').click(function() {
        var isRight = 0;//填写错误数
        $('.smtpInput').each(
            function () {
                if ($(this).val() !== '') {
                    console.log('Right')//url填写正确（调试用）
                } else {
                    var inputclass ='.'+ $(this).attr("class").substr(23)//获得input输入框类名
                    console.log(inputclass)
                    $(inputclass).css("border", "1px solid #ff4b4b")
                    $(".errorAlert").css("display", "block")//检查提示
                    isRight++;
                }
            }
        )
        Formid = "#SMTPForm";//设置提交表单的类名
        if(isRight === 0){
            $(".smtpInput").css("border", "1px solid var(--input-border)")
            $(".errorAlert").css("display", "none")//检查提示
            submitSMTP();//填写内容正确 提交
        }
    })
)
var submitSMTP = function() {
    //特殊字符编码formdata
    var formData  = "module=smtp_verification&"+decodeURIComponent($(Formid).serialize().toString())
    console.log(Formid)
    console.log($(Formid).serialize())
    $.ajax({
        type: "POST",//方法类型
        dataType: "json",//预期服务器返回的数据类型
        url: "/install" ,//url
        data:formData,
        // contentType: "multipart/form-data; charset=utf-8",
        success: function (result) {
            $(".Verify").show();
        },
        error : function() {
           // 邮箱验证
            $(".errorAlert").fadeIn();
            setTimeout(function(){
                $(".errorAlert").fadeOut();
            }, 3000);
			
        }
    });
}
//验证邮箱
//控制键盘仅输入数字
var keyPress =function(){    
     var keyCode = event.keyCode;    
     if ((keyCode >= 48 && keyCode <= 57))    
    {    
         event.returnValue = true;    
     } else {    
           event.returnValue = false;    
    }    
 } 
 //重新发送按钮
$('.btn-resend').click(function(){
    $('.btn-resend').attr('disabled', 'true');
    $('.btn-resend').css('background-color', '#e6fbf5');
    $('.btn-resend').css('color', '#3c554e');
    submitSMTP();
	var	count = 61;
	var tiktok = setInterval(function(){
        count --;
        $('.btn-resend').html(count);
        if(count === 0){
            clearInterval(tiktok);
            count = 61;
            $('.btn-resend').removeAttr('disabled');
            $('.btn-resend').html('重新发送');
            $('.btn-resend').css('background-color', '#05B9A4');
            $('.btn-resend').css('color', 'white');
        }
	},1000/1)
})
//验证码发送请求
$("#verify").on('click', function(){
    $("#verify").attr('disabled', 'true');
    $.ajax({
        type: "POST",
        dataType: "json",//预期服务器返回的数据类型
        url: "/install" ,//url
        data: {
            module: "smtp_confirm",
            verification_code: $(".Verifycode").val()
        },
        success: function(){
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "/user/admin",
                success: function(){
                    Next.data = 4;
                    $("#verify").removeAttr('disabled');
                }
            })
        },
        error: function(){
            $(".Verifycode").css('color', '#fa7298');
            $(".Verifycode").val("ERROR");
            setTimeout(function(){
                $(".Verifycode").val("");
            }, 300);
            setTimeout(function(){
                $(".Verifycode").val("ERROR");
            }, 600);
            setTimeout(function(){
                $(".Verifycode").val("");
            }, 900);
            setTimeout(function(){
                $(".Verifycode").val("ERROR");
            }, 1200);
            setTimeout(function(){
                $(".Verifycode").val("");
                $(".Verifycode").css('color', '#495057');
            }, 1500);
            $("#verify").removeAttr('disabled');
        }
    })
})