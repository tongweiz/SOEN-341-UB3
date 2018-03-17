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

</head>
<body class="Site">

<!-- Navigation -->
@include('header')

<!-- Page Content -->
<div class="container Site-content">

    <div class="row">

        <div class="col-md-8">
            <h1 class="my-4">
                <small> Questions you previously asked on Jux!</small>
            </h1>

            <!-- Print questions-->
            @include('common_questions')

        </div>

        <!-- Sidebar Widgets Column -->
        <div class="col-md-4">

        <!-- Edit Profile Widget -->
            <div class="card my-4 ">
                <h5 class="card-header">Who are you? </h5>
                <div class="card-body">

                    <!-- We only have one user but a foreach makes the array easier to manipulate (TO MODIFY)-->
                    @foreach($user_info as $key => $data)
                        {!! Form::open(['url' => 'home']) !!}
                        <div class="row">
                            <div class="col-lg-auto">
                                <ul style="list-style-type: none; padding: 0; margin: 0;">
                                    <li><p style="margin-bottom: 0; font-weight: bold;"> Name: </p>
                                        <input id="username-input" type="text" value="{{$data->name}}"
                                               style="margin-bottom: 15px;" disabled>
                                    </li>

                                    <li><p style="margin-bottom: 0; font-weight: bold;"> Email: </p>
                                        <input id="email-input" type="text" value="{{$data->email}}"
                                               style="margin-bottom: 15px;" disabled>
                                    </li>

                                    <li><p style="margin-bottom: 0; font-weight: bold;"> Password: </p>
                                        <input id="password-input" type="password" value="**ENCRYPTED**"
                                               style="margin-bottom: 15px;" disabled>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <span class="input-group-btn">
                            <button type="button" id="edit-info" class="btn btn-secondary edit-info-js"> Edit </button>
                            <button type="button" id="save-info" class="btn btn-secondary save-info-js"
                                    name="{{$data->id}}"
                                    disabled style="margin-left: 25px"> Save </button>
                            <button type="button" id="cancel-info" class="btn btn-secondary cancel-info-js"
                                    disabled style="margin-left: 25px"> Cancel </button>
                        </span>

                        <p style="margin-top: 20px; visibility: hidden;" id="error_msg"></p>

                        {!! Form::close() !!}
                    @endforeach
                </div>
            </div>

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

<!--  script used to edit profile information! -->
<script type="text/javascript" src="{{ URL::asset('js/edit-info.js') }}"></script>

</body>

</html>
