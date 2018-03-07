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

</div>

</body>
</html>