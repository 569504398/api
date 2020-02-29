<?php
  $URL="http://localhost:8080";
  // 设置允许访问的服务器,其它服务器是不允许获取该数据的
  header("Access-Control-Allow-Origin:".$URL);  
include_once("mysql.php");
$mysql= new  MyMysql("surpermall","goods_network");



      
//展示数据     show()
    if(isset($_GET["page"])){
        $pop=$mysql->show('pop');
        $new=$mysql->show('new');
        $sell=$mysql->show('sell');
    
        $data=[
                'pop'=>$pop,
                'new'=>$sell,
                'sell'=>$new
        ];
        $data=json_encode($data);

        echo $data;
  }
        
     function data(){
        $banner=[
            "  http://192.168.43.31:8000/images/swiper2.jpg",
            "  http://192.168.43.31:8000/images/swiper1.jpg",
            "  http://192.168.43.31:8000/images/swiper3.jpg",
        ];
        $recomond=[
            ["img"=>"http://192.168.43.31:8000/images/katong1.jpg","desc"=>"十点抢券"],
            ["img"=>  "  http://192.168.43.31:8000/images/katong2.jpg","desc"=>"好物特卖"],
            ["img"=>  "  http://192.168.43.31:8000/images/katong3.jpg","desc"=>"内购福利"],
            ["img"=> "  http://192.168.43.31:8000/images/katong4.jpg","desc"=>"初秋上新"],
        ]; 
        $title=[  "流行","新款","精选"];

        $data=['banner'=>$banner,'recomond'=>$recomond,'title'=>$title];
        return  $data;
     }

// getPages($per_count)  获取页数
if(isset($_GET["per_count"])&&isset($_GET["current_page"])){    
            $pop=$mysql->getPages($_GET["per_count"],$_GET["current_page"],"goods_network",'pop');
            $new=$mysql->getPages($_GET["per_count"],$_GET["current_page"],"goods_network",'new');
            $sell=$mysql->getPages($_GET["per_count"],$_GET["current_page"],"goods_network",'sell');
               $arr=data();
            //    echo "<pre>";
            //     print_r($arr);
            //    die();
            $data=[
                 'data'=>$arr,
                'pop'=>$pop,
                'new'=>$new,
                'sell'=>$sell,
            ];
             $data=json_encode($data);
             echo $data;
}
   
if(isset($_POST["per_count"])&&isset($_POST["current_page"])){    
    $pop=$mysql->getPages($_POST["per_count"],$_POST["current_page"],"goods_network",'pop');
    $new=$mysql->getPages($_POST["per_count"],$_POST["current_page"],"goods_network",'new');
    $sell=$mysql->getPages($_POST["per_count"],$_POST["current_page"],"goods_network",'sell');
       $arr=data();
    //    echo "<pre>";
    //     print_r($arr);
    //    die();
    $data=[
         'data'=>$arr,
        'pop'=>$pop,
        'new'=>$new,
        'sell'=>$sell,
    ];
     $data=json_encode($data);
     echo $data;
}

