//주소 API
function execDaumPostcode() {
  /* 폼은 다음 주소찾기 빌리면서 입력값은 여기서 받고 처리하네?  */
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
      if (data.userSelectedType === 'R') {
        //법정동명이 있을 경우 추가한다.
        if (data.bname !== '') {
          extraAddr += data.bname;
        }
        // 건물명이 있을 경우 추가한다.
        if (data.buildingName !== '') {
          extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
        }
        // 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
        fullAddr += (extraAddr !== '' ? ' (' + extraAddr + ')' : '');
      }
      // 우편번호와 주소 정보를 해당 필드에 넣는다.
      // document.getElementById('address2').value = data.zonecode; //5자리 새우편번호 사용
      document.getElementById('address1').value = fullAddr;
      // 커서를 상세주소 필드로 이동한다.
      // document.getElementById('address2').value = "";
      // document.getElementById('address2').focus();
    }
  }).open();
}
//이미지파일 미리보기기능v --- 1개는 가능
var sel_file;
function handleImgFileSelect(e,img_box){
  var files = e.target.files;
  var filesArr = Array.prototype.slice.call(files);
  filesArr.forEach(function(f) {
    if(!f.type.match("image.*")){
      alert("확장자는 이미지 확장자만 가능합니다.");
      return;
  }
  sel_file = f;
  var reader = new FileReader();

  reader.onload = function(e) {
    $("#"+img_box).attr("src", e.target.result);
    $("#"+img_box).attr("style","width:150px; height:150px; margin-right:20px;");
  }
  reader.readAsDataURL(f);
});
}

//아지트이름 등록시 저절로 상세주소란에 아지트이름이 등록되게끔
function write_agit(){
var agit_name = $("#agit_name").val();
$("#address2").val(agit_name);
}
