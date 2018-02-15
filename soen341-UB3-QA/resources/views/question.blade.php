<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title> Jux - Details of a Question </title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/blog-post.css" rel="stylesheet">

    <!--Styles for icons-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- This interferes with the look of the side bar in template needed for continuity.
         Try to find something else for accept/reject icons please. Not too ugly right now without it-->
    <!--<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">-->

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
            <h1 class="mt-4">{{$info['question']->title}}</h1>

            <!-- Author -->
            <p class="lead">
                by
                <a href="#">User #{{$info['question']->user_id}}</a>
            </p>

            <hr>

            <!-- Date/Time -->
            <p>Posted on {{$info['question']->created_at}}</p>

            <hr>
            <table class="table" style="background-color: #FAFAFA;">
                <tbody>
                    <tr class="question" >
                        <td width=70%>
                            {{$info['question']->content}}
                        </td>
                        <td class="rating" style="vertical-align:middle; "  width=15%>
                            <div style="color:teal; float:left; margin: 0 40% 0 50%;">
                                <a href="#">
                                    <i class="fa fa-thumbs-up" aria-hidden="true"></i></span> 7
                                </a>
                            </div>
                            <br />
                            <div style="color:teal; float:left; margin: 0 40% 0 50%;">
                                <a href="#">
                                    <i class="fa fa-thumbs-up" style="transform: rotate(180deg); "aria-hidden="true"></i> 2
                                </a>
                            </div>
                        </td>
                        <td class="" width=15%>

                        </td>
                    </tr>
                </tbody>
            </table>
            <p>
				{{count($info['replies'])}} answers
            </p>
            <table class="answers table" width=100% style="background-color: #FAFAFA;">
                <tbody>
                    @if(count($info['replies']) > 0)
						@foreach($info['replies'] as $reply)
                    <tr class="answer">
                        <td class="answer-text" width=70%>
                            <p>
							{{$reply->content}}
                            </p>
                        </td>
                        <td class="rating" style="vertical-align:middle; "  width=15%>
                            <div style="color:teal; float:left; margin: 0 40% 0 50%;">
                                <a href="#">
                                    <i class="fa fa-thumbs-up" aria-hidden="true"></i></span> {{$reply->likectr}}
                                </a>
                            </div>
                            <br />
                            <div style="color:teal; float:left; margin: 0 40% 0 50%;">
                                <a href="#">
                                    <i class="fa fa-thumbs-up" style="transform: rotate(180deg); "aria-hidden="true"></i> {{$reply->dislikectr}}
                                </a>
                            </div>
                        </td>
                        <!--<td class="w3-padding w3-xlarge w3-teal" style="vertical-align:middle; ">-->
                        <td class="w3-padding w3-xlarge w3-text-green" style="vertical-align:middle;" width=15%>
                            <i class="fa fa-check-circle"></i>
                        </td>
                    </tr>
					@endforeach
					@else
						<p>No comments</p>
					@endif
                </tbody>
            </table>
            <hr>

            <!-- Comments Form -->
            <div class="card my-4">
                <h5 class="card-header">Leave a Comment:</h5>
                <div class="card-body">
                    <form method="POST" action="/reply/{{$info['question']->id}}">
						{{ csrf_field() }}
                        <div class="form-group">
                            <textarea name="body" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
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
