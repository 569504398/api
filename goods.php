<?php


// 路由：http://www.dofan.top:8081/goods.php?current_page=1&per_count=5
  $URL="http://127.0.0.1:8000";  //表示请求的服务器的电脑的8080软件能防问或者在请求的服务器在浏览器上能防问
//   如果是存在本地，表示这台电脑的node能够获取接口数据，8082就获取不到因为没有这个端口，并且请求栏地址的端口与这个端口是一样的
//   如果是存在远程，表示远程这台电脑的node能够获取接口数据，我在本地浏览器是获取不到的，实际上实际远程电脑获取远程接口
  header("Access-Control-Allow-Origin: *");  
include_once("mysql.php");
$mysql= new  MyMysql("surpermall","goods");



      
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
        $test=["a"=>1,"b"=>2];
        $banner=[
            "  http://localhost:8000/images/swiper2.jpg",
            "  http://localhost:8000/images/swiper1.jpg",
            "  http://localhost:8000/images/swiper3.jpg",
        ];
        $recomond=[
            ["img"=>"http://localhost:8000/images/katong1.jpg","desc"=>"十点抢券"],
            ["img"=>  "  http://localhost:8000/images/katong2.jpg","desc"=>"好物特卖"],
            ["img"=>  "  http://localhost:8000/images/katong3.jpg","desc"=>"内购福利"],
            ["img"=> "  http://localhost:8000/images/katong4.jpg","desc"=>"初秋上新"],
        ]; 
        $title=[  "流行","新款","精选"];
       
        $data=['banner'=>$banner,'recomond'=>$recomond,'title'=>$title,"test"=>$test];
        return  $data;
     }



    


// getPages($per_count)  获取页数
if(isset($_GET["per_count"])&&isset($_GET["current_page"])){    
            $pop=$mysql->getPages($_GET["per_count"],$_GET["current_page"],"goods",'pop');
            $new=$mysql->getPages($_GET["per_count"],$_GET["current_page"],"goods",'new');
            $sell=$mysql->getPages($_GET["per_count"],$_GET["current_page"],"goods",'sell');
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

//接收post请求

if(isset($_POST["per_count"])&&isset($_POST["current_page"])){    
  $pop=$mysql->getPages($_POST["per_count"],$_POST["current_page"],"goods",'pop');
  $new=$mysql->getPages($_POST["per_count"],$_POST["current_page"],"goods",'new');
  $sell=$mysql->getPages($_POST["per_count"],$_POST["current_page"],"goods",'sell');
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