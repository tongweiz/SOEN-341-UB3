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

    <!--Token needed for ajax call when editing user info-->
    <meta name="csrf-token" content="{{ csrf_token() }}">


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
<body id="welcome_body" class="Site">

<!-- Navigation -->
@include('header')

<!-- Page Content -->
<div class="container Site-content">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <h1 class="my-4">
                <small> Discover User Questions!</small>
            </h1>

            <div class="btn-group" style="margin-top: 10px; margin-bottom: 25px">

                <h5 style="margin-top: 5px; margin-right: 10px"> Order By: </h5>
                <div class="dropdown" style="margin-right: 50px">
                    <button dusk="dropdown1" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" id="ordo">
                        Date Created<span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li id="ord" class="date"><a dusk="datecreated" class="click order" id="Date Created">Date Created</a></li>
                        <li><a dusk="numreplies" class="click order" id="Number of Replies">Number of Replies</a></li>
                        <li><a dusk="title" class="click order" id="Title">Title</a></li>
                        <li><a dusk="lastupdated" class="click order" id="Last Updated">Last Updated</a></li>
                    </ul>
                </div>

                <h5 style="margin-top: 5px; margin-right: 10px"> Direction: </h5>
                <div class="dropdown" style="margin-right: 50px">
                    <button dusk="dropdown2" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" id="diro">
                        Ascending<span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li id="dir" class="asc"><a dusk="ascending" class="click orderD" id="asc">Ascending</a></li>
                        <li><a dusk="descending" class="click orderD" id="desc">Descending</a></li>
                    </ul>
                </div>

            </div>

            <!-- Question Post -->
            @include('common_questions')

        </div>

        <!-- Sidebar Widgets Column -->
        <div class="col-md-4">
            @include('sidebar_search')
            @include('sidebar_labels')
        </div>
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

<!-- Script with function to list questions with labels -->
<script type="text/javascript" src="{{ URL::asset('js/filter-labels.js') }}"></script>

</body>

</html>
