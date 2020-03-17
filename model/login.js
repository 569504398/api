let fs = require("fs")
let path = require("path")
exports.find = function (form, callback) {
        fs.readFile(path.join(__dirname, "../db/login.json"), "utf8", function (err, data) {
                if (err) {
                        return callback(err)
                }
                let user = JSON.parse(data).username
                let res = user.find(function (item) {
                        return item.user.includes(form.user) && item.password.includes(form.password)
                })
                callback(null, res)
        })
}


// 127.0.0.1:7000/users?perCount=2&currentPage=1&name=""
exports.getUser = function (obj, callback) {
        fs.readFile(path.join(__dirname, "../db/users.json"), "utf8", function (err, data) {
                if (err) {
                        return callback(err)
                }
                let perCount = obj.perCount
                let currentPage = obj.currentPage
                const users = JSON.parse(data).users

                function getfilter(users, perCount, currentPage) {
                        //总记录数    4
                        let count = users.length
                        //总页数    2
                        let pages;
                        if (count % perCount !== 0) {
                                pages = parseInt(count / perCount) + 1
                        } else {
                                pages = count / perCount
                        }
                        let from = (currentPage - 1) * perCount
                        let arr = users.slice(from, from + parseInt(perCount))
                        callback(null, {
                                count,
                                pages,
                                arr
                        })
                }
                if (obj.name !== "") {
                        let newUser = users.filter(function (item) {
                                return item.user.includes(obj.user)
                        })
                        getfilter(newUser, perCount, currentPage)
                } else {
                        getfilter(users, perCount, currentPage)
                }
        })
}


// http://127.0.0.1:7000/users/2/state/true
exports.UpdateStatus = function (obj, callback) {
        fs.readFile(path.join(__dirname, "../db/users.json"), "utf8", function (err, data) {
                if (err) {
                        return callback(err)
                }
                const users = JSON.parse(data).users
                let currentUser = users.find(function (item) {
                        return item.id == obj.id
                })
                //改变的是引用类型，user这个数组，并没有改变data这个json串
                currentUser.status = !currentUser.status
                let json = JSON.stringify({
                        "users": users
                })
                fs.writeFile(path.join(__dirname, "../db/users.json"), json, 'utf8', function (err) {
                        if (err) {
                                return callback(err)
                        }
                        callback(null)
                })
        })
}
// [
//         {"id":1,"user":"liuyi","email":"569504@qq.com","tel":123456,"status":true},
//         {"id":2,"user":"liuren","email":"569505@qq.com","tel":123457,"status":false},
//         {"id":3,"user":"zhangsan","email":"569506@qq.com","tel":123458,"status":true},
//         {"id":4,"user":"lisi","email":"569507@qq.com","tel":123496,"status":false},
//         {"id":5,"user":"wangwu","email":"569517@qq.com","tel":123296,"status":false},
//         {"id":6,"user":"wangwu","email":"569517@qq.com","tel":123296,"status":false}
//   ]
exports.addUser = function (obj, callback) {
        fs.readFile(path.join(__dirname, "../db/users.json"), "utf8", function (err, data) {
                if (err) {
                        return callback(err)
                }
                const users = JSON.parse(data).users
                //获取元素中最大的id，创建一个新的id
                let newId = users.sort(function (a, b) {
                        return b.id  - a.id
                })[0].id + 1
                obj.id = newId
                obj.status = false  
                users.push(obj)
                let json = JSON.stringify({
                        "users": users
                })
                fs.writeFile(path.join(__dirname, "../db/users.json"), json, 'utf8', function (err) {
                        if (err) {
                                return callback(err)
                        }
                        callback(null)
                })
        })
}

exports.editUser = function (obj,callback){
        fs.readFile(path.join(__dirname, "../db/users.json"), "utf8", function (err, data) {
                if (err) {
                        return callback(err)
                }
                const users = JSON.parse(data).users 
                //  通过id获取对应的记录
                let   userInfo = users.find(function(item){
                         return  item.id == obj.id  
                })
                //获取修改的email,tel ,并修改用户信息
                  userInfo.email = obj.email
                  userInfo.tel =obj.tel    
                   let json = JSON.stringify({
                           "users":users
                   })
                   fs.writeFile(path.join(__dirname, "../db/users.json"), json, 'utf8', function (err) {
                        if (err) {
                                return callback(err)
                        }
                        callback(null)
                })
        })
}

exports.deleteUser = function (id,callback){
        fs.readFile(path.join(__dirname, "../db/users.json"), "utf8", function (err, data) {
                if (err) {
                        return callback(err)
                }

                
                const users = JSON.parse(data).users  
                //通过id获取该id对象在数组中所于的索引
                let index = users.findIndex(function(item){
                        return item.id ==  id
                })
                 users.splice(index,1)      
                 let json = JSON.stringify({
                        "users":users
                })
                fs.writeFile(path.join(__dirname, "../db/users.json"), json, 'utf8', function (err) {
                     if (err) {
                             return callback(err)
                     }
                     callback(null)
             })
        })
}