<?php
		
			include_once('../config/routeros_api.class.php');			
			include_once('conn.php');
			include_once('../phpqrcode/qrlib.php');

			$ARRAY = $API->comm("/ip/hotspot/user/profile/print");
	
				if(!empty($_REQUEST['username'])){

					if($_REQUEST['name']==$_GET['id']){
						$user=$_GET['id'];
						$password=$_REQUEST['password'];					
						$username=$_REQUEST['username'];
						$profile=$_REQUEST['profile'];
						$status=$_REQUEST['status'];
						$img=$user.".png";
						$file=$username.".png";
						@unlink("../qrcode/".$img);
						QRcode::png('http://'.$ip.'/login?username='.$username.'&password='.$password.'', '../qrcode/'.$file.'');
						mysql_query("UPDATE mt_gen SET user='".$_REQUEST['username']."', pass='".$_REQUEST['password']."', profile='".$_REQUEST['profile']."', status='".$_REQUEST['status']."' WHERE user='".$user."'");
						
						$ARRAY = $API->comm("/ip/hotspot/user/set", array(											
											"name"		=> $username,
											"password"  => $password,
											"profile"	=> $profile,
											"numbers"	=> $user,
								));		
						
						echo "<script>alert('ทำการแก้ไขผู้ใช้งาน Hotspot เรียบร้อยแล้ว.')</script>";
						echo "<meta http-equiv='refresh' content='0;url=index.php?opt=userall' />";
						exit();
					}else{

						$sql=mysql_query("SELECT user FROM mt_gen where user='".$_REQUEST['username']."'");
						$num=mysql_num_rows($sql);						

						if($num==0){
							$user=$_GET['id'];
							$password=$_REQUEST['password'];					
							$username=$_REQUEST['username'];
							$profile=$_REQUEST['profile'];
							$status=$_REQUEST['status'];
							$img=$user.".png";
							$file=$username.".png";
							@unlink("qrcode/".$img);
							QRcode::png('http://'.$ip.'/login?username='.$username.'&password='.$password.'', 'qrcode/'.$file.'');
							mysql_query("UPDATE mt_gen SET user='".$_REQUEST['username']."', pass='".$_REQUEST['password']."', profile='".$_REQUEST['profile']."',qrcode='".$file."', status='".$_REQUEST['status']."' WHERE user='".$user."'");
							
							$ARRAY = $API->comm("/ip/hotspot/user/set", array(											
												"name"		=> $username,
												"password"  => $password,
												"profile"	=> $profile,
												"numbers"	=> $user,
									));		
							
							echo "<script>alert('ทำการแก้ไขผู้ใช้งาน Hotspot เรียบร้อยแล้ว.')</script>";
							echo "<meta http-equiv='refresh' content='0;url=index.php?opt=user_list' />";
							exit();
						}else{							
							echo "<script>alert('ไม่สามารถเปลี่ยนแปลงผู้ใช้งาน Hotspot = <".$username."> ได้.')</script>";							
						}
					}
				}
			
									   								
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
 <!-- Page Content -->
      <div class="content-wrapper">
        <section class="content">
            <div class="row">

               <div class="col-lg-12">
		                  <div class="box box-solid box-success">                             
		                        <div class="box-header">
		                           <h3 class="box-title"><i class="fa fa-user"></i> แก้ไขข้อมูลผู้ใช้งานอินเตอร์เน็ตห้องสมุด</h3>
		                        </div>
		                       <div class="box-body">
		                           <form id="add_user" action="" method="post">
                                   <?php
								   		$result=mysql_fetch_array(mysql_query("SELECT * FROM mt_gen WHERE user='".$_REQUEST['id']."'"));
								   ?>
                                        <div class="form-group input-group">
                                            <span class="input-group-addon">ชื่อผู้ใช้&nbsp;&nbsp;&nbsp;</span>
                                            <input type="text" name="username" placeholder="กรุณากรอกชื่อผู้ใช้งาน" class="form-control" value="<?php echo $result['user']; ?>" required>
                                        </div>
                                        <div class="form-group input-group">
                                            <span class="input-group-addon">รหัสผ่าน&nbsp;</span>
                                            <input type="text" name="password" placeholder="กรุณากรอกรหัสผ่าน" class="form-control" value="<?php echo $result['pass']; ?>" required>
                                        </div>
                                        <div class="form-group input-group">
                                            <span class="input-group-addon">กลุ่มผู้ใช้งาน&nbsp;</span>
                                            <select class="form-control" name="profile" size="1" id="profile">   
											<option value="<?php echo $result['profile']; ?>"><?php echo $result['profile']; ?></option>
                                            	<?php
													$num =count($ARRAY);
													for($i=0; $i<$num; $i++){
														$seleceted = ($i == 0) ? 'selected="selected"' : '';
														if($ARRAY[$i]['name']!=$result['profile']){
															echo '<option value="'.$ARRAY[$i]['name'].$selected.'">'.$ARRAY[$i]['name'].'</option>';
														}
														
													}
												?>
                                          </select>
                                        </div>                                        
                                      	<div class="form-group input-group">
                                            <span class="input-group-addon">Status&nbsp;&nbsp;&nbsp;</span>
                                            <input type="text" name="status" placeholder="แก้ไขสถานะ" class="form-control" value="<?php echo $result['status']; ?>" required>
                                        </div>
                                     <div class="form-group input-group">                                        
                                        <button id="btnSave" class="btn btn-success" type="submit"><i class="fa fa-check"></i>&nbsp;บันทึก&nbsp;</button>&nbsp;&nbsp;&nbsp;                                        
										<button id="btnCancel" class="btn btn-danger" type="reset"  Onclick="javascript:history.back()"><i class="fa fa-times"></i>&nbsp;ยกเลิก&nbsp;</button>
                                    </div> 
                                    </form>
		                        </div>		                        
                            </div>
                        <!-- /.col-lg-12 -->
                        </div>
                    <!-- /.row -->
                    </div>
                <!-- /#page-wrapper -->
            </div>
        </section>
    </div> 
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Desing By</b> Manas Panjai
        </div>
    <strong>Copyright &copy; 2016 - <?php echo date("Y");?> <a href="#">โรงเรียนหนองบัว</a>.</strong> All rights
  </footer>  
</body>
</html>
