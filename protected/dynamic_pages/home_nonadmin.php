<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>欢迎使用JSPastebin</title>
    <link href="https://cdn.bootcss.com/bootstrap-table/1.11.1/bootstrap-table.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="https://blogfile.sunxiaochuan258.com/cdn/fontawesome/css/all.min.css?ver=5.13.0">
    <script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.6.0/jquery.js"></script>
    <script src="https://cdn.staticfile.org/popper.js/1.15.0/umd/popper.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <!-- bootstrap-table.min.js -->
    <script src="https://cdn.bootcss.com/bootstrap-table/1.18.2/bootstrap-table.min.js"></script>
    <!-- 引入中文语言包 -->
    <script src="https://cdn.bootcss.com/bootstrap-table/1.18.2/locale/bootstrap-table-zh-CN.min.js"></script>
    <link rel="stylesheet" href="static/css/users.css">
    <link rel="stylesheet" href="static/css/home.css">
    <link rel="stylesheet" href="static/css/firework.css">
</head>
<body>
<div class="board">
    <div class="broadbackimg"></div>
    <div class="barContainer">
        <div class="title ">
            JSPastebin
        </div>
        <div class="topBar">
            <div class="underline"></div>
            <div class="pagebtn pagebtn0" > 一键部署 </div>
            <div class="pagebtn pagebtn1" > 账户设置 </div>
            <div class="pagebtn pagebtn2" > 关于我们 </div>
        </div>
        <div class="userIndex">
            <a href="" class="userNameRT" style="color:#454747"><?php echo $current_user['username']; ?></a>
            <img src="static/img/头像.png" />
        </div>
    </div>
    <div class="Container">
        <li class="page">
            <div class="Pastebin">
                <div class="form-group pastebar">
                    <div class="form-group filename-input">
                        <input type="text" class="form-control" id="filename-custom" placeholder="选填（不含后缀）">
                        <label class="label diylabel">文件名</label>
                    </div>
                    <div class="btn-style1 pushcode" id="pushcode">
                        Paste!
                    </div>
                    <div class=" chooseBar pastebin">
                        <div class="type">
                            <div class="choose JS">JavsScript</div>
                            <div class="choose CSS"> CSS </div>
                        </div>
                        <div class= "backdiv" ></div>
                        <div class="linkbar">
                            <div class="link"> </div>
                            <div class="copy">复制URL</div>
                        </div>
                    </div>
                    <textarea class="form-control " id="Inputcode" ></textarea>
                </div>
                <div class="recordbar">
                    <div class="DIYConfig">
                        <div class="diyCover"></div>
                        <!--							自定义配置-->
                        <form id="DIYConfigForm"  method="post" >
                            <div class="diyConfig ">
                                <div class="diyTitle">
                                    自定义配置
                                </div>
                                <div class=" chooseBar-back diyChoose" >
                                    <div class="backSquare custom_back"></div>
                                    <div class="choose-btn custom_ON" id="non-custom">OFF</div>
                                    <div class="choose-btn custom_OFF">ON</div>
                                </div>
                            </div>

                            <div class="form-group" >
                                <div class="expla">
                                    请求间隔时间
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control diyinput " id="DIY_time_span">
                                    <label class="label diylabel" >Time_Span</label>
                                </div>
                            </div>
                            <div class="expla">
                                每个IP可请求次数
                            </div>
                            <div class="form-group">
                                <input type="number" class="form-control diyinput " id="DIY_ip_limit">
                                <label class="label diylabel" >IP_Limit</label>
                            </div>
                            <div class="expla">
                                缓存生命周期
                            </div>
                            <div class="form-group">
                                <input type="number" class="form-control diyinput cache_max_age" id="DIY_cache_max_age" >
                                <label class="label diylabel" >max_age</label>
                            </div>
                            <div class="expla">
                                cache-control字段
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control diyinput cache_max_custom" id="DIY_cache_max_custom" >
                                <label class="label diylabel" >Custom</label>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </li>
        <li class="page">
            <div class="account-bar">
                <h4>修改您的信息</h4>
                <p>如果您更改了邮箱或重置了token，您的登录状态将解除。</p>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="*" id="nondamin-input-username" aria-describedby="emailHelp" value="<?php echo $current_user['username']; ?>">
                    <label class="label label1">用户名</label>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="*" id="nondamin-input-email" aria-describedby="emailHelp" value="<?php echo $current_user['email']; ?>">
                    <label class="label label1">邮箱</label>
                </div>
                <div class="nonadmin-account-buttons">
                    <span class="nonadmin-account-notice"></span>
                    <button class="btn btn-green btn-reset-token" id="nonadmin-reset-token">重置token</button>
                    <button class="btn btn-green btn-reset-apply" id="nonadmin-apply">应用更改</button>
                    <button class="btn btn-red btn-delete" id="nonadmin-logout">登出账户</button>
                </div>
            </div>
        </li>
        <li class="page">
            <div class="nondamin-bar">
                <h4 class="about-jspb-title">关于JSPastebin</h4>
                <p class="about-jspb">JSPastebin为方便CMS使用者而生，动动鼠标，一键粘贴，极速上云。配置可自定义，高度可定制化。</p>
                <p class="about-jspb">JSPastebin采用FantsyPHP框架开发，符合Restful标准，可无障碍进行二次开发。</p>
                <p class="about-jspb">开箱即用，极速部署，文档详细，就算零基础也能迅速上手。</p>
                <p class="about-jspb">界面美观，赏心悦目，交互便利，就算无引导也能高效使用。</p>
            </div>
        </li>
    </div>
</div>
</div>
</body>
<script src="static/js/nonadmin.js"></script>
<script src="static/js/Config_nonadmin.js"></script>
<script src="static/js/firework.js"></script>
</html>
