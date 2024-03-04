<?php

namespace application\src\models\post;

use application\src\controllers as Controller;
use application\src\models as Model;

class PostManager {

    public static function getPosts(){
        $query = "
            SELECT
                idPost,
                titlePost,
                chapoPost,
                textPost,
                category.nameCategory as categoryPost,
                user.firstNameUser as authorPost,
                DATE_FORMAT(dateCreationPost, '%d/%m/%Y') AS dateCreationPost,
                DATE_FORMAT(dateModificationPost, '%d/%m/%Y') AS dateModificationPost
            FROM 
                post
            JOIN 
                category ON category.idCategory = post.idCategory
            JOIN 
                adminUser ON adminUser.idAdminUser = post.idAdminUser
            JOIN 
                user ON user.idUser = adminUser.idUser
            ORDER BY 
                dateCreationPost DESC
        ";
        

        $result = Model\database\DbConnect::executeQuery($query);

        $posts = [];

        if (is_array($result)) {
            foreach ($result as $post) {
                $posts[] = new Post($post);
            }
            return $posts;
        }        

        return null;
    }

    public static function getPost($idPost){
        $query = "
            SELECT
                idPost,
                titlePost,
                chapoPost,
                textPost,
                category.nameCategory as categoryPost,
                user.firstNameUser as authorPost,
                DATE_FORMAT(dateCreationPost, '%d/%m/%Y') AS dateCreationPost,
                DATE_FORMAT(dateModificationPost, '%d/%m/%Y') AS dateModificationPost
            FROM 
                post
            JOIN 
                category ON category.idCategory = post.idCategory
            JOIN 
                adminUser ON adminUser.idAdminUser = post.idAdminUser
            JOIN 
                user ON user.idUser = adminUser.idUser
            WHERE 
                idPost = :idPost
        ";

        $params = [":idPost" => $idPost];
        $result = Model\database\DbConnect::executeQuery($query, $params);
    
        if (count($result) > 0) {
            return new Post($result[0]);
        }
    
        return null;
    }

}