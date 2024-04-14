<headers>

    <div class="header p-3" style="background-color: #ECECF1;">
        <div class="row">
            <div class="col-md-6" align="left">
                <div class="header-brand pl-5 ml-5 text-primary font-weight-bold">
                    <img src="{{ asset('assets/images/Voctech.png') }}" class="mx-3" width="30" alt="voctech">
                    Voctech Senior High School
                </div>
            </div>
            <div class="col-md-6" align="right">
                <div class="nav-menu mr-5 pr-5">
                    <div class="dropdown">
                        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 0;">
                            <img src="{{ asset('svg/Vector.svg') }}" width="30" alt="menu">
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                            @guest
                                <a class="dropdown-item" href="{{ route('login') }}">{{ __('Login') }}</a>
                            @else
                                <a class="dropdown-item" href="{{ route('admin') }}">Dashboard</a>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                    <i class="mdi mdi-power text-danger"></i>
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</header>