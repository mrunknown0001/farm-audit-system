<script>
	  /**
	   * showNotification
	   * 
	   */
	  function showNotification(auditor)
	  {
	    const notification = new Notification("New Audit Notification", {
	      body: "New Audit Notification from " + auditor,
	      icon: "{{ asset('img/BGC.png') }}"
	    });

	    notification.addEventListener('click', () => {	
			  // datatable = $('#audits').DataTable();
				// datatable.ajax.reload();
				window.location.href = "{{ route('audit.review') }}";
	    });
	  }

	  /**
	   * triggerNotification
	   *
	   */
	  function triggerNotification(auditor) { 
	    if (Notification.permission === "granted") {
	      showNotification(auditor);
	    } 
	    else if (Notification.permission !== "denied") {
	      Notification.requestPermission().then(permission => {
	      if(permission === "granted") {
	        showNotification();
	      } else {
	        alert('Notification Permission Denied');
	      }
	      });
	    }
	  }


	  /**
	   * checkForUpdates
	   * 
	   */
	  function checkForUpdates() {
	    
	    a = $.ajax({
	      type: "GET",
	      url: '{{ route('reviewer.notification') }}',
	      success: function(data) {
	        if(data.id == 1) {
	        	triggerNotification(data.auditor);
	        }
	      },
	      dataType: "json"
	    });
	  
	    return a;
	  }


	  (function(){
	    // do something here
	    var num = checkForUpdates();

	    setTimeout(arguments.callee, 3000);
	  })();
</script>