<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css"/>
        <script src="https://kit.fontawesome.com/9a785616dc.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="/css/styles.css">
        <link rel="stylesheet" href="/css/responsive.css">
        <meta name="csrf-token" content="{{ csrf_token() }}">   
    </head>
    <body>
        <header>
            <nav class="navbar">
                <div class="navbar-collapse" id="navbar">
                    <a href="/" class="navbar-brand">
                        <img src="" alt="">
                    </a>
                    <ul class="navbars">
                        <div class="hamburger" id="hamburger-1" onclick="showMenu()">
                            <span class="line"></span>
                            <span class="line"></span>
                            <span class="line"></span>
                        </div>
                        <ul class="navbar-nav" id="categorias-list">
                            <li class="nav-item">
                                <a href="/" class="nav-link center">HOME</a>
                            </li>
                            <li class="nav-item">
                                <a href="/movies/category/28" class="nav-link center">AÇÃO</a>
                            </li>
                            <li class="nav-item">
                                <a href="/movies/category/35" class="nav-link center">COMEDIA</a>
                            </li>
                            <li class="nav-item">
                                <a href="/movies/category/27" class="nav-link center">TERROR</a>
                            </li>
                            <li class="nav-item">
                                <a href="/movies/category/10749" class="nav-link center">ROMANCE</a>
                            </li>
                            <li class="nav-item">
                                <a href="/movies/category/99" class="nav-link center">DOCUMENTARIO</a>
                            </li>
                        </ul>
                        <ul class="navbar-nav" id="search-li">
                            <li class="search-item">
                                <div class="">
                                    <form action="{{ url('/movies/search') }}" method="post" onsubmit="updateSearchInput()">
                                        @csrf
                                        <input type="text" name="search" id="search" class="hidden">
                                        <i class="fa-solid fa-magnifying-glass" id="lupa" onclick="toggleInput()"></i>
                                    </form>
                                </div>
                                <ul class="search-movies">
                                    <h3>Filmes</h3>
                                </ul>
                              </li>
                            @auth
                            <li class="nav-item" id="submenu">
                                <div class="avatar">
                                    <p class="avatar-user">{{ substr(auth()->user()->name, 0, 1) }}</p>
                                </div>
                                <ul class="avatar-submenu">
                                    <li>
                                        <a href="/movies/favorites">
                                            <i class="fa-solid fa-heart"></i>
                                            <p>Favoritos</p>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="">
                                            <i class="fa-solid fa-list"></i>
                                           <p>Listas</p>
                                        </a>
                                    </li>
                                    <li>
                                        <form action="/logout" method="POST">
                                            @csrf
                                            <a href="/logout" 
                                            onclick="event.preventDefault(); 
                                            this.closest('form').submit();">
                                            <i class="fa-solid fa-right-from-bracket"></i><p>Sair</p></a>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                            @endauth
                            @guest
                            <li class="nav-item">
                                <a href="/login" class="login"><p>Entrar</p></a>
                            </li>
                            @endguest
                        </ul>
                    </ul>
                </div>
            </nav>
        </header>
    
        @yield('content')
        
    <footer>
        <div class="footer-top">
            <div class="container">
                <ul class="redes-sociais">
                    <a href="https://www.linkedin.com/in/thiago-meira-503a86229/" target="_blank">
                        <li class="center"><i class="fa-brands fa-linkedin-in"></i></li>
                    </a>
                    <a href="https://github.com/Thiagomeircoq/" target="_blank">
                        <li class="center"><i class="fa-brands fa-github"></i></li>
                    </a>
                    <a href="https://wa.me/5577999188942" target="_blank">
                        <li class="center"><i class="fa-brands fa-whatsapp"></i></li>
                    </a>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>Thiago Meira @copy; 2023</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/js/scripts.js"></script> 
    <script src="/js/favorite.js"></script> 
    <script src="/js/comments.js"></script>     
</body>
</html>
