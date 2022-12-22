<?php
$pagination_code = null;
$pagenum_max = $the_query_contents->max_num_pages;
$now_page = $paged;
if($now_page == 0){
    $now_page = 1;
}

if($now_page == 0 or empty($now_page) or $now_page == 1){
    $now_page_p1 = null;
    if($pagenum_max > $now_page){
        $pagination_code .= '<span>1</span>';
        for ($i=2; $i <= $pagenum_max; $i++) {
            if($i < 5){
                $pagination_code .= '<a href="'.$pagination_url.'&paged='.$i.'">'.$i.'</a>';
            }
        }
    }
    if($now_page < $pagenum_max){
        if($now_page == 0){
            $now_page_p1 = $now_page + 2;
        }
        else{
            $now_page_p1 = $now_page + 1;
        }
        if($pagenum_max > $now_page){
            $pagination_code .= '<a href="'.$pagination_url.'&paged='.$now_page_p1.'">次へ</a>';
        }
    }
}
else{
    $now_page_m1 = null;
    $now_page_m1 = $now_page - 3;
    $now_page_m1_2 = $now_page - 1;
    $pagination_code .= '<a href="'.$pagination_url.'&paged='.$now_page_m1_2.'">戻る</a>';
    for ($i=$now_page_m1; $i < $now_page; $i++) {
        if($i > 0){
            $pagination_code .= '<a href="'.$pagination_url.'&paged='.$i.'">'.$i.'</a>';
        }
    }
    $now_page_p1 = null;
    $pagination_code .= '<span>'.$now_page.'</span>';
    $now_page_p1 = $now_page + 1;
    $i2 = 0;
    for ($i=$now_page_p1; $i <= $pagenum_max; $i++) {
        $i2++;
        if($i2 < 4){
            $pagination_code .= '<a href="'.$pagination_url.'&paged='.$i.'">'.$i.'</a>';
        }
        else{
            break;
        }
    }
    if($pagenum_max > $now_page){
        $pagination_code .= '<a href="'.$pagination_url.'&paged='.$now_page_p1.'">次へ</a>';
    }
}

if(!empty($pagination_code)){
    echo '<nav class="pagination">'.$pagination_code.'</nav>';
}
?>
