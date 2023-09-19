<nav class="navbar navbar-expand-md text-white shadow-sm overflow-visible">
    <div class="container overflow-visible">
        @if (request()->is('admin/student*'))
                <a class="navbar-brand text-white mr-auto" href="{{ route('item.index') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
        @else
            <a class="navbar-brand text-white w-[70%]" href="{{ route('student.index') }}">
                Product Itemss
            </a>
        @endif

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon bi bi-list w-full h-full text-white"></span>
        </button>

       


                @guest
                        <a class=" text-white" href="{{ route('login') }}">{{ __('Login') }}</a>
                    @if (Route::has('register'))
                            <a class="text-white" href="{{ route('register') }}">{{ __('Register') }}</a>
                    @endif
                @else
                        <span class="text-center mr-4 flex-end">
                            {{-- {{ ucfirst(Auth::user()->name) }} :  --}}
                        </span>
                            <a class="flex-end" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                 

                 
                @endguest
           
       
    </div>
</nav>


{{-- <nav class="w-full bg-primary px-2 py-3">
    <div class="w-full h-full flex justify-center items-center">
        <a class="min-w-[150px] h-full grid place-items-center text-lg font-bold text-white tracking-wider"
            href="{{ route('student.index') }}">
            {{ config('app.name') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link text-white text-base" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link text-white text-base" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown w-full min-w-[200px] flex gap-5 justify-center ">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle text-lg text-white p-2" href=""
                            role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ ucfirst(Auth::user()->name) }} :<span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right h-full my-auto" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item text-lg text-white p-2" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav> --}}
