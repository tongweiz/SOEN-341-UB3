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
    .dropdown-menu
    {
        left: 50%;
        right: auto;
        text-align: center;
        transform: translate(-50%, 0);
    }

    .click
    {
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

            <div class="btn-group">
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" id="diro">Direction<span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li id="dir" class="asc"><a class="click orderD" id="asc">Ascending</a></li>
                        <li><a class="click orderD" id="desc">Descending</a></li>
                    </ul>
                </div>
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" id="ordo">Order By<span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li id="ord" class="date"><a class="click order" id="date">Date</a></li>
                        <li><a class="click order" id="replies">Number of Replies</a></li>
                        <li><a class="click order" id="title">Title</a></li>
                        <li><a class="click order" id="updated">Last Updated<a></li>
                    </ul>
                </div>
            </div>

            <div id="questions">
            <!-- Question Post -->
            @if(count($question_data) > 0)
                @foreach($question_data as $key => $data)
                    <div class="card mb-4">
                        <div class="card-body">

                            <!--Display question title -->
                            <h4 class="card-title">{{$data->title}}</h4> </br>

                            <!--Display first sentence of question content-->
                            <p class="card-text" style="margin-top: -20px; margin-bottom: 20px">
                                <?php $parts = explode('.', $data->content); echo($parts[0] . '...')?></p>

                            <!--Display labels of question (TO MODIFY WITH DB DATA)-->
                            <span id="labels-styled">LABEL 1</span> <span id="labels-styled">LABEL 2</span>

                            <!--Display read more button-->
                            <a href="/question/{{$data->id}}" class="btn btn-primary" name="Read" style="float: right;">Read
                                More &rarr;</a>
                        </div>

                        <!--Display who posted it and when -->
                        <div class="card-footer text-muted">
                            Posted on the <span style="text-decoration: underline;">
                            <?php $parts = explode('-', $data->updated_at);
                                $month = (DateTime::createFromFormat('!m', $parts[1]))->format('F');
                                echo substr($parts[2], 0, 2) . "th of $month of $parts[0] at " . substr($parts[2], 2)?> </span>
                            by <span style="text-decoration: underline;">{{$data->name}}</span>

                            <!--Displaynumber of replies-->
                            <span style="float: right"> #{{$data->nb_replies}} replie(s)</span>
                        </div>

                    </div>
                @endforeach

            </div>

            <!-- Pagination (TO IMPLEMENT IF WE HAVE TIME)-->
                <ul class="pagination justify-content-center mb-4">
                    <li class="page-item">
                        <a class="page-link" href="#">&larr; Older</a>
                    </li>
                    <li class="page-item disabled">
                        <a class="page-link" href="#">Newer &rarr;</a>
                    </li>
                </ul>
            @else
                <p>No question has been asked on the website yet! </p>
            @endif
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
