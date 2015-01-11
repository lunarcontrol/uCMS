<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Simple Admin</title>
    <link href="media/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="media/css/custom.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="media/js/html5shiv.js"></script>
      <script src="media/js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="navbar navbar-inverse" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle Nav</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Simple Admin</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#">Link</a></li>
            <li><a href="#">Link</a></li>
            <li><a href="#">Logout</a></li>
          </ul>
          <form class="navbar-form navbar-right" method="get" action="#" role="form">
            <div class="form-group">
              <input type="text" placeholder="Search" name="s" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Search</button>
          </form>
        </div><!--/.nav-collapse -->
      </div>
    </div>




    <div class="container">

      <div class="row">

        <div class="col-sm-3 col-md-2">

          <div class="list-group">
            <a href="index.html" class="list-group-item"><span class="glyphicon glyphicon-dashboard"></span> Dashboard</a>
            <a href="users.html" class="list-group-item"><span class="glyphicon glyphicon-user"></span> Users</a>
            <a href="#" class="list-group-item"><span class="badge">3</span> <span class="glyphicon glyphicon-flag"></span> Notices</a>
            <a href="forms.html" class="list-group-item"><span class="glyphicon glyphicon-th-list"></span> Forms</a>
            <a href="media.html" class="list-group-item"><span class="glyphicon glyphicon-picture"></span> Media</a>
          </div>

        </div> <!-- end left -->

        <div class="col-sm-9 col-md-10">

          <div class="panel panel-default">			

                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </div>
              </form>

            </div>
          </div>


        </div><!-- end right -->

      </div><!-- end main row -->

    </div><!-- end container -->

    <script src="media/js/jquery-1.10.2.min.js"></script>
    <script src="media/bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>