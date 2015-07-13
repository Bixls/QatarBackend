

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
      <form role="form">
      <?php
        foreach ($body as $key=>$colum) {
          ?>
          <div class="form-group">
            <label for="<?php    echo($key); ?>"> <?php    echo($key); ?></label>
            <input class="form-control" id="<?php    echo($key); ?>" value="<?php    echo($colum); ?>" >
          </div>
          <?php
        }
      ?>
         <button type="submit" class="btn btn-default">Submit</button>
    </form>
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

});
</script>
