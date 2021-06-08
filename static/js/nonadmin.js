$(document).ready(function(){
    window.current_user = {};
    $.ajax({
        type: 'GET',
        url: 'api/user',
        success: function(data){
            current_user = data;
        }
    });
    $('body').on('click','#nonadmin-reset-token', function(){
        $.ajax({
            type: 'POST',
            url: 'api/user',
            data: {
                method: 'PUT',
                token: 1
            },
            success: function(){
                $(".nonadmin-account-notice").text("操作成功!请前往邮箱点击新的令牌链接登陆。");
                $(".nonadmin-account-notice").css("color", "green");
                $(".nonadmin-account-notice").fadeIn();
                setTimeout(function(){
                    $(".nonadmin-account-notice").fadeOut();
                    $(".nonadmin-account-notice").text("");
                }, 3000);
            },
            error: function(){
                $(".nonadmin-account-notice").text("操作失败!");
                $(".nonadmin-account-notice").css("color", "red");
                $(".nonadmin-account-notice").fadeIn();
                setTimeout(function(){
                    $(".nonadmin-account-notice").fadeOut();
                    $(".nonadmin-account-notice").text("");
                }, 3000);
            }
        });
    });
    $('body').on('click','#nonadmin-apply', function(){
        var apply_data = {};
        var flag = false;
        new_username = $("#nondamin-input-username").val();
        new_email = $("#nondamin-input-email").val();
        if(new_username != current_user.username){
            apply_data['username'] = new_username;
        }
        if(new_email != current_user.email){
            flag = true;
            apply_data['email'] = new_email;
        }
        apply_data['method'] = 'PUT';
        $.ajax({
            type: 'POST',
            url: 'api/user',
            data: apply_data,
            success: function(){
                if(flag){
                    $(".nonadmin-account-notice").text("操作成功!请点击发送到新邮箱的令牌链接重新登录。");
                }
                else{
                    $(".nonadmin-account-notice").text("操作成功!");
                }
                $(".nonadmin-account-notice").css("color", "green");
                $(".nonadmin-account-notice").fadeIn();
                setTimeout(function(){
                    $(".nonadmin-account-notice").fadeOut();
                    $(".nonadmin-account-notice").text("");
                }, 3000);
            },
            error: function(){
                flag = false;
                $("#nondamin-input-username").val(current_user.username);
                $("#nondamin-input-email").val(current_user.email);
                $(".nonadmin-account-notice").text("操作失败!");
                $(".nonadmin-account-notice").css("color", "red");
                $(".nonadmin-account-notice").fadeIn();
                setTimeout(function(){
                    $(".nonadmin-account-notice").fadeOut();
                    $(".nonadmin-account-notice").text("");
                }, 3000);
            }
        });
    });
    $('body').on('click','#nonadmin-logout', function(){
        $.ajax({
            type: 'GET',
            url: 'api/user/logout',
            success: function(){
                $(".nonadmin-account-notice").text("登录状态已解除，您可以关闭本页面。");
                $(".nonadmin-account-notice").css("color", "green");
                $(".nonadmin-account-notice").fadeIn();
                setTimeout(function(){
                    $(".nonadmin-account-notice").fadeOut();
                    $(".nonadmin-account-notice").text("");
                }, 3000);
            },
            error: function(){
                $(".nonadmin-account-notice").text("操作失败!");
                $(".nonadmin-account-notice").css("color", "red");
                $(".nonadmin-account-notice").fadeIn();
                setTimeout(function(){
                    $(".nonadmin-account-notice").fadeOut();
                    $(".nonadmin-account-notice").text("");
                }, 3000);
            }
        });
    });
});