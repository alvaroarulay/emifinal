<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user">
        <div>
          <p class="app-sidebar__user-name">{{ Auth::user()->name }} </p>
        </div>
      </div>
      @if(Auth::check())
        @if (Auth::user()->idrol == 1)
      <ul class="app-menu">
        <li @click="menu=0"><a class="app-menu__item" href="#"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Escritorio</span></a></li>
        <li @click="menu=1"><a class="app-menu__item" href="#"><i class="bi bi-database-fill-gear"></i><span class="app-menu__label">&nbsp;&nbsp;Base de Datos</span></a></li>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="bi bi-cash-coin"></i><span class="app-menu__label">&nbsp;&nbsp;Activos</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li @click="menu=2"><a class="treeview-item" href="#"><i class="icon fa fa-circle-o"></i> Activos Fijos</a></li>
            <li @click="menu=23"><a class="treeview-item" href="#"><i class="icon fa fa-circle-o"></i> Bajas</a></li>
            <li @click="menu=3"><a class="treeview-item" href="#"><i class="icon fa fa-circle-o"></i> Inventario Rápido</a></li>
          </ul>
        </li>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="bi bi-calculator"></i><span class="app-menu__label">&nbsp;&nbsp;Grupos Contables</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li @click="menu=5"><a class="treeview-item" href="#"><i class="icon fa fa-circle-o"></i> Auxiliares</a></li>
          </ul>
        </li>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="bi bi-buildings"></i><span class="app-menu__label">&nbsp;&nbsp;Oficinas</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li @click="menu=6"><a class="treeview-item" href="#"><i class="icon fa fa-circle-o"></i> Unidad Administrativa</a></li>
            <li @click="menu=22"><a class="treeview-item" href="#"><i class="icon fa fa-circle-o"></i> Oficinas</a></li>
          </ul>
        </li>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="bi bi-people-fill"></i><span class="app-menu__label">&nbsp;&nbsp;Responsables</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li @click="menu=8"><a class="treeview-item" href="#"><i class="icon fa fa-circle-o"></i> Responsables</a></li>
            <li @click="menu=9"><a class="treeview-item" href="#"><i class="icon fa fa-circle-o"></i> Asignaciones</a></li>
            <li @click="menu=10"><a class="treeview-item" href="#"><i class="icon fa fa-circle-o"></i> Devoluciones</a></li>
          </ul>
        </li>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="bi bi-lock"></i><span class="app-menu__label">&nbsp;&nbsp;Acceso</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li @click="menu=11"><a class="treeview-item" href="#"><i class="icon fa fa-circle-o"></i> Usuarios</a></li>
            <li @click="menu=12"><a class="treeview-item" href="#"><i class="icon fa fa-circle-o"></i> Nuevo Usuario</a></li>
            <li @click="menu=13"><a class="treeview-item" href="#"><i class="icon fa fa-circle-o"></i> Roles</a></li>
          </ul>
        </li>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="bi bi-file-earmark-bar-graph"></i><span class="app-menu__label">&nbsp;&nbsp;Reportes</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li @click="menu=14"><a class="treeview-item" href="#"><i class="icon fa fa-circle-o"></i> Asignación / Devolución</a></li>
            <li @click="menu=16"><a class="treeview-item" href="#"><i class="icon fa fa-circle-o"></i> Registro de Movimientos</a></li>
            <li @click="menu=17"><a class="treeview-item" href="#"><i class="icon fa fa-circle-o"></i> Activos</a></li>
            <li @click="menu=18"><a class="treeview-item" href="#"><i class="icon fa fa-circle-o"></i> Responsables</a></li>
            <li @click="menu=19"><a class="treeview-item" href="#"><i class="icon fa fa-circle-o"></i> Registro de Asignaciones</a></li>
          </ul>
        </li>
        <li @click="menu=20"><a class="app-menu__item" href="#"><i class="app-menu__icon fa fa-file-pdf-o"></i><span class="app-menu__label">Ayuda </span></a></li>
        </li>
        <li @click="menu=21"><a class="app-menu__item" href="#"><i class="app-menu__icon fa fa-info"></i><span class="app-menu__label"> Acerca de...</span></a></li>
        </li>
       </ul>
       @elseif (Auth::user()->idrol == 2)
       <ul class="app-menu">
        <li @click="menu=0"><a class="app-menu__item" href="#"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Escritorio</span></a></li>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="bi bi-cash-coin"></i><span class="app-menu__label">&nbsp;&nbsp;Activos</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li @click="menu=2"><a class="treeview-item" href="#"><i class="icon fa fa-circle-o"></i> Activos Fijos</a></li>
            <li @click="menu=23"><a class="treeview-item" href="#"><i class="icon fa fa-circle-o"></i> Bajas</a></li>
            <li @click="menu=3"><a class="treeview-item" href="#"><i class="icon fa fa-circle-o"></i> Inventario Rápido</a></li>
          </ul>
        </li>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="bi bi-calculator"></i><span class="app-menu__label">&nbsp;&nbsp;Grupos Contables</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li @click="menu=5"><a class="treeview-item" href="#"><i class="icon fa fa-circle-o"></i> Auxiliares</a></li>
          </ul>
        </li>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="bi bi-buildings"></i><span class="app-menu__label">&nbsp;&nbsp;Oficinas</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
           <li @click="menu=22"><a class="treeview-item" href="#"><i class="icon fa fa-circle-o"></i> Oficinas</a></li>
          </ul>
        </li>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="bi bi-people-fill"></i><span class="app-menu__label">&nbsp;&nbsp;Responsables</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li @click="menu=8"><a class="treeview-item" href="#"><i class="icon fa fa-circle-o"></i> Responsables</a></li>
            <li @click="menu=9"><a class="treeview-item" href="#"><i class="icon fa fa-circle-o"></i> Asignaciones</a></li>
            <li @click="menu=10"><a class="treeview-item" href="#"><i class="icon fa fa-circle-o"></i> Devoluciones</a></li>
          </ul>
        </li>
        
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="bi bi-file-earmark-bar-graph"></i><span class="app-menu__label">&nbsp;&nbsp;Reportes</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li @click="menu=14"><a class="treeview-item" href="#"><i class="icon fa fa-circle-o"></i> Asignación / Devolución</a></li>
            <li @click="menu=16"><a class="treeview-item" href="#"><i class="icon fa fa-circle-o"></i> Registro de Movimientos</a></li>
            <li @click="menu=17"><a class="treeview-item" href="#"><i class="icon fa fa-circle-o"></i> Activos</a></li>
            <li @click="menu=18"><a class="treeview-item" href="#"><i class="icon fa fa-circle-o"></i> Responsables</a></li>
            <li @click="menu=19"><a class="treeview-item" href="#"><i class="icon fa fa-circle-o"></i> Registro de Asignaciones</a></li>
          </ul>
        </li>
        <li @click="menu=20"><a class="app-menu__item" href="#"><i class="app-menu__icon fa fa-file-pdf-o"></i><span class="app-menu__label">Ayuda </span></a></li>
        </li>
        <li @click="menu=21"><a class="app-menu__item" href="#"><i class="app-menu__icon fa fa-info"></i><span class="app-menu__label"> Acerca de...</span></a></li>
        </li>
       </ul>
       @else
    @endif
    @else
    <main>
        <p>Sesión Expirada, por favor  <a href="{{ route('login.perform') }}">Inicie Sesión</a></p>
    </main>
@endif
    </aside>