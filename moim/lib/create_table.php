<?php
  function create_table($conn, $table_name){

    $flag="NO";
    $sql = "show tables from moim";
    $result = mysqli_query($conn, $sql) or die('Error: ' . mysqli_error($conn));

    while ($row=mysqli_fetch_row($result)) {
      if($row[0]==="$table_name"){
        $flag="OK";
        break;
      }
    }
    if($flag=="NO"){
      switch ($table_name) {
        case 'membership':
          $sql = "CREATE TABLE `membership` (
          `num` int NOT NULL AUTO_INCREMENT,
          `id` varchar(10) NOT NULL,
          `name` varchar(10) NOT NULL,
          `passwd` varchar(20) NOT NULL,
          `phone` varchar(20) NOT NULL,
          `address` varchar(50) NOT NULL,
          `email` varchar(50) NOT NULL,
          `kakao_id` varchar(40),
          `google_id` varchar(40)
          PRIMARY KEY (`num`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
          break;
        case 'buy':
          $sql = "CREATE TABLE `buy` (
          `buy_num` int(11) NOT NULL AUTO_INCREMENT,
          `buy_id` varchar(10) NOT NULL,
          `buy_club_num` int(11) NOT NULL,
          PRIMARY KEY (`buy_num`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
          break;
        case 'cart':
          $sql = "CREATE TABLE `cart` (
          `cart_num` int(11) NOT NULL AUTO_INCREMENT,
          `cart_id` varchar(10) NOT NULL,
          `cart_club_num` int(11) NOT NULL,
          PRIMARY KEY (`cart_num`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
          break;
        case 'club':
          $sql = "CREATE TABLE `club` (
          `club_num` int(11) NOT NULL AUTO_INCREMENT,
          `club_id` varchar(10) NOT NULL,
          `club_name` varchar(10) NOT NULL,
          `club_content` text NOT NULL,
          `club_category` varchar(10) NOT NULL,
          `club_price` int(11) NOT NULL,
          `club_to` int(11) NOT NULL,
          `club_rent_info` varchar(50) NOT NULL,
          `club_start` date NOT NULL,
          `club_end` date NOT NULL,
          `club_apply` int(11) NOT NULL,
          `club_schedule` varchar(30) NOT NULL,
          `club_hit` int(11) NOT NULL,
          `club_open` varchar(10) NOT NULL,
          `club_image_name` varchar(50) DEFAULT NULL,
          `club_image_copied` varchar(50) DEFAULT NULL,
          `club_file_name` varchar(50) DEFAULT NULL,
          `club_file_copied` varchar(50) DEFAULT NULL,
          `club_file_type` varchar(50) DEFAULT NULL,
          PRIMARY KEY (`club_num`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
          break;
        case 'faq':
          $sql = "CREATE TABLE `faq` (
          `faq_num` int(11) NOT NULL AUTO_INCREMENT,
          `faq_question` varchar(300) NOT NULL,
          `faq_answer` varchar(300) NOT NULL,
          `faq_cetegory` varchar(10) NOT NULL,
          PRIMARY KEY (`faq_num`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
          break;
        case 'msg':
          $sql = "CREATE TABLE `msg` (
          `msg_num` int(11) NOT NULL AUTO_INCREMENT,
          `msg_name` varchar(45) NOT NULL,
          `send_id` varchar(45) NOT NULL,
          `receive_id` varchar(45) NOT NULL,
          `msg_content` text NOT NULL,
          `msg_date` varchar(45) NOT NULL,
          `msg_check` varchar(45) NOT NULL,
          PRIMARY KEY (`msg_num`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
          break;
        case 'notice':
          $sql = "CREATE TABLE `notice` (
          `notice_num` int(11) NOT NULL AUTO_INCREMENT,
          `notice_id` varchar(10) NOT NULL,
          `notice_subject` varchar(50) NOT NULL,
          `notice_content` text NOT NULL,
          `notice_date` date NOT NULL,
          `notice_hit` int(11) NOT NULL,
          `notice_file_name` varchar(50) DEFAULT NULL,
          `notice_file_copied` varchar(50) DEFAULT NULL,
          `notice_file_type` varchar(50) DEFAULT NULL,
          PRIMARY KEY (`notice_num`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
          break;
        case 'qna':
          $sql = "CREATE TABLE `qna` (
          `qna_num` int(11) NOT NULL AUTO_INCREMENT,
          `qna_id` varchar(10) NOT NULL,
          `qna_subject` varchar(50) NOT NULL,
          `qna_content` text NOT NULL,
          `qna_date` date NOT NULL,
          PRIMARY KEY (`qna_num`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
          break;
        case 'ripple':
          $sql = "CREATE TABLE `ripple` (
          `ripple_num` int(11) NOT NULL AUTO_INCREMENT,
          `ripple_id` varchar(10) NOT NULL,
          `ripple_gno` int(11) NOT NULL,
          `ripple_depth` int(11) NOT NULL,
          `ripple_ord` int(11) NOT NULL,
          `ripple_subject` varchar(50) NOT NULL,
          `ripple_content` text NOT NULL,
          `ripple_date` date NOT NULL,
          `parent_num` int NOT NULL,
          PRIMARY KEY (`ripple_num`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
          break;
        case 'user_club':
          $sql = "CREATE TABLE `user_club` (
          `user_num` int(11) NOT NULL AUTO_INCREMENT,
          `user_name` varchar(10) NOT NULL,
          `user_id` varchar(10) NOT NULL,
          `user_content` text NOT NULL,
          `user_category` varchar(10) NOT NULL,
          `user_to` int(11) NOT NULL,
          `user_rent_info` varchar(50) NOT NULL,
          `user_start` date NOT NULL,
          `user_end` date NOT NULL,
          `user_schedule` varchar(30) NOT NULL,
          `user_price` int(11) NOT NULL,
          `user_check` varchar(10) NOT NULL,
          `user_image_name` varchar(50) DEFAULT NULL,
          `user_image_copied` varchar(50) DEFAULT NULL,
          `user_file_name` varchar(50) DEFAULT NULL,
          `user_file_copied` varchar(50) DEFAULT NULL,
          `user_file_type` varchar(50) DEFAULT NULL,
          PRIMARY KEY (`user_num`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
          break;
          case 'club_ripple':
            $sql = "CREATE TABLE `club_ripple` (
            `c_ripple_num` int(11) NOT NULL AUTO_INCREMENT,
            `c_parent_num` int(11) NOT NULL,
            `c_buy_id` varchar(10) NOT NULL,
            `c_ripple_name` varchar(10) NOT NULL,
            `c_ripple_content` text NOT NULL,
            `c_ripple_date` date NOT NULL,
            PRIMARY KEY (`c_ripple_num`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
            break;
        default :
          echo "<script>alert('해당된 테이블 이름이 없습니다.');</script>";
          break;
      }
      if(mysqli_query($conn,$sql)){
        echo "<script>alert('$table_name 테이블이 생성되었습니다.');</script>";
      }else{
        echo "실패원인".mysqli_error($conn);
      }
    }
  }

 ?>
