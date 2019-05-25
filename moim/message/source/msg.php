<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."./moim/lib/db_connector.php";
include $_SERVER['DOCUMENT_ROOT']."/moimw/lib/create_table.php";
if(!isset($_SESSION['userid'])){
  echo "<script>alert('권한이 없습니다');
  window.close();
  </script>";
  exit;
}
$id = $_SESSION['userid'];
$name = $_SESSION['username'];
$mode = "receive";

if(isset($_GET['mode'])){
    $mode = $_GET['mode'];
}

 ?>
 <!DOCTYPE html>
 <html lang="ko" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>메세지</title>
     <?php
    if($mode == "receive"){
        $sql = "select * from msg where receive_id = '$id' order by msg_num desc";
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        $total_record = mysqli_num_rows($result); //전체 레코드 수
    }else{
        $sql = "select * from msg where send_id = '$id' order by msg_num desc";
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        $total_record = mysqli_num_rows($result); //전체 레코드 수
    }
    // 페이지 당 글수, 블럭당 페이지 수
    $rows_scale=3;
    $pages_scale=5;
    // 전체 페이지 수 ($total_page) 계산
    $total_pages= ceil($total_record/$rows_scale);
    if(empty($_GET['page'])){
        $page=1;
    }else{
        $page = $_GET['page'];
    }
    // 현재 페이지 시작 위치 = (페이지 당 글 수 * (현재페이지 -1))  [[ EX) 현재 페이지 2일 때 => 3*(2-1) = 3 ]]
    $start_row= $rows_scale * ($page -1) ;
    // 이전 페이지 = 현재 페이지가 1일 경우. null값.
    $pre_page= $page>1 ? $page-1 : NULL;
    // 다음 페이지 = 현재페이지가 전체페이지 수와 같을 때  null값.
    $next_page= $page < $total_pages ? $page+1 : NULL;
    // 현재 블럭의 시작 페이지 = (ceil(현재페이지/블럭당 페이지 제한 수)-1) * 블럭당 페이지 제한 수 +1  [[  EX) 현재 페이지 5일 때 => ceil(5/3)-1 * 3  +1 =  (2-1)*3 +1 = 4 ]]
    $start_page= (ceil($page / $pages_scale ) -1 ) * $pages_scale +1 ;
    // 현재 블럭 마지막 페이지
    $end_page= ($total_pages >= ($start_page + $pages_scale)) ? $start_page + $pages_scale-1 : $total_pages;

    //리스트에 보여줄 번호
    $number=$total_record- $start_row;
