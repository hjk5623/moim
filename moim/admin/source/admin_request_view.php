<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."./moim/lib/db_connector.php";

if(isset($_GET["user_num"]) && !empty($_GET["user_num"])){

    if(empty($_GET['page'])){
        $page=1;
    }else{
        $page = $_GET['page'];
    }

    $user_num = test_input($_GET["user_num"]);

    $sql="SELECT * from `user_club` where user_num='$user_num';";

    $result = mysqli_query($conn,$sql);
    if (!$result) {
      die('Error: ' . mysqli_error($conn));
    }
    $row = mysqli_fetch_array($result);

    $user_name=$row['user_name'];
    $user_content=$row['user_content'];
    $user_intro=$row['user_intro'];
    $user_content=html_entity_decode($user_content);
    $user_image_name=$row['user_image_name'];
    $user_image_copied=$row['user_image_copied'];

    $user_file_name=$row['user_file_name'];
    $user_file_copied=$row['user_file_copied'];
    $user_file_type=$row['user_file_type'];

    if(isset($user_image_copied)){
      $image_info = getimagesize("../../mypage/data/".$user_image_copied);
      $image_width = $image_info[0];
      $image_height = $image_info[1];
      $image_type = $image_info[2];
      if($image_width>500) $image_width="500";
    }else{
      $image_width = "";
      $image_height = "";
      $image_type = "";
    }
}
?>
 <!DOCTYPE html>
 <html lang="ko" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title></title>
     <link rel="stylesheet" href="../css/admin_request_view.css">
   </head>
   <body>
     <?php
     include $_SERVER['DOCUMENT_ROOT']."/moim/admin/source/admin.php";
     ?>
     <div class="requst_div">
      <h2>신청모임관리</h2>
      <hr class="memberlist_hr">
       <table class="request_table">
         <tr>
           <td>모임이름</td>
           <td colspan="2"><?=$user_name?></td>
         </tr>
         <tr>
           <td>첨부파일</td>
           <?php
            $file_path = "../../mypage/data/".$user_file_copied;
            $file_size = filesize($file_path);
            ?>
            <td>
            <img src="../img/attach_file.png" alt="" width="18px" height="15px;">첨부파일 : <?=$user_file_name?> (<?=$file_size?> Byte)&nbsp;&nbsp;&nbsp;
                 <a href='download.php?mode=download&user_num=<?=$user_num?>'>[저장]</a>
           </td>
         </tr>
         <tr>
           <td>모임대표이미지</td>
           <td colspan="2">
             <img src="../../mypage/data/<?=$user_image_copied?>" width="<?=$image_width?>">
           </td>
         </tr>
         <tr>
           <td>간단소개</td>
           <td colspan="2">
            <?=$user_intro?>
           </td>
         </tr>
         <tr>
           <td colspan="2">
            내&nbsp;&nbsp;&nbsp;&nbsp;용
           </td>
         </tr>
         <tr>
           <td colspan="2">
             <br>
                <?=$user_content?>
           </td>
         </tr>
         <tr>
           <td colspan="2" style="text-align:right">
             <a href="./admin_request_list.php?page=<?=$page?>"><button type="button" name="button">list</button></a>
           </td>
         </tr>
        </table>
      </div><!--end of div class="requst_div" -->
      </div><!--wrap -->
   </body>
 </html>
