 
 
 let express = require("express")
 let  bodyParse =   require ("body-parser")
let  router = require ("./router")
let  jwt = require("jsonwebtoken")


// 第一个参数是一个json对象或json串或buffer，第二 个参数是token的钥匙，后面是是可选参数如有效期，然后一个回调   

  //相当创建server
   let server = express()

//设置跨域请求
server.all('*', function(req, res, next) {
   res.header("Access-Control-Allow-Origin", "*");
   res.header("Access-Control-Allow-Headers", "Content-Type,Content-Length, Authorization, Accept,X-Requested-With");
   res.header("Access-Control-Allow-Methods","PUT,POST,GET,DELETE,OPTIONS");
   res.header("X-Powered-By",' 3.2.1')
   if(req.method=="OPTIONS") res.send(200);/*让options请求快速返回*/
   else  next();
});
 


server.use("/public/",express.static("./public/"))
server.use('/node_modules/',express.static('./node_modules/'))
server.engine("html",require('express-art-template'))
server.use(bodyParse.urlencoded({extended:false}))
server.use(bodyParse.json())

server.use(router)


   server.listen(7000,function(){
       console.log("启动成功");
  })


  
