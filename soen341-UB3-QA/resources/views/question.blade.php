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

    <style>
            .like, .dislike {
                background:none!important;
                color:rgb(30, 144, 255);
                border:none; 
                padding:0!important;
                font: inherit;
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
                    </tr>
                </tbody>
            </table>


            <!-- Comments Form -->
            <div class="card my-4">
                <h5 class="card-header">Leave a Comment:</h5>
                <div class="card-body">
                    <form method="POST" action="/question/reply/{{$info['question']->id}}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <textarea name="body" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>

            <p>
				{{count($info['replies'])}} answers
            </p>
            <table class="answers table" width=100% style="background-color: #FAFAFA;">
                <br>
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
                                <button class="like" id="{{$reply->id}}bl">
                                    <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                </button>
                                <span id="{{$reply->id}}l">{{$reply->likectr}}</span>
                            </div>
                            <br />
                            <div style="color:teal; float:left; margin: 0 40% 0 50%;">
                                <button class="dislike" id="{{$reply->id}}bdl">
                                    <i class="fa fa-thumbs-up" style="transform: rotate(180deg); "aria-hidden="true"></i>
                                </button>
                                <span id="{{$reply->id}}dl">{{$reply->dislikectr}}</span>
                            </div>
                        </td>
                        <!--<td class="w3-padding w3-xlarge w3-teal" style="vertical-align:middle; ">-->
                        <td class="w3-padding w3-xlarge w3-text-green" style="vertical-align:middle;" width=15%>
						@if($info['qOwner'])
							<a href="/question/accept/{{$reply->id}}">
								<i class="fa fa-check-circle <?php if($reply->status == 1) echo 'fa-2x'; ?>"></i>
							</a>
							<a href="/question/normalize/{{$reply->id}}">
								<i class="fa fa-bars <?php if($reply->status == 0) echo 'fa-2x'; ?>"></i>
							</a>
							<a href="/question/reject/{{$reply->id}}">
								<i class="fa fa-ban <?php if($reply->status == -1) echo 'fa-2x'; ?>"></i>
							</a>
						@else
							@if($reply->status == -1)
								<i class="fa fa-ban <?php echo 'fa-2x'; ?>"></i>
							@elseif($reply->status == 1)
								<i class="fa fa-check-circle <?php echo 'fa-2x'; ?>"></i>
							@endif
						@endif
                        </td>
                    </tr>
					@endforeach
					@else
						<p>No comments</p>
					@endif
                </tbody>
            </table>
            <hr>
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

<script>
    $(document).ready(function(){
        $(".like").click(function(){
            let idAttr = $(this).attr("id")
            let id = idAttr.substr(0, idAttr.length - 2);

            let sid = "#" + id + "l";
            let did = "/question/like/" + id;

            $.get("/question/like/" + id, function(data, status){
                if(status == "success"){
                    $("#" + id + "l").text(data);
                    $("#" + idAttr).prop("disabled", true);
                    $("#" + id + "bdl").prop("disabled", false);
                }
            });
        });

        $(".dislike").click(function(){
            let idAttr = $(this).attr("id")
            let id = idAttr.substr(0, idAttr.length - 3);

            let sid = "#" + id + "dl";
            let did = "/question/dislike/" + id;

            $.get("/question/dislike/" + id, function(data, status){
                if(status == "success"){
                    $("#" + id + "dl").text(data);
                    $("#" + idAttr).prop("disabled", true);
                    $("#" + id + "bl").prop("disabled", false);
                }
            });
        });
    });
</script>

</body>

</html>
