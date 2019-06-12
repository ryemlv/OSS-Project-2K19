<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<!-- 게시물 읽기 시작 { -->

<article id="bo_v" style="width:<?php echo $width; ?>">

    <!-- 게시물 상단 버튼 시작 { -->
    <div id="bo_v_top">
        <?php
        ob_start();
         ?>

        <ul class="bo_v_com">
            <?php if ($update_href) { ?><li><a href="<?php echo $update_href ?>" class="btn_b01">수정</a></li><?php } ?>
            <?php if ($delete_href) { ?><li><a href="<?php echo $delete_href ?>" class="btn_b01" onclick="del(this.href); return false;">삭제</a></li><?php } ?>
            <?php if ($search_href) { ?><li><a href="<?php echo $search_href ?>" class="btn_b01">검색</a></li><?php } ?>
            <li><a href="<?php echo $list_href ?>" class="btn_b01">목록</a></li>
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b02">글쓰기</a></li><?php } ?>
        </ul>
        <?php
        $link_buttons = ob_get_contents();
        ob_end_flush();
         ?>
    </div>
    <!-- } 게시물 상단 버튼 끝 -->

    <section id="bo_v_atc">
	

        <h2 id="bo_v_atc_title">본문</h2>
		    <header>
        <h1 id="bo_v_title">

        </h1>
    </header>

		
		<script type="text/javascript">
$(function(){
	$("#imgList li>img").hover(function(){
		$("#mainImg img").attr('src', $(this).attr('src'));
	});

});
</script>
		
<style>


	#mainImg{text-align:center; border:0px solid #ddd;}
	#mainImg img{width:450px;height:350px;}
	#imgList{list-style:none; padding:0;*zoom:1; width:450px; margin:10px auto 0 auto;}
	#imgList:after{content:""; display:block; clear:both;}
	#imgList li{float:left;padding:0px;margin:0px; }
	#imgList li img{width:112px;height:80px;}

	.viewInfo{border-collapse:collapse; border-top:0px solid #ddd;border-bottom:0px solid #ddd;width:100%;}
	.viewInfo th, .viewInfo td{font-size:12px;color: #777;text-align:left;border:0px solid #ededed;}
	.viewInfo th{background:url("<?=$board_skin_path?>/img/map_icon.gif") 4px 12px no-repeat;}
</style>

<div style="border-top:1px solid #ddd;border-bottom:1px solid #ddd;padding:20px;text-align:center;font-size:13pt">
		            <?php
            if ($category_name) echo $view['ca_name'].' | '; // 분류 출력 끝
            echo cut_str(get_text($view['wr_subject']), 70); // 글제목 출력
            ?>		
</div>

    <div class="tbl_frm011">
        <table>
        <tbody>
   

        <tr valign="top">
            <th width="450px">

			<div id="mainImg">
			<img src='<?=$view['file']['0']['path'].'/'.$view['file']['0']['file']?>' /></div>
			<?php
				if($view['file']['count'])
				{
					echo "<ul id='imgList'>";
					for($i=0; $i<$view['file']['count'];$i++)
					{
						if($view['file'][$i]['view']){
							if($i>=5) continue;
							if($i==4) {
								echo "<li><div style='position: absolute; color:#fff; font-size:40px; margin:25px 0 0 60px; z-index:10;'>+".$view['file']['count']."</div><img src='{$view['file'][$i][path]}/{$view['file'][$i][file]}' /></li>";							
							} else {
								echo "<li><img src='{$view['file'][$i]['path']}/{$view['file'][$i]['file']}' /></li>";							
							}
						}
					}
					echo "</ul>";
				}
			?>
		
			
			
			</th>
			<td width="450px" style="border:0px;padding-top:28px">
<!-- 다음지도 추가 -->
<div id="map" style="width:100%;height:350px;"></div>
<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=bf50763ece062712c586a754b8f391d9&libraries=services"></script>
<script>
var mapContainer = document.getElementById('map'), // 지도를 표시할 div 
    mapOption = { 
        center: new daum.maps.LatLng(<?=$view['wr_8']?>, <?=$view['wr_9']?>), // 지도의 중심좌표
        level: 3 // 지도의 확대 레벨
    };

var map = new daum.maps.Map(mapContainer, mapOption); // 지도를 생성합니다

// 일반 지도와 스카이뷰로 지도 타입을 전환할 수 있는 지도타입 컨트롤을 생성합니다
var mapTypeControl = new daum.maps.MapTypeControl();

// 지도에 컨트롤을 추가해야 지도위에 표시됩니다
// daum.maps.ControlPosition은 컨트롤이 표시될 위치를 정의하는데 TOPRIGHT는 오른쪽 위를 의미합니다
map.addControl(mapTypeControl, daum.maps.ControlPosition.TOPRIGHT);

// 지도 확대 축소를 제어할 수 있는  줌 컨트롤을 생성합니다
var zoomControl = new daum.maps.ZoomControl();
map.addControl(zoomControl, daum.maps.ControlPosition.RIGHT);

// 지도를 클릭한 위치에 표출할 마커입니다
var marker = new daum.maps.Marker({ 
    // 지도 중심좌표에 마커를 생성합니다 
    position: map.getCenter() 
}); 
// 지도에 마커를 표시합니다
marker.setMap(map);

</script>

<!-- //다음지도 추가 -->           			
            <!-- 본문 내용 시작  -->
        <div id="bo_v_con" style="font-size:10pt"><?php echo get_view_thumbnail($view['content']); ?></div>
        <?php//echo $view['rich_content']; // {이미지:0} 과 같은 코드를 사용할 경우 ?>
        <!--  본문 내용 끝 -->


			</td>
        </tr>
		<Tr>

</article>
<!-- } 게시판 읽기 끝 -->
