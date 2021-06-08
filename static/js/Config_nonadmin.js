var index = 0 ;//页面索引
var code_type = 'js';//代码类型
$($(".pagebtn").click(function(){
        index = $(".pagebtn").index($(this))  ;//获取当前点击按钮索引
        pageSwitch();
    })
)
//切换对应页面
var pageSwitch = function(){
    $(".pagebtn0").css("color","#454747");
    $(".pagebtn2").css("color","#454747");
    $(".pagebtn1").css("color","#454747");
    var newPosX = 367 +index*100;
    $(".pagebtn"+index).css("color","#00DDA3");
    $(".underline").css("left",newPosX);
    //页面切换
    var pageposX = index * (-100);
    $(":root").css("--page-posX",pageposX+"%");
}
// 切换上传类型
$($(".JS").click(function(){
        $(".JS").css("color","white");
        $(".CSS").css("color","#22CCA0");
        $(".backdiv").css("left","10px");
        code_type = 'js';
    })
)
$($(".CSS").click(function(){
        $(".CSS").css("color","white");
        $(".JS").css("color","#22CCA0");
        $(".backdiv").css("left","105px");
        code_type = 'css';
    })
)
//提交代码按钮
$($(".pushcode").click(function(){
        //
    })
)

// var global_config = {};
//
// var switch_CDN, rate_limit_mode, anti_leech_mode, ip_list_mode, cache_mode = 0;
// $.ajax({
//     type: 'GET',
//     url: 'api/global',
//     dataType: "json",
//     success: function (data){
//         global_config = data;
//         switch_CDN = data.cdn_mode;
//         console.log(switch_CDN);
//         rate_limit_mode = data.rate_limit.mode;
//         if(data.anti_leech.mode == 'none'){
//             anti_leech_mode = 0;
//         }else if(data.anti_leech.mode == 'whitelist'){
//             anti_leech_mode = 1;
//         }else{
//             anti_leech_mode = 2;
//         }
//         if(data.ip_list.mode == 'none'){
//             ip_list_mode = 0;
//         }else if(data.ip_list.mode == 'whitelist'){
//             ip_list_mode = 1;
//         }else{
//             ip_list_mode = 2;
//         }
//         cache_mode = data.cache.mode;
//         if(switch_CDN != "0"){
//             console.log(switch_CDN);
//             switch_ON();
//             console.log('switch_on');
//             $('.cover').show();
//         }
//         else{
//             switch_OFF();
//             $('.cover').hide();
//         }
//         if(rate_limit_mode != "0"){
//             rate_limitON();
//         }
//         else{
//             rate_limitOFF();
//         }
//         if(ip_list_mode == 1){
//             whitelistON();
//         }
//         else if(ip_list_mode == 0){
//             ip_list_OFF();
//         }
//         else{
//             blacklistON();
//         }
//         if(anti_leech_mode == 1){
//             leech_whitelistON();
//         }
//         else if(anti_leech_mode == 0){
//             anti_leech_OFF();
//         }
//         else{
//             leech_blacklistON();
//         }
//         if(cache_mode != "0"){
//             cache_diyON();
//         }
//         else{
//             cache_diyOFF();
//         }
//     }
// })
//
//
// // 切换CDN模式
// // var switch_CDN =0 ;//载入配置开启状态b 0直连 1 CDN
// var switch_ON=function(){
//     $(".CND_ON").css("color", "white");
//     $(".CDN_OFF").css("color", "#22CCA0");
//     $(".CDN_back").css("left", "0px");
// }
// var switch_OFF=function(){
//     $(".CDN_OFF").css("color","white");
//     $(".CND_ON").css("color","#22CCA0");
//     $(".CDN_back").css("left","90px");
// }
// if(switch_CDN == 1){
//     switch_ON();
//     $('.cover').show();
// }
// else{
//     switch_OFF();
//     $('.cover').hide();
// }
// $($(".CND_ON").click(function () {
//     switch_ON();//点击开启CDN
//     $('.cover').show();
//     switch_CDN = 1;
// }))
// $($(".CDN_OFF").click(function () {
//     switch_OFF();//点击关闭CDN
//     $('.cover').hide();
//     switch_CDN = 0;
// }))
// //                                 限流设置
// // var rate_limit_mode = 1 ;//载入配置开启状态
// var rate_limitON=function(){
//     $(".rate_limit_ON").css("color", "white");
//     $(".rate_limit_OFF").css("color", "#22CCA0");
//     $(".rate_limit_back").css("left", "0px");
// }
// var rate_limitOFF=function(){
//     $(".rate_limit_OFF").css("color","white");
//     $(".rate_limit_ON").css("color","#22CCA0");
//     $(".rate_limit_back").css("left","90px");
// }
// if(rate_limit_mode == 1){
//     rate_limitON();
// }
// else{
//     rate_limitOFF();
// }
// $(".rate_limit_ON").click(function () {
//     rate_limitON();//点击开启限流
//     rate_limit_mode = 1
// })
// $(".rate_limit_OFF").click(function () {
//     rate_limitOFF();//点击关闭限流
//     rate_limit_mode = 0
// })
//
// //                                  IP黑白名单
//
// // var ip_list_mode = 0 ;// 0不使用1白名单2黑名单
// var ip_list_OFF=function(){
//     $(".ip_list_OFF").css("color", "white");
//     $(".ip_list_White").css("color", "#22CCA0");
//     $(".ip_list_Black").css("color", "#22CCA0");
//     $(".ip_list_back").css("left", "0px");
// }
// var whitelistON=function(){
//     console.log('on')
//     $(".ip_list_White").css("color", "white");
//     $(".ip_list_OFF").css("color", "#22CCA0");
//     $(".ip_list_Black").css("color", "#22CCA0");
//     $(".ip_list_back").css("left","90px");
// }
// var blacklistON=function(){
//     $(".ip_list_Black").css("color", "white");
//     $(".ip_list_White").css("color", "#22CCA0");
//     $(".ip_list_OFF").css("color", "#22CCA0");
//     $(".ip_list_back").css("left","180px");
// }
// if(ip_list_mode == 1){
//     whitelistON();
// }
// else if(ip_list_mode == 0){
//     ip_list_OFF();
// }
// else{
//     blacklistON();
// }
// $(".ip_list_OFF").click(function () {
//     ip_list_OFF();//点击关闭IP管理
//     ip_list_mode = 0;
// })
// $(".ip_list_White").click(function () {
//     whitelistON();//点击开启白名单
//     ip_list_mode = 1;
// })
// $(".ip_list_Black").click(function () {
//     blacklistON();//点击开启黑名单
//     ip_list_mode = 2;
// })
//
// //                                  防盗链
//
// // var anti_leech_mode  = 0;// 0不使用1白名单2黑名单
// var anti_leech_OFF=function(){
//     $(".anti_leech_OFF").css("color", "white");
//     $(".anti_leech_White").css("color", "#22CCA0");
//     $(".ip_list_Black").css("color", "#22CCA0");
//     $(".anti_leech_back").css("left", "0px");
// }
// var leech_whitelistON=function(){
//     console.log('on')
//     $(".anti_leech_White").css("color", "white");
//     $(".anti_leech_OFF").css("color", "#22CCA0");
//     $(".anti_leech_Black").css("color", "#22CCA0");
//     $(".anti_leech_back").css("left","90px");
// }
// var leech_blacklistON=function(){
//     $(".anti_leech_Black").css("color", "white");
//     $(".anti_leech_White").css("color", "#22CCA0");
//     $(".anti_leech_OFF").css("color", "#22CCA0");
//     $(".anti_leech_back").css("left","180px");
// }
// if(anti_leech_mode == 1){
//     leech_whitelistON();
// }
// else if(anti_leech_mode == 0){
//     anti_leech_OFF();
// }
// else{
//     leech_blacklistON();
// }
// $(".anti_leech_OFF").click(function () {
//     anti_leech_OFF();//点击关闭防盗链
//     anti_leech_mode = 0;
// })
// $(".anti_leech_White").click(function () {
//     leech_whitelistON();//点击开启白名单
//     anti_leech_mode = 1;
// })
// $(".anti_leech_Black").click(function () {
//     leech_blacklistON();//点击开启黑名单
//     anti_leech_mode = 2;
// })
// //                                 限流设置
//
// // var cache_mode = 1 ;//载入配置开启状态 1开启 0关闭
// var cache_diyON=function(){
//     $(".cache_ON").css("color", "white");
//     $(".cache_OFF").css("color", "#22CCA0");
//     $(".cache_back").css("left", "0px");
// }
// var cache_diyOFF=function(){
//     $(".cache_OFF").css("color","white");
//     $(".cache_ON").css("color","#22CCA0");
//     $(".cache_back").css("left","90px");
// }
// if(cache_mode == 1){
//     cache_diyON();
// }
// else{
//     cache_diyOFF();
// }
// $(".cache_ON").click(function () {
//     cache_diyON();//点击开启缓存自定义
//     cache_mode = 1;
// })
// $(".cache_OFF").click(function () {
//     cache_diyOFF();//点击关闭缓存自定义
//     cache_mode = 0;
// })
// //                                      保存配置 post提交
// $(".saveConfig").click(function () {
//
//     var CDN_Data;//CDN 配置数据
//     if(switch_CDN == 1){
//         CDN_Data = 'cdn_mode=1';
//     }
//     else {
//         CDN_Data = 'cdn_mode=0';
//     }
//     var rate_limit_Data;//限流 配置数据
//     if(rate_limit_mode == 0){
//         rate_limit_Data = 'rate_limit_mode=0';
//     }
//     else{
//         rate_limit_Data = 'rate_limit_mode=1&'
//             +'rate_limit_time_span=' +$('#time_span').val()+'&'
//             +'rate_limit_limit='+$('#ip_limit').val();
//     }
//     var ip_list_Data;//IP管理 配置数据
//     if(ip_list_mode == 0){
//         ip_list_Data = 'ip_list_mode=none';
//     }
//     else if(ip_list_mode ==1){
//         ip_list_Data = 'ip_list_mode=whitelist&'
//             +'ip_list_whitelist=' +$('.ip_text').val();
//     }
//     else{
//         ip_list_Data = 'ip_list_mode=blacklist&'
//             +'ip_list_blacklist=' +$('.ip_text').val();
//     }
//     var anti_leech_Data;//防盗链 配置数据
//     if(anti_leech_mode == 0){
//         anti_leech_Data = 'anti_leech_mode=none';
//     }
//     else if(anti_leech_mode == 1){
//         anti_leech_Data = 'anti_leech_mode=whitelist&'
//             +'ip_list_whitelist=' +$('.anti_text').val();
//     }
//     else{
//         anti_leech_Data = 'anti_leech_mode=blacklist&'
//             +'ip_list_blacklist=' +$('.anti_text').val();
//     }
//     var cache_Data;//缓存 配置数据
//     if(cache_mode == 0){
//         cache_Data = 'cache_mode=0';
//     }
//     else{
//         cache_Data = 'cache_mode=1&'
//             +'cache_max_age=' +$('#cache_max_age').val()+'&'
//             +'cache_max_custom='+$('#cache_max_custom').val();
//     }
//     var data_all = CDN_Data + '&' + rate_limit_Data + '&' + ip_list_Data + '&' + anti_leech_Data + '&' + cache_Data;
//     // data_all = encodeURI(data_all)
//     console.log(data_all);
//     $.ajax({
//         type: "POST",//方法类型
//         dataType: "json",//预期服务器返回的数据类型
//         url: "/api/global" ,//url
//         // data: {
//         // 	CDN_Data,
//         // 	rate_limit_Data,
//         // 	ip_list_Data,
//         // 	anti_leech_Data,
//         // 	cache_Data,
//         // },
//         data: data_all,
//         success: function (result) {
//             $(".global-notice").text("操作成功！");
//             $(".global-notice").css("color", "green");
//             $(".global-notice").fadeIn();
//             setTimeout(function(){
//                 $(".global-notice").fadeOut();
//                 $(".global-notice").text("");
//             }, 3000)
//         },
//         error : function() {
//             $(".global-notice").text("操作失败！");
//             $(".global-notice").css("color", "red");
//             $(".global-notice").fadeIn();
//             setTimeout(function(){
//                 $(".global-notice").fadeOut();
//                 $(".global-notice").text("");
//             }, 3000)
//         }
//     });
//
// })
// var switch_DIYCDN = 0 ;//载入配置开启状态
// var switch_DIYON=function(){
//     $(".DIYCDN_ON").css("color", "white");
//     $(".DIYCDN_OFF").css("color", "#22CCA0");
//     $(".DIYCDN_back").css("left", "0px");
// }
// var switch_DIYOFF=function(){
//     $(".DIYCDN_OFF").css("color","white");
//     $(".DIYCDN_ON").css("color","#22CCA0");
//     $(".DIYCDN_back").css("left","90px");
// }
// if(switch_DIYCDN === 1){
//     switch_DIYON();
//     $('.diyCover').show();
// }
// else{
//     switch_DIYOFF();
//     $('.diyCover').hide();
// }23
// $($(".DIYCDN_ON").click(function () {
//     switch_DIYON();//点击开启CDN
//     $('.diyCover').show();
//     switch_DIYCDN = 1;
// }))
// $($(".DIYCDN_OFF").click(function () {
//     switch_DIYOFF();//点击关闭CDN
//     $('.diyCover').hide();
//     switch_DIYCDN = 0;
// }))

