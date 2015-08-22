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
      <a class="navbar-brand" href="index.php">دعوات قطر</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            الاعضاء <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="?fn=viewUnApprovedMemberList&c=members&i=0">الموافقع على الاعضاء</a></li>
              <li><a href="?fn=viewMemberList&c=members&i=0">عرض جميع الاعضاء</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
           aria-haspopup="true" aria-expanded="false">القبائل <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a onclick="goTo('CreateNew','CN','','groups','')" href="#">اضافه قبيله جديده</a></li>
            <li><a href="?fn=viewGroupList&c=groups&i=0">عرض جميع القبائل</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
           aria-haspopup="true" aria-expanded="false">المناسبات <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="?fn=ViewUnApprovedEventList&c=events&i=0">الموافقه على المناسبات</a></li>
            <li><a href="?fn=ViewEventList&c=events&i=0">عرض جميع المناسبات</a></li>
            <li><a href="?fn=getEventTypesList&c=general&i=0">عرض انواع الدعوات</a></li>
            <li><a onclick="goTo('CreateEventTypesNew','CN','','general','')" href="#">اضافه نوع دعوة جديد</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
          aria-haspopup="true" aria-expanded="false">الاخبار <span class="caret"></span></a>
          <ul class="dropdown-menu">
              <li><a onclick="goTo('CreateNew','CN','','news','')" href="#">اضافه خبر</a></li>
            <li><a href="?fn=ViewNewsList&c=news&i=0">عرض جميع الاخبار</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
          aria-expanded="false">خيارات<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">الاعلانات</a></li>
            <li><a href="#">رسائل البرنامج</a></li>
            <li><a href="#" onclick="goTo('CreateNew','CN','','Avatars','')">اضافه صوره رمزيه </a></li>
            <li><a href="?fn=getAvatarsList&c=avatars&i=0">الصور الرمزيه</a>  </li>
            <li><a href="?fn=viewFeedbackList&c=Feedbacks&i=0">الشكاوى و المقترحات</a></li>

          </ul>
        </li>
      </ul>
      <form class="navbar-form navbar-left" id="SearchForm" role="search">
        <div class="form-group">
          <input type="text" id="SK" class="form-control searchText"
          <?php //placeholding search with searching item
          $selectedSearch="";
           if(array_key_exists('fn', $_GET)&&array_key_exists('i', $_GET)){$selectedSearch=$_GET['c'];if($_GET['fn']=="search"){echo ("value=".$_GET['i']);}
          } ?>
           placeholder="بحث">
          <select class="form-control  searchDrop" id="SF">
            <?php
            $SearchElements=array(
            'members' => "الاعضاء",
            'groups' => "القبائل",
            'events' => "المناسبات",
            'news' => "الاخبار"
                  );
                  foreach ($SearchElements as $key => $value) {
                  echo("<option value='".$key."' ".($key==$selectedSearch?'selected':'').">".$value."</option>");
                  }
             ?>
      </select>
        </div>
        <button type="submit"  class="btn btn-default">بحث</button>
      </form>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            حسابي <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">تغير كلمه السر</a></li>
            <li><a href="logout.php">تسجيل خروج</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

</script>
