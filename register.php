<?php
include('head.php');
$ip_may = $_SERVER['REMOTE_ADDR'];
$_captcha=rand(1,10); 
$_captcha2=rand(1,10); 
$tong_captcha = $_captcha + $_captcha2;
if(isset($_GET['ref'])){
$goi_thieu ='               
<labe> mã gới thiệu </labe>                     <div class="row">
                        <div class="col-7">
                            <input style="height: 50px; border-radius: 15px; font-weight: bold;"
                                   type="text" class="form-control mt-1" name="ma_gt" value="'.$_GET['ref'].'"
                                   placeholder="Mã giới thiệu">
                        </div>
                                                   ';
}else{
$goi_thieu ="";
}
if(isset($_POST['username'])){
$tk = htmlspecialchars($_POST['username']);
$mk = htmlspecialchars($_POST['password']);
$captcha = htmlspecialchars($_POST['captcha']);
if($_POST['submit'] == $captcha){
$sql4 = "SELECT * FROM account WHERE username ='$tk'";
                            $result4 = mysqli_query($conn, $sql4);
                            if($row4 = mysqli_fetch_assoc($result4)){
                            echo'
<script type="text/javascript">
                
                $(document).ready(function(){
                
                  swal({
                        title: "Thất bại",
                        text: "Thông tin tài khoản đã có chủ",
                        type: "error",
                        confirmButtonText: "OK",
                  })
                });
                
                </script>';
                            }else{
                            if($mk == $_POST['repassword']){
                            if(isset($_POST['ma_gt'])){
                            $sql1000 = "SELECT * FROM account WHERE ip ='$ip_may'";
                            $result1000 = mysqli_query($conn, $sql1000);
                            if($row1000 = mysqli_fetch_assoc($result1000)){
                            $update_query = "INSERT INTO account (username, password, ip) VALUES ('$tk', '$mk', '$ip_may')";
                                    mysqli_query($conn, $update_query);
                            echo '
						<script type="text/javascript">
						
						$(document).ready(function(){
						
						  swal({
								title: "Thành công",
								text: "Đăng kí thành công && tài khoản giới thiệu sẽ k đc cộng vì máy bạn có đk trc rồi!!",
								type: "success",
								confirmButtonText: "OK",
						  })
						});
						
						</script>
						';
                            }else{
                            $id_chu_gt = $_GET['ref'];
                            $sql1001 = "SELECT * FROM account WHERE id ='$id_chu_gt'";
                            $result1001 = mysqli_query($conn, $sql1001);
                            if($row1001 = mysqli_fetch_assoc($result1001)){
                            if($row1001['gioithieu'] == 3){
                                $update_query = "INSERT INTO account (username, password, ip) VALUES ('$tk', '$mk', '$ip_may')";
                                    mysqli_query($conn, $update_query);
                            echo '
						<script type="text/javascript">
						
						$(document).ready(function(){
						
						  swal({
								title: "Thành công",
								text: "Đăng kí thành công && tài khoản giới thiệu đang đủ điểm k thể công thêm!!",
								type: "success",
								confirmButtonText: "OK",
						  })
						});
						
						</script>
						';
                            }else{
                            $goithieu_new = $row1001['gioithieu'] + 1;
                            $update_query1 = "UPDATE account SET 
 gioithieu = '$gioithieu_new'
 WHERE id = '$id_chu_gt'";
 mysqli_query($conn, $update_query1);
                                $update_query = "INSERT INTO account (username, password, ip) VALUES ('$tk', '$mk', '$ip_may')";
                                    mysqli_query($conn, $update_query);
                            echo '
						<script type="text/javascript">
						
						$(document).ready(function(){
						
						  swal({
								title: "Thành công",
								text: "Đăng kí thành công && chủ giới thiệu đc cộng 1 điểm!!",
								type: "success",
								confirmButtonText: "OK",
						  })
						});
						
						</script>
						';
                            }
                            }else{
                                $update_query = "INSERT INTO account (username, password, ip) VALUES ('$tk', '$mk', '$ip_may')";
                                    mysqli_query($conn, $update_query);
                            echo '
						<script type="text/javascript">
						
						$(document).ready(function(){
						
						  swal({
								title: "Thành công",
								text: "Đăng kí thành công && mã giới thiệu không tồn tại!!",
								type: "success",
								confirmButtonText: "OK",
						  })
						});
						
						</script>
						';
                            }
                           
                            }
                            }else{
                            $update_query = "INSERT INTO account (username, password, ip_address) VALUES ('$tk', '$mk', '$ip_may')";
                                    mysqli_query($conn, $update_query);
                            echo '
						<script type="text/javascript">
						
						$(document).ready(function(){
						
						  swal({
								title: "Thành công",
								text: "Đăng kí thành công!!",
								type: "success",
								confirmButtonText: "OK",
						  })
						});
						
						</script>
						';
						}
                            }else{
                            echo'
<script type="text/javascript">
                
                $(document).ready(function(){
                
                  swal({
                        title: "Thất bại",
                        text: "Hai mật khẩu không giống nhau",
                        type: "error",
                        confirmButtonText: "OK",
                  })
                });
                
                </script>';
                            }
                            }
}else{
echo'
<script type="text/javascript">
                
                $(document).ready(function(){
                
                  swal({
                        title: "Thất bại",
                        text: "Thông tin captcha k chíng xác!",
                        type: "error",
                        confirmButtonText: "OK",
                  })
                });
                
                </script>';
}
}
?>
<script>
     title: 'Bạn có chắc chắn muốn đăng xuất?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Đồng ý',
            cancelButtonText: 'Đóng'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Thành công',
                    text: '',
                    icon: 'success',
                    timer: 1000,
                    showConfirmButton: false
                }
                ).then(() => {
                    window.location = 'logout.php'
                });
            }
        })
    }
