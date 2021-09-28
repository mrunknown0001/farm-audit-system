<script type="text/javascript">
  var idleTime = 0;
  $(document).ready(function () {
    //Increment the idle time counter every minute.
    var idleInterval = setInterval(timerIncrement, 600000); // 10 minutes = 600000
    //Zero the idle timer on mouse movement.
    $(this).mousemove(function (e) {
      idleTime = 0;
    });
    $(this).keypress(function (e) {
      idleTime = 0;
    });
  });
  function timerIncrement() {
    idleTime = idleTime + 1;
    if (idleTime > 1) { // 20 minutes
      Swal.fire({
        title: 'Inactivity Logout!',
        text: "",
        type: 'info',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Close'
      }).then(() => {
        window.location.href = '/logout';
      });
    }
  }
</script> 