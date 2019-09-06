var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io').listen(server);
var ent = require('ent');
// Permet de bloquer les caractères HTML (sécurité équivalente à htmlentities en PHP)

server.listen(8000);
// Chargement de la page index.html
app.get('/', function (req, res) {
  res.sendfile(__dirname + '/templates/chat/index.html.twig');
});

io.sockets.on('connection', function (socket, pseudo) {
    // Dès qu'on nous donne un pseudo, on le stocke en variable de session et on informe les autres personnes
    socket.on('nouveau_client', function(pseudo) {
        pseudo = encode(pseudo);
        socket.pseudo = pseudo;
        socket.broadcast.emit('nouveau_client', pseudo);
    });

    // Dès qu'on reçoit un message, on récupère le pseudo de son auteur et on le transmet aux autres personnes
    socket.on('message', function (message) {
        message = encode(message);
        socket.broadcast.emit('message', {pseudo: socket.pseudo, message: message});
    });
});


