<?php
  include('../config/common.conf.php');
    if(!empty($_GET['update'])){
      $food_id = $_GET['food_id'];
      $sql = 'select * from mh_food where food_id = '.$food_id;
     //p($sql);die;
      $food_info = get_one($sql);
      // echo WEB_PATH.'/images/'.$banner_info['banner_img_url'];die;
     //p($case_info);die;
      }else{
      show_msg('非法进入','mh_food_list.php');die;
      }
    if(isset($_POST['active'])&&!empty($_POST['active'])){
      // p($_POST);die;
        $food_id = $_POST['food_id'];
        $data['food_title'] = $_POST['title'];
        $data['class'] = $_POST['class'];
        $data['is_show'] = $_POST['is_show'];
        $data['addtime'] = time();
        // p($data);die;
        if($_FILES){
        //接收file标签传过来的信息
        //判断，如果是多文件上传那么我们就需要遍历$_FILES这个数字，将数组里面的文件一一上传
       $name = $_FILES;//确定我们file标签里面的名字name值
          // p($name);die;
        $type = array('png','jpg','gif');//确定上传的类型，获取我们想要的文件类型
        $size = 5*1024*1024;//确定文件大小
        $path = BOOT_PATH.'/images';//确定存放文件的路径
       // p($path);die;
        foreach($name as $key =>$val){
            //跳过没有上传的文件
            if(empty($val['name'])){
              continue;
            }
            //将我们的文件上传
            $res = uploads($key,$type,$size,$path);
           // P($res);die;
            if(!isset($res[1])){
              show_msg($res[0]);die;
            }
             $old ='old_'. $key;
             // p($old);die;
            $old_url = $path.'/'.$_POST[$old];
            // unlink($old_url);//上传成功就会旧历史
            //将我们的上传文件的文件名存到data里面去
            $data[$key]=$res[1];
            // // $old_url = $path.'/'.$_POST['old_'.$key];
            // // p($old_url);die;
        }
    }
    // p($res);die;
    $table = 'mh_food';
    $where = 'food_id = '.$food_id;
     // p($data);die;
    $res = update($table,$data,$where);
    // p($res);die;
    if($res){
      show_msg('修改成功','mh_food_list.php');
    }else{
      show_msg('修改失败');
    }
}   
// //阻止非法进入者
//     session_start();
//     if(empty($_SESSION['is_login'])){
//  // print_r($_SESSION['is_login']);die;
//     show_msg('非法进入','login.php');die;
//   }
?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <title>CMS内容管理系统</title>
<?php include('header.php');?>
  <!-- Core Javascript - via CDN --> 
</head>

<body>
<!-- Start: Header -->
<header class="navbar navbar-fixed-top" style="background-image: none; background-color: rgb(240, 240, 240);">
  <div class="pull-left"> <a class="navbar-brand" href="#">
    <div class="navbar-logo"><img src="images/logo.png" alt="logo"></div>
    </a> </div>
  <div class="pull-right header-btns">
    <a class="user"><span class="glyphicons glyphicon-user"></span> admin</a>
    <a href="login.html" class="btn btn-default btn-gradient" type="button"><span class="glyphicons glyphicon-log-out"></span> 退出</a>
  </div>
</header>
<!-- End: Header -->

<!-- Start: Main -->
<div id="main"> 
    <!-- Start: Sidebar -->
  <aside id="sidebar" class="affix">
    <div id="sidebar-search">
        
    </div>
    <div id="sidebar-menu">
      <?php include('nav.php');?>
    </div>
  </aside>
  <!-- End: Sidebar -->    
  <!-- Start: Content -->
  <section id="content">
    <div id="topbar" class="affix">
      <ol class="breadcrumb">
        <li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
        <li class="active">编辑案例</li>
      </ol>
    </div>
    <div class="container">

	 <div class="row">
        <div class="col-md-10 col-lg-11 center-column">
        <form action="#" method="post" class="cmxform" enctype="multipart/form-data">
        	<div class="panel">
            <div class="panel-heading">
              <div class="panel-title">编辑案例</div>
              <div class="panel-btns pull-right margin-left">
              <a href="case_list.html" class="btn btn-default btn-gradient dropdown-toggle"><span class="glyphicon glyphicon-chevron-left"></span></a>
            	  </div>
            </div>
            <div class="panel-body">
            	  <div class="col-md-7">
                <div class="form-group">
                  <div class="input-group"> <span class="input-group-addon">所属分类</span>
                    <select name="class" class="form-control">
                          <option value="1">特色美食1组</option>
                          <option value="2">特色美食2组</option>
                          <option value="3">特色美食3组</option>
                          <option value="4">特色美食4组</option>
                          <option value="5">特色美食5组</option>
                          <option value="6">特色水果组</option>
                          <option value="车型展示1">车型展示1组</option>
                          <option value="车型展示2">车型展示2组</option>
                          <option value="车型展示3">车型展示3组</option>
                          <option value="车型展示4">车型展示4组</option>
                    </select>
                  </div>
                </div>
                 <div class="input-group">
                    <span class="input-group-addon">图片</span>
                    <input type="file" name="img_url" id="aaa" value="<?php echo $food_info['img_url'];?>" class="form-control" >
                    <img width="100px" height="100" src="<?php echo WEB_PATH.'/images/'.$food_info['img_url'];?>">
                    <input type="hidden" name="old_img_url" value="<?php echo $food_info['img_url']?>">
                </div>
                <div class="form-group"></div>
                <div style="clear:both;"></div>
                <div class="form-group"></div>
                <div class="form-group">
                  <div class="input-group"> <span class="input-group-addon">美食名称</span>
                    <input type="text" name="title" value="<?php echo $food_info['food_title']?>" class="form-control">
                  </div>
                </div>
                 <div class="form-group">
                  <div class="input-group"> <span class="input-group-addon">是否显示</span>
                    <select name="is_show" class="form-control">
                          <option value="1"<?php echo 1==$food_info['is_show']?'selected':'';?>>显示</option>
                          <option value="2"<?php echo 2==$food_info['is_show']?'selected':'';?>>隐藏</option>
                    </select>
                  </div>
                  </div>
                  <div class="input-group"> 
                  <span class="input-group-addon">更新时间</span>
                    <input class="form-control date-picker" id="class_code_cc_time_input" type="text" data-date-format="yyyymmdd" name="time" value="<?php echo $food_info['addtime'];?>">
                </div>
                  
                </div>
                </div>
                <div class="form-group col-md-12">
                </div>
                <input type="hidden" name="active" value="1">
                <input type="hidden" name="food_id" value="<?php echo $food_info['food_id'];?>">
                <div class="col-md-7">
	                <div class="form-group">
	                  <input type="submit" value="提交" class="submit btn btn-blue">
	                </div>
                </div>
            </div>
          </div>
          </form>
        </div>
    </div>
  </section>
  <!-- End: Content --> 
</div>
</body>

</html>
<script src="js/date-time/bootstrap-datepicker.min.js"></script>
<script src="js/common.unpre.js"></script>
<script>
    $('#summernote').summernote({
      height: 300,                 // set editor height
      minHeight: null,             // set minimum height of editor
      maxHeight: null,             // set maximum height of editor
      focus: true                  // set focus to editable area after initializing summernote
    });
  </script>