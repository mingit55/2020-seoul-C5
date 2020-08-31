<?php
use App\DB;

function dd(){
    foreach(func_get_args() as $arg){
        echo "<pre>";
        var_dump($arg);
        echo "</pre>";
    }
    exit;
}
function dump(){
    foreach(func_get_args() as $arg){
        echo "<pre>";
        var_dump($arg);
        echo "</pre>";
    }
}

function user(){
    if(isset($_SESSION['user'])){
        $user = DB::who($_SESSION['user']->user_email);
        
        if(!$user){
            unset($_SESSION['user']);
            go("/", "회원정보를 찾을 수 없습니다. 로그아웃 됩니다.");
        } else {
            $_SESSION['user'] = $user;
            return $user;
        }
    } else {
        return false;
    }
}

function company(){
    return user() && user()->type == 'company' ? user() : false;
}

function admin(){
    return user() && user()->type == 'admin' ? user() : false;
}

function go($url, $message = ""){
    echo "<script>";
    if($message != "") echo "alert('$message');";
    echo "location.href='$url';";
    echo "</script>";
    exit;
}

function back($message){
    echo "<script>";
    if($message != "") echo "alert('$message');";
    echo "history.back();";
    echo "</script>";
    exit;
}

function json_response($data){
    header("Content-Type: application/json");
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

function view($viewName, $data = []){
    extract($data);

    require VIEW."/header.php";
    require VIEW."/$viewName.php";
    require VIEW."/footer.php";
    exit;
}

function extname($filename){
    return strtolower(substr($filename, strrpos($filename, ".")));
}

function fileinfo($filename){
    $localpath = UPLOAD."/$filename";
    $filepath = "/uploads/$filename";
    $name = substr($filename, strpos($filename, "-") + 1);
    $size = number_format( filesize($localpath) / 1024, 2 ) . "KB";
    $extname = extname($name);

    return (object)compact("name", "size", "filepath", "extname", "localpath");
}

function upload_base64($input){
    $temp = explode(";base64,", $input);
    $data = base64_decode($temp[1]);
    $filename = time(). ".jpg";
    file_put_contents(UPLOAD."/$filename", $data);
    
    return $filename;
}

function checkEmpty(){
    foreach($_POST as $input){
        if(trim($input) == ""){
            back("모든 정보를 입력해 주세요.");
        }
    }
}

function enc($output){
    return nl2br( str_replace(" ", "&nbsp;", htmlentities($output)) );
}

function pagination($data){
    define("PAGE__COUNT", 9);
    define("PAGE__BCOUNT", 5);

    $page = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] >= 1 ? $_GET['page'] : 1;

    $totalPage = ceil(count($data) / PAGE__COUNT);
    $block = ceil($page / PAGE__BCOUNT);

    $start = ($block - 1) * PAGE__BCOUNT + 1;
    $end = $start + PAGE__BCOUNT - 1;
    $start = $start < 1 ? 1 : $start;
    $end = $end > $totalPage ? $totalPage : $end;

    $prevPage = $start - 1;
    $prev = $prevPage >= 1;
    
    $nextPage = $end + 1;
    $next = $nextPage <= $totalPage;

    $data = array_slice( $data, ($page-1) * PAGE__COUNT, PAGE__COUNT );

    return (object)compact("start", "end", "nextPage", "next", "prevPage", "prev", "data", "page");
}

function dt($date){
    return date("Y년 m월 d일", strtotime($date));
}