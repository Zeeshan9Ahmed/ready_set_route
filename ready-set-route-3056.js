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
// const options = {
//     key: fs.readFileSync('/home/serverappsstagin/ssl/keys/c2a88_d6811_bbf1ed8bd69b57e3fcff0d319a045afc.key'),
//     cert: fs.readFileSync('/home/serverappsstagin/ssl/certs/server_appsstaging_com_c2a88_d6811_1665532799_3003642ca1474f02c7d597d2e7a0cf9b.crt'),
// };

// const server = require('https').createServer(options, app);
const server = require('http').createServer(app);

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
    user: "root",
    password: "",
    database: "ready-set-route",
    debug: true
});

// SOCKET START
io.on('connection', function(socket) {


    //users
    socket.on('get_users', function(object) {

        var driver_room = "user_" + object.id;
        var customer_room = "user_" + object.ride_user_id;
        socket.join(customer_room);
        console.log(customer_room);
        get_users(object, function(response) {
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

    // GET MESSAGES EMIT
    socket.on('get_messages', function(object) {
        // console.log("GET_MESG", object.sender_id);
        // return;
        var user_room = "user_" + object.sender_id+" "+object.sender_type;
        socket.join(user_room);

        get_messages(object, function(response) {
            if (response) {
                console.log("get_messages has been successfully executed...");
                io.to(user_room).emit('response', { object_type: "get_messages", data: response });
            } else {
                console.log("get_messages has been failed...");
                io.to(user_room).emit('error', { object_type: "get_messages", message: "There is some problem in get_messages..." });
            }
        });
    });





    // SEND MESSAGE EMIT
    socket.on('send_message', function(object) {

        var sender_room = "user_" + object.sender_id+" "+object.sender_type;
        var receiver_room = "user_" + object.reciever_id+" "+object.reciever_type;
        console.log("trting to send mesg", object);
        var user_name = "";
        sender_user(object, function(response) {
            user_name = response[0].name;
        });
        send_message(object, function(response) {
            if (response) {
                console.log("send_message has been successfully executed...");
                io.to(sender_room).to(receiver_room).emit('response', { object_type: "get_message", data: response[0] });
                // get_user_token(object, function(response) {
                //     if (response.length > 0) {
                //         const message_notification = {
                //             notification: {
                //                 title: user_name + " Messaged to You ",
                //                 body: "New Message Recieved"
                //             },
                //              data: {
                //                 title: user_name + " Messaged to You ",
                //                 body: "New Message Recieved"
                //             }
                           
                //         };
                //         //Push Notification
                //         const registrationToken = response[0].device_token;
                //         const options = notification_options
                //         admin.messaging().sendToDevice(registrationToken, message_notification, options);

                //     }
                // });
            } else {
                console.log("send_message has been failed...");
                io.to(sender_room).to(receiver_room).emit('error', { object_type: "get_message", message: "There is some problem in get_message..." });
            }
        });
    });


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





var get_messages = function(object, callback) {
    con_mysql.getConnection(function(error, connection) {
        if (error) {
            callback(false);
        } else {
            connection.query(`select chats.* ,
            (CASE 
            WHEN sender_type = "admin" THEN (  (select admins.name from admins where id = chats.sender_id )   )  
            WHEN sender_type = "teacher" THEN (  (select teachers.name from teachers where id = chats.sender_id )   )  
            WHEN sender_type = "user" THEN (  (select users.name from users where id = chats.sender_id )   )  
            WHEN sender_type = "school" THEN (  (select schools.name from schools where id = chats.sender_id )   )  
            WHEN sender_type = "driver" THEN (  (select drivers.name from drivers where id = chats.sender_id )   )
            
            ELSE ""
            END 

            ) as name,
            (CASE 
            WHEN sender_type = "admin" THEN (  (select admins.image from admins where id = chats.sender_id )   )  
            WHEN sender_type = "teacher" THEN (  (select teachers.image from teachers where id = chats.sender_id )   )  
            WHEN sender_type = "user" THEN (  (select users.image from users where id = chats.sender_id )   )  
            WHEN sender_type = "school" THEN (  (select schools.image from schools where id = chats.sender_id )   )  
            WHEN sender_type = "driver" THEN (  (select drivers.image from drivers where id = chats.sender_id )   )
            
            ELSE ""
            END 

            ) as image 
            from chats 
            where 
            ( (chats.sender_id = ${object.sender_id} AND chats.reciever_id = ${object.reciever_id}) 
            OR ( chats.sender_id = ${object.reciever_id} AND chats.reciever_id = ${object.sender_id} ) ) 
            AND ( (chats.sender_type = "${object.sender_type}" AND chats.reciever_type = "${object.reciever_type}") 
            OR (chats.sender_type = "${object.reciever_type}" AND chats.reciever_type = "${object.sender_type}") ) order by id ASC`, function(error, data) {
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


// GET users FUNCTION
var get_users = function(object, callback) {
    con_mysql.getConnection(function(error, connection) {
        if (error) {
            callback(false);
        } else {
            connection.query(`SELECT id,latitude,longitude FROM users WHERE role = "student" ORDER BY id ASC`, function(error, data) {
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


// SEND MESSAGE FUNCTION
var send_message = function(object, callback) {
    console.log("Send msf call bacj")
    con_mysql.getConnection(function(error, connection) {
        if (error) {
            console.log("CONNECTIOn ERROR ON SEND MESSAFE")
            callback(false);
        } else {
            connection.query(`INSERT INTO chats (sender_id ,sender_type , reciever_id, reciever_type , message , created_at , updated_at ) 
                                                VALUES 
                                ('${object.sender_id}', '${object.sender_type}' , '${object.reciever_id}','${object.reciever_type}', '${object.message}', NOW(), NOW() )`, function(error, data) {
                if (error) {
                    console.log("FAILED TO VERIFY LIST")
                    callback(false);
                } else {
                    console.log("update_list has been successfully executed...");
                    connection.query(`select chats.* ,
                    (CASE 
                    WHEN sender_type = "admin" THEN (  (select admins.name from admins where id = chats.sender_id )   )  
                    WHEN sender_type = "teacher" THEN (  (select teachers.name from teachers where id = chats.sender_id )   )  
                    WHEN sender_type = "user" THEN (  (select users.name from users where id = chats.sender_id )   )  
                    WHEN sender_type = "school" THEN (  (select schools.name from schools where id = chats.sender_id )   )  
                    WHEN sender_type = "driver" THEN (  (select drivers.name from drivers where id = chats.sender_id )   )
                    
                    ELSE ""
                    END 
        
                    ) as name,
                    (CASE 
                    WHEN sender_type = "admin" THEN (  (select admins.image from admins where id = chats.sender_id )   )  
                    WHEN sender_type = "teacher" THEN (  (select teachers.image from teachers where id = chats.sender_id )   )  
                    WHEN sender_type = "user" THEN (  (select users.image from users where id = chats.sender_id )   )  
                    WHEN sender_type = "school" THEN (  (select schools.image from schools where id = chats.sender_id )   )  
                    WHEN sender_type = "driver" THEN (  (select drivers.image from drivers where id = chats.sender_id )   )
                    
                    ELSE ""
                    END 
        
                    ) as image 
                    from chats 
                    where 
                    chats.id = '${data.insertId}'`, function(error, data) {
                        connection.release();
                        if (error) {
                            callback(false);
                        } else {
                            callback(data);
                        }
                    });

                }
            });
        }
    });
};





//Push Notification

var get_user_token = function(object, callback) {
    con_mysql.getConnection(function(error, connection) {
        if (error) {
            callback(false);
        } else {
            connection.query(`select * from users where id=${object.reciever_id}`, function(error, data) {
                connection.release();
                if (error) {
                    callback(error);
                } else {
                    callback(data);
                }
            });
        }
    });
};

var sender_user = function(object, callback) {
    con_mysql.getConnection(function(error, connection) {
        if (error) {
            callback(false);
        } else {
            connection.query(`select * from users where id=${object.sender_id}`, function(error, data) {
                connection.release();
                if (error) {
                    callback(error);
                } else {
                    callback(data);
                }
            });
        }
    });
};

// end chat

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

                    connection.query(`SELECT name, image FROM users WHERE id = '${response}' ORDER BY id ASC`, function(error, data) {
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
server.listen(3056, function() {
    console.log("Server is running on port 3003");
});