<header id="unalTop">
    <div class="logo">
        <a href="http://unal.edu.co">
            <!--[if (gte IE 9)|!(IE)]><!-->
            <svg width="93%" height="93%">
                <image xlink:href="{{ asset('images/escudoUnal.svg') }}" width="100%" height="100%" class="hidden-print"/>
            </svg>

            <!--<![endif]-->
            <!--[if lt IE 9]>
            <img src="{{ asset('images/escudoUnal.png') }}" width="93%" height="auto" class="hidden-print"/>
            <![endif]-->
            <img src="{{ asset('images/escudoUnal_black.png') }}" class="visible-print" />
        </a>
    </div>
    <div class="seal">
        <img class="hidden-print" alt="Escudo de la República de Colombia" src="{{ asset('images/sealColombia.png') }}" width="66" height="66" />

        <img class="visible-print" alt="Escudo de la República de Colombia" src="{{ asset('images/sealColombia_black.png') }}" width="66" height="66" />
    </div>
    <div class="firstMenu">

        <!--<button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#bs-navbar" aria-controls="bs-navbar" aria-expanded="false">
            <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
        </button>-->
        <div class="navbar-toggle menu-icon hide-show change">
            <div class="bar1"></div>
            <div class="bar2"></div>
            <div class="bar3"></div>
        </div>
        <div class="btn-group languageMenu hidden-xs">
            <div class="btn btn-default dropdown-toggle" data-toggle="dropdown">es<span class="caret"></span></div>
            <ul class="dropdown-menu">
                <li><a href="index.html#">es</a></li>
                <li><a href="index.html#">en</a></li>
            </ul>
        </div>
        <ul class="socialLinks hidden-xs">
            <li>
                <a href="https://www.facebook.com/UNColombia" target="_blank" class="facebook" title="Página oficial en Facebook"></a>
            </li>
            <li>
                <a href="https://twitter.com/UNColombia" target="_blank" class="twitter" title="Cuenta oficial en Twitter"></a>
            </li>
            <li>
                <a href="https://www.youtube.com/channel/UCnE6Zj2llVxcvL5I38B0Ceg" target="_blank" class="youtube" title="Canal oficial de Youtube"></a>
            </li>
            <li>
                <a href="http://agenciadenoticias.unal.edu.co/nc/sus/type/rss2.html" target="_blank" class="rss" title="Suscripción a canales de información RSS"></a>
            </li>
        </ul>
        <div class="navbar-default">
            <nav id="profiles">
                <ul class="nav navbar-nav dropdown-menu">
                    <li class="item_Aspirantes #>"><a href="index.html#">Aspirantes</a></li>
                    <li class="item_Estudiantes #>"><a href="index.html#">Estudiantes</a></li>
                    <li class="item_Egresados #>"><a href="index.html#">Egresados</a></li>
                    <li class="item_Docentes #>"><a href="index.html#">Docentes</a></li>
                    <li class="item_Administrativos #>"><a href="index.html#">Administrativos</a></li>
                </ul>
            </nav>
        </div>
    </div>
    <div id="bs-navbar" class="navbar-collapse collapse navigation"><br>
        <div class="site-url"><a href=""> Sistema de ETL (Extracción - Transformación - Carga)</a></div>
        <div class="buscador">
            <div class="gcse-searchbox-only" data-resultsUrl="http://unal.edu.co/resultados-de-la-busqueda/" data-newWindow="true"></div>
        </div>
        <div class="mainMenu">
            <div class="btn-group"></div>
            <div class="btn-group">
                <div class="btn btn-default dropdown-toggle" data-toggle="dropdown">Sedes<span class="caret"></span></div>
                <ul class="dropdown-menu dropItem-16">
                    <li><a href="http://www.imani.unal.edu.co" target="_blank">Amazonia</a><span class="caret-right"></span></li>
                    <li><a href="http://www.bogota.unal.edu.co" target="_blank">Bogotá</a><span class="caret-right"></span></li>
                    <li><a href="http://www.caribe.unal.edu.co" target="_blank">Caribe</a><span class="caret-right"></span></li>
                    <li><a href="http://www.manizales.unal.edu.co" target="_blank">Manizales</a><span class="caret-right"></span></li>
                    <li><a href="http://www.medellin.unal.edu.co" target="_blank">Medellín</a><span class="caret-right"></span></li>
                    <li><a href="http://www.orinoquia.unal.edu.co" target="_blank">Orinoquia</a><span class="caret-right"></span></li>
                    <li><a href="http://www.palmira.unal.edu.co" target="_blank">Palmira</a><span class="caret-right"></span></li>
                    <li><a href="http://www.tumaco-pacifico.unal.edu.co" target="_blank">Tumaco</a><span class="caret-right"></span></li>
                </ul>
            </div>
        </div>
        <div class="btn-group hidden-sm hidden-md hidden-lg hidden-print">
            <div class="btn btn-default dropdown-toggle" data-toggle="dropdown" id="unalOpenMenuServicios" data-target="#services">Servicios<span class="caret"> </span>
            </div>
        </div>
    </div>
</header>