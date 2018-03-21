<!DOCTYPE html>
<html lang="en">

<body class="Site">

<!-- Question Post -->
<div id="questions" class="Site-content">
    @if(count($question_data) > 0)
        <?php 
            $count = 0; 
            if(!isset($page)) $page = 0;
        ?>
        @foreach($question_data as $key => $data)
            @if($page == floor($count++ / 5))
            <div class="card mb-4">
                <div class="card-body">

                    <!--Display question title -->
                    <h4 dusk="{{$data->title}}-{{$key}}" class="card-title">{{$data->title}}</h4> </br>

                    <!--Display first sentence of question content-->
                    <p class="card-text" style="margin-top: -20px; margin-bottom: 20px">
                        <?php $parts = explode('.', $data->content); echo($parts[0] . '...')?></p>

                    <!--Display labels of question-->
                    @if((!$data->labels) == "")
                        <?php $parts = explode(',', $data->labels);
                        $trimed_parts = array_map('trim', $parts); $parts = array_unique($trimed_parts);
                        $duplicates = array();?>

                        @foreach($parts as $label)
                            <span id="labels-styled">{{$label}}</span>
                        @endforeach
                    @endif

                <!--Display read more button-->
                    <a href="/question/{{$data->id}}" class="btn btn-primary" name="Read" style="float: right;">Read
                        More &rarr;</a>
                </div>

                <!--Display who posted it and when -->
                <div class="card-footer text-muted">
                    Posted on the <span style="text-decoration: underline;">
                            <?php $parts = explode('-', $data->created_at);
                        $month = (DateTime::createFromFormat('!m', $parts[1]))->format('F');
                        echo substr($parts[2], 0, 2) . "th of $month of $parts[0] at" . substr($parts[2], 2)?> </span>
                    by <span style="text-decoration: underline;">{{$data->name}}</span>

                    <!--Displaynumber of replies-->
                    <span style="float: right"> {{$data->nb_replies}} replies</span>
                </div>

            </div>
            @endif
        @endforeach
        <span id="page" class="<?php echo $page; ?>"></span>
        <span id="lastP" class="<?php if(floor(count($question_data) / 5) == $page) { echo "1"; } else { echo "0"; } ?>"></span>
    @else
        <div class="card mb-4 ">
            <div class="card-body">
                <p> No questions were asked yet! </p>
            </div>
        </div>
    @endif
</div>

</body>
</html>