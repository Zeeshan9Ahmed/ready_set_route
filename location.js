const express = require('express');
const app = express();
var fs = require('fs');
var admin = require("firebase-admin");
var serviceAccount = require("./ready-set.json");
admin.initializeApp({
    credential: admin.credential.cert(serviceAccount),
    //   databaseURL: "https://sample-project-e1a84.firebaseio.com"
});
const notification_options = {
    priority: "high",
    timeToLive: 60 * 60 * 24
};
const options = {
    key: fs.readFileSync('/home/serverappsstagin/ssl/keys/c2a88_d6811_bbf1ed8bd69b57e3fcff0d319a045afc.key'),
    cert: fs.readFileSync('/home/serverappsstagin/ssl/certs/server_appsstaging_com_c2a88_d6811_1665532799_3003642ca1474f02c7d597d2e7a0cf9b.crt'),
};

const server = require('https').createServer(options, app);
var io = require('socket.io')(server, {

    cors: {
        origin: "*",
        methods: ["GET", "POST", "PATCH", "DELETE"],
        credentials: false,
        transports: ['websocket', 'polling'],
        allowEIO3: true
    },
});

var mysql = require("mysql");
var con_mysql = mysql.createPool({
    host: "localhost",
    user: "serverappsstagin_readysetroute",
    password: "readysetroute",
    database: "serverappsstagin_readysetroute",
    debug: true
});

// SOCKET START
io.on('connection', function(socket) {

    // GET location EMIT
    socket.on('get_location', function(object) {

        var driver_room = "user_" + object.id;
        var customer_room = "user_" + object.ride_user_id;
        socket.join(customer_room);
        console.log(customer_room);
        get_location(object, function(response) {
            if (response) {
                console.log("get_driver has been successfully executed.", response);
                console.log("sender is" + object.id);
                io.to(customer_room).emit('response', { object_type: "get_driver", data: response });
            } else {
                console.log("get_driver has been failed...");
                io.to(customer_room).emit('error', { object_type: "get_driver", message: "There is some problem in get_driver2..." });
            }
        });
    });

    // SEND location EMIT
    socket.on('send_location', function(object) {

        var driver_room = "user_" + object.id;
        var customer_room = "user_" + object.ride_user_id;

        send_location(object, function(response) {
            if (response) {
                console.log("send_driver has been successfully executed.", customer_room);
                /*console.log(response);*/
                io.to(driver_room).to(customer_room).emit('response', { object_type: "get_driver", data: response });
            } else {
                console.log("send_driver has been failed...");
                io.to(driver_room).to(customer_room).emit('error', { object_type: "get_driver", message: "There is some problem in get_driver1..." });

            }
        });

    });


    socket.on('disconnect', function() {

        console.log("Use disconnection", socket.id)
    });
});
// SOCKET END



//start tracking
//Functions
// GET tracking FUNCTION
var get_location = function(object, callback) {
    con_mysql.getConnection(function(error, connection) {
        if (error) {
            callback(false);
        } else {
            connection.query(`SELECT * FROM users WHERE id = '${object.id}' ORDER BY id ASC`, function(error, data) {
                connection.release();
                if (error) {
                    callback(false);
                } else {
                    callback(data);
                }
            });
        }
    });
};


// SEND tracking FUNCTION
var send_location = function(object, callback) {
    con_mysql.getConnection(function(error, connection) {
        if (error) {
            callback(false);
        } else {

            verify_list(object, function(response) {
                if (response) {

                    console.log("success")

                    connection.query(`SELECT name, image WHERE id = '${response}' ORDER BY id ASC`, function(error, data) {
                        connection.release();
                        if (error) {
                            callback(false);
                        } else {

                            callback(data);
                        }
                    });

                } else {
                    console.log("verify_list has been failed...");
                    callback(false);
                }

            });

        }
    });
};


// VERIFY LIST FUNCTION
var verify_list = function(message, callback) {
    con_mysql.getConnection(function(error, connection) {
        if (error) {
            callback(false);
        } else {
            connection.query(`SELECT * from users where (id = ${message.id})  LIMIT 1 `, function(error, data) {
                if (error) {
                    callback(false);
                } else {
                    console.log(message);
                    var today = new Date();
                    var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
                    var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                    var dateTime = date + ' ' + time;
                    console.log(dateTime);
                    if (data.length === 0) {

                        connection.query(`INSERT INTO users (id , latitude , longitude , created_at) 
                        VALUES ('${message.id}' , '${message.latitude}', '${message.longitude}' , '${dateTime}') where id = '${(data[0].id)}' `, function(error, data) {
                            connection.release();
                            if (error) {
                                callback(false);
                            } else {
                                console.log("data.insertId")
                                callback(data.insertId);
                            }
                        });
                    } else {
                        connection.query(`UPDATE  users SET latitude= '${message.latitude}', longitude= '${message.longitude}' where id= '${(data[0].id)}' `, function(error, data) {
                            connection.release();
                            if (error) {
                                callback(false);
                            }
                        });
                        callback(data[0].id);
                    }
                }
            });
        }
    });
};

// SERVER LISTENER
server.listen(3003, function() {
    console.log("Server is running on port 3003");
});