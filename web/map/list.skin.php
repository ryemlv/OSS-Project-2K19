<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);

$js_conn=mysqli_connect('seulgi94.mooo.com:3306','ryan','dksqortks1!','gnuwiz');
$js_sql="SELECT* FROM g5_write_map ORDER BY wr_id ASC;";
$js_result = mysqli_query($js_conn,$js_sql);

?>
<!-- 다음지도 추가 -->
<div id="map" style="width:100%;height:350px;"></div>
<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=bf50763ece062712c586a754b8f391d9"></script>

<script>
    //https://www.codingfactory.net/11405
var mapContainer = document.getElementById('map'), // 지도를 표시할 div 
    mapOption = { 
        center: new daum.maps.LatLng(36.799734, 127.075038), // 지도의 중심좌표
        level: 4 // 지도의 확대 레벨
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

<?php
while($js_row=mysqli_fetch_array($js_result)){
?>
var marker = new daum.maps.Marker({
        map: map, // 마커를 표시할 지도
        position: new daum.maps.LatLng(<?php echo($js_row['wr_8']) ?>, <?php echo($js_row['wr_9']) ?>) // 마커의 위치
    });

    var infowindow = new daum.maps.InfoWindow({ //인웅이가 ^^ 
		content:'<p style="margin:5px 0 5px 12px;  font-size:12px"><?=$js_row['wr_subject']?></p>'
		});  
		
        marker.setMap(map);
     
   // 마커에 mouseover 이벤트와 mouseout 이벤트를 등록합니다
    // 이벤트 리스너로는 클로저를 만들어 등록합니다 
    // for문에서 클로저를 만들어 주지 않으면 마지막 마커에만 이벤트가 등록됩니다
    daum.maps.event.addListener(marker, 'mouseover', makeOverListener(map, marker, infowindow));
    daum.maps.event.addListener(marker, 'mouseout', makeOutListener(infowindow));
    //daum.maps.event.addListener(marker, 'click', br_redirect(positions[i].wr_id));
    // 마커에 click 이벤트를 등록합니다
    daum.maps.event.addListener(marker, 'click', function() {

        location.href = "./board.php?bo_table=Map&wr_id="+<?=$js_row['wr_id']?>;
    });

// 인포윈도우를 표시하는 클로저를 만드는 함수입니다 
function makeOverListener(map, marker, infowindow) {
    return function() {
        infowindow.open(map, marker);
    };
}

// 인포윈도우를 닫는 클로저를 만드는 함수입니다 
function makeOutListener(infowindow) {
    return function() {
        infowindow.close();
    };
}

<?php
}
?>
</script>


<!-- //다음지도 추가 -->      

<!-- 게시판 검색 시작 { -->
<table cellpadding="0" cellspacing="0" border="0" width="1100px">


        <label for="sfl" class="sound_only">검색대상</label>
	<tr bgcolor="#3155b0">
		<td style="padding:10px" width="60px">
  <?php if ($is_category) { ?>
 <form name="fcategory" method="get">
 <input type="hidden" name="bo_table" value="<?php echo $bo_table; ?>">
<select name="sca" onchange="this.form.submit();" style="padding:9px;border:0px">
	<option value=''>지역선택</option>
     <?php echo get_category_option($bo_table, $sca); // SELECT OPTION 태그로 넘겨받음 ?>
 </select>
 </form>
 <?php } ?>
		</td>
        <form name="fsearch" method="get">
        <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
        <input type="hidden" name="sca" value="<?php echo $sca ?>">
        <input type="hidden" name="sop" value="and">
		<td height="40px" style="padding:10px" width="130px">
		<select name="sfl" id="sfl" style="padding:9px;border:0px">
            <option value="wr_subject"<?php echo get_selected($sfl, 'wr_subject', true); ?>>원룸이름</option>
            <option value="wr_content"<?php echo get_selected($sfl, 'wr_content'); ?>>원룸정보</option>
            <option value="wr_4"<?php echo get_selected($sfl, 'wr_4'); ?>>주소</option>
            <option value="wr_subject||wr_content"<?php echo get_selected($sfl, 'wr_subject||wr_content'); ?>>원룸이름+원룸정보</option>
            <!-- <option value="mb_id,1"<?php echo get_selected($sfl, 'mb_id,1'); ?>>회원아이디</option>
            <option value="mb_id,0"<?php echo get_selected($sfl, 'mb_id,0'); ?>>회원아이디(코)</option> -->
            <option value="wr_name,1"<?php echo get_selected($sfl, 'wr_name,1'); ?>>글쓴이</option>
            <!-- <option value="wr_name,0"<?php echo get_selected($sfl, 'wr_name,0'); ?>>글쓴이(코)</option> -->
        </select>
		</td>
		<td>
        <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
        <input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" required id="stx" class="sch_input" size="25" maxlength="20" placeholder="검색어를 입력해주세요" style="width:100%;border:0px;padding:10px">
        </td>
		<td width="95px" align="right" style="padding-right:15px">
		<button type="submit" value="검색" class="sch_btn" style="padding:10px 20px;border:0px ">검색</button>
        </td>
		</form>
		</tr>
	</table>
<!-- } 게시판 검색 끝 -->

<!--타이틀 <nav id="page-nav" class="container-fluid">
    <div class="container">
        <h1 class="product-title pull-left hidden-xs"><a href=""><?php echo $board['bo_subject'] ?></a></h1>
    </div>
</nav>-->
<!-- 게시판 목록 시작 { -->



<!--<h2 id="container_title"><img src="<?php echo G5_THEME_IMG_URL; ?>/point_b.png"><?php echo $board['bo_subject'] ?><span class="sound_only"> 목록</span></h2>-->
<!-- 게시판 목록 시작 { -->


    <!--<?php if ($is_category) { ?>
    <nav id="bo_cate">
        <h2><?php echo $board['bo_subject'] ?> 카테고리</h2>
        <ul id="bo_cate_ul">
            <?php echo $category_option ?>
        </ul>
    </nav>
    <?php } ?>-->

    <!--<div class="bo_fx">
        <div id="bo_list_total">
            <span>Total <?php echo number_format($total_count) ?></span> / 
            <?php echo $page ?> page
        </div>

        <?php if ($rss_href || $write_href) { ?>
        <ul class="btn_bo_user">
            <?php if ($rss_href) { ?><li><a href="<?php echo $rss_href ?>" class="btn_b01">RSS</a></li><?php } ?>
            <?php if ($admin_href) { ?><li><a href="<?php echo $admin_href ?>" class="btn_admin">관리자</a></li><?php } ?>
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b02">write</a></li><?php } ?>
        </ul>
        <?php } ?>
    </div>-->

    <form name="fboardlist"  id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="sw" value="">

    <?php if ($is_checkbox) { ?>
    <div id="gall_allchk">
        <label for="chkall" class="sound_only">현재 페이지 게시물 전체</label>
        <input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);">
    </div>
    <?php } ?>
<br>
<table cellpadding="0" cellspacing="0" border="0" width="1100px">
	<tr bgcolor="#f5f5f5" style="font-size:11pt;font-family:Malgun Gothic;">
		<th height="50px" width="60px" style="border-top:1px solid #ddd;border-bottom:1px solid #ddd">번호</th>
		<th width="200px" style="border-top:1px solid #ddd;border-bottom:1px solid #ddd">사진</th>
		<th width="300px" style="border-top:1px solid #ddd;border-bottom:1px solid #ddd">원룸/주소/전화</th>
		<th style="border-top:1px solid #ddd;border-bottom:1px solid #ddd">원룸정보</th>
	</tr>
        <?php for ($i=0; $i<count($list); $i++) {			
            if($i>0 && ($i % $bo_gallery_cols == 0))
                $style = 'clear:both;';
            else
                $style = '';
            if ($i == 0) $k = 0;
            $k += 1;
            if ($k % $bo_gallery_cols == 0) $style .= "margin:0 !important;";			
         ?>
	<tr>
        <td align="center" style="border-bottom:1px solid #ddd">
            <?php if ($is_checkbox) { ?>
            <label for="chk_wr_id_<?php echo $i ?>" class="sound_only"><?php echo $list[$i]['subject'] ?></label>
            <input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
            <?php } ?>
            <span class="sound_only">

            </span>
            <?php
                if ($wr_id == $list[$i]['wr_id'])
                    echo "<span class=\"bo_current\">열람중</span>";
                else
                    echo $list[$i]['num'];
             ?>
		</td>
         <td style="padding:10px;border-bottom:1px solid #ddd">
				<a href="<?php echo $list[$i]['href'] ?>">
                    <?php
                    if ($list[$i]['is_notice']) { // 공지사항  ?>
                        <strong style="width:<?php echo $board['bo_gallery_width'] ?>px;height:<?php echo $board['bo_gallery_height'] ?>px">공지</strong>
                    <?php } else {
					    $thumb = get_list_thumbnail($board['bo_table'], $list[$i]['wr_id'], $board['bo_gallery_width'], $board['bo_gallery_height']);

                        if($thumb['src']) {
                            $img_content = '<img src="'.$thumb['src'].'" alt="'.$thumb['alt'].'" width="'.$board['bo_gallery_width'].'" height="'.$board['bo_gallery_height'].'" id="mainImg'.$i.'" class=mine>';
                        } else {
                            $img_content = '<span style="width:'.$board['bo_gallery_width'].'px;height:'.$board['bo_gallery_height'].'px">no image</span>';
                        }

                        echo $img_content;
                    }
                     ?>
                    </a>
                    

                    
                </td>




                
                
<style>
.subb { margin-left:5px !important;}
#imgList{list-style:none; padding:0;*zoom:1; margin:0 auto 0 auto; position:absolute;cursor:pointer;}
#imgList:after{content:""; display:block; clear:both;}
#imgList li{ /*padding:0 10px;*/margin:0px;width:100%}
#imgList li img{ width:90px;height:70px; margin:0 !important;border:1px solid #ddd;padding:10px}

.mine{border:1px solid #ddd;padding:10px; width:90px;height:70px;}
</style>
                
                <td  style="border-bottom:1px solid #ddd;line-height:1.8em;">
          
                    <a href="<?php echo $list[$i]['href'] ?>" style="font-size:12pt;font-weight:bold;font-family:Malgun Gothic;color:#155196">
                        <?php echo $list[$i]['subject'] ?>
                        <?php if ($list[$i]['comment_cnt']) { ?><span class="sound_only">댓글</span><?php echo $list[$i]['comment_cnt']; ?><span class="sound_only">개</span><?php } ?>
                    </a>
                    <?php
                    // if ($list[$i]['link']['count']) { echo '['.$list[$i]['link']['count']}.']'; }
                    // if ($list[$i]['file']['count']) { echo '<'.$list[$i]['file']['count'].'>'; }

                    //if (isset($list[$i]['icon_new'])) echo $list[$i]['icon_new'];
                    if (isset($list[$i]['icon_hot'])) echo $list[$i]['icon_hot'];
                    //if (isset($list[$i]['icon_file'])) echo $list[$i]['icon_file'];
                    //if (isset($list[$i]['icon_link'])) echo $list[$i]['icon_link'];
                    //if (isset($list[$i]['icon_secret'])) echo $list[$i]['icon_secret'];
                     ?>
					 <br><span style="font-size:10pt;">주소</span>: <?php echo $list[$i]['wr_4']?><br><span style="font-size:10pt;">전화번호</span>: <?php echo $list[$i]['wr_5']?>
                </td>
				<td style="border-bottom:1px solid #ddd;font-size:10pt;"><?php echo $list[$i]['wr_content']?></td>
               </tr>
        <?php } ?>
	</table><br>
    <?php if ($list_href || $is_checkbox || $write_href) { ?>
    <div class="bo_fx">
        <?php if ($is_checkbox) { ?>
        <ul class="btn_bo_adm">
            <li><input type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value"></li>
            <li><input type="submit" name="btn_submit" value="선택복사" onclick="document.pressed=this.value"></li>
            <li><input type="submit" name="btn_submit" value="선택이동" onclick="document.pressed=this.value"></li>
        </ul>
        <?php } ?>

        <?php if ($list_href || $write_href) { ?>
        <ul class="btn_bo_user">
            <?php if ($list_href) { ?><li><a href="<?php echo $list_href ?>" class="btn_b01">list</a></li><?php } ?>
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b02">write</a></li><?php } ?>
        </ul>
        <?php } ?>
    </div>
    <?php } ?>
    </form>
</div>

<?php if($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>

<!-- 페이지 -->
<?php echo $write_pages;  ?>

<!-- 게시물 검색 시작 { -->

<!-- } 게시