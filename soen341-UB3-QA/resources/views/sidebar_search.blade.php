<!DOCTYPE html>
<html lang="en">

<body>

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

</body>
</html>