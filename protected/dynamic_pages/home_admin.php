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
    <script src="static/js/home.js"></script>
    <link rel="stylesheet" href="static/css/home.css">
    <link rel="stylesheet" href="static/css/users.css">
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
            <div class="pagebtn pagebtn1" > 全局配置 </div>
            <div class="pagebtn pagebtn2" > 用户管理 </div>
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
            <div class="switch-group" >
                <div class=" chooseBar-back"  >
                    <div class="backSquare CDN_back "></div>
                    <div class="choose-btn CND_ON">CDN</div>
                    <div class="choose-btn CDN_OFF">Direct</div>
                </div>
                <span class="global-notice"></span>
                <div class="saveConfig">保存配置</div>
            </div>

            <div class="caner" >
                <div class="container ">
                    <div class="configcard ">
                        <div class="switch rate_limit_title">
                            <div class="name">限流 </div>
                            <div class=" chooseBar-back rate_limit_switchbar" >
                                <div class="backSquare rate_limit_back"></div>
                                <div class="choose-btn rate_limit_ON">ON</div>
                                <div class="choose-btn rate_limit_OFF">OFF</div>
                            </div>
                        </div>
                        <div class="Configitem rate_limit_item1">
                            <div class="expla">
                                请求间隔时间
                            </div>
                            <div class="form-group">
                                <input type="number" class="form-control " id="time_span" value="<?php echo $global['rate_limit']['time_span']; ?>">
                                <label class="label label1" >Time_Span</label>
                            </div>
                        </div>
                        <div class="Configitem rate_limit_item2">
                            <div class="expla">
                                每个IP可请求次数
                            </div>
                            <div class="form-group">
                                <input type="number" class="form-control " id="ip_limit" value="<?php echo $global['rate_limit']['limit']; ?>">
                                <label class="label label1" >IP_Limit</label>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="configcard ip_list">
                        <div class="switch rate_limit_title">
                            <div class="name">IP管理 </div>
                            <div class=" chooseBar-back ip_list_switchbar" >
                                <div class="backSquare ip_list_back"></div>
                                <div class="choose-btn ip_list_OFF">OFF</div>
                                <div class="choose-btn ip_list_White">White</div>
                                <div class="choose-btn ip_list_Black">Black</div>
                            </div>
                        </div>
                        <div class="ipitem">
                            <textarea class="form-control textareaforconfig ip_text"><?php
                                if($global['ip_list']['mode'] == 'blacklist'){
                                    for($i = 0; $i < count($global['ip_list']['blacklist']); ++$i){
                                        echo $global['ip_list']['blacklist'][$i] . '&#x000A;';
                                    }
                                }
                                elseif($global['ip_list']['mode'] == 'whitelist'){
                                    for($i = 0; $i < count($global['ip_list']['whitelist']); ++$i){
                                        echo $global['ip_list']['whitelist'][$i] . '&#x000A;';
                                    }
                                }
                                ?></textarea>
                        </div>

                    </div>
                </div>
                <div class="container">
                    <div class="configcard anti_leech">
                        <div class="switch rate_limit_title">
                            <div class="name">防盗链 </div>
                            <div class=" chooseBar-back anti_leech_switchbar" >
                                <div class="backSquare anti_leech_back"></div>
                                <div class="choose-btn anti_leech_OFF">OFF</div>
                                <div class="choose-btn anti_leech_White">White</div>
                                <div class="choose-btn anti_leech_Black">Black</div>
                            </div>
                        </div>
                        <div class="ipitem">
                            <textarea class="form-control textareaforconfig anti_text"><?php
                                if($global['anti_leech']['mode'] == 'blacklist'){
                                    for($i = 0; $i < count($global['anti_leech']['blacklist']); ++$i){
                                        echo $global['anti_leech']['blacklist'][$i] . '&#x000A;';
                                    }
                                }
                                elseif($global['anti_leech']['mode'] == 'whitelist'){
                                    for($i = 0; $i < count($global['anti_leech']['whitelist']); ++$i){
                                        echo $global['anti_leech']['whitelist'][$i] . '&#x000A;';
                                    }
                                }
                                ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="configcard cache">
                        <div class="switch rate_limit_title">
                            <div class="name">缓存自定义</div>
                            <div class=" chooseBar-back cache_switchbar" >
                                <div class="backSquare cache_back"></div>
                                <div class="choose-btn cache_ON">ON</div>
                                <div class="choose-btn cache_OFF">OFF</div>
                            </div>
                        </div>
                        <div class="Configitem cache_item1">
                            <div class="expla">
                                缓存生命周期
                            </div>
                            <div class="form-group">
                                <input type="number" class="form-control " id="cache_max_age" value="<?php echo $global['cache']['max_age']; ?>" >
                                <label class="label label1" >max_age</label>
                            </div>
                        </div>
                        <div class="Configitem cache_item2">
                            <div class="expla">
                                cache-control字段
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control " id="cache_max_custom" value="<?php echo $global['cache']['custom']; ?>" >
                                <label class="label label1" >Custom</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="cover" >
                <div class="container ">
                    <div class="cover-item">

                    </div>
                </div>
                <div class="container">
                    <div class="cover-item">

                    </div>
                </div>
                <div class="container">
                    <div class="cover-item">

                    </div>
                </div>
                <div class="container">
                    <div class="cover-item">

                    </div>
                </div>
            </div>
        </li>
        <li class="page">
            <div class="usersbar">
                <?php include_once('protected/dynamic_pages/users_table.php'); ?>
            </div>
        </li>
    </div>
</div>
</div>
</body>
<script src="static/js/Config.js"></script>
<script src="static/js/firework.js"></script>
</html>
