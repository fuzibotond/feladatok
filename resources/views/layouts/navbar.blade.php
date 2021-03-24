<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{  config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="true" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <ul class="navbar-nav mr-auto">
                    <a class="nav-link" href="http://127.0.0.1:8000/home">{{ Auth::user()->name }}</a>
                    <a class="nav-link" href="http://127.0.0.1:8000/login">Login</a>
                    <a class="nav-link" href="http://127.0.0.1:8000/register">Register</a>
                </ul>
                

            </div>
        </nav>