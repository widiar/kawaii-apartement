@inject('url', 'Illuminate\Routing\UrlGenerator')
<div id="fh5co-header">
    <header id="fh5co-header-section">
        <div class="container">
            <div class="nav-header">
                <a href="#" class="js-fh5co-nav-toggle fh5co-nav-toggle"><i></i></a>
                <h1 id="fh5co-logo"><a href="{{ route('home', app()->getLocale()) }}">Kawaii</a></h1>
                <nav id="fh5co-menu-wrap" role="navigation">
                    <ul class="sf-menu" id="fh5co-primary-menu">
                        <li><a class="{{ Route::currentRouteName() == 'home' ? 'active' : '' }}" href="{{ route('home', app()->getLocale()) }}">Home</a></li>
                        <li>
                            <a href="#" class="fh5co-sub-ddown">{{ strtoupper(app()->getLocale()) }}</a>
                            <ul class="fh5co-sub-menu">
                                 <li><a href="{{ $url->setLanguage('id') }}">ID</a></li>
                                 <li><a href="{{ $url->setLanguage('en') }}">EN</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    
</div>