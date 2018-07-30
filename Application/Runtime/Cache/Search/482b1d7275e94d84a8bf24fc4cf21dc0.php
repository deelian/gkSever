<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="/Public/css/bootstrap.css">
<link rel="stylesheet" href="/Public/css/bootstrap-theme.css">
<link rel="stylesheet" href="/Public/css/animate.css">
<link rel="stylesheet" href="/Public/css/jquery.toast.css">
<link rel="stylesheet" href="/Public/css/buttons.css">
<link rel="stylesheet" href="/Public/css/layer.css">
<link rel="stylesheet" href="/Public/css/dee.css">
    <title><?php echo ($sysInfo["siteName"]); ?></title>
</head>
<body>
  <!-- header -->
  <link rel="stylesheet" href="/Public/css/fileinput.min.css">
<div class="container navbar-fixed-top">
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="<?php echo U('/');?>" class="navbar-brand" style="color: #fff;"><span class="glyphicon glyphicon-home">.</span>HomeEbola</a>
            </div>
            <div>
                <ul class="nav navbar-nav">
                    <!--<li><a href="#">Top100</a></li>-->
                    <!--<li><a href="#">Hot100</a></li>-->
                </ul>
            </div>
            <div class="navbar-form navbar-right" role="search">
                <div class="file-loading">
                    <input id="input-709" name="kartik-input-709" type="file" multiple>
                </div>
            </div>
        </div>
    </nav>
</div>
<div class="alerts">
    <div id="kv-error-1" style="margin-top:10px;display:none"></div>
    <div id="kv-success-1" class="alert alert-success" style="margin-top:10px;display:none"></div>
</div>
<script>
    var SubUrl = "<?php echo U('/search/file');?>";
    var SubMsg = "<?php echo U('/search/index/message');?>";
    var UserMsg = "<?php echo U('/chat');?>";
    var BaseUrl = "<?php echo I('server.HTTP_HOST');?>";
</script>
  <!-- searchBox -->
  <div class="container">
    <div class="row">
      <div class="col-md-9">
        <div class="row">
          <div class="row text-center">
              <form action="<?php echo U('Index/search');?>" role="search" id="searchBox" class="navbar-form" method="get">
    <div class="form-group input-group input-group-lg" >
        <input type="text" id="searchKey" name="key" class="form-control" autocomplete="off" placeholder="Search" autofocus value="<?php if(empty($data.kw)): else: echo ($data["kw"]); endif; ?>">
    </div>
    <button type="submit" class="btn btn-success btn-lg">Search Now</button>
</form>
<!-- 搜索框弹出框 -->
<div class="" id='foraspcn'></div>
              <div class=" mt center-block mlb">
                  <?php if(is_array($hot)): foreach($hot as $key=>$hot): ?><a href="<?php echo U('/Search/Index/search', ['key'=>$hot]);?>">
                          <span class="label label-<?php echo rangTahs();?>"><?php echo ($hot); ?></span>
                      </a><?php endforeach; endif; ?>
              </div>
          </div>
        </div>
        <div class="row mt">
            <?php if(is_array($listA)): foreach($listA as $key=>$list): ?><div class="col-md-6">
                    <ul class="list-group">
                        <!--<li class="list-group-item bg333"><span class="glyphicon glyphicon-flag">.</span></li>-->
                        <!--<li class="list-group-item">***<span class="badge">new</span></li>-->
                        <?php if(is_array($list)): foreach($list as $key=>$L): ?><li class="list-group-item list"><a href="<?php echo U('/Search/index/detail', ['code'=>$L[id]]);?>"><?php echo ($L["res_name"]); ?></a></li><?php endforeach; endif; ?>
                    </ul>
                </div><?php endforeach; endif; ?>
        </div>
      </div>
      <div class="col-md-3">

          <?php if(is_array($listB)): foreach($listB as $key=>$list): ?><div class="row">
                  <div class="col-md-12 m">
                      <ul class="list-group">
                          <!--<li class="list-group-item bg333"><span class="glyphicon glyphicon-flag">.</span>免费域名注册</li>-->
                          <?php if(is_array($list)): foreach($list as $key=>$L): ?><li class="list-group-item list"><a href="<?php echo U('/Search/index/detail', ['code'=>$L[id]]);?>"><?php echo ($L["res_name"]); ?></a></li><?php endforeach; endif; ?>
                      </ul>
                  </div>
              </div><?php endforeach; endif; ?>

      </div>
    </div>
  </div>
  <!-- footer -->
  <div class="container">
    <footer>
        <div class="container text-center">
            <p>&copy; CopyRight <?php echo ($sysInfo["copyRight"]); ?></p>
        </div>
    </footer>
</div>
<div class="msg">
    <img src="/Public/images/msg.jpg" alt="">
</div>
<div class="userMsg">
    <div class="msgBox"></div>
    <div class="msgBtn">
        <input type="text" class="animated bounceInRight" id="user_msg" name="msg">
        <button class="button button-glow button-border button-rounded button-pill button-primary" id="sendBtn">Say something</button>
    </div>
</div>
<div class="tz">
    <script src="http://s13.cnzz.com/z_stat.php?id=1274031341&web_id=1274031341" language="JavaScript"></script>
</div>
<script type="text/javascript" src="/Public/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="/Public/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/Public/js/jquery.toast.js"></script>
<script type="text/javascript" src="/Public/js/socket.io.js"></script>
<script type="text/javascript" src="/Public/js/layer.js"></script>
<script type="text/javascript" src="/Public/js/search.js"></script>
<script type="text/javascript" src="/Public/js/fileinput.min.js"></script>
</body>
</html>