<!DOCTYPE html>
<html lang="en">

<body>

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

</body>
</html>