</script>            <div class="p-1 mt-1 alert" style="border-radius alert-danger: 7px; box-shadow: 0px 0px 5px black;
    bs-alert-color: #842029;
--bs-alert-bg: 
#d8e37d66
;
   -bs-alert-border-color: #d51c2e;
}">
                <form class="text-center col-lg-5 col-md-10" style="margin: auto;"
                      method="post">
                    <h1 class="h3 mb-3 font-weight-normal" style="color: #000000">Đăng ký</h1>
                    <input style="height: 40px; border-radius: 15px; font-weight: bold;" name="username" required="" autofocus=""
                           type="text" class="form-control mt-1" placeholder="Tên tài khoản">
                    <span style="color: red; font-size: 12px; font-weight: bold;">
                                            </span>
                    <input style="height: 40px; border-radius: 15px; font-weight: bold;" name="password" required=""
                           type="password" class="form-control mt-1" placeholder="Mật khẩu">
                    <span style="color: red; font-size: 12px; font-weight: bold;">
                                            </span>
                    <input style="height: 40px; border-radius: 15px; font-weight: bold;" name="repassword" required=""
                           type="password" class="form-control mt-1" placeholder="Nhập lại mật khẩu">
                    <span style="color: red; font-size: 12px; font-weight: bold;">
                                            </span>
                    
                    
                    <div class="row">
                        <div class="col-7">
                            <input style="height: 40px; border-radius: 15px; font-weight: bold;"
                                   type="text" class="form-control mt-1" name="captcha"
                                   placeholder="Nhập kết quả captcha">
                        </div>
                        <div class="col-5" style="color: #000000">
                            <?php echo''.$_captcha.' + '.$_captcha2.'';?>
                        </div>
                    </div>
                    <span style="color: red; font-size: 12px; font-weight: bold;">
                                            </span>
 
      <?php echo$goi_thieu;?>    
                                                                              
                    <div class="text-center mt-1">
                    
                    
                    
                        <button class="btn btn-lg btn-dark btn-block" style="border-radius: 10px;width: 100%; height: 50px;"
                                type="submit" name="submit" value="<?php echo$tong_captcha;?>">Đăng ký</button>
                    </div>
                </form>
            </div>
            <!-- footer -->
<footer class="mt-1">
    
    
    <div class="text-center mt-1"
       <b style="color: #000000";font-size:13px" class="text-white">Tham gia cộng đồng giao lưu game với tớ.</b>
       <br>
       
   </div>
    
    </div>
</footer>        </div>
    </body>
</html>
