<?php session_start();
    if (empty($_SESSION['ses_fbid'])) {
header("Location: index.php");
}
function convertdate($date) {
//�¡����Ţ�͡�ҡ����ͧ���� -
  $day = substr($date, 8, 2);
  $year = substr($date, 0, 4);
  $month = substr($date, 5, 2);
//�ӡ�����ҧ Array �������͹��ҧ�
  $thai_month_arr=array(
  "0"=>"",
  "01"=>"���Ҥ�",
  "02"=>"����Ҿѹ��",
  "03"=>"�չҤ�",
  "04"=>"����¹",
  "05"=>"����Ҥ�",
  "06"=>"�Զع�¹", 
  "07"=>"�á�Ҥ�",
  "08"=>"�ԧ�Ҥ�",
  "09"=>"�ѹ��¹",
  "10"=>"���Ҥ�",
  "11"=>"��Ȩԡ�¹",
  "12"=>"�ѹ�Ҥ�"         
);
//�ӡ�����͡��͹�������Ţ����к�
  $month_final = $thai_month_arr[($month)];
//�ӡ����� �ѹ ��͹ �� ����繵�������ǡѹ ����������觤���͡�͡�ѧ��ѹ
  $date = $day . ' ' . $month_final . ' ' . $year; 
//�觤���͡�͡�ѧ��ѹ ���͹����ҹ���
  return $date;
}
 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Anypic2u - Your Movies Your Select!</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Anypic2u - �����䫵��Ǻ��������ѹ�ԧ�ú��ѹ �����Ҩ����Ҿ¹����ҧ����� �Ф� ��������ҧ�">
    <meta name="author" content="Kusumoto">
   <link rel="icon" href="img/logo1.png" type="image/x-icon"/>

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
      <script src="http://code.jquery.com/jquery.js"></script>
      <script src="js/bootstrap.min.js"></script>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
   <!-- <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="../assets/ico/favicon.png">-->

 <script>
$(document).ready(function(){
    $("#form").on('submit',function(event){
    event.preventDefault();
        $.ajax({
        type: "POST",
        url: "savedonate.php",
        data: $("#form").serialize(),
        }).done(function(msg) {{
            $("#alert").html(msg);
        }
        });
    });
});
</script>

   <script>
window.onload = function() {
   document.getElementById("load").style.display = "none";
}
</script>

    <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=372632369514370";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<script type="text/javascript">
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>
  </head>
  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
           <a class="brand" href="index.php"><img src="img/logo.png"></a>
          <ul class="nav pull-right">
          <li class="divider-vertical"></li>
              <?php include('fb_user.php'); ?>
            </ul>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li><a href="index.php"><i class="icon-home"></i> Home</a></li>
              <li><a href="sys_status.php"><i class="icon-signal"></i> System Status</a></li>
              <li><a href="#"><i class="icon-play"></i> Player</a></li>
              <li><a href="notifi.php"><i class="icon-bullhorn"></i> Notification</a></li>
              <li class="active"><a href="donate.php"><i class="icon-info-sign"></i> Donate <img src="img/donate_notif.png" \></a></li>
              <li><a href="invite.php"><i class="icon-share"></i> Invite</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

<div class="container-fluid">
  <div class="alert alert-error">
  <?php include('notification_new.php'); ?>
</div>
<?php
include('db_connect.php');
$link = new mysqli($host,$user,$pass,$db);
if ($link->connect_error) {
  die("Error : ".mysqli_connect_errno());
}
$fbid = $_SESSION['ses_fbid'];
$link->set_charset("utf8");
$coinquery = $link->query("SELECT * from anypic2u_coin WHERE fbid='$fbid'");
$coinnum = $coinquery->num_rows;
if ($coinnum == 0) {
  $coin = 0;
}else{
  $i=0;
  while($row = $coinquery->fetch_array(MYSQLI_BOTH)) {
    $coin = $row['coin'];
    $i++;
  }
}
$userquery = $link->query("SELECT * from anypic2u_user WHERE fbid='$fbid'");
$usernum = $userquery->num_rows;
if ($usernum != 0) {
  $fetch_array = $userquery->fetch_array(MYSQLI_BOTH);
  $donate1 = $fetch_array['donate'];
  $vipdatequery = $link->query("SELECT * from anypic2u_vipdate WHERE fbid='$fbid'");
  while($row = $vipdatequery->fetch_array(MYSQLI_BOTH)) {
    $datex = $row['date'];
  }
}
$datex = convertdate($datex);
?>

