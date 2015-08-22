<!DOCTYPE html>
<html lang="en">
<head>
 <title><?php   echo $title  ?></title>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <link rel="stylesheet" href="extra.css">
 <!-- Load Bootstrap RTL theme from CDNJS -->
<link rel="stylesheet" href="//cdn.rawgit.com/morteza/bootstrap-rtl/master/dist/cdnjs/3.3.1/css/bootstrap-rtl.min.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
 <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
 <script type="text/javascript">
 $(document).ready(function(){
   $("#SearchForm" ).submit(function( event ) {
     event.preventDefault();
    var sf=$("#SF option:selected").val();
    var sk=$('#SK').val();
    var url="?fn=search&c="+sf+"&i="+sk;
  if (url) { // require a URL
      window.location = url; // redirect
  }

});
});

 function goTo(fun,f,ids,cl,msg){
   var r=true;
   if(f=="d")
   {
     r = confirm(msg);
   }
   if(r){
     $.post("direct.php",
     {
       i:ids,
       fn: fun,
       c:cl
     },
     function(data,status){
       $('#loading').hide();
       $("#myModal").modal("hide");
       $('.modal-backdrop').remove();
       $('body').removeClass( "modal-open" );
       $('#messeges').html(data);
     });
   }
 }


     $(function(){
       // bind change event to select
       $('#dynamic_select').on('change', function () {
           var url = $(this).val(); // get selected value
           if (url) { // require a URL
               window.location = url; // redirect
           }
           return false;
       });
       $(".chBox").change(function() {
           if(this.checked) {
             var url=$(this).attr('ch');
           }else{
             var url=$(this).attr('unch');
           }
           if (url) { // require a URL
               window.location = url; // redirect
           }
           return false;

       });
     });



 </script>

</head>
<body>
  <?php include ("views/navBar.php"); ?>

  <div id="messeges">
  </div>

<div class="container">