?>
     <script type="text/javascript">
     function msg_form(){
       var popupX = (window.screen.width/2)-(600/2);
       var popupY = (window.screen.height/2)-(400/2);
       window.open('./msg_form.php','','left='+popupX+',top='+popupY+', width=500, height=400, status=no, scrollbars=no');
     }
     function chat_view(url){
       var popupX = (window.screen.width/2)-(600/2);
       var popupY = (window.screen.height/2)-(400/2);
       window.open(url,'','left='+popupX+',top='+popupY+', width=500, height=400, status=no, scrollbars=no');
     }
     function msg_close(){
       window.close();
       window.opener.location.reload(true);
     }
     </script>
   </head>
   <body>
     <header>
      <b style="">message</b><a href="./msg.php?mode=receive">받은메세지</a>ㅣ<a href="./msg.php?mode=send">보낸메세지</a>
     </header>
     <hr>
     <?php
           for($i=$start_row; ($i<$start_row+$rows_scale) && ($i< $total_record); $i++){
             //가져올 레코드 위치 이동
             mysqli_data_seek($result, $i);
             //하나 레코드 가져오기
             $row=mysqli_fetch_array($result);
             $msg_num=$row["msg_num"];//오토인크리먼트
             $msg_name=$row["msg_name"];//보내는사람이름
             $send_id=$row["send_id"];//보내는이 아이디
             $receive_id=$row["receive_id"];//받는이 아이디
             $msg_content=$row["msg_content"];//내용
             $msg_date=$row["msg_date"];//날짜
             $msg_check=$row["msg_check"];//읽음여부
             $msg_date=substr($msg_date,0,10);//시간떼고 날짜만 ex)2019-05-15
      ?>
     <div id="list1"><!-- 리스트 -->
       <!-- 여기에 모드=수신 송신 읽음 안읽음 나누어서 넣기 -->
       <?php
       if($mode == "receive"){
              if($msg_check == "N"){
                  ?>
          		<div id="list2"><b><?=$msg_name."님"?></b>&nbsp<b><?="( ".$send_id." ) 에게 받은 메세지 "?></b>&nbsp</a></div>
          		<div id="list2"><a id="messageLink" href="#" onclick="chat_view('msg_view.php?msg_num=<?=$msg_num ?>')"><b><?=$msg_content?></b></a></div>
          		<div id="list_item4"><b><?=$msg_date?> 안읽음</b></div>
          		<?php
          	    }else{
          	    ?>
          		<div id="list2"><?=$msg_name."님"?>&nbsp<?="( ".$send_id." ) 에게 받은  메세지 "?>&nbsp</a></div>
          		<div id="list2"><a id="messageLink" href="#" onclick="chat_view('msg_view.php?msg_num=<?=$msg_num ?>')" style="text-decoration: none; color: black;"><?=$msg_content?></a></div>
          		<div id="list_item4"><?=$msg_date?> 읽음 </div>
         		<?php
               }
           }else{
              if($msg_check == "N"){
                  ?>
          		<div id="list2"><?=$receive_id."님"?>에게 보낸 메세지&nbsp</a></div>
          		<div id="list2"><a id="messageLink" href="#" onclick="chat_view('msg_view.php?msg_num=<?=$msg_num ?>')" style="text-decoration: none; color: black;"><?=$msg_content?></a></div>
          		<div id="list_item4"><?=$msg_date?></div>
          		<?php
          	    }else{
          	    ?>
          		<div id="list2"><?=$receive_id."님"?>에게 보낸 메세지 &nbsp</a></div>
          		<div id="list2"><a id="messageLink" href="#" onclick="chat_view('msg_view.php?msg_num=<?=$msg_num ?>')"><?=$msg_content?></a></div>
          		<div id="list_item4"><?=$msg_date?></div>
         		<?php
               }
       }?>
     </div>
     <hr>
     <?php
   }
   ?>

     <div class="page_box"><!-- 페이지 표시하는곳 -->
       <!-- 페이지 표시하는 곳 표기 -->
       <?PHP
         #----------------이전블럭 존재시 링크------------------#
         if($start_page > $pages_scale){
            $go_page= $start_page - $pages_scale;
            echo "<a id='before_block' href='msg.php?mode=$mode&page=$go_page'> << </a>";
         }
         #----------------이전페이지 존재시 링크------------------#
         if($pre_page){
             echo "<a id='before_page' href='msg.php?mode=$mode&page=$pre_page'> < </a>";
         }
          #--------------바로이동하는 페이지를 나열---------------#
         for($dest_page=$start_page;$dest_page <= $end_page;$dest_page++){
            if($dest_page == $page){
                 echo( "&nbsp;<b id='present_page'>$dest_page </b>&nbsp" );
             }else{
                 echo "<a id='move_page' href='msg.php?mode=$mode&page=$dest_page '>$dest_page </a>";
             }
          }
          #----------------이전페이지 존재시 링크------------------#
          if($next_page){
              echo "<a id='next_page' href='msg.php?mode=$mode&page=$next_page'> > </a>";
          }
          #---------------다음페이지를 링크------------------#
         if($total_pages >= $start_page+ $pages_scale){
           $go_page= $start_page+ $pages_scale;
           echo "<a id='next_block' href='msg.php?mode=$mode&page=$go_page'> >> </a>";
          }
        ?>
     </div>
     <div class="downside">
       <?php
        if(isset($id)){
        ?>
         <a href="#" onclick="msg_form()">메세지 보내기</a>
         <a href="#" onclick="msg_close()">닫기</a>
      </div>
      <?php
      }
      ?>
     </body>
   </body>
 </html>