<div class="alert alert-warning" id="load">
  <p><img src='img/20-0.gif' border='0'>  <strong>˹�ҹ�����������Ŵ�ѡ����Ф�Ѻ �ô�ͨ�����˹�ҹ�����Ŵ����</strong></p>
</div>
<center><div class="fb-like-box" data-href="https://www.facebook.com/zxpic" data-width="500" data-height="210" data-show-faces="true" data-stream="false" data-show-border="false" data-header="true"></div></center>
      </br>
      <?php if ($donate1 == 2) { ?>
      <div class="alert alert-info"><center><strong>�ô��Һ : </strong>ʶҹ� Donater �ͧ�س�����ŧ��ѹ��� <?=$datex;?></center></div>
      </br>
      <?php }else if ($donate1 == 1) { ?>
      <div class="alert alert-info"><center><strong>�ô��Һ : </strong>ʶҹ� Donater �ͧ�س��Ẻ����</center></div>
      <?php } ?>
      <h1>Donation</h1>
      <small>���ͧ�ҡ��âѺ����͹���䫵��� ���繵�ͧ�դ�������㹡�ô�����ѡ���к� ������ Server ��Ф���Ѿ�ô�к������ ���ѹ��������ͧ�Ѻ��ԡ���ҡ��� ��ú�ԨҤ�����Թ�ͧ�س�з�������䫵���Թ�������ҧ�Һ��� ������������� ������ͧ��蹡ѹ����</small>
      </br>
      <h3>��ԨҤ����������?</h3>
      <small>�����Ҫԡ����� (Donater) ���¤�Һ�ԡ����͹�� 150 �ҷ (0.7 BTC) �س�����Ѻ����ͧ���´�� <img src="img/star.png" \> �����繡���ʴ���������ҷ�ҹ����ҪԡẺ Donater �·ҧ��Ҩ��������Թ�ͧ�س�������� ���ѵ�Ҥ�Һ�ԡ�è�ᵡ��ҧ�ѹ �ѧ���</small> 
      <h3>��ͧ�ҧ��Ѻ�Թ</h3>
      <div class="alert alert-warning">
      <p><strong>�ô��Һ �͹���س���ʹ�Թ���� <font color="red"><?=$coin;?></font> �ҷ</strong> <a href="setvip.php?type=1" class="btn btn-primary" >�ѡ�Թ���͵������ Donater (�������ѹ 10 �ҷ)</a> <a href="setvip.php?type=2" class="btn btn-primary" >�ѡ�Թ���͵������ Donater (��������͹ 150 �ҷ)</a> <a href="setinvite.php" class="btn btn-primary" >�ѡ�Թ���ͫ��� Invite (1 �ѹ 20 �ҷ)</a> <a href="setdemo.php" class="btn btn-primary" >���ͧ��ҹ 1 �ѹ (���)</a></p>
      </div>
      <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>��ͧ�ҧ㹡���Ѻ�Թ</th>
                <th>��������´</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <img src="img/true.jpg" />
                </td>
                <td>
                  <code>��ҹ��ͧ�ҧ True Money ��ҹ�е�ͧ�Ѻ����㹡�è��¤�Ҹ�������㹡���ѡ�Թ (�������Թ�ء���� ���ա���ѡ��ҷ����� 15% 㹡������Թ�ء����)</code>
                </td>
              </tr>
              <tr>
                <td>
                   <img src="img/bitcoin.jpg" />
                  
                </td>
                <td>
                  <code>��ҹ��ͧ�ҧ Bitcoin ��ҹ�е�ͧ�Ѻ����㹡�è��¤�Ҹ�������㹡���ѡ�Թ (�������Թ�ء���� ���ա���ѡ��Ҹ������� 100 �ҷ㹡�����)</code>
                </td>
              </tr>
            </tbody>
          </table>

      <h3>�����š�ú�Ԩҡ��ҹ True Money</h3>
      <div id="warning" style="text-align:center;background-color:green;color:white;font-weight:bold;font-size:120%;padding:5px;">�к��ѡ�Թ�ѵ��ѵ� �ӧҹ�������Ǥ�Ѻ</div>
      <small><strong>��سҴ� ��С�͡�����ŵ�������Һ͡���¹Ф�Ѻ ���ͻ���ª��ͧ��ҹ�ͧ ���ж�ҷҧ��͡����������������Һ͡��ҹ��ҧ ���ջѭ�ҵ���ҷ���ѧ��Ф�Ѻ</strong></small>
      <hr>
      <div class="control-group">
        <strong>Facebook ID :: </strong><?=$fbid;?> <strong><font color="red">(�Ӥѭ�ҡ�Ф�Ѻ ��͡���ç�ء���)</font></strong>
        </div>
      <div class="control-group">
        <strong>E-Mail Address :: </strong>��͡ E-Mail �������ö�Դ��͡�Ѻ��ͧ�س
        </div>
        <div class="control-group">
        <strong>�������Ѿ�� :: </strong>��͡�������Ѿ��������ö�Դ��ͤس��
        </div>
       
       <a href="http://www.tmtopup.com/topup/?uid=" target="_BLANK" class="btn btn-primary">������鹢�鹵͹��è����Թ���� True Money</a>
        <hr>
      <h3>�駺�ԨҤ (����Ѻ Bitcoin)</h3>
    <form class="form-horizontal" id="form" method="GET" action="savedonate.php">
          <div class="control-group">
              <label class="control-label">�ӹǹ�Թ</label>
                  <div class="controls">
                      <input type="text" name="donate_total" class="input-mini" >
           </div>
         </div>
    <div class="control-group">
            <label class="control-label">�ѹ�����͹</label>
                <div class="controls">
                  <input class="hasDatepicker" name="date" type="text"><span class="help-inline">��͡�ѹ������������´�ú��ǹ ������㹡�õ�Ǩ�ͺ</span>
            </div>
    </div>
    <div class="control-group">
      <label class="control-label">��Ҥ�÷���͹</label>
       <div class="controls">
         <select class="span2" name="bank">
          <option>Bitcoin</option>
        </select>
        </div>
       Bitcoin QR Code <img src="img/bitcoin.png" >
   </div>

           <div class="controls">
    <button type="submit" class="btn btn-primary" data-loading-text="Loading...">���͹�Թ</button>
    </div>
    </form>
    
