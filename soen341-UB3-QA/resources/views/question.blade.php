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
                <h1 class="mt-4" id="question-title">Can (a==1 && a==2 && a==3) evaluate to true in Java?
                </h1>

                <table class="table">
                    <tbody>
                        <tr class="question" >
                            <td style="border:1px solid teal">
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
                            <td class="rating" style="vertical-align:middle;">
                                <div style="color:teal; float:left; margin: 50%">
                                    <a href="#">
                                        <i class="fa fa-thumbs-up" aria-hidden="true"></i></span> 56
                                    </a>
                                </div>
                                <br />
                                <div style="color:teal; float:left; margin: 50%">
                                    <a href="#">
                                        <i class="fa fa-thumbs-up" style="transform: rotate(180deg); "aria-hidden="true"></i> 12
                                    </a>
                                </div>
                            </td>
                            <td class="">

                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="answers table">
                    <tbody>
                        <tr class="answer" style="height:100px">
                            <td class="answer-text" style="border:1px solid teal;">
                                <p>
                                    I HAVE A SOLUTION FOR YOU!
                                </p>
                            </td>
                            <td class="rating" style="vertical-align:middle;">
                                <div style="color:teal; float:left; margin: 50%">
                                    <a href="#">
                                        <i class="fa fa-thumbs-up" aria-hidden="true"></i></span> 7
                                    </a>
                                </div>
                                <br />
                                <div style="color:teal; float:left; margin: 50%">
                                    <a href="#">
                                        <i class="fa fa-thumbs-up" style="transform: rotate(180deg); "aria-hidden="true"></i> 2
                                    </a>
                                </div>
                            </td>
                            <!--<td class="w3-padding w3-xlarge w3-teal" style="vertical-align:middle; ">-->
                            <td class="w3-padding w3-xlarge w3-text-green" style="vertical-align:middle; ">
                                <i class="fa fa-check-circle"></i>
                            </td>
                        </tr>
                        <tr class="answer" style="height:100px">
                            <td class="answer-text" style="border:1px solid teal;">
                                <p>
                                    I have the wrong answer for you
                                </p>
                            </td>
                            <td class="rating" style="vertical-align:middle;">
                                <div style="color:teal; float:left; margin: 50%">
                                    <a href="#">
                                        <i class="fa fa-thumbs-up" aria-hidden="true"></i></span> 1
                                    </a>
                                </div>
                                <br />
                                <div style="color:teal; float:left; margin: 50%">
                                    <a href="#">
                                        <i class="fa fa-thumbs-up" style="transform: rotate(180deg); "aria-hidden="true"></i> 15
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

                <div class="your-answer">
                    <h2 class="mt-4" id="question-title">Your Answer</h2>
                    <textarea style="height:100px" class="form-control"></textarea>
                    <br />
                    <button style="float:right" class="btn btn-primary" type="submit">Publish</button>
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
