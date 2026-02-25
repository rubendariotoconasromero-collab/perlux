<style>
    /* Texto e iconos base: Blanco */
    .nav-item a i,
    .nav-item a p {
        color: #b9babf !important; /* Un gris muy claro es mejor que blanco puro para descansar la vista */
        transition: all 0.3s ease;
    }

    li.nav-item a:hover i,
    li.nav-item a:hover p {
        color: #007EAB !important;
    }

    li.nav-item.active a i,
    li.nav-item.active a p {
        color: #007EAB !important;
        font-weight: 700;
    }

    /* Títulos de sección (MENU) */
    .text-section {
        color: #ffffff !important;
        opacity: 0.7;
    }

    .nav-item a:before :hover{
        color: #007EAB !important;
    }

  

    .sidebar .nav.nav-secondary>.nav-item.active a i, .sidebar[data-background-color=white] .nav.nav-secondary>.nav-item.active a i p{
        color: #007EAB !important;
    }

    .sidebar .nav>.nav-item.active>a p, .sidebar[data-background-color=white] .nav>.nav-item.active>a p {
        color: #007EAB !important;
        font-weight: 600;
    }
    

    .sidebar .nav>.nav-item.active>a, .sidebar[data-background-color=white] .nav>.nav-item.active>a {
        background: #e4e4e4b2 !important;
    }



    /* 1. ESTILOS PARA EL ÍCONO (Activo O Hover) */
    .sidebar .nav.nav-secondary > .nav-item.active a i,
    .sidebar .nav.nav-secondary > .nav-item:hover a i { 
        color: #007EAB !important;
    }

    /* 2. ESTILOS PARA EL TEXTO (Activo O Hover) */
    .sidebar .nav > .nav-item.active > a p,
    .sidebar .nav > .nav-item:hover > a p {
        color: #007EAB !important;
        font-weight: 600;
    }

</style>

<ul class="nav nav-secondary">

    <li class="nav-section">
        <span class="sidebar-mini-icon">
            <i class="fa fa-ellipsis-h"></i>
        </span>
        <h4 class="text-section">Menu</h4>
    </li>
    
    <li class="nav-item {{ Request::is('bienvenida') ? 'active' : '' }}">
        <a href="/bienvenida">
            <i class="fas fa-home"></i>
            <p>Bienvenida</p>
        </a>
    </li>

    <li class="nav-item {{ Request::is('colores*') ? 'active' : '' }}">
        <a href="/colores">
            <i class="fas fa-palette"></i> <p>Colores</p>
        </a>
    </li>

    <li class="nav-item {{ Request::is('tallas*') ? 'active' : '' }}">
        <a href="/tallas">
            <i class="fas fa-ruler-combined"></i> <p>Tallas</p>
        </a>
    </li>

    <li class="nav-item {{ Request::is('colecciones*') ? 'active' : '' }}">
        <a href="/colecciones">
            <i class="fas fa-layer-group"></i> <p>Categorias</p>
        </a>
    </li>

     <li class="nav-item {{ Request::is('productos*') ? 'active' : '' }}">
        <a href="/productos">
            <i class="fas fa-tshirt"></i> <p>Productos</p>
        </a>
    </li>

    <li class="nav-item {{ Request::is('admin-orders*') ? 'active' : '' }}">
        <a href="/admin-orders">
            <i class="fas fa-tshirt"></i> <p>Ordenes</p>
        </a>
    </li>
    

    <li class="nav-section">
        <span class="sidebar-mini-icon">
            <i class="fa fa-ellipsis-h"></i>
        </span>
        <h4 class="text-section">Administración</h4>
    </li>

    <li class="nav-item {{ Request::is('users_admin*') ? 'active' : '' }}">
        <a href="/users_admin">
            <i class="fas fa-users-cog"></i> <p>Usuarios</p>
        </a>
    </li>
    
</ul>