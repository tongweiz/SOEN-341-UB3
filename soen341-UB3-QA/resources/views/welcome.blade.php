<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title> Jux - Dashboard </title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/blog-home.css" rel="stylesheet">

    <!-- general background css -->
    <link href="/css/general.css" rel="stylesheet">

    <style>
        .dropdown-menu {
            left: 50%;
            right: auto;
            text-align: center;
            transform: translate(-50%, 0);
        }

        .click {
            cursor: pointer;
        }
    </style>
</head>
<body>

<!-- Navigation -->
@include('header')

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <h1 class="my-4">
                <small> Discover User Questions!</small>
            </h1>

            <div class="btn-group" style="margin-top: 10px; margin-bottom: 25px">

                <h5 style="margin-top: 5px; margin-right: 10px"> Order By: </h5>
                <div class="dropdown" style="margin-right: 50px">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" id="ordo">
                        ...<span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li id="ord" class="date"><a class="click order" id="date">Date</a></li>
                        <li><a class="click order" id="replies">Number of Replies</a></li>
                        <li><a class="click order" id="title">Title</a></li>
                        <li><a class="click order" id="updated">Last Updated</a></li>
                    </ul>
                </div>

                <h5 style="margin-top: 5px; margin-right: 10px"> Direction: </h5>
                <div class="dropdown" style="margin-right: 50px">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" id="diro">
                        ...<span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li id="dir" class="asc"><a class="click orderD" id="asc">Ascending</a></li>
                        <li><a class="click orderD" id="desc">Descending</a></li>
                    </ul>
                </div>

            </div>

                <!-- Question Post -->
                @include('common_questions')

        </div>
            @include('sidebar')
    </div>

        <!-- /.row -->

    </div>
    <!-- /.container -->

    <!-- Footer -->
@include('footer')

<!-- Bootstrap core JavaScript -->
    <script src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.bundle.min.js"></script>

    <!-- script to order questions -->
    <script type="text/javascript" src="{{ URL::asset('js/order-questions.js') }}"></script>

</body>

</html>
