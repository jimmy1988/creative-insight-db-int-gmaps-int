function randomPassword(length = 10) {
    var chars = "abcdefghijklmnopqrstuvwxyz!@#$%^&*()-+<>ABCDEFGHIJKLMNOP1234567890";
    var pass = "";
    for (var x = 0; x < length; x++) {
        var i = Math.floor(Math.random() * chars.length);
        pass += chars.charAt(i);
    }
    return pass;
}

$(document).ready(function(){
  $(".generate-password-button").on("click", function(){
    $("#user_password, #user_password_confirm").val(randomPassword());
    $("#user_password, #user_password_confirm").attr("type", "text");
    $("#user_password").parent().children(".toggle-password").toggleClass("fa-eye-slash fa-eye");
    $("#user_password_confirm").parent().children(".toggle-password").toggleClass("fa-eye-slash fa-eye")
  });
});
