<?php
namespace Controller;

use App\DB;

class ActionController {
    // 관리자 추가
    function initAdmin(){
        DB::query("INSERT INTO users(user_email, password, user_name, type) VALUES (?, ?, ?, ?)", ["admin", "1234", "관리자", "admin"]);
    }


    // 회원가입
    function signUp(){
        checkEmpty();
        extract($_POST);

        $image = $_FILES['image'];
        $filename = time() . "-" . $image['name'];
        move_uploaded_file($image['tmp_name'], UPLOAD."/$filename");

        DB::query("INSERT INTO users(user_email, password, user_name, image, type) VALUES (?, ?, ?, ?, ?)", [$user_email, $password, $user_name, $filename, $type]);

        go("/", "회원가입 되었습니다.");
    }

    // 로그인
    function signIn(){
        checkEmpty();
        extract($_POST);

        $user = DB::who($user_email);
        if(!$user) back("아이디와 일치하는 회원이 존재하지 않습니다.");
        if($user->password !== $password) back("비밀번호가 일치하지 않습니다.");

        $_SESSION['user'] = $user;
        go("/", "로그인 되었습니다.");
    }

    // 로그아웃
    function logout(){
        unset($_SESSION['user']);
        go("/", "로그아웃 되었습니다.");
    }

    // 공지 추가
    function insertNotice(){
        checkEmpty();
        extract($_POST);


        if(mb_strlen($title) > 50) back("제목은 50자 이하여야 합니다.");

        $files = $_FILES['files'];
        $fileLength = count($files['name']);
        $filenames = [];

        for($i = 0; $i < $fileLength; $i++ ){
            if(!$files['name'][$i]) continue;

            $name = $files['name'][$i];
            $tmp_name = $files['tmp_name'][$i];
            $size = $files['size'][$i];
            $filename = time() . "-" . $name;
            $filenames[] = $filename;

            if( $size > 1024 * 1024 * 10 ) back("파일은 10MB 이하만 업로드 가능합니다.");
            if($i > 3) back("파일은 4개까지만 업로드 가능합니다.");
            
            move_uploaded_file($tmp_name, UPLOAD."/$filename");
        }

        DB::query("INSERT INTO notices(title, content, files) VALUES (?, ?, ?)", [$title, $content, json_encode($filenames)]);

        go("/notices", "공지가 추가되었습니다.");
    }

    // 공지 수정
    function updateNotice($id){
        $notice = DB::find("notices", $id);
        if(!$notice) back("대상을 찾을 수 없습니다.");
        checkEmpty();
        extract($_POST);

        if(mb_strlen($title) > 50) back("제목은 50자 이하여야 합니다.");

        $files = $_FILES['files'];
        $fileLength = count($files['name']);
        $filenames = json_decode($notice->files);

        
        if($fileLength >= 1 && $files['name'][0]) {
            for($i = 0; $i < $fileLength; $i++ ){
                if(!$files['name'][$i]) continue;
    
                $name = $files['name'][$i];
                $tmp_name = $files['tmp_name'][$i];
                $size = $files['size'][$i];
                $filename = time() . "-" . $name;
                $filenames[] = $filename;
    
                if( $size > 1024 * 1024 * 10 ) back("파일은 10MB 이하만 업로드 가능합니다.");
                if($i > 3) back("파일은 4개까지만 업로드 가능합니다.");
                
                move_uploaded_file($tmp_name, UPLOAD."/$filename");
            }
        }

        DB::query("UPDATE notices SET title = ?, content = ?, files = ? WHERE id = ?", [$title, $content, json_encode($filenames), $id]);

        go("/notices/$id", "공지를 수정했습니다.");
    }

    // 공지 삭제
    function deleteNotice($id){
        $notice = DB::find("notices", $id);
        if(!$notice) back("대상을 찾을 수 없습니다.");

        DB::query("DELETE FROM notices WHERE id = ?", [$id]);

        go("/notices", "공지를 삭제했습니다.");
    }

    // 파일 다운로드
    function downloadFile($filename){
        $info = fileinfo($filename);

        header("Content-Disposition: attachement; filename=". $info->name);
        readfile($info->localpath);
    }

    // 문의 추가
    function insertInquire(){
        checkEmpty();
        extract($_POST);

        if(mb_strlen($title) > 50) back("제목은 50자 이하여야 합니다.");

        DB::query("INSERT INTO inquires(uid, title, content) VALUES (?, ?, ?)", [user()->id, $title, $content]);
        go("/inquires", "문의가 작성되었습니다.");
    }

    // 답변 추가
    function insertAnswer(){
        checkEmpty();
        extract($_POST);

        $inquire = DB::find("inquires", $iid);
        if(!$inquire) back("대상을 찾을 수 없습니다.");

        DB::query("INSERT INTO answers(iid, answer) VALUES (?, ?)", [$iid, $answer]);

        go("/inquires", "답변을 보냈습니다.");
    }


