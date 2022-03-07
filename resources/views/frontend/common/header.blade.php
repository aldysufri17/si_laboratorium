    <!-- ======= Top Bar ======= -->
    <section id="topbar" class="d-flex align-items-center" style="background-color:#3d59ab; margin-bottom:-1px;">
        <div class="container d-flex justify-content-center justify-content-md-between">
            <div class="contact-info d-flex align-items-center">
                <i class="bi bi-envelope d-flex align-items-center"><a href="siskom@undip.ac.id ">siskom@undip.ac.id
                    </a></i>
                <i class="bi bi-phone d-flex align-items-center ms-4"><span>(024) 76480609</span></i>
            </div>
            <div class="social-links d-none d-md-flex align-items-center">
                <a href="https://web.facebook.com/undip.official/" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="https://twitter.com/undip" class="twitter"><i class="bi bi-twitter"></i></a>
                <a href="https://www.instagram.com/undip.official/" class="instagram"><i
                        class="bi bi-instagram"></i></a>
            </div>
        </div>
    </section><!-- End Top Bar-->

    <!-- ======= Header ======= -->
    <header id="header" class="d-flex align-items-center" style="background-color: #001349">
        <div class="container d-flex justify-content-between">

            <div id="logo">
                <a href="{{ url('/') }}"><img
                        src="https://tekkom.ft.undip.ac.id/wp-content/uploads/2020/10/DEPARTEMEN-TEKKOM.png"></a>
            </div>

            <nav id="navbar" class="navbar">
                <ul>
                    <li class="dropdown"><a href="{{ url('/')}}"><span>Beranda</span> <i
                                class="bi bi-chevron-down"></i></a>
                        <ul>
                            <li><a href="#about">Tentang</a></li>
                            <li><a href="#">Profile</a></li>
                            <li><a href="#">Galeri</a></li>
                        </ul>
                    </li>
                    <li><a class="nav-link scrollto" href="#">Profil</a></li>
                    @auth
                    @if (auth()->user()->role_id == 3)
                    <li><a class="nav-link scrollto " href="{{ route('cart') }}"><i class="fas fa-shopping-cart" style="font-size: 18px" ></i></a></li>
                    <li class="dropdown"><a href="#"><img class="rounded-circle my-2" width="30px"
                                src="{{ asset(auth()->user()->foto ? 'storage/user/'. auth()->user()->foto : 'admin/img/undraw_profile.svg') }}"></a>
                        <ul>
                            <li><a href="{{ route('profile.detail') }}">Profile</a></li>
                            <li><a class="nav-link scrollto" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                            </li>
                        </ul>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                    @else
                    <li><a class="nav-link scrollto " href="{{ route('dashboard') }}">AdminPanel</a>
                    </li>
                    @endif
                    @endauth
                    @guest
                    <li><a class="nav-link scrollto" href="{{ route('login') }}">Login</a></li>
                    @endguest
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->

        </div>
    </header><!-- End Header -->
