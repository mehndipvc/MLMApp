<?php
function myResponseNoData($code){
    $msgg=" ";
    if($code==200){
        $msgg="ok";
    }else if($code==201){
        $msgg="CREATED";
    }else if($code==204){
        $msgg="NO CONTENT";
    }else if($code==405){
        $msgg="NOT ALLOWED";
    }else if ($code==400){
        $msgg="BAD REQUEST";
    }
    $data = [
        'status' => $code,
        'message' => $msgg,
    ];
    header("HTTP/1.0 $code $msgg ");
    return json_encode($data);
    exit();
}

function myResponseWithData($code,$data){
    $msgg="";
    if($code==200){
        $msgg="ok";
    }else if($code==201){
        $msgg="CREATED";
    }else if($code==204){
        $msgg="NO CONTENT";
    }else if($code==405){
        $msgg="NOT ALLOWED";
    }else if ($code==400){
        $msgg="BAD REQUEST";
    }

    $data = [
        'status' => $code,
        'message' => $msgg,
        'data' => $data
    ];
    header("HTTP/1.0 $code $msgg ");
    return json_encode($data);
    exit();
}

function myResponseWithMessage($code,$data){
    $msgg="";
    if($code==200){
        $msgg="ok";
    }else if($code==201){
        $msgg="CREATED";
    }else if($code==204){
        $msgg="NO CONTENT";
    }else if($code==405){
        $msgg="NOT ALLOWED";
    }else if ($code==400){
        $msgg="BAD REQUEST";
    }
    
    $data = [
        'status' => $code,
        'message' => $data
    ];
    header("HTTP/1.0 $code $msgg ");
    return json_encode($data);
    exit();
}
?>