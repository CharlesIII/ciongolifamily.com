<?php

require_once('rdb.php');

$id = $_POST["id"];
$admin = $_POST["admin"];
$message = $_POST["message"]; 

if ($message){
        $date=date('c');
        if ($admin=='yes') {
            $sql= "$call query_add_admin_recipe_comments(:id,:uid,:message,:date)" ;
        } else {
            $sql= "$call query_add_recipe_comments(:id,:uid,:message,:date)" ;
        }
        $sendcomment = $rdb->prepare($sql);
        $sendcomment->bindValue(':id', $id);
        $sendcomment->bindValue(':uid', $uid);
        $sendcomment->bindValue(':message', $message);
        $sendcomment->bindValue(':date', $date);
        
        if($sendcomment->execute()){
            $sendcomment->closeCursor();
            
            $sql = "$call query_recipe_comments(:id)";
            $commentquery = $rdb->prepare($sql);
            $commentquery->bindValue(':id', $id);
            $commentquery->execute();
            $err=$rdb->errorInfo();
            $commentNum = $commentquery->rowCount();
            $commentquery->closeCursor();
            echo "$commentNum|Submission Successful|$user";

        } else {
            echo "0|There was an error with the submission.";
        }
} else {
    echo "0|Please enter a comment.";
}

?>
