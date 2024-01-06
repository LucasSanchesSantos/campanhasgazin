<body class="bg-light">
    <nav class="navbar bg-white sticky-top shadow">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <button class="navbar-toggler bg-white me-2 shadow" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand fw-bold fs-4 m-0 d-flex align-middle" href="<?= URL ?>inicio"><img src="<?= PATH_IMG ?>cartazeando.png" width="150px"></a>
            </div>
            <div class="d-flex align-items-center">
                <div class="btn-group">
                    <button type="button" class="d-flex align-items-center btn border-0 p-0 text-dark" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle fs-4 me-1 text-dark-blue"></i><?= $usuario['usuario'] ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a href="<?= URL ?>usuario/edicao" class="dropdown-item text-end" type="button">
                                Usuário<i class="bi bi-person-gear ms-1"></i>
                            </a>
                            <a href="<?= URL ?>login/logout" class="dropdown-item text-end" type="button">
                                Sair<i class="bi bi-box-arrow-right ms-1"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="offcanvas offcanvas-start bg-light" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header shadow">
                    <h5 class="offcanvas-title text-dark-blue" id="offcanvasNavbarLabel">Menu</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div>
                    <ul class="navbar-nav justify-content-end flex-grow-1">

                        <?php
                            if ($isAdministrativo) {
                        ?>
                            <li class="nav-item">
                                <a class="nav-link px-3 border-bottom" aria-current="page" href="#" data-bs-toggle="collapse" data-bs-target="#submenuManutencoes" aria-expanded="false">
                                    <i class="text-dark-blue bi bi-tools me-2"></i>Manutenções
                                </a>
                                <ul class="collapse list-unstyled ms-4" id="submenuManutencoes">
                                    <li class="nav-item">
                                        <a class="nav-link px-3 border-bottom" aria-current="page" href="<?= URL ?>usuario/index"><i class="text-dark-blue bi bi-person-gear me-2"></i>Usuários</a>
                                    </li>
                                </ul>
                            </li>

                        <?php
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="bg-white div-content rounded shadow-lg">