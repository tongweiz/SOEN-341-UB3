<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title> Jux - Ask a Question </title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/blog-post.css" rel="stylesheet">
</head>

<body>

<!-- Navigation -->
@include('header')

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Post Content Column -->
        <div class="col-lg-8">

            <!-- Title -->
            <h1 class="mt-4">Have a question? Ask below!</h1>

            <!-- Comments Form -->
            <div class="card my-4">
                {!! Form::open(['url' => 'ask']) !!}
                <div class="card-body">
                    <div class="form-group">
                        {!! Form::label('title','Title:') !!}
                        {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Enter your question title here']) !!}
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        {!! Form::label('content', 'Contents:') !!}
                        {!! Form::textarea('content', null, ['class' => 'form-control', 'placeholder' => 'Enter the details of your question here']) !!}
                    </div>
                    {{--</form>--}}
                </div>
                <div class="card-body">
                    {{--<form>--}}
                        <div class="form-group">
                            {{--<h4 class="mt-4">Label 1:(optional)</h4>--}}
                            {{--<textarea class="form-control" rows="1"></textarea>--}}
                            {!! Form::label('label_1','Label 1:(optional)') !!}
                            {!! Form::text('label_1', null, ['class' => 'form-control',
                            'placeholder' => 'Enter the label 1 of your question here']) !!} 
                        </div>
                        <div class="form-group">
                            {{--<h4 class="mt-4">Label 2:(optional)</h4>--}}
                            {{--<textarea class="form-control" rows="1"></textarea>--}}
                            {!! Form::label('label_2','Label 2:(optional)') !!}
                            {!! Form::text('label_2', null, ['class' => 'form-control', 
                            'placeholder' => 'Enter the label 2 of your question here']) !!} 
                        </div>
                        {!! Form::submit('Submit', ['class' => 'btn btn-primary', 'name' => 'Submit']) !!}
                </div>
                {!! Form::close() !!}
            </div>


            <!-- Comment with nested comments -->
            <div class="media mb-4">

                <div class="media-body">

                    <div class="media mt-4">
                        <div class="media-body">
                        </div>
                    </div>

                    <div class="media mt-4">
                        <div class="media-body">
                        </div>
                    </div>

                </div>
            </div>

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
