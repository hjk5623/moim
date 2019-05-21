<?php
// 위지윅에디터이용으로 이 페이지는 이제 사용하지 않을 예쩡 혹시몰라 안지우고 살려둠..

session_start();
?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css" />
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script src="//code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>
  <script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
  <style media="screen">
      table {
        margin: 0 auto;
      }
      #submit_btn{
        text-align: center;
      }
      .ui-datepicker{ font-size: 13px; width: 250px; }
      .ui-datepicker select.ui-datepicker-month{ width:30%; font-size: 12px; }
      .ui-datepicker select.ui-datepicker-year{ width:40%; font-size: 12px; }
  </style>
  <script type="text/javascript">
    //datepocler의 옵션을 설정
    $.datepicker.setDefaults({
      dateFormat: 'yy-mm-dd',
      prevText: '이전 달',
      nextText: '다음 달',
      monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
      dayNames: ['일', '월', '화', '수', '목', '금', '토'], //달력의 요일 부분 텍스트
      dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'], //달력의 요일 부분 Toottip 텍스트
      showMonthAfterYear: true, //년도 먼저 나오고, 뒤에 월 표시
      yearSuffix: '년' //달력의 년도 부분 뒤에 붙는 텍스트
    });
    // 출발일 입력칸은 input 태그의 text 타입이지만 이곳을 클릭하면 datepicker가 작동된다.
    //$("#datepicker1 , #datepicker2").datepicker 라고 input 객체를 datepicker 로 사용하겠다고 선언되어있기때문에
    $(function() {
      $("#datepicker1 , #datepicker2").datepicker({
        minDate: 0 //오늘부터 선택
      });
    });
    //주소 API
    function execDaumPostcode() {/* 폼은 다음 주소찾기 빌리면서 입력값은 여기서 받고 처리하네?  */
        new daum.Postcode({
            oncomplete: function(data) {
                // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                var fullAddr = ''; // 최종 주소 변수
                var extraAddr = ''; // 조합형 주소 변수

                // 사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                    fullAddr = data.roadAddress;

                } else { // 사용자가 지번 주소를 선택했을 경우(J)
                    fullAddr = data.jibunAddress;
                }

                // 사용자가 선택한 주소가 도로명 타입일때 조합한다.
                if(data.userSelectedType === 'R'){
                    //법정동명이 있을 경우 추가한다.
                    if(data.bname !== ''){
                        extraAddr += data.bname;
                    }
                    // 건물명이 있을 경우 추가한다.
                    if(data.buildingName !== ''){
                        extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                    }
                    // 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
                    fullAddr += (extraAddr !== '' ? ' ('+ extraAddr +')' : '');
                }

                // 우편번호와 주소 정보를 해당 필드에 넣는다.
                // document.getElementById('address2').value = data.zonecode; //5자리 새우편번호 사용
                document.getElementById('address1').value = fullAddr;

                // 커서를 상세주소 필드로 이동한다.
                document.getElementById('address2').value ="";
                document.getElementById('address2').focus();
            }
        }).open();
    }
  </script>
  <!--다음오픈에디터-->
  <link rel="stylesheet" href="css/editor.css" type="text/css" charset="utf-8" />
  <script src="js/editor_loader.js" type="text/javascript" charset="utf-8"></script>
  <!--다음오픈에디터-->
  <title></title>
</head>

