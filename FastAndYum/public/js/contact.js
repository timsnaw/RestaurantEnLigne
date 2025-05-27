
document.getElementById("whatsappBtn").addEventListener("click", function () {
    var name = document.getElementById("name").value.trim();
    var email = document.getElementById("email").value.trim();
    var message = document.getElementById("message").value.trim();

    if (!name || !email || !message) {
        alert("Veuillez remplir tous les champs !");
        return;
    }

   
    var fullMessage = "Bonjour, je suis " + name +
                      " (" + email + ").\n\n" +
                      "Message :\n" + message;

    
    var encodedMessage = encodeURIComponent(fullMessage);

   
    var phoneNumber = "212712635736";

  
    var whatsappURL = "https://wa.me/" + phoneNumber + "?text=" + encodedMessage;
    window.open(whatsappURL, '_blank');
});