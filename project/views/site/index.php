<?php

/* @var $this yii\web\View */

use project\assets\AppAsset;

project\assets\DataViewAsset::register($this);

$this->title = '首页';
?>
<div class="dataview" id="dataview">

    <div class="canvas" style="opacity: .2"><iframe frameborder="0" src="/js/index.html" style="width: 100%; height: 100%"></iframe></div>
    <div class="loading" style="display: none;">
        <div class="loadbox"><img src="/image/dataview/loading.gif">页面加载中...</div>
    </div>
    <div class="head">
        <h1>中软国际-华为云创新中心运营看板</h1>
        <div class="weather"><span id="showTime"></span></div>
        <div class="fullscreen" id="fullScreen"><span class="glyphicon glyphicon-fullscreen" title="全屏"></span></div>

    </div>
    <div class="mainbox">
        <ul class="clearfix">
            <li>
                <div class="boxall" style="height: 3.2rem">
                    <div class="alltitle">企业健康度</div>
                    <div class="allnav" id="echart1"></div>
                    <div class="boxfoot"></div>
                </div>
                <div class="boxall" style="height: 3.2rem">
                    <div class="alltitle">企业用户数</div>
                    <div class="allnav" id="echart2"></div>
                    <div class="boxfoot"></div>
                </div>
                <div class="boxall" style="height: 3.2rem">
                    <div style="height:100%; width: 100%;">
                        <div class="sy" id="fb1"></div>
                        <div class="sy" id="fb2"></div>
                        <div class="sy" id="fb3"></div>
                        <div class="boxfoot"></div>
                    </div>
            </li>
            <li>
                <div class="bar">
                    <div class="barbox">
                        <ul class="clearfix">
                            <li class="pulll_left counter"><?= $allocate_num ?></li>
                            <li class="pulll_left counter"><?= $allocate_amount ?></li>
                        </ul>
                    </div>
                    <div class="barbox2">
                        <ul class="clearfix">
                            <li class="pulll_left">累计补贴企业（家）</li>
                            <li class="pulll_left">累计补贴金额（万元）</li>
                        </ul>
                    </div>
                </div>
                <div class="map">
                    <div class="map1"><img src="/image/dataview/lbx.png"></div>
                    <div class="map2"><img src="/image/dataview/jt.png"></div>
                    <div class="map3"><img src="/image/dataview/map.png"></div>
                    <div class="map4" id="map_1"></div>
                </div>
            </li>
            <li>
                <div class="boxall" style="height:3.4rem">
                    <div class="alltitle">企业补贴统计</div>
                    <div class="allnav" id="echart4"></div>
                    <div class="boxfoot"></div>
                </div>
                <div class="boxall" style="height: 3.2rem">
                    <div class="alltitle">模块标题样式</div>
                    <div class="allnav" id="echart5"></div>
                    <div class="boxfoot"></div>
                </div>
                <div class="boxall" style="height: 3rem">
                    <div class="alltitle">下拨套餐占比</div>
                    <div class="allnav" id="echart6"></div>
                    <div class="boxfoot"></div>
                </div>
            </li>
        </ul>
    </div>
    <div class="back"></div>
</div>
<script>
    <?php $this->beginBlock('dataview') ?>
    $(window).on('load', function() {
        $(".loading").fadeOut()
    });
    $(document).ready(function() {
        var whei = $(window).width();
        $("html").css({
            fontSize: whei / 20
        });
        $(window).resize(function() {
            var whei = $(window).width();
            $("html").css({
                fontSize: whei / 20
            })
        });

    });

    var t = null;
    t = setTimeout(time, 1000);

    function time() {
        clearTimeout(t);
        dt = new Date();
        var y = dt.getFullYear();
        var mt = dt.getMonth() + 1;
        var day = dt.getDate();
        var h = dt.getHours();
        var m = dt.getMinutes();
        var s = dt.getSeconds();
        document.getElementById("showTime").innerHTML = y + "年" + mt + "月" + day + "日 " + h + "时" + m + "分" + s + "秒";
        t = setTimeout(time, 1000);
    }

    $(function() {

        $("#fullScreen").on("click", function() {
            var isFull = !!(document.webkitIsFullScreen || document.mozFullScreen ||
                document.msFullscreenElement || document.fullscreenElement
            ); //!document.webkitIsFullScreen都为true。因此用!!
            if (isFull == false) {
                //全屏
                fullScreen();

            } else {
                //退出全屏
                exitFullscreen();

            }

        })
    })

    //fullScreen()和exitScreen()有多种实现方式，此处只使用了其中一种
    //全屏
    function fullScreen() {
        var element = document.getElementById("dataview");
        if (element.requestFullscreen) {
            element.requestFullscreen();
        } else if (element.msRequestFullscreen) {
            element.msRequestFullscreen();
        } else if (element.mozRequestFullScreen) {
            element.mozRequestFullScreen();
        } else if (element.webkitRequestFullscreen) {
            element.webkitRequestFullscreen();
        }
    }

    //退出全屏 
    function exitFullscreen() {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        }
    }

    //监听window是否全屏，并进行相应的操作,支持esc键退出
    window.addEventListener("resize", function() {
        //全屏
        var isFull = !!(document.webkitIsFullScreen || document.mozFullScreen ||
            document.msFullscreenElement || document.fullscreenElement
        ); //!document.webkitIsFullScreen都为true。因此用!!
        if (isFull == false) {
            $("#fullScreen span").attr("class", "glyphicon glyphicon-fullscreen");
        } else {
            $("#fullScreen span").attr("class", "glyphicon glyphicon-resize-small");
        }
    })



    $(function() {
        var echart4 = echarts.init(document.getElementById("echart4"));
        echart4.setOption(n());
        echart4.setOption({
            series: <?= json_encode($series['amount']) ?>
        });

        var echart6 = echarts.init(document.getElementById("echart6"));
        echart6.setOption(p());
        echart6.setOption({
            series: <?= json_encode($series['allocate_num']) ?>
        });

        window.addEventListener("resize", function() {
            echart4.resize();
            echart6.resize()
        })
    })

    <?php $this->endBlock() ?>
</script>
<?php $this->registerJs($this->blocks['dataview'], \yii\web\View::POS_END); ?>