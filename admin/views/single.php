

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

      if(isset($ViewImage)){echo ('<div class="col-md-6"><img class="img-responsive " src="../image.php?id='.$ViewImage.'" /></div>');}
      echo ('<div class="col-md-6">'.$body);
      if(isset($menus)){echo('<div>'.$menus.'</div>');}
      echo("</div>");

       ?>

<div class="col-md-12"></div>
        </div>
        <div class="modal-footer" style="clear: both;">
          <button type="button" class="btn btn-default" data-dismiss="modal">اغلاق</button>
        </div>
      </div>

    </div>
  </div>


<script>
function goTo(fun,f,id,cl){
  var r=true;
  if(f=="d")
  {
    r = confirm("do you Realy want to delete "+id);
  }
  if(r){
    $.post("direct.php",
    {
      i:id,
      fn: fun,
      c:cl
    },
    function(data,status){
      $('#loading').hide();
      $("#myModal").modal("hide");
      $('#messeges').append(data);
    });
  }
}


$(document).ready(function(){
  $("#myModal").modal();
  $("#mForm").on('submit',(function(e) {
  e.preventDefault();
  $('#loading').append("loading");
  $.ajax({
  url: "direct.php", // Url to which the request is send
  type: "POST",             // Type of request to be send, called as method
  data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
  contentType: false,       // The content type used when sending data to the server.
  cache: false,             // To unable request pages to be cached
  processData:false,        // To send DOMDocument or non processed data file it is set to false
  success: function(data)   // A function to be called if request succeeds
  {
  $('#loading').hide();
  $("#myModal").modal("hide");
  $('#messeges').append(data);
  }
  });
  }));
});
</script>
</script>
