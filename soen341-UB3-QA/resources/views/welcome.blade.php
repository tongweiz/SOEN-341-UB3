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

</head>
<body>

<!-- Navigation -->
@include('header')

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <h1 class="my-4"> <small> Discover User Questions! </small> </h1>

            <!-- Question Post -->
            @foreach($question_data as $key => $data)
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="card-title">{{$data->title}}</h4> </br>
                        <a href="#" class="btn btn-primary">Read More &rarr;</a>
                    </div>
                    <div class="card-footer text-muted"> Posted on  {{$data->updated_at}} by {{$data->name}}</div>
                </div>
            @endforeach

            <!-- Pagination (TO IMPLEMENT IF WE HAVE TIME)-->
            <ul class="pagination justify-content-center mb-4">
                <li class="page-item">
                    <a class="page-link" href="#">&larr; Older</a>
                </li>
                <li class="page-item disabled">
                    <a class="page-link" href="#">Newer &rarr;</a>
                </li>
            </ul>

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

</body>

</html>
