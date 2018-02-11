<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Blog Post - Start Bootstrap Template</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/blog-post.css" rel="stylesheet">

    <!--Styles for icons-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

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
            <h1 class="mt-4">Can (a==1 && a==2 && a==3) evaluate to true in Java?</h1>

            <!-- Author -->
            <p class="lead">
                by
                <a href="#">User #123123</a>
            </p>

            <hr>

            <!-- Date/Time -->
            <p>Posted on January 1, 2018 at 12:00 PM</p>

            <hr>
            <table class="table" style="background-color: #FAFAFA;">
                <tbody>
                    <tr class="question" >
                        <td width=70%>
                            <p>We know it can in JavaScript.<br />

                                But is it possible to print "Success" message on the condition given below in Java?<br />
                                <code>
                                    if (a==1 && a==2 && a==3) {<br />
                                        System.out.println("Success");<br />
                                    }<br />
                                </code>
                                Someone suggested:<br />
                                <code>
                                    int _a = 1;<br />
                                    int a  = 2;<br />
                                    int a_ = 3;<br />
                                    if (_a == 1 && a == 2 && a_ == 3) {<br />
                                        System.out.println("Success");<br />
                                    }<br />
                                </code>
                                But by doing this we are changing the actual variable. Is there any other way?<br />
                            </p>
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
                8 answers
            </p>
            <table class="answers table" width=100% style="background-color: #FAFAFA;">
                <tbody>
                    <tr class="answer">
                        <td class="answer-text" width=70%>
                            <p>
                                I HAVE A SOLUTION FOR YOU!
                            </p>
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
                        <!--<td class="w3-padding w3-xlarge w3-teal" style="vertical-align:middle; ">-->
                        <td class="w3-padding w3-xlarge w3-text-green" style="vertical-align:middle;" width=15%>
                            <i class="fa fa-check-circle"></i>
                        </td>
                    </tr>
                    <tr class="answer">
                        <td class="answer-text">
                            <p>
                                I have the wrong answer for you
                            </p>
                        </td>
                        <td class="rating" style="vertical-align:middle; "  width=15%>
                            <div style="color:teal; float:left; margin: 0 50% 0 50%;">
                                <a href="#">
                                    <i class="fa fa-thumbs-up" aria-hidden="true"></i></span> 7
                                </a>
                            </div>
                            <br />
                            <div style="color:teal; float:left; margin: 0 50% 0 50%;">
                                <a href="#">
                                    <i class="fa fa-thumbs-up" style="transform: rotate(180deg); "aria-hidden="true"></i> 2
                                </a>
                            </div>
                        </td>
                        <!--<td class="w3-padding w3-xlarge w3-teal" style="vertical-align:middle; ">-->
                        <td class="w3-padding w3-xlarge w3-text-red" style="vertical-align:middle; ">
                            <i class="fa fa-times"></i>
                        </td>
                    </tr>
                </tbody>
            </table>
            <hr>

            <!-- Comments Form -->
            <div class="card my-4">
                <h5 class="card-header">Leave a Comment:</h5>
                <div class="card-body">
                    <form method="POST" action="/reply">
						{{ csrf_field() }}
                        <div class="form-group">
                            <textarea name="body" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar Widgets Column -->
        <div class="col-md-4">

            <!-- Search Widget -->
            <div class="card my-4">
                <h5 class="card-header">Search</h5>
                <div class="card-body">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for...">
                        <span class="input-group-btn">
                  <button class="btn btn-secondary" type="button">Go!</button>
                </span>
                    </div>
                </div>
            </div>

            <!-- Categories Widget -->
            <div class="card my-4">
                <h5 class="card-header">Categories</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <ul class="list-unstyled mb-0">
                                <li>
                                    <a href="#">Web Design</a>
                                </li>
                                <li>
                                    <a href="#">HTML</a>
                                </li>
                                <li>
                                    <a href="#">Freebies</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-6">
                            <ul class="list-unstyled mb-0">
                                <li>
                                    <a href="#">JavaScript</a>
                                </li>
                                <li>
                                    <a href="#">CSS</a>
                                </li>
                                <li>
                                    <a href="#">Tutorials</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Side Widget -->
            <div class="card my-4">
                <h5 class="card-header">Side Widget</h5>
                <div class="card-body">
                    You can put anything you want inside of these side widgets. They are easy to use, and feature the new Bootstrap 4 card containers!
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

</body>

</html>
