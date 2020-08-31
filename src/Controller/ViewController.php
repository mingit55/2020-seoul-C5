<?php
namespace Controller;

use App\DB;

class ViewController {
    function main(){
        view("main", [
            "artworks" => DB::fetchAll("SELECT A.*, user_name FROM artworks A LEFT JOIN users U ON U.id = A.uid WHERE rm_reason IS NULL ORDER BY id DESC LIMIT 0, 4"),
            "notices" => DB::fetchAll("SELECT * FROM notices ORDER BY id DESC LIMIT 0, 5")
        ]);
    }

    /**
     * 전주한지문화축제
     */
    function intro(){
        view("intro");
    }

    function roadmap(){
        view("roadmap");
    }

    /**
     * 한지상품판매관
     */
    function companies(){
        $companies = DB::fetchAll("SELECT U.*, IFNULL(totalPoint, 0) totalPoint
                                    FROM users U
                                    LEFT JOIN (SELECT SUM(point) totalPoint, uid FROM history GROUP BY uid) S ON S.uid = U.id
                                    WHERE U.type = 'company'
                                    ORDER BY totalPoint DESC");

        view("companies", [
            "rankers" => array_slice($companies, 0, 4),
            "companies" => pagination( array_slice($companies, 4) )
        ]);
    }

    function store(){
        view("store");
    }
    
    /**
     * 한지공예대전
     */
    function entry(){
        view("entry");
    }
    function artworks(){

        global $tags, $search;
        $tags = [];
        $search = isset($_GET['search']) && json_decode($_GET['search']) ? json_decode($_GET['search']) : [];

        $artworks = array_map(function($artwork){
            global $tags;
            $artwork->hash_tags = json_decode($artwork->hash_tags);
            array_push($tags, ...$artwork->hash_tags);
                   
            return $artwork;
        }, DB::fetchAll("SELECT DISTINCT A.*, user_name, type, IFNULL(score, 0) score
                            FROM artworks A
                            LEFT JOIN users U ON U.id = A.uid
                            LEFT JOIN (SELECT ROUND(AVG(score), 1) score, aid FROM scores GROUP BY aid) S ON S.aid = A.id
                            WHERE rm_reason IS NULL"));

        
        if(count($search) > 0){
            $artworks = array_filter($artworks, function($artwork){
                global $search;
                foreach($artwork->hash_tags as $tag){
                    if(array_search($tag, $search) !== false)
                        return true;
                }
                return false;
            });
        }

        view("artworks", [
            "tags" => $tags,
            "search" => $search,
            "myList" => !user() ? [] : array_map(function($artwork){
                $artwork->hash_tags = json_decode($artwork->hash_tags);
                return $artwork;
            }, DB::fetchAll("SELECT DISTINCT A.*, user_name, type, IFNULL(score, 0) score
                                FROM artworks A
                                LEFT JOIN users U ON U.id = A.uid
                                LEFT JOIN (SELECT ROUND(AVG(score), 1) score, aid FROM scores GROUP BY aid) S ON S.aid = A.id
                                WHERE A.uid = ?", [user()->id])),
            "rankers" => array_map(function($artwork){
                                    $artwork->hash_tags = json_decode($artwork->hash_tags);
                                    return $artwork;
                                }, DB::fetchAll("SELECT DISTINCT A.*, user_name, type, IFNULL(score, 0) score
                                                    FROM artworks A
                                                    LEFT JOIN users U ON U.id = A.uid
                                                    LEFT JOIN (SELECT ROUND(AVG(score), 1) score, aid FROM scores GROUP BY aid) S ON S.aid = A.id
                                                    WHERE A.created_at >= ? AND rm_reason IS NULL
                                                    ORDER BY score DESC
                                                    LIMIT 0, 4", [ date("Y-m-d", strtotime("-7 Day")) ])),
            "artworks" => pagination($artworks)
        ]);
    }
    function artwork($id){
        $artwork = DB::fetch("SELECT A.*, IFNULL(S.score, 0) score, M.id reviewed, user_email, user_name, U.image user_image, type
                                FROM artworks A
                                LEFT JOIN users U ON U.id = A.uid
                                LEFT JOIN (SELECT ROUND(AVG(score), 1) score, aid FROM scores GROUP BY aid) S ON S.aid = A.id
                                LEFT JOIN (SELECT id, uid, aid FROM scores WHERE uid = ?) M ON M.aid = A.id
                                WHERE A.id = ?" ,[user() ? user()->id : '', $id]);
        if(!$artwork || $artwork->rm_reason) back("대상을 찾을 수 없습니다.");
        $artwork->hash_tags = json_decode($artwork->hash_tags);

        view("artwork", [
            "artwork" => $artwork
        ]);
    }

    /**
     * 축제 공지사항
     */
    function notices(){
        view("notices", [
            "notices" => pagination(DB::fetchAll("SELECT * FROM notices ORDER BY id DESC"))
        ]);
    }
    function notice($id){
        $notice = DB::find("notices", $id);
        if(!$notice) back("대상을 찾을 수 없습니다.");       
        $notice->files = json_decode($notice->files);

        view("notice", [
            "notice" => $notice
        ]);
    }
    function inquires(){
        if(admin())
            view("inquires-admin", [
                "inquires" => DB::fetchAll("SELECT I.*, A.id answered
                                            FROM inquires I
                                            LEFT JOIN answers A ON A.iid = I.id")
            ]);
        else if(user()) 
            view("inquires-user", [
                "inquires" => DB::fetchAll("SELECT I.*, A.id answered
                                            FROM inquires I
                                            LEFT JOIN answers A ON A.iid = I.id
                                            WHERE I.uid = ?", [user()->id])
            ]);
        else go("/sign-in", "로그인 후 이용하실 수 있습니다.");
    }

    /**
     * 회원관리
     */
    function signIn(){
        view("sign-in");
    }
    function signUp(){
        view("sign-up");
    }
}