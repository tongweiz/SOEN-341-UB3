<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Question Page (DB UPLOAD)</title>

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
            <h1 class="mt-4" id="question-title">Question Title (run script to upload question title)</h1>

            <div id="question-description">
                SOME DESCRIPTION FOR THE QUESTION (DB UPLOAD)
            </div>
            <div id="answer-list" >
                <div class="answer-container">


                    <div class="answer" style="display: inline-block; float:left; height:34px; border: 1px solid red">
                        ANSWER #1
                    </div>

                    <div class="rating" style="display: inline-block;">
                        <div style="color:red; float:left; ">
                            upvote 56
                        </div>
                        <div style="color:red;">
                            downvote 12
                        </div>
                    </div>
                    <div class="approved" style="display: inline-block; text-align: center;">
                        approved
                    </div>
                </div>

                <div class="answer-container">


                    <div class="answer" style="display: inline-block; float:left; height:34px; border: 1px solid red">
                        ANSWER #1
                    </div>

                    <div class="rating" style="display: inline-block;">
                        <div style="color:red; float:left; ">
                            upvote 56
                        </div>
                        <div style="color:red;">
                            downvote 12
                        </div>
                    </div>
                    <div class="approved" style="display: inline-block; text-align: center;">
                        approved
                    </div>
                </div>

                <div class="answer-container">


                    <div class="answer" style="display: inline-block; float:left; height:34px; border: 1px solid red">
                        ANSWER #1
                    </div>

                    <div class="rating" style="display: inline-block;">
                        <div style="color:red; float:left; ">
                            upvote 56
                        </div>
                        <div style="color:red;">
                            downvote 12
                        </div>
                    </div>
                    <div class="approved" style="display: inline-block; text-align: center;">
                        approved
                    </div>
                </div>
            </div>

            <div class="your-answer">
                <h1 class="mt-4" id="question-title">Your Answer</h1>
                <textarea>

                </textarea>
                <button type="submit">Publish</button>
            </div>
            <!-- Comments Form -->
            <div>
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

        <!-- Sidebar Widgets Column -->
        <div class="col-md-4">

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