    // 한지 추가
    function insertPaper(){
        checkEmpty();
        extract($_POST);

        $image = $_FILES['image'];
        $filename = time(). "-" . $image['name'];
        move_uploaded_file($image['tmp_name'], UPLOAD."/$filename");

        DB::query("INSERT INTO papers(uid, paper_name, width_size, height_size, point, hash_tags, image)
                VALUES (?, ?, ?, ?, ?, ?, ?)",
                [ user()->id, $paper_name, $width_size, $height_size, $point, $hash_tags, $filename ]);

        $pid = DB::lastInsertId();
        DB::query("INSERT INTO inventory(uid, pid, count) VALUES (?, ?, ?)", [user()->id, $pid, -1]);

        go("/store", "상품을 등록했습니다.");
    }

    // 인벤토리 추가
    function insertInventory(){
        checkEmpty();
        extract($_POST);

        if(user()->point < $totalPoint){
            back("포인트가 부족하여 구매하실 수 없습니다.");
        }
        
        $cartList = json_decode($cartList);

        foreach($cartList as $item){
            $paper = DB::find("papers", $item->id);
            $exist = DB::fetch("SELECT * FROM inventory WHERE uid = ? AND pid = ?", [user()->id, $paper->id]);
            $totalPoint = $item->count * $paper->point;
            
            if($exist) {
                DB::query("UPDATE inventory SET count = count + ? WHERE id = ?", [$item->count, $exist->id]);
            } else {
                DB::query("INSERT INTO inventory (uid, pid, count) VALUES (?, ?, ?)", [user()->id, $item->id, $item->count]);
            }

            DB::query("UPDATE users SET point = point - ? WHERE id = ?", [$totalPoint, user()->id]);
            DB::query("UPDATE users SET point = point + ? WHERE id = ?", [$totalPoint, $paper->uid]);

            DB::query("INSERT INTO history(uid, point) VALUES (?, ?)", [$paper->uid, $totalPoint]);
        }
        

        go("/store", "총 {$totalCount}개의 한지가 구매되었습니다.");
    }

    // 인벤토리 수정
    function updateInventory($id){
        $item = DB::find("inventory", $id);
        if(!$item || $item->uid !== user()->id) return;

        checkEmpty();
        extract($_POST);

        DB::query("UPDATE inventory SET count = ?", [$count]);
    }

    // 인벤토리 삭제
    function deleteInventory($id){
        $item = DB::find("inventory", $id);
        if(!$item || $item->uid !== user()->id) return;

        DB::query("DELETE FROM inventory WHERE id = ?", [$id]);
    }


    // 작품 추가
    function insertArtwork(){
        checkEmpty();
        extract($_POST);

        $filename = upload_base64($image);

        DB::query("INSERT INTO artworks(uid, title, content, image, hash_tags) VALUES (?, ?, ?, ?, ?)", [user()->id, $title, $content, $filename, $hash_tags]);

        go("/entry", "작품을 등록했습니다.");
    }

    // 작품 수정
    function updateArtwork($id){
        $artwork = DB::find("artworks", $id);
        if(!$artwork) back("대상을 찾을 수 없습니다.");
        checkEmpty();
        extract($_POST);

        DB::query("UPDATE artworks SET title = ?, content = ?, hash_tags = ? WHERE id = ?", [$title, $content, $hash_tags, $id]);
        go("/artworks/$id", "수정되었습니다.");
    }

    // 작품 삭제
    function deleteArtwork($id){
        $artwork = DB::find("artworks", $id);
        if(!$artwork) back("대상을 찾을 수 없습니다.");
        DB::query("DELETE FROM artworks WHERE id = ?", [$id]);

        go("/artworks", "삭제했습니다.");
    }

    // 관리자 작품 삭제
    function deleteArtworkByAdmin($id){
        $artwork = DB::find("artworks", $id);
        if(!$artwork) back("대상을 찾을 수 없습니다.");
        checkEmpty();
        extract($_POST);

        DB::query("UPDATE artworks SET rm_reason = ? WHERE id = ?", [$rm_reason, $id]);

        go("/artworks", "삭제했습니다.");
    }


    // 평점 추가
    function insertScore(){
        checkEmpty();
        extract($_POST);

        $artwork = DB::find("artworks", $aid);
        if(!$artwork) back("대상을 찾을 수 없습니다.");

        DB::query("INSERT INTO scores(uid, aid, score) VALUES (?, ?, ?)", [user()->id, $aid, $score]);
        DB::query("UPDATE users SET point = point + 100 WHERE id = ?", [$artwork->uid]);

        go("/artworks/$aid");
    }
    
}