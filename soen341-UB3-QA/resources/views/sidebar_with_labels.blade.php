<!DOCTYPE html>
<html lang="en">

<body>


<!-- Sidebar Widgets Column -->
<div class="col-md-4">

    <!-- Search Widget -->
    <div class="card my-4">
        <h5 class="card-header">Search </h5>
        <div class="card-body">
            {!! Form::open(['url' => 'home']) !!}
            <div class="input-group">
                {!! Form::text('search', '', array('class'=>'form-control',
                    'style'=>'margin-right:10px;', 'placeholder'=>'Search for...')) !!}
                <span class="input-group-btn">
                    {!! Form::submit('Go!', ['class' => 'btn btn-secondary', 'name' => "Go!"]) !!}
                </span>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

    <!-- Asking Questions sidebar -->
    <div class="card my-4">
        <h5 class="card-header">Have a Question of your own?</h5>
        <div class="card-body">
            <div>
                @if (Route::has('login'))

                    @guest
                        <a href="{{ route('register') }}" class="btn btn-primary">Ask it here!</a>

                    @else
                        <a href="{{ route('ask') }}" class="btn btn-primary">Ask it here!</a>

                    @endguest
                @endif
            </div>
        </div>
    </div>

    <!-- Categories Widget -->
    <div class="card my-4">
        <h5 class="card-header">Filter By Labels </h5>
        <div class="card-body">
            <div class="row">
                <div style="margin-left: 20px;">

                    <p>
                    <?php $arr_labels = [];?>
                    @if(count($label_data) > 0)
                        @foreach($label_data as $key => $data)
                            @if((!$data->labels) == "")

                                <!--Trim and take out duplicates in database rows (label,label)-->
                                <?php $parts = explode(',', $data->labels);
                                $trimed_parts = array_map('trim', $parts); $parts = array_unique($trimed_parts);?>

                                <!--take out duplicates in single labels-->
                                @foreach($parts as $label)
                                    @if( (!(in_array($label, $arr_labels))) || empty($arr_labels))
                                        <?php array_push($arr_labels, $label); ?>
                                    @endif
                                @endforeach

                            @endif
                        @endforeach
                    @endif

                    <!-- print labels-->
                        @foreach($arr_labels as $label1)
                            <a href="#" class="filter_labels" style="margin: 20px;">{{$label1}}</a>
                        @endforeach
                    </p>

                </div>
            </div>
        </div>
    </div>


</div>

</body>
</html>