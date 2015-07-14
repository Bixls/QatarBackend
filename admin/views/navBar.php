<nav class="navbar navbar-default">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Qatar Invitations</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Members <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="?fn=viewUnApprovedMemberList&c=members&i=0">Approve Members</a></li>
              <li><a href="?fn=viewMemberList&c=members&i=0">View All</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
           aria-haspopup="true" aria-expanded="false">Groups <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a class="menuLinks" id="CreateGroup" i="0" c="groups" fn="CreateNew" href="#">Create New</a></li>
            <li><a href="?fn=viewGroupList&c=groups&i=0">View All</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
           aria-haspopup="true" aria-expanded="false">Events <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="?fn=ViewUnApprovedEventList&c=events&i=0">Approve Events</a></li>
            <li><a href="?fn=ViewEventList&c=events&i=0">View All</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
          aria-haspopup="true" aria-expanded="false">News <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Create New</a></li>
            <li><a href="#">View All</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
          aria-expanded="false">Advertising <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Create New</a></li>
            <li><a href="#">View All</a></li>
          </ul>
        </li>
      </ul>
      <form class="navbar-form navbar-left" role="search">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Account <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Sign out</a></li>
            <li><a href="#">Change password</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<script type="text/javascript">
$(document).ready(function(){
    $(".menuLinks").click(function(event){
      $.post("direct.php",
      {
        i:$("#"+event.target.id).attr( "i" ),
        fn:$("#"+event.target.id).attr( "fn" ),
        c:$("#"+event.target.id).attr( "c" )
      },
      function(data,status){
        $('#messeges').html(data);
      });

    });
});
</script>
