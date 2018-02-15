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
                    {!! Form::submit('Go!', ['class' => 'btn btn-secondary']) !!}
                </span>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

    <!-- Asking Question sidebar -->
    <div class="card my-4">
        <h5 class="card-header">Have a Question of your own?</h5>
        <div class="card-body">
            <div>
                <a href="{{ route('ask') }}" class="btn btn-primary">Ask it here!</a>
            </div>
        </div>
    </div>

    <!-- Categories Widget -->
    <div class="card my-4">
        <h5 class="card-header">Filter By Labels </h5>
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

    <!-- ONLY HERE IN THE MEANTIME THAT HOME PAGE IS NOT DONE -->
    <div>
        <a href="/question/1" class="btn btn-primary">Question Page link</a>
    </div>
</div>


</body>
</html>