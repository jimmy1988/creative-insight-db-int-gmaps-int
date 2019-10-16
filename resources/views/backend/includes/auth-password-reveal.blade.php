<script type="text/javascript" async defer>
  $(".toggle-password").click(function() {
    event.preventDefault();
    $(this).toggleClass("fas-eye fas-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });
</script>