<div id="set_security" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="security_title" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">?</button>
      <h3 id="security_title">���ҧ/��Ѻ����¹���ʼ�ҹ�������к�Ẻ��������</h3>
        </div>
      <div class="modal-body">
     <iframe width="100%" height="260px" frameborder="0" scrolling="no" allowtransparency="true" src="set_securitycode.php"></iframe>
      </div>
   <div class="modal-footer">
      <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> �Դ</button>
    </div>
</div>

        <div class="alert alert-error" id="alert">
    </div>

      <footer>
        <hr>
        <p class="pull-right"><!-- Histats.com  START  (standard)-->
<script type="text/javascript">document.write(unescape("%3Cscript src=%27http://s10.histats.com/js15.js%27 type=%27text/javascript%27%3E%3C/script%3E"));</script>
<a href="http://www.histats.com" target="_blank" title="counter free hit invisible" ><script  type="text/javascript" >
try {Histats.start(1,2414640,4,110,145,23,"00000001");
Histats.track_hits();} catch(err){};
</script></a>
<noscript><a href="http://www.histats.com" target="_blank"><img  src="http://sstatic1.histats.com/0.gif?2414640&101" alt="counter free hit invisible" border="0"></a></noscript>
<!-- Histats.com  END  --><a href="#">Back to top</a></p>
        <p>&copy; 2013 Anypic2u by Kusumoto <script type="text/javascript" language="javascript1.1" src="http://tracker.stats.in.th/tracker.php?sid=50590"></script><noscript><a target="_blank" href="http://www.stats.in.th/">www.Stats.in.th</a></noscript></p>
      </footer>
  </div>
  

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap-transition.js"></script>
    <script src="js/bootstrap-alert.js"></script>
    <script src="js/bootstrap-modal.js"></script>
    <script src="js/bootstrap-dropdown.js"></script>
    <script src="js/bootstrap-scrollspy.js"></script>
    <script src="js/bootstrap-tab.js"></script>
    <script src="js/bootstrap-tooltip.js"></script>
    <script src="js/bootstrap-popover.js"></script>
    <script src="js/bootstrap-button.js"></script>
    <script src="js/bootstrap-collapse.js"></script>
    <script src="js/bootstrap-carousel.js"></script>
    <script src="js/bootstrap-typeahead.js"></script>

  </body>
</html>