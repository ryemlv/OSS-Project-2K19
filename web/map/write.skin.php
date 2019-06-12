<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);

// 다음지도 처음화면 설정
if($write['wr_8'] == null){$write['wr_8'] =  37.566400714093284;}
if($write['wr_9'] == null){$write['wr_9'] = 126.9785391897507;}

?>
<div id="map" style="width:100%;height:450px;"></div>

<div id="clickLatlng"></div>
<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=bf50763ece062712c586a754b8f391d9&libraries=services"></script>


<script>
var mapContainer = document.getElementById('map'), // 지도를 표시할 div 
    mapOption = {
        center: new daum.maps.LatLng(<?=$write['wr_8']?>, <?=$write['wr_9']?>), // 지도의 중심좌표
        level: 2 // 지도의 확대 레벨
    };  

// 지도를 생성합니다    
var map = new daum.maps.Map(mapContainer, mapOption); 

// 주소-좌표 변환 객체를 생성합니다
var geocoder = new daum.maps.services.Geocoder();

// 지도를 클릭한 위치에 표출할 마커입니다
var marker = new daum.maps.Marker({ 
    map: map,
    // 지도 중심좌표에 마커를 생성합니다 
    position: map.getCenter() 
}); 


function getLByAddress(address) {
// 주소로 좌표를 검색합니다
geocoder.addressSearch(address, function(result, status) {

    // 정상적으로 검색이 완료됐으면 
     if (status === daum.maps.services.Status.OK) {

        var coords = new daum.maps.LatLng(result[0].y, result[0].x);

		marker.setPosition(coords);
		// 지도에 마커를 표시합니다
		marker.setMap(map);

        // 지도의 중심을 결과값으로 받은 위치로 이동시킵니다
        map.setCenter(coords);
		document.getElementById('wr_8').value = coords.getLat();
		document.getElementById('wr_9').value = coords.getLng();    
    } 
});  
}

// 지도에 클릭 이벤트를 등록합니다
// 지도를 클릭하면 마지막 파라미터로 넘어온 함수를 호출합니다
daum.maps.event.addListener(map, 'click', function(mouseEvent) {        
	// 지도에 마커를 표시합니다
	marker.setMap(map);
    
    // 클릭한 위도, 경도 정보를 가져옵니다 
    var latlng = mouseEvent.latLng; 
    
    // 마커 위치를 클릭한 위치로 옮깁니다
    marker.setPosition(latlng);
    
    document.getElementById('wr_8').value = latlng.getLat();
    document.getElementById('wr_9').value = latlng.getLng();    
    
});


</script>

<!-- //다음지도 추가 -->
<section id="bo_w">

    <!-- 게시물 작성/수정 시작 { -->
    <form name="fwrite" id="fwrite" action="<?php echo $action_url ?>" method="post" enctype="multipart/form-data" autocomplete="off" style="width:<?php echo $width; ?>">

    <div class="tbl_frm01 tbl_wrap"> <!-- // 주소, 위도/경도, 제목, 전화번호, 내용, 첨부파일 입력 form 생성 -->
        <table>
        <tbody>
        <tr> 
			<th scope="row"><label for="wr_pi_goods_color_s">주소</label></th> 
				<td>
					<input type="text" name="wr_4" id="wr_4" value="<?=$write['wr_4']?>" class="frm_input" maxlength="255" style="width:600px;" onBlur="getLByAddress(this.value);">
					(주소가 정확치 않으면 나타나지 않습니다.)
				</td>
		</tr>

		<tr>
			<th>위도 /경도</th>
			<td><input type="text" name="wr_8" value="<?php echo $write['wr_8'] ?>" id="wr_8" readonly class="frm_input full_input">  <input type="text" name="wr_9" value="<?php echo $write['wr_9'] ?>" id="wr_9" readonly class="frm_input full_input">
    </div></td>
	</tr>
    
        <tr>
            <th scope="row"><label for="wr_subject">제목<strong class="sound_only">필수</strong></label></th>
            <td>
                <div id="autosave_wrapper">
                    <input type="text" name="wr_subject" value="<?php echo $subject ?>" id="wr_subject" required class="frm_input required" size="50" maxlength="255">
                </div>
            </td>
        </tr>
        

 		<tr>
			<th scope="row"><label for="wr_pi_goods_color_s">전화번호</label></th>
				<td>
					<input type="text" name="wr_5" id="wr_5" value="<?=$write['wr_5']?>" class="frm_input" maxlength="255" style="width:600px;">
				</td>
		</tr>

        <tr>
            <th scope="row"><label for="wr_content">내용<strong class="sound_only">필수</strong></label></th>
            <td class="wr_content">
                <?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>
            </td>
        </tr>

        <?php for ($i=0; $is_file && $i<$file_count; $i++) { //첨부파일 입력 ?>
        <tr>
            <th scope="row">파일 #<?php echo $i+1 ?></th>
            <td>
                <input type="file" name="bf_file[]" title="파일첨부 <?php echo $i+1 ?> :  용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능" class="frm_file frm_input">
                <?php if ($is_file_content) { ?>
                <input type="text" name="bf_content[]" value="<?php echo ($w == 'u') ? $file[$i]['bf_content'] : ''; ?>" title="파일 설명을 입력해주세요." class="frm_file frm_input" size="50">
                <?php } ?>
                <?php if($w == 'u' && $file[$i]['file']) { ?>
                <input type="checkbox" id="bf_file_del<?php echo $i ?>" name="bf_file_del[<?php echo $i;  ?>]" value="1"> <label for="bf_file_del<?php echo $i ?>"><?php echo $file[$i]['source'].'('.$file[$i]['size'].')';  ?> 파일 삭제</label>
                <?php } ?>
            </td>
        </tr>
        <?php } ?>

        </tbody>
        </table>
    </div>

    <div class="btn_confirm">
        <input type="submit" value="작성완료" id="btn_submit" accesskey="s" class="btn_submit">
        <a href="./board.php?bo_table=<?php echo $bo_table ?>" class="btn_cancel">취소</a>
    </div>
    </form>

</section>
<!-- } 게시물 작성/수정 끝 -->

<? if($write['wr_4']) { ?>
<script>
	getLByAddress('<?=$write['wr_4']?>');
</script>
<? } ?>
