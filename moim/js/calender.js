var agit_name = "";

  function calendar_ajax(year,month,agit_name1){
    var value_array= [];
    var value_date= [];
    var value_num= [];
    var value_club= [];

    // var value_array= new Array();
    if(agit_name1!=undefined){
      agit_name = agit_name1;
    }

    setDate_thisyear =  new Date();
    var thisday=setDate_thisyear.getDate();
    var thisyear =setDate_thisyear.getFullYear();
    var thismonth = setDate_thisyear.getMonth()+1;
    var twoyear = year+"";
    twoyear = twoyear.substring(2,4);
    var prev_month= month-1;
    var next_month = month*1+1;
    var prev_year =year;
    var next_year =year;
    if(month==1){
      prev_month = 12;
      prev_year = year-1;
    }else if(month==12){
      next_month = 1;
      next_year=year*1+1;
    }
    var preyear = year-1;
    var nextyear = year*1+1;

    var max_day= getTotalDate(year,month);  //해당월의 마지막 날짜
    var setDate_start = new Date(year, month-1, 1);
    var start_week = setDate_start.getDay();  //시작요일
    var total_week=Math.ceil((max_day+start_week)/7); //총 몇주인지
    var setDate_last = new Date(year, month-1,  max_day);
    var last_week = setDate_last.getDay();  //마지막요일구하기


    $.ajax({
      url: './calender_query.php?mode=modal_calendar',
      type: 'POST',
      data: {
        agit_name : agit_name,
        year: year,
        month: month
      }
    })
    .done(function(result) {
      // 19-05-23, 19-05-27, 19-05-28, 19-05-29, 19-05-30/생각하는 주방/2 & 19-05-31, 19-06-01, 19-06-02/등록확인/20
      console.log("success");
      result=result.replace("\n","");
      result=result.replace("\r","");
      var total_value= result.split("&");
      for(i=0;i<total_value.length;i++){
        value_array[i] = total_value[i].split("/");
        value_date[i] = value_array[i][0].split(",");
      }
      var count=0;
      for(i=0;i<value_date.length;i++){
        for(j=0;j<value_date[i].length;j++){
          value_num[count] = value_date[i][j]+"-"+value_array[i][1]+"-"+value_array[i][2]+"-"+value_array[i][3];
          count++;
        }
      }

      $("#modal-content").html("<h2 align='center'>"+agit_name+"</h2>");
      $("#modal-content").append("<span class='back'>◀</span><span class='close'>&times;</span>");
      $("#modal-content").append("<div class='container_cal'>");
      $(".container_cal").append("<table id='table1' class='table table-bordered table-responsive'>");
      $("#table1").append("<tr class='table_top'>");
      $(".table_top").append("<td><span onclick='calendar_ajax("+preyear+","+month+")'>PRE YEAR</span></td>");
      $(".table_top").append("<td><span onclick='calendar_ajax("+prev_year+","+prev_month+")'>◀</span></td>");
      $(".table_top").append("<td colspan='3'><span onclick='calendar_ajax("+thisyear+","+thismonth+")'>"+year+"년"+month+"월</span></td>");
      $(".table_top").append("<td><span onclick='calendar_ajax("+next_year+","+next_month+")'>▶</span></td>");
      $(".table_top").append("<td><span onclick='calendar_ajax("+nextyear+","+month+")'>NEXT YEAR</span></td>");
      $("#table1").append("</tr>");
      $("#table1").append("<tr class='table_day'>");
      $(".table_day").append("<th>일</th><th>월</th><th>화</th><th>수</th><th>목</th><th>금</th><th>토</th>");
      $("#table1").append("</tr>");

        var day=1;
        for(i=1; i<= total_week; i++){
          $("#table1").append("<tr class='tr"+i+"'>");
          for (j = 0; j < 7; j++) {
            $(".tr"+i).append("<td class='cal_day"+j+"'>");
            if (!((i == 1 && j < start_week) || (i == total_week && j > last_week))) {
              $(".tr"+i+" .cal_day"+j).append(day);
              if(year==thisyear && month==thismonth && day==thisday){
                $(".tr"+i+" .cal_day"+j).append("<br>Today");
                $(".tr"+i+" .cal_day"+j).css("color","red");
              }
              $(".tr"+i+" .cal_day"+j).append("<div id='schedule"+day+"'></div>");
            day++;
            }
            $(".tr"+i).append("</td>");
          }
          $("#table1").append("</tr>");
          $(".tr"+i).css("height","130px");
        }
        $("#modal-content").append("</table>");

      for(i=0;i<value_num.length;i++){
        choice_date = value_num[i].split("-");
        if(choice_date[2] < 10){
          choice_date[2]=choice_date[2].substring(1);
        }
        if(($.trim(choice_date[0]) == $.trim(twoyear)) && (choice_date[1] == month)){
          if(choice_date[5]=="yes"){
            $("#schedule"+choice_date[2]).append("<a class=day"+choice_date[4]+" href='./clubing/source/ing_view.php?club_num="+choice_date[4]+"'>"+choice_date[3]+"<br></a>");
          }else{
            $("#schedule"+choice_date[2]).append("<a class=day"+choice_date[4]+" href='./club_list/source/view.php?club_num="+choice_date[4]+"'>"+choice_date[3]+"<br></a>");
          }
        }

      }

    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });

  }
  function getTotalDate(year, month){
    if(month==4 || month==6 || month==9 || month==11){
      return 30;
    }else if(month==2){
      if(year%4 == 0){ // 2월이면서 윤년일 때
        return 29;
      }else{	// 2월이면서 윤년이 아닐 때
        return 28;
      }
    }else{
      return 31;
    }
  }

  $(document).on("click",".close",function() {
    var modal = document.getElementById('myModal');
    modal.style.display = "none";
  });

  $(document).on("click",".back",function() {
    setDate_thisyear =  new Date();
    var thisyear =setDate_thisyear.getFullYear();
    var thismonth = setDate_thisyear.getMonth()+1;

    $("#modal-content").html("<span class='close'>&times;</span>");
    $("#modal-content").append("<div class='button-8' id='button-1' onclick='calendar_ajax("+thisyear+","+thismonth+", \"홍대아지트\")'>");
    $("#button-1").append("<div class='eff-8'></div>");
    $("#button-1").append("<a href='#'><span>홍대아지트</span></a>");
    $("#modal-content").append("</div>");
    $("#modal-content").append("<div class='button-8' id='button-2' onclick='calendar_ajax("+thisyear+","+thismonth+", \"역삼아지트\")'>");
    $("#button-2").append("<div class='eff-8'></div>");
    $("#button-2").append("<a href='#'><span>역삼아지트</span></a>");
    $("#modal-content").append("</div>");
    $("#modal-content").append("<div class='button-8' id='button-3' onclick='calendar_ajax("+thisyear+","+thismonth+", \"여의도아지트\")'>");
    $("#button-3").append("<div class='eff-8'></div>");
    $("#button-3").append("<a href='#'><span>여의도아지트</span></a>");
    $("#modal-content").append("</div>");
    $("#modal-content").append("<div class='button-8' id='button-4' onclick='calendar_ajax("+thisyear+","+thismonth+", \"을지로아지트\")'>");
    $("#button-4").append("<div class='eff-8'></div>");
    $("#button-4").append("<a href='#'><span>을지로아지트</span></a>");
    $("#modal-content").append("</div>");
  });

    function calendar_choice(){
      setDate_thisyear =  new Date();
      var thisyear =setDate_thisyear.getFullYear();
      var thismonth = setDate_thisyear.getMonth()+1;
      var modal = document.getElementById('myModal');
      $("#modal-content").html("<span class='close'>&times;</span>");
      $("#modal-content").append("<div class='button-8' id='button-1' onclick='calendar_ajax("+thisyear+","+thismonth+", \"홍대아지트\")'>");
      $("#button-1").append("<div class='eff-8'></div>");
      $("#button-1").append("<a href='#'><span>홍대아지트</span></a>");
      $("#modal-content").append("</div>");
      $("#modal-content").append("<div class='button-8' id='button-2' onclick='calendar_ajax("+thisyear+","+thismonth+", \"역삼아지트\")'>");
      $("#button-2").append("<div class='eff-8'></div>");
      $("#button-2").append("<a href='#'><span>역삼아지트</span></a>");
      $("#modal-content").append("</div>");
      $("#modal-content").append("<div class='button-8' id='button-3' onclick='calendar_ajax("+thisyear+","+thismonth+", \"여의도아지트\")'>");
      $("#button-3").append("<div class='eff-8'></div>");
      $("#button-3").append("<a href='#'><span>여의도아지트</span></a>");
      $("#modal-content").append("</div>");
      $("#modal-content").append("<div class='button-8' id='button-4' onclick='calendar_ajax("+thisyear+","+thismonth+", \"을지로아지트\")'>");
      $("#button-4").append("<div class='eff-8'></div>");
      $("#button-4").append("<a href='#'><span>을지로아지트</span></a>");
      $("#modal-content").append("</div>");

      modal.style.display="block";
    }



  
