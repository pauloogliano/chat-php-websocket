const socket  = new WebSocket('ws://localhost:8080');
const message = document.getElementById('message');


function transmitMessage() {
  socket.send(message.value);
}

function clearInput() {
  message.value = "";
}

socket.onmessage = function(e) {
  const messageSent = JSON.parse(e.data);

  if (messageSent.from == "me") {
    var messageFromUser = document.createElement("p");
  } else {
    var messageFromUser = document.createElement("p");
  }
  messageFromUser.appendChild(document.createTextNode(messageSent.msg));
  document.getElementById("messages").appendChild(messageFromUser);
}



$(document).on("click", "button", function() {
  transmitMessage();
  clearInput();
});

$(document).on("keydown", function(e) {
  if (e.which == 13) {
    transmitMessage();
    clearInput();
  }
});
