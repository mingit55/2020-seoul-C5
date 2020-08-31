<?php
namespace Controller;

use App\DB;

class ApiController {
    function getUser($user_email){
        json_response(
            DB::who($user_email)
        );
    }

    function getInquire($id){
        json_response(
            DB::fetch("SELECT I.*, user_name, user_email, A.answer, A.created_at answered_at
                                FROM inquires I
                                LEFT JOIN users U ON U.id = I.uid
                                LEFT JOIN answers A ON A.iid = I.id
                                WHERE I.id = ?", [$id])
        );
    }

    function getPapers(){
        json_response(
            array_map(function($paper){
                $paper->hash_tags = json_decode($paper->hash_tags);
                return $paper;
            }, DB::fetchAll("SELECT P.*, user_name company_name, U.id uid
                            FROM papers P
                            LEFT JOIN users U ON U.id = P.uid"))
        );
    }

    function getInventory(){
        json_response(
            DB::fetchAll("SELECT I.*, paper_name, image, width_size, height_size
                        FROM inventory I
                        LEFT JOIN papers P ON P.id = I.pid
                        WHERE I.uid = ?", [user()->id])
        );
    }
}