var switch_custom = 1 ;//载入配置开启状态
var switch_customON=function(){
    $(".custom_ON").css("color", "white");
    $(".custom_OFF").css("color", "#22CCA0");
    $(".custom_back").css("left", "0px");
}
var switch_customOFF=function(){
    $(".custom_OFF").css("color","white");
    $(".custom_ON").css("color","#22CCA0");
    $(".custom_back").css("left","90px");
}
if(switch_custom === 1){
    switch_customON();
    $('.diyCover').show();
}
else{
    switch_customOFF();
    $('.diyCover').hide();
}23
$($(".custom_ON").click(function () {
    switch_customON();//点击开启CDN
    $('.diyCover').show();
    switch_custom = 1;
}))
$($(".custom_OFF").click(function () {
    switch_customOFF();//点击关闭CDN
    $('.diyCover').hide();
    switch_custom = 0;
}))

$('#non-custom').on('click',function(){
    $("#DIY_time_span").val("");
    $("#DIY_ip_limit").val("");
    $("#DIY_cache_max_age").val("");
    $("#DIY_cache_max_custom").val("");
})

var link ;//代码链接
//点击提交代码
$(".pushcode").click(function () {
    console.log(11111);
    // var DIY_CDN_Data;//CDN 配置数据
    // if(switch_DIYCDN === 1){
    //     DIY_CDN_Data = 'cdn_mode=1';
    // }
    // else {
    //     DIY_CDN_Data = 'cdn_mode=0';
    // }
    var DIY_rate_limit_Data;//限流 DIY配置数据
    var DIY_time_span = $('#DIY_time_span').val();
    var DIY_ip_limit = $('#DIY_ip_limit').val();
    if(DIY_time_span==='' &&  DIY_ip_limit==='' ){
        DIY_rate_limit_Data = 'rate_limit_mode=0';
    }
    else{
        DIY_rate_limit_Data = 'rate_limit_mode=1&'
            +'rate_limit_time_span=' +DIY_time_span+'&'
            +'rate_limit_limit='+DIY_ip_limit;
    }
    var DIY_cache_Data;//缓存 DIY配置数据
    var DIY_max_age = $('#DIY_cache_max_age').val();
    var DIY_max_custom = $('#DIY_cache_max_custom').val();
    if(DIY_max_age==='' &&  DIY_max_custom==='' ){
        DIY_cache_Data = 'rate_limit_mode=0';
    }
    else{
        DIY_cache_Data = 'cache_mode=1&'
            +'cache_max_age='+DIY_max_age+'&'
            +'cache_max_custom='+DIY_max_custom;
    }
    var filename = Date.now()+'.'+code_type;//随机时间戳文件名
    if($("#filename-custom").val()){
        filename = $("#filename-custom").val()+'.'+code_type;
    }
    var code_Data = $('#Inputcode').val();
    // var code_params = filename + '&' +
    upload_params = {};
    upload_params['filename'] = filename;
    upload_params['ext'] = code_type;
    upload_params['content'] = code_Data;
    if($("#DIY_time_span").val()){
        upload_params['rate_limit_time_span'] = $("#DIY_time_span").val();
    }
    if($("#DIY_ip_limit").val()){
        upload_params['rate_limit_limit'] = $("#DIY_ip_limit").val();
    }
    if($("#DIY_cache_max_age").val()){
        upload_params['cache_max_age'] = $("#DIY_cache_max_age").val();
    }
    if($("#DIY_cache_max_custom").val()){
        upload_params['cache_custom'] = $("#DIY_cache_max_custom").val();
    }
    $.ajax({
        type: "POST",//方法类型
        dataType: "json",//预期服务器返回的数据类型
        url: "api/resources" ,//url
        data: upload_params,
        success: function (data) {
            if(code_type == 'js'){
                link = '<script src="'+data.link +'"></script>';
            }
            else{
                link = '<link rel="stylesheet" href="'+data.link +'">'
            }
            copytobroad();
            $('.link').html("成功！链接已以HTML的形式复制到剪切板！");
            setTimeout(function(){
                $('.link').html(data.link)
            }, 2000);
            $("#DIY_time_span").val("");
            $("#DIY_ip_limit").val("");
            $("#DIY_cache_max_age").val("");
            $("#DIY_cache_max_custom").val("");
        },
        error : function() {
            $('.link').html('上传失败');
        }
    });

})
//点击复制直链
$('.copy').click(function () {
    link = $('.link').html();
    copytobroad();
})
//复制到剪贴板函数
var copytobroad=function () {
    const input = document.createElement('input');
    document.body.appendChild(input);
    input.setAttribute('value',link);
    input.select();
    if (document.execCommand('copy')) {
        document.execCommand('copy');
        console.log('复制成功');
    }
    document.body.removeChild(input);
}

