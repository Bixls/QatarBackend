

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
      echo ('<div class="col-md-6">'.$body.'<div>'.$menus.'</div></div>');

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
$(document).ready(function(){
  $("#myModal").modal();
});
</script>