<body>
  <?php
  include $_SERVER['DOCUMENT_ROOT']."/moim/admin/source/admin.php";
  ?>
  <div id="col2">
    <p id="board_title_p">&nbsp;&nbsp;</p>
    <div id="board_title_div">
    </div>
    <!--end of title -->
    <div class="clear"></div>
    <div id="write_form_title">
    </div>
    <!--end of write_form_title -->
    <div class="clear"></div>
    <div class="body">
      <!-- 에디터 시작 -->
      <!--
          @decsription
          등록하기 위한 Form으로 상황에 맞게 수정하여 사용한다. Form 이름은 에디터를 생성할 때 설정값으로 설정한다.
         -->
      <form name="tx_editor_form" id="tx_editor_form" action="./admin_query.php?mode=clubinsert" method="post" enctype="multipart/form-data" accept-charset="utf-8">
        <div id="write_form"  style="margin-top:100px; margin-bottom:100px;">
          <!--모임이름, 모집정원, 모집시작일 ,모집종료일, 가격  -->
        <table border="1">
          <tr>
          <td>모임이름</td>
            <td colspan="2"><input type="text" name="club_name" value=""> </td>
          </tr>
          <tr>
            <td id="write_td">카테고리</td>
            <td colspan="2">
              <select name="club_category" id="club_category">
                 <option>선택</option>
                 <option value="글쓰기">글쓰기</option>
                 <option value="요리">요리</option>
                 <option value="영화">영화</option>
                 <option value="미술">미술</option>
                 <option value="사진">사진</option>
                 <option value="디자인">디자인</option>
              </select>
            </td>
          </tr>
          <tr>
            <td id="write_td">모임장소</td>
            <td><input id="address1" type="text" name="club_rent_info1" value="" onclick="execDaumPostcode()" size="45" placeholder="주소"></td>
            <td><input id="address2" type="text" name="club_rent_info2" value="" placeholder="상세주소"></td>
          </tr>
          <tr>
            <td id="write_td">모집정원</td>
            <td colspan="2"><input type="number" name="club_to" value=""></td>
          </tr>
          <tr>
            <td>모집시작일</td>
            <td colspan="2"><input type="text" name="club_start" value="" id="datepicker1"></td>
          </tr>
          <tr>
            <td>모집종료일</td>
            <td colspan="2"><input type="text" name="club_end" value="" id="datepicker2"></td>
          </tr>
          <tr>
            <td>가격</td>
            <td colspan="2"><input type="number" name="club_price" value=""></td>
          </tr>
          <tr>
            <td>수업일정</td>
            <td colspan="2"><input type="text" name="club_schedule" value=""></td>
          </tr>
          <tr>
            <td>사진 [gif,jpeg,png파일만 등록]</td>
            <td colspan="2"><input type="file" name="upimage" value="" accept="image/gif,image/jpeg,image/png"></td>
          </tr>
          <tr>
            <td>모임세부사항 [첨부파일]</td>
            <td colspan="2">
              <?php
              if($mode=="update"  && !empty($file_name_0)){
                echo "$file_name_0 파일이 등록되어 있습니다.";
                echo '<input type="checkbox" name="del_file" value="1" id="del_file">삭제';
                echo '<div class="clear"></div>';
              }else{
                echo "<input type='file' name='upfile' value=''>";

              }
            ?>

            </td>
          </tr>
          <tr>
            <td colspan="3" style="text-align:left">내용</td>
          </tr>
          <tr>
            <td colspan="3">
                      <!-- 에디터 컨테이너 시작 -->
                      <div id="tx_trex_container" class="tx-editor-container">
                        <!-- 사이드바 -->
                        <div id="tx_sidebar" class="tx-sidebar">
                          <div class="tx-sidebar-boundary">
                            <!-- 사이드바 / 첨부 -->
                            <ul class="tx-bar tx-bar-left tx-nav-attach">
                              <!-- 이미지 첨부 버튼 시작 -->
                              <!--
                                      @decsription
                                     <li></li> 단위로 위치를 이동할 수 있다.
                                -->
                              <li class="tx-list">
                                <div unselectable="on" id="tx_image" class="tx-image tx-btn-trans">
                                  <a href="javascript:;" title="사진" class="tx-text">사진</a>
                                </div>
                              </li>
                              <!-- 이미지 첨부 버튼 끝 -->
                              <li class="tx-list">
                                <div unselectable="on" id="tx_file" class="tx-file tx-btn-trans">
                                  <a href="javascript:;" title="파일" class="tx-text">파일</a>
                                </div>
                              </li>
                              <li class="tx-list">
                                <div unselectable="on" id="tx_media" class="tx-media tx-btn-trans">
                                  <a href="javascript:;" title="외부컨텐츠" class="tx-text">외부컨텐츠</a>
                                </div>
                              </li>
                              <li class="tx-list tx-list-extra">
                                <div unselectable="on" class="tx-btn-nlrbg tx-extra">
                                  <a href="javascript:;" class="tx-icon" title="버튼 더보기">버튼 더보기</a>
                                </div>
                                <ul class="tx-extra-menu tx-menu" style="left:-48px;" unselectable="on">
                                  <!--
                                         @decsription
                                         일부 버튼들을 빼서 레이어로 숨기는 기능을 원할 경우 이 곳으로 이동시킬 수 있다.
                                      -->
                                </ul>
                              </li>
                            </ul>
                            <!-- 사이드바 / 우측영역 -->
                            <ul class="tx-bar tx-bar-right">
                              <li class="tx-list">
                                <div unselectable="on" class="tx-btn-lrbg tx-fullscreen" id="tx_fullscreen">
                                  <a href="javascript:;" class="tx-icon" title="넓게쓰기 (Ctrl+M)">넓게쓰기</a>
                                </div>
                              </li>
                            </ul>
                            <ul class="tx-bar tx-bar-right tx-nav-opt">
                              <li class="tx-list">
                                <div unselectable="on" class="tx-switchtoggle" id="tx_switchertoggle">
                                  <a href="javascript:;" title="에디터 타입">에디터</a>
                                </div>
                              </li>
                            </ul>
                          </div>
                        </div>

                        <!-- 툴바 - 기본 시작 -->
                        <!--
                        @decsription
                            툴바 버튼의 그룹핑의 변경이 필요할 때는 위치(왼쪽, 가운데, 오른쪽) 에 따라 <li> 아래의 <div>의 클래스명을 변경하면 된다.
                            tx-btn-lbg: 왼쪽, tx-btn-bg: 가운데, tx-btn-rbg: 오른쪽, tx-btn-lrbg: 독립적인 그룹

                            드롭다운 버튼의 크기를 변경하고자 할 경우에는 넓이에 따라 <li> 아래의 <div>의 클래스명을 변경하면 된다.
                            tx-slt-70bg, tx-slt-59bg, tx-slt-42bg, tx-btn-43lrbg, tx-btn-52lrbg, tx-btn-57lrbg, tx-btn-71lrbg
                            tx-btn-48lbg, tx-btn-48rbg, tx-btn-30lrbg, tx-btn-46lrbg, tx-btn-67lrbg, tx-btn-49lbg, tx-btn-58bg, tx-btn-46bg, tx-btn-49rbg
                            -->
                        <div id="tx_toolbar_basic" class="tx-toolbar tx-toolbar-basic">
                          <div class="tx-toolbar-boundary">
                            <ul class="tx-bar tx-bar-left">
                              <li class="tx-list">
                                <div id="tx_fontfamily" unselectable="on" class="tx-slt-70bg tx-fontfamily">
                                  <a href="javascript:;" title="글꼴">굴림</a>
                                </div>
                                <div id="tx_fontfamily_menu" class="tx-fontfamily-menu tx-menu" unselectable="on"></div>
                              </li>
                            </ul>
                            <ul class="tx-bar tx-bar-left">
                              <li class="tx-list">
                                <div unselectable="on" class="tx-slt-42bg tx-fontsize" id="tx_fontsize">
                                  <a href="javascript:;" title="글자크기">9pt</a>
                                </div>
                                <div id="tx_fontsize_menu" class="tx-fontsize-menu tx-menu" unselectable="on"></div>
                              </li>
                            </ul>
                            <ul class="tx-bar tx-bar-left tx-group-font">

                              <li class="tx-list">
                                <div unselectable="on" class="       tx-btn-lbg    tx-bold" id="tx_bold">
                                  <a href="javascript:;" class="tx-icon" title="굵게 (Ctrl+B)">굵게</a>
                                </div>
                              </li>
                              <li class="tx-list">
                                <div unselectable="on" class="       tx-btn-bg    tx-underline" id="tx_underline">
                                  <a href="javascript:;" class="tx-icon" title="밑줄 (Ctrl+U)">밑줄</a>
                                </div>
                              </li>
                              <li class="tx-list">
                                <div unselectable="on" class="       tx-btn-bg    tx-italic" id="tx_italic">
                                  <a href="javascript:;" class="tx-icon" title="기울임 (Ctrl+I)">기울임</a>
                                </div>
                              </li>
                              <li class="tx-list">
                                <div unselectable="on" class="       tx-btn-bg    tx-strike" id="tx_strike">
                                  <a href="javascript:;" class="tx-icon" title="취소선 (Ctrl+D)">취소선</a>
                                </div>
                              </li>
                              <li class="tx-list">
                                <div unselectable="on" class="       tx-slt-tbg    tx-forecolor" id="tx_forecolor">
                                  <a href="javascript:;" class="tx-icon" title="글자색">글자색</a>
                                  <a href="javascript:;" class="tx-arrow" title="글자색 선택">글자색 선택</a>
                                </div>
                                <div id="tx_forecolor_menu" class="tx-menu tx-forecolor-menu tx-colorpallete" unselectable="on"></div>
                              </li>
                              <li class="tx-list">
                                <div unselectable="on" class="       tx-slt-brbg    tx-backcolor" id="tx_backcolor">
                                  <a href="javascript:;" class="tx-icon" title="글자 배경색">글자 배경색</a>
                                  <a href="javascript:;" class="tx-arrow" title="글자 배경색 선택">글자 배경색 선택</a>
                                </div>
                                <div id="tx_backcolor_menu" class="tx-menu tx-backcolor-menu tx-colorpallete" unselectable="on"></div>
                              </li>
                            </ul>
                            <ul class="tx-bar tx-bar-left tx-group-align">
                              <li class="tx-list">
                                <div unselectable="on" class="       tx-btn-lbg    tx-alignleft" id="tx_alignleft">
                                  <a href="javascript:;" class="tx-icon" title="왼쪽정렬 (Ctrl+,)">왼쪽정렬</a>
                                </div>
                              </li>
                              <li class="tx-list">
                                <div unselectable="on" class="       tx-btn-bg    tx-aligncenter" id="tx_aligncenter">
                                  <a href="javascript:;" class="tx-icon" title="가운데정렬 (Ctrl+.)">가운데정렬</a>
                                </div>
                              </li>
                              <li class="tx-list">
                                <div unselectable="on" class="       tx-btn-bg    tx-alignright" id="tx_alignright">
                                  <a href="javascript:;" class="tx-icon" title="오른쪽정렬 (Ctrl+/)">오른쪽정렬</a>
                                </div>
                              </li>
                              <li class="tx-list">
                                <div unselectable="on" class="       tx-btn-rbg    tx-alignfull" id="tx_alignfull">
                                  <a href="javascript:;" class="tx-icon" title="양쪽정렬">양쪽정렬</a>
                                </div>
                              </li>
                            </ul>
                            <ul class="tx-bar tx-bar-left tx-group-tab">
                              <li class="tx-list">
                                <div unselectable="on" class="       tx-btn-lbg    tx-indent" id="tx_indent">
                                  <a href="javascript:;" title="들여쓰기 (Tab)" class="tx-icon">들여쓰기</a>
                                </div>
                              </li>
                              <li class="tx-list">
                                <div unselectable="on" class="       tx-btn-rbg    tx-outdent" id="tx_outdent">
                                  <a href="javascript:;" title="내어쓰기 (Shift+Tab)" class="tx-icon">내어쓰기</a>
                                </div>
                              </li>
                            </ul>
                            <ul class="tx-bar tx-bar-left tx-group-list">
                              <li class="tx-list">
                                <div unselectable="on" class="tx-slt-31lbg tx-lineheight" id="tx_lineheight">
                                  <a href="javascript:;" class="tx-icon" title="줄간격">줄간격</a>
                                  <a href="javascript:;" class="tx-arrow" title="줄간격">줄간격 선택</a>
                                </div>
                                <div id="tx_lineheight_menu" class="tx-lineheight-menu tx-menu" unselectable="on"></div>
                              </li>
                              <li class="tx-list">
                                <div unselectable="on" class="tx-slt-31rbg tx-styledlist" id="tx_styledlist">
                                  <a href="javascript:;" class="tx-icon" title="리스트">리스트</a>
                                  <a href="javascript:;" class="tx-arrow" title="리스트">리스트 선택</a>
                                </div>
                                <div id="tx_styledlist_menu" class="tx-styledlist-menu tx-menu" unselectable="on"></div>
                              </li>
                            </ul>
                            <ul class="tx-bar tx-bar-left tx-group-etc">
                              <li class="tx-list">
                                <div unselectable="on" class="       tx-btn-lbg    tx-emoticon" id="tx_emoticon">
                                  <a href="javascript:;" class="tx-icon" title="이모티콘">이모티콘</a>
                                </div>
                                <div id="tx_emoticon_menu" class="tx-emoticon-menu tx-menu" unselectable="on"></div>
                              </li>
                              <li class="tx-list">
                                <div unselectable="on" class="       tx-btn-bg    tx-link" id="tx_link">
                                  <a href="javascript:;" class="tx-icon" title="링크 (Ctrl+K)">링크</a>
                                </div>
                                <div id="tx_link_menu" class="tx-link-menu tx-menu"></div>
                              </li>
                              <li class="tx-list">
                                <div unselectable="on" class="       tx-btn-bg    tx-specialchar" id="tx_specialchar">
                                  <a href="javascript:;" class="tx-icon" title="특수문자">특수문자</a>
                                </div>
                                <div id="tx_specialchar_menu" class="tx-specialchar-menu tx-menu"></div>
                              </li>
                              <li class="tx-list">
                                <div unselectable="on" class="       tx-btn-bg    tx-table" id="tx_table">
                                  <a href="javascript:;" class="tx-icon" title="표만들기">표만들기</a>
                                </div>
                                <div id="tx_table_menu" class="tx-table-menu tx-menu" unselectable="on">
                                  <div class="tx-menu-inner">
                                    <div class="tx-menu-preview"></div>
                                    <div class="tx-menu-rowcol"></div>
                                    <div class="tx-menu-deco"></div>
                                    <div class="tx-menu-enter"></div>
                                  </div>
                                </div>
                              </li>
                              <li class="tx-list">
                                <div unselectable="on" class="       tx-btn-rbg    tx-horizontalrule" id="tx_horizontalrule">
                                  <a href="javascript:;" class="tx-icon" title="구분선">구분선</a>
                                </div>
                                <div id="tx_horizontalrule_menu" class="tx-horizontalrule-menu tx-menu" unselectable="on"></div>
                              </li>
                            </ul>
                            <ul class="tx-bar tx-bar-left">
                              <li class="tx-list">
                                <div unselectable="on" class="       tx-btn-lbg    tx-richtextbox" id="tx_richtextbox">
                                  <a href="javascript:;" class="tx-icon" title="글상자">글상자</a>
                                </div>
                                <div id="tx_richtextbox_menu" class="tx-richtextbox-menu tx-menu">
                                  <div class="tx-menu-header">
                                    <div class="tx-menu-preview-area">
                                      <div class="tx-menu-preview"></div>
                                    </div>
                                    <div class="tx-menu-switch">
                                      <div class="tx-menu-simple tx-selected"><a><span>간단 선택</span></a></div>
                                      <div class="tx-menu-advanced"><a><span>직접 선택</span></a></div>
                                    </div>
                                  </div>
                                  <div class="tx-menu-inner">
                                  </div>
                                  <div class="tx-menu-footer">
                                    <img class="tx-menu-confirm" src="./images/icon/editor/btn_confirm.gif?rv=1.0.1" alt="" />
                                    <img class="tx-menu-cancel" hspace="3" src="./images/icon/editor/btn_cancel.gif?rv=1.0.1" alt="" />
                                  </div>
                                </div>
                              </li>
                              <li class="tx-list">
                                <div unselectable="on" class="       tx-btn-bg    tx-quote" id="tx_quote">
                                  <a href="javascript:;" class="tx-icon" title="인용구 (Ctrl+Q)">인용구</a>
                                </div>
                                <div id="tx_quote_menu" class="tx-quote-menu tx-menu" unselectable="on"></div>
                              </li>
                              <li class="tx-list">
                                <div unselectable="on" class="       tx-btn-bg    tx-background" id="tx_background">
                                  <a href="javascript:;" class="tx-icon" title="배경색">배경색</a>
                                </div>
                                <div id="tx_background_menu" class="tx-menu tx-background-menu tx-colorpallete" unselectable="on"></div>
                              </li>
                              <li class="tx-list">
                                <div unselectable="on" class="       tx-btn-rbg    tx-dictionary" id="tx_dictionary">
                                  <a href="javascript:;" class="tx-icon" title="사전">사전</a>
                                </div>
                              </li>
                            </ul>
                            <ul class="tx-bar tx-bar-left tx-group-undo">
                              <li class="tx-list">
                                <div unselectable="on" class="       tx-btn-lbg    tx-undo" id="tx_undo">
                                  <a href="javascript:;" class="tx-icon" title="실행취소 (Ctrl+Z)">실행취소</a>
                                </div>
                              </li>
                              <li class="tx-list">
                                <div unselectable="on" class="       tx-btn-rbg    tx-redo" id="tx_redo">
                                  <a href="javascript:;" class="tx-icon" title="다시실행 (Ctrl+Y)">다시실행</a>
                                </div>
                              </li>
                            </ul>
                            <ul class="tx-bar tx-bar-right">
                              <li class="tx-list">
                                <div unselectable="on" class="tx-btn-nlrbg tx-advanced" id="tx_advanced">
                                  <a href="javascript:;" class="tx-icon" title="툴바 더보기">툴바 더보기</a>
                                </div>
                              </li>
                            </ul>
                          </div>
                        </div>
                        <!-- 툴바 - 기본 끝 -->
                        <!-- 툴바 - 더보기 시작 -->
                        <div id="tx_toolbar_advanced" class="tx-toolbar tx-toolbar-advanced">
                          <div class="tx-toolbar-boundary">
                            <ul class="tx-bar tx-bar-left">
                              <li class="tx-list">
                                <div class="tx-tableedit-title"></div>
                              </li>
                            </ul>

                            <ul class="tx-bar tx-bar-left tx-group-align">
                              <li class="tx-list">
                                <div unselectable="on" class="tx-btn-lbg tx-mergecells" id="tx_mergecells">
                                  <a href="javascript:;" class="tx-icon2" title="병합">병합</a>
                                </div>
                                <div id="tx_mergecells_menu" class="tx-mergecells-menu tx-menu" unselectable="on"></div>
                              </li>
                              <li class="tx-list">
                                <div unselectable="on" class="tx-btn-bg tx-insertcells" id="tx_insertcells">
                                  <a href="javascript:;" class="tx-icon2" title="삽입">삽입</a>
                                </div>
                                <div id="tx_insertcells_menu" class="tx-insertcells-menu tx-menu" unselectable="on"></div>
                              </li>
                              <li class="tx-list">
                                <div unselectable="on" class="tx-btn-rbg tx-deletecells" id="tx_deletecells">
                                  <a href="javascript:;" class="tx-icon2" title="삭제">삭제</a>
                                </div>
                                <div id="tx_deletecells_menu" class="tx-deletecells-menu tx-menu" unselectable="on"></div>
                              </li>
                            </ul>

                            <ul class="tx-bar tx-bar-left tx-group-align">
                              <li class="tx-list">
                                <div id="tx_cellslinepreview" unselectable="on" class="tx-slt-70lbg tx-cellslinepreview">
                                  <a href="javascript:;" title="선 미리보기"></a>
                                </div>
                                <div id="tx_cellslinepreview_menu" class="tx-cellslinepreview-menu tx-menu" unselectable="on"></div>
                              </li>
                              <li class="tx-list">
                                <div id="tx_cellslinecolor" unselectable="on" class="tx-slt-tbg tx-cellslinecolor">
                                  <a href="javascript:;" class="tx-icon2" title="선색">선색</a>

                                  <div class="tx-colorpallete" unselectable="on"></div>
                                </div>
                                <div id="tx_cellslinecolor_menu" class="tx-cellslinecolor-menu tx-menu tx-colorpallete" unselectable="on"></div>
                              </li>
                              <li class="tx-list">
                                <div id="tx_cellslineheight" unselectable="on" class="tx-btn-bg tx-cellslineheight">
                                  <a href="javascript:;" class="tx-icon2" title="두께">두께</a>

                                </div>
                                <div id="tx_cellslineheight_menu" class="tx-cellslineheight-menu tx-menu" unselectable="on"></div>
                              </li>
                              <li class="tx-list">
                                <div id="tx_cellslinestyle" unselectable="on" class="tx-btn-bg tx-cellslinestyle">
                                  <a href="javascript:;" class="tx-icon2" title="스타일">스타일</a>
                                </div>
                                <div id="tx_cellslinestyle_menu" class="tx-cellslinestyle-menu tx-menu" unselectable="on"></div>
                              </li>
                              <li class="tx-list">
                                <div id="tx_cellsoutline" unselectable="on" class="tx-btn-rbg tx-cellsoutline">
                                  <a href="javascript:;" class="tx-icon2" title="테두리">테두리</a>

                                </div>
                                <div id="tx_cellsoutline_menu" class="tx-cellsoutline-menu tx-menu" unselectable="on"></div>
                              </li>
                            </ul>
                            <ul class="tx-bar tx-bar-left">
                              <li class="tx-list">
                                <div id="tx_tablebackcolor" unselectable="on" class="tx-btn-lrbg tx-tablebackcolor" style="background-color:#9aa5ea;">
                                  <a href="javascript:;" class="tx-icon2" title="테이블 배경색">테이블 배경색</a>
                                </div>
                                <div id="tx_tablebackcolor_menu" class="tx-tablebackcolor-menu tx-menu tx-colorpallete" unselectable="on"></div>
                              </li>
                            </ul>
                            <ul class="tx-bar tx-bar-left">
                              <li class="tx-list">
                                <div id="tx_tabletemplate" unselectable="on" class="tx-btn-lrbg tx-tabletemplate">
                                  <a href="javascript:;" class="tx-icon2" title="테이블 서식">테이블 서식</a>
                                </div>
                                <div id="tx_tabletemplate_menu" class="tx-tabletemplate-menu tx-menu tx-colorpallete" unselectable="on"></div>
                              </li>
                            </ul>

                          </div>
                        </div>
                        <!-- 툴바 - 더보기 끝 -->
                        <!-- 편집영역 시작 -->
                        <!-- 에디터 Start -->
                        <div id="tx_canvas" class="tx-canvas">
                          <div id="tx_loading" class="tx-loading">
                            <div><img src="images/icon/editor/loading2.png" width="113" height="21" align="absmiddle" /></div>
                          </div>
                          <div id="tx_canvas_wysiwyg_holder" class="tx-holder" style="display:block;">
                            <iframe id="tx_canvas_wysiwyg" name="tx_canvas_wysiwyg" allowtransparency="true" frameborder="0"></iframe>
                          </div>
                          <div class="tx-source-deco">
                            <div id="tx_canvas_source_holder" class="tx-holder">
                              <textarea id="tx_canvas_source" rows="30" cols="30"></textarea>
                            </div>
                          </div>
                          <div id="tx_canvas_text_holder" class="tx-holder">
                            <textarea id="tx_canvas_text" rows="30" cols="30"></textarea>
                          </div>
                        </div>
                        <!-- 높이조절 Start -->
                        <div id="tx_resizer" class="tx-resize-bar">
                          <div class="tx-resize-bar-bg"></div>
                          <img id="tx_resize_holder" src="images/icon/editor/skin/01/btn_drag01.gif" width="58" height="12" unselectable="on" alt="" />
                        </div>
                        <div class="tx-side-bi" id="tx_side_bi">
                          <div style="text-align: right;">
                            <!-- <img hspace="4" height="14" width="78" align="absmiddle" src="images/icon/editor/editor_bi.png" /> -->
                          </div>
                        </div>
                        <!-- 편집영역 끝 -->
                        <!-- 첨부박스 시작 -->
                        <!-- 파일첨부박스 Start -->
                        <div id="tx_attach_div" class="tx-attach-div">
                          <div id="tx_attach_txt" class="tx-attach-txt">파일 첨부</div>
                          <div id="tx_attach_box" class="tx-attach-box">
                            <div class="tx-attach-box-inner">
                              <div id="tx_attach_preview" class="tx-attach-preview">
                                <p></p><img src="images/icon/editor/pn_preview.gif" width="147" height="108" unselectable="on" />
                              </div>
                              <div class="tx-attach-main">
                                <div id="tx_upload_progress" class="tx-upload-progress">
                                  <div>0%</div>
                                  <p>파일을 업로드하는 중입니다.</p>
                                </div>
                                <ul class="tx-attach-top">
                                  <li id="tx_attach_delete" class="tx-attach-delete"><a>전체삭제</a></li>
                                  <li id="tx_attach_size" class="tx-attach-size">
                                    파일: <span id="tx_attach_up_size" class="tx-attach-size-up"></span>/<span id="tx_attach_max_size"></span>
                                  </li>
                                  <li id="tx_attach_tools" class="tx-attach-tools">
                                  </li>
                                </ul>
                                <ul id="tx_attach_list" class="tx-attach-list"></ul>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- 첨부박스 끝 -->
                      </div>
                      <!-- 에디터 컨테이너 끝 -->
                    </form>
                  </div>
                  <!-- 에디터 끝 -->
                  <script type="text/javascript">
                    var config = {
                      txHost: '',
                      /* 런타임 시 리소스들을 로딩할 때 필요한 부분으로, 경로가 변경되면 이 부분 수정이 필요. ex) http://xxx.xxx.com */
                      txPath: '',
                      /* 런타임 시 리소스들을 로딩할 때 필요한 부분으로, 경로가 변경되면 이 부분 수정이 필요. ex) /xxx/xxx/ */
                      txService: 'sample',
                      /* 수정필요없음. */
                      txProject: 'sample',
                      /* 수정필요없음. 프로젝트가 여러개일 경우만 수정한다. */
                      initializedId: "",
                      /* 대부분의 경우에 빈문자열 */
                      wrapper: "tx_trex_container",
                      /* 에디터를 둘러싸고 있는 레이어 이름(에디터 컨테이너) */
                      form: 'tx_editor_form' + "",
                      /* 등록하기 위한 Form 이름 */
                      txIconPath: "images/icon/editor/",
                      /*에디터에 사용되는 이미지 디렉터리, 필요에 따라 수정한다. */
                      txDecoPath: "images/deco/contents/",
                      /*본문에 사용되는 이미지 디렉터리, 서비스에서 사용할 때는 완성된 컨텐츠로 배포되기 위해 절대경로로 수정한다. */
                      canvas: {
                        exitEditor: {
                          /*
                          desc:'빠져 나오시려면 shift+b를 누르세요.',
                          hotKey: {
                              shiftKey:true,
                              keyCode:66
                          },
                          nextElement: document.getElementsByTagName('button')[0]
                          */
                        },
                        styles: {
                          color: "#123456",
                          /* 기본 글자색 */
                          fontFamily: "굴림",
                          /* 기본 글자체 */
                          fontSize: "10pt",
                          /* 기본 글자크기 */
                          backgroundColor: "#fff",
                          /*기본 배경색 */
                          lineHeight: "1.5",
                          /*기본 줄간격 */
                          padding: "8px" /* 위지윅 영역의 여백 */
                        },
                        showGuideArea: false
                      },
                      events: {
                        preventUnload: false
                      },
                      sidebar: {
                        attachbox: {
                          show: true,
                          confirmForDeleteAll: true
                        }
                      },
                      size: {
                        // contentWidth: 700 /* 지정된 본문영역의 넓이가 있을 경우에 설정 */ --- 설정안해주면 왼쪽부터 글씨 잘 쓰인다.
                      }
                    };

                    EditorJSLoader.ready(function(Editor) {
                      var editor = new Editor(config);
                    });
                  </script>

                  <!-- Sample: Saving Contents -->
                  <script type="text/javascript">
                    /* 예제용 함수 */
                    function saveContent() {
                      Editor.save(); // 이 함수를 호출하여 글을 등록하면 된다.
                    }
                    /**
                     * Editor.save()를 호출한 경우 데이터가 유효한지 검사하기 위해 부르는 콜백함수로
                     * 상황에 맞게 수정하여 사용한다.
                     * 모든 데이터가 유효할 경우에 true를 리턴한다.
                     * @function
                     * @param {Object} editor - 에디터에서 넘겨주는 editor 객체
                     * @returns {Boolean} 모든 데이터가 유효할 경우에 true
                     */
                    function validForm(editor) {
                      // Place your validation logic here

                      // sample : validate that content exists
                      var validator = new Trex.Validator();
                      var content = editor.getContent();
                      if (!validator.exists(content)) {
                        alert('내용을 입력하세요');
                        return false;
                      }
                      return true;
                    }

                    /**
                     * Editor.save()를 호출한 경우 validForm callback 이 수행된 이후
                     * 실제 form submit을 위해 form 필드를 생성, 변경하기 위해 부르는 콜백함수로
                     * 각자 상황에 맞게 적절히 응용하여 사용한다.
                     * @function
                     * @param {Object} editor - 에디터에서 넘겨주는 editor 객체
                     * @returns {Boolean} 정상적인 경우에 true
                     */
                    function setForm(editor) {
                      var i, input;
                      var form = editor.getForm();
                      var content = editor.getContent();

                      // 본문 내용을 필드를 생성하여 값을 할당하는 부분
                      var textarea = document.createElement('textarea');
                      textarea.name = 'content';
                      textarea.value = content;
                      form.createField(textarea);

                      /* 아래의 코드는 첨부된 데이터를 필드를 생성하여 값을 할당하는 부분으로 상황에 맞게 수정하여 사용한다.
                       첨부된 데이터 중에 주어진 종류(image,file..)에 해당하는 것만 배열로 넘겨준다. */
                      var images = editor.getAttachments('image');
                      for (i = 0; i < images.length; i++) {
                        // existStage는 현재 본문에 존재하는지 여부
                        if (images[i].existStage) {
                          // data는 팝업에서 execAttach 등을 통해 넘긴 데이터
                          alert('attachment information - image[' + i + '] \r\n' + JSON.stringify(images[i].data));
                          input = document.createElement('input');
                          input.type = 'hidden';
                          input.name = 'attach_image';
                          input.value = images[i].data.imageurl; // 예에서는 이미지경로만 받아서 사용
                          form.createField(input);
                        }
                      }

                      var files = editor.getAttachments('file');
                      for (i = 0; i < files.length; i++) {
                        input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'attach_file';
                        input.value = files[i].data.attachurl;
                        form.createField(input);
                      }
                      return true;
                    }
                  </script>
                  <div  id="submit_btn"><button onclick='saveContent()' >등록</button></div>
            </td>
          </tr>
          </table>

        </div>
        <!--end of write_form -->




    <!-- End: Saving Contents -->

    <!-- Sample: Loading Contents -->
    <textarea id="sample_contents_source" style="display:none;">
                 <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                 <p style="text-align: center;">
                    <img src="http://cfile273.uf.daum.net/image/2064CD374EE1ACCB0F15C8" class="tx-daum-image" style="clear: none; float: none;"/>
                 </p>
                 <p>
                    <a href="http://cfile297.uf.daum.net/attach/207C8C1B4AA4F5DC01A644"><img src="snapshot/images/icon/p_gif_s.gif"/> editor_bi.gif</a>
                 </p>
              </textarea>
    <script type="text/javascript">
      function loadContent() {
        var attachments = {};
        <!-- attachments['image'] = []; -->
        attachments['image'].push({
          'attacher': 'image',
          'data': {
            'imageurl': 'http://cfile273.uf.daum.net/image/2064CD374EE1ACCB0F15C8',
            'filename': 'github.gif',
            'filesize': 59501,
            'originalurl': 'http://cfile273.uf.daum.net/original/2064CD374EE1ACCB0F15C8',
            'thumburl': 'http://cfile273.uf.daum.net/P150x100/2064CD374EE1ACCB0F15C8'
          }
        });
        attachments['file'] = [];
        attachments['file'].push({
          'attacher': 'file',
          'data': {
            'attachurl': 'http://cfile297.uf.daum.net/attach/207C8C1B4AA4F5DC01A644',
            'filemime': 'image/gif',
            'filename': 'editor_bi.gif',
            'filesize': 640
          }
        });
        /* 저장된 컨텐츠를 불러오기 위한 함수 호출 */
        Editor.modify({
          "attachments": function() {
            /* 저장된 첨부가 있을 경우 배열로 넘김, 위의 부분을 수정하고 아래 부분은 수정없이 사용 */
            var allattachments = [];
            for (var i in attachments) {
              allattachments = allattachments.concat(attachments[i]);
            }
            return allattachments;
          }(),
          "content": document.getElementById("sample_contents_source") /* 내용 문자열, 주어진 필드(textarea) 엘리먼트 */
        });
      }
    </script>
    <!-- <div><button onclick='loadContent()'>SAMPLE - load contents to editor</button></div> -->
  </div>
  <!--end of col2 -->
  </div> <!-- end of content -->
  </div> <!-- end of wrap -->
</body>

</html>
