let fs = require("fs")
exports.find = function (callback){
        fs.readFile("./db/students.json","utf8",function(err,data){
                if(err){
                  return   callback(err)
                }
                 callback(null,data)
        })
}
// [
//         {"user":"liuyi","email":"569504@qq.com","tel":123456,"status":true},
//         {"user":"liuren","email":"569505@qq.com","tel":123457,"status":false},
//         {"user":"zhangsan","email":"569506@qq.com","tel":123458,"status":true},
//         {"user":"lisi","email":"569507@qq.com","tel":123496,"status":false}
//   ]




