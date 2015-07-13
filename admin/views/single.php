

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><? echo $header ?></h4>
        </div>
        <div class="modal-body">
      <?php
      echo $body;
       ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>


<script>
$(document).ready(function(){
  $("#myModal").modal();
  $("#uploadimage").on('submit',(function(e) {
  e.preventDefault();
  $('#loading').append("loading");
  $.ajax({
  url: "../upload.php", // Url to which the request is send
  type: "POST",             // Type of request to be send, called as method
  data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
  contentType: false,       // The content type used when sending data to the server.
  cache: false,             // To unable request pages to be cached
  processData:false,        // To send DOMDocument or non processed data file it is set to false
  success: function(data)   // A function to be called if request succeeds
  {
  $('#loading').hide();
  $("#msg").html(data);
  }
  });
  }));


});
</script>
