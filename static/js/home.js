// function getQueryVariable(variable)
// {
//     var query = window.location.search.substring(1);
//     var vars = query.split("&");
//     for (var i=0;i<vars.length;i++) {
//         var pair = vars[i].split("=");
//         if(pair[0] == variable){return pair[1];}
//     }
//     return(false);
// }
//
// var index = 0 ;
//
// switch(getQueryVariable("page")){
//     case 'global':
//         index = 1;
//         $(":root").css("--page-posX","-100%");
//         break;
//     case 'users':
//         $(":root").css("--page-posX","-200%");
//         break;
// }

// var pageSwitch = function(){
//     var pageposX = index * (-100);
//     $(":root").css("--page-posX",pageposX+"%");
// }
//
// var Next = {}, data=0;
// Object.defineProperty(Next,'data', {
//     get: function () {
//         return data;
//     },
//     set: function (newValue) {
//         data = newValue;
//         index = data;
//         pageSwitch();
//     }
// });
//
// Next.data = 2;
function load_table(){
    console.log("load table");
    $("#users-table").bootstrapTable({
        pagination: true,   //是否显示分页条
        pageSize: 7,   //一页显示的行数
        paginationLoop: false,   //是否开启分页条无限循环，最后一页时点击下一页是否转到第一页
        pageList: [7],   //选择每页显示多少行，数据过少时可能会没有效果
        search: true,
        showSearchButton: true,
        searchOnEnterKey: true,
        searchAlign: "left"
    });
}
$(document).ready(function(){
    load_table();
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "/api/user" ,
        success: function(data){
            window.users = data;
        }
    })
    $('body').on('click','.btn-add-user', function(){
        str = this.getAttribute('id');
        id = str.substring(9, str.length);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "/api/user" ,
            data: {
                username: $("#username-input-" + id).val(),
                email: $("#email-input-" + id).val()
            },
            success: function(){
                $.ajax({
                    type: "GET",
                    // dataType: "json",
                    url: "/user?encode=html" ,
                    success: function(data){
                        $(".usersbar").html(data);
                        load_table();
                        $.ajax({
                            type: "GET",
                            dataType: "json",
                            url: "/api/user" ,
                            success: function(data){
                                window.users = data;
                            }
                        })
                    }
                })
            },
            error: function(){
                console.log("error");
            }
        })
    });
    $('body').on('click','.btn-reset-token', function(){
        str = this.getAttribute('id');
        id = str.substring(12, str.length);
        uid = $("#uid-" + id).text();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "api/user",
            data:{
                method: "PUT",
                token: 1,
                id: uid
            },
            success: function(){
                $("#notice-" + id).text("操作成功！");
                $("#notice-" + id).css("color", "green");
                $("#notice-" + id).fadeIn();
                setTimeout(function(){
                    $("#notice-" + id).fadeOut();
                    $("#notice-" + id).text("");
                }, 3000)
            },
            error: function(){
                $("#notice-" + id).text("操作失败！");
                $("#notice-" + id).css("color", "red");
                $("#notice-" + id).fadeIn();
                setTimeout(function(){
                    $("#notice-" + id).fadeOut();
                    $("#notice-" + id).text("");
                }, 3000)
            }
        })
    });
    $('body').on('click','.btn-reset-apply', function(){
        str = this.getAttribute('id');
        id = str.substring(6, str.length);
        uid = $("#uid-" + id).text();
        username = $("#username-" + id).val();
        email = $("#email-" + id).val();
        var params = {};
        if(username != users[id].username){
            params["username"] = username;
        }
        if(email != users[id].email){
            params["email"] = email;
        }
        params["id"] = uid;
        params["method"] = 'PUT';
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "api/user",
            data: params,
            success: function(){
                $("#notice-" + id).text("操作成功！");
                $("#notice-" + id).css("color", "green");
                $("#notice-" + id).fadeIn();
                setTimeout(function(){
                    $("#notice-" + id).fadeOut();
                    $("#notice-" + id).text("");
                }, 3000)
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: "/api/user" ,
                    success: function(data){
                        window.users = data;
                    }
                })
            },
            error: function(){
                $("#notice-" + id).text("操作失败！");
                $("#notice-" + id).css("color", "red");
                $("#notice-" + id).fadeIn();
                $("#username-" + id).val(users[id].username);
                $("#email-" + id).val(users[id].email);
                setTimeout(function(){
                    $("#notice-" + id).fadeOut();
                    $("#notice-" + id).text("");
                }, 3000)
            }
        })
    });
    $('body').on('click','.btn-delete', function(){
        str = this.getAttribute('id');
        id = str.substring(7, str.length);
        uid = $("#uid-" + id).text();
        var params = {};
        params["id"] = uid;
        params["method"] = 'DELETE';
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "api/user",
            data: params,
            success: function(){
                $.ajax({
                    type: "GET",
                    // dataType: "json",
                    url: "/user?encode=html" ,
                    success: function(data){
                        $(".usersbar").html(data);
                        load_table();
                    }
                })
            },
            error: function(){
                console.log("error");
            }
        })
    });
});
