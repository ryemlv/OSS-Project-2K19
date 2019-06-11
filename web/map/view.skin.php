<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<!-- 게시물 읽기 시작 { -->

<!--<div id="bo_v_table"><?php echo $board['bo_subject']; ?></div>-->


<article id="bo_v" style="width:<?php echo $width; ?>">


    <!-- section id="bo_v_info">
        <h2>페이지 정보</h2>
        작성자 <strong><?php echo $view['name'] ?><?php if ($is_ip_view) { echo "&nbsp;($ip)"; } ?></strong>
        <span class="sound_only">작성일</span><strong><?php echo date("y-m-d H:i", strtotime($view['wr_datetime'])) ?></strong>
        조회<strong><?php echo number_format($view['wr_hit']) ?>회</strong>
        댓글<strong><?php echo number_format($view['wr_comment']) ?>건</strong>
    </section  -->

    <?php
    if ($view['file']['count']) {
        $cnt = 0;
        for ($i=0; $i<count($view['file']); $i++) {
            if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view'])
                $cnt++;
        }
    }
     ?>

    <?php if($cnt) { ?>
    <!-- 첨부파일 시작 { -->
    <section id="bo_v_file">
        <h2>첨부파일</h2>
        <ul>
        <?php
        // 가변 파일
        for ($i=0; $i<count($view['file']); $i++) {
            if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view']) {
         ?>
            <li>
                <a href="<?php echo $view['file'][$i]['href'];  ?>" class="view_file_download">
                    <img src="<?php echo $board_skin_url ?>/img/icon_file.gif" alt="첨부">
                    <strong><?php echo $view['file'][$i]['source'] ?></strong>
                    <?php echo $view['file'][$i]['content'] ?> (<?php echo $view['file'][$i]['size'] ?>)
                </a>
                <span class="bo_v_file_cnt"><?php echo $view['file'][$i]['download'] ?>회 다운로드</span>
                <span>DATE : <?php echo $view['file'][$i]['datetime'] ?></span>
            </li>
        <?php
            }
        }
         ?>
        </ul>
    </section>
    <!-- } 첨부파일 끝 -->
    <?php } ?>

    <?php
    if (implode('', $view['link'])) {
     ?>
     <!-- 관련링크 시작 { -->
    <section id="bo_v_link">
        <h2>관련링크</h2>
        <ul>
        <?php
        // 링크
        $cnt = 0;
        for ($i=1; $i<=count($view['link']); $i++) {
            if ($view['link'][$i]) {
                $cnt++;
                $link = cut_str($view['link'][$i], 70);
         ?>
            <li>
                <a href="<?php echo $view['link_href'][$i] ?>" target="_blank">
                    <img src="<?php echo $board_skin_url ?>/img/icon_link.gif" alt="관련링크">
                    <strong><?php echo $link ?></strong>
                </a>
                <span class="bo_v_link_cnt"><?php echo $view['link_hit'][$i] ?>회 연결</span>
            </li>
        <?php
            }
        }
         ?>
        </ul>
    </section>
    <!-- } 관련링크 끝 -->
    <?php } ?>

    <!-- 게시물 상단 버튼 시작 { -->
    <div id="bo_v_top">
        <?php
        ob_start();
         ?>
        <!--<?php if ($prev_href || $next_href) { ?>
        <ul class="bo_v_nb">
            <?php if ($prev_href) { ?><li><a href="<?php echo $prev_href ?>" class="btn_b01">Preview</a></li><?php } ?>
            <?php if ($next_href) { ?><li><a href="<?php echo $next_href ?>" class="btn_b01">Next</a></li><?php } ?>
        </ul>
        <?php } ?>-->

        <ul class="bo_v_com">
            <?php if ($update_href) { ?><li><a href="<?php echo $update_href ?>" class="btn_b01">수정</a></li><?php } ?>
            <?php if ($delete_href) { ?><li><a href="<?php echo $delete_href ?>" class="btn_b01" onclick="del(this.href); return false;">삭제</a></li><?php } ?>
            <?php if ($copy_href) { ?><li><a href="<?php echo $copy_href ?>" class="btn_admin" onclick="board_move(this.href); return false;">복사</a></li><?php } ?>
            <?php if ($move_href) { ?><li><a href="<?php echo $move_href ?>" class="btn_admin" onclick="board_move(this.href); return false;">이동</a></li><?php } ?>
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
        <!--<span style="margin-bottom:13px; margin-left:15px;"><?php echo $view['wr_4']?></span>-->
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
        level: 6 // 지도의 확대 레벨
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





<script>
var mapContainer = document.getElementById('map'), // 지도의 중심좌표
    mapOption = { 
        center: new daum.maps.LatLng(<?=$view['wr_8']?>, <?=$view['wr_9']?>), // 지도의 중심좌표
        level: 6 // 지도의 확대 레벨
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

// 지도에 마커를 표시합니다 
var marker = new daum.maps.Marker({
    map: map, 
    position: new daum.maps.LatLng(<?=$view['wr_8']?>, <?=$view['wr_9']?>)
});
	

var content = '<div class="mapwrap">' + 
            '    <div class="mapinfo">' + 
            '        <div class="maptitle">' + 
            '            <?=$view['wr_subject']?>' + 
            '            <div class="mapclose" onclick="closeOverlay()" title="닫기"></div>' + 
            '        </div>' + 
            '        <div class="mapbody">' + 
            '            <div class="mapimg">' +
            '                <?php
                                 $v_img_count = count($view['file']);
                                 if($v_img_count) {
                                 echo "<div id=\"bo_v_img\" style=\"width:73px; height:70px;\"  style=margin-top:50px>";
                                 if ($view['file'][0]['view']) {
                                 echo get_view_thumbnail($view['file'][0]['view']);
                                 }
                                 else {
                                 echo "<img src=$board_skin_url/img/no_image.gif>";
                                 }
                                 echo "</div>";
                                 }
                             ?>' +
            '           </div>' + 
            '            <div class="mapdesc">' + 
            '                <div class="mapellipsis" style=margin-top:10px><?=$view['wr_4']?></div>' + 
            '                <div class="mapjibun mapellipsis"><i class="fa fa-phone-square" aria-hidden="true"></i> <?=$view[wr_5]?></div>' + 
            '            </div>' + 
            '        </div>' + 
            '    </div>' +    
            '</div>';

var overlay = new daum.maps.CustomOverlay({
    content: content,
    map: map,
    position: marker.getPosition()       
});

daum.maps.event.addListener(marker, 'click', function() {
    overlay.setMap(map);
});

function closeOverlay() {
    overlay.setMap(null);     
}
</script>
<!-- //다음지도 추가 -->           			
            <!-- 본문 내용 시작 { -->
        <div id="bo_v_con" style="font-size:10pt"><?php echo get_view_thumbnail($view['content']); ?></div>
        <?php//echo $view['rich_content']; // {이미지:0} 과 같은 코드를 사용할 경우 ?>
        <!-- } 본문 내용 끝 -->



			</td>

        </tr>
		<Tr>
			<Td colspan="2" align="center">
<style type="text/css">
	.view_image{display:block}
</style>
			
        <?php
        // 파일 출력
        $v_img_count = count($view['file']);
        if($v_img_count) {
            echo "<div id=\"bo_v_img\" style=clear:both>\n";

            for ($i=0; $i<=count($view['file']); $i++) {
                if ($view['file'][$i]['view']) {
                    //echo $view['file'][$i]['view'];
                    echo get_view_thumbnail($view['file'][$i]['view']);
                }
            }

            echo "</div>\n";
        }
         ?>			
			</td>
		</tr>

        </tbody>
		
		
		
        </table>
    </div>



		

<br>
    <!-- 링크 버튼 시작 { -->
    <div id="bo_v_bot">
        <?php echo $link_buttons ?>
    </div>
    <!-- } 링크 버튼 끝 -->

</article>
<!-- } 게시판 읽기 끝 -->


<script>
<?php if ($board['bo_download_point'] < 0) { ?>
$(function() {
    $("a.view_file_download").click(function() {
        if(!g5_is_member) {
            alert("다운로드 권한이 없습니다.\n회원이시라면 로그인 후 이용해 보십시오.");
            return false;
        }

        var msg = "파일을 다운로드 하시면 포인트가 차감(<?php echo number_format($board['bo_download_point']) ?>점)됩니다.\n\n포인트는 게시물당 한번만 차감되며 다음에 다시 다운로드 하셔도 중복하여 차감하지 않습니다.\n\n그래도 다운로드 하시겠습니까?";

        if(confirm(msg)) {
            var href = $(this).attr("href")+"&js=on";
            $(this).attr("href", href);

            return true;
        } else {
            return false;
        }
    });
});
<?php } ?>

function board_move(href)
{
    window.open(href, "boardmove", "left=50, top=50, width=500, height=550, scrollbars=1");
}
</script>

<script>
$(function() {
    $("a.view_image").click(function() {
        window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
        return false;
    });

    // 추천, 비추천
    $("#good_button, #nogood_button").click(function() {
        var $tx;
        if(this.id == "good_button")
            $tx = $("#bo_v_act_good");
        else
            $tx = $("#bo_v_act_nogood");

        excute_good(this.href, $(this), $tx);
        return false;
    });

    // 이미지 리사이즈
    $("#bo_v_atc").viewimageresize();
});

function excute_good(href, $el, $tx)
{
    $.post(
        href,
        { js: "on" },
        function(data) {
            if(data.error) {
                alert(data.error);
                return false;
            }

            if(data.count) {
                $el.find("strong").text(number_format(String(data.count)));
                if($tx.attr("id").search("nogood") > -1) {
                    $tx.text("이 글을 비추천하셨습니다.");
                    $tx.fadeIn(200).delay(2500).fadeOut(200);
                } else {
                    $tx.text("이 글을 추천하셨습니다.");
                    $tx.fadeIn(200).delay(2500).fadeOut(200);
                }
            }
        }, "json"
    );
}
</script>
<!-- } 게시글 읽기 끝 -->