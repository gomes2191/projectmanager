    <?php
        if (($objControl->login_required && !$this->logged_in) && !defined('Config::HOME_URI')) {
            return;
        }
    ?>
    <nav class="navbar navbar-dark bg-gclinic navbar-expand-lg fixed-top top-mix navbar-icon-top">
        <!-- Fixed navbar -->
        <div class="container-fluid">
            <div class="d-flex w-50 order-0">
                <a class="navbar-brand mr-1" href="javascript:void(0)">
                    <img src="<?= Config::HOME_URI; ?>/logo.png" alt="Gestor Clínico" title="GC - Gestor Clínico" class="img-responsive">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsingNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="navbar-collapse collapse justify-content-center order-2" id="collapsingNavbar">
                <ul class="navbar-nav">
                    <li class="nav-item <?= (GFunc::isSite('p_gclinic')) ? 'active' : FALSE ?>">
                        <a class="nav-link" href="<?= Config::HOME_URI; ?>" title="Página inicial">
                            <i class="fal fa-home"></i> HOME
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item <?= (GFunc::isSite('agenda')) ? 'active' : false; ?>">
                        <a class="nav-link" href="<?= Config::HOME_URI; ?>/agenda" title="Agenda">
                            <i class='fal fa-calendar-alt'></i> AGENDA
                        </a>
                    </li>
                    <li class="nav-item dropdown <?= (GFunc::isSite('covenant', 'fees', 'providers', 'patrimony', 'stock', 'laboratory')) ? 'active' : false; ?>">
                        <a class="nav-link dropdown-toggle" href="javascript:void(0);" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class='fal fa-building '></i> EMPRESA
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item <?= (GFunc::isSite('providers')) ? 'active' : FALSE; ?>" href="<?= Config::HOME_URI; ?>/providers">Fornecedores</a>
                            <a class="dropdown-item <?= (GFunc::isSite('patrimony')) ? 'active' : FALSE; ?>" href="<?= Config::HOME_URI; ?>/patrimony">Patrimônio</a>
                            <a class="dropdown-item <?= (GFunc::isSite('stock')) ? 'active' : FALSE; ?>" href="<?= Config::HOME_URI; ?>/stock">Controle de Estoque</a>
                            <a class="dropdown-item <?= (GFunc::isSite('laboratory')) ? 'active' : FALSE; ?>" href="<?= Config::HOME_URI; ?>/laboratory">Laboratório</a>
                            <a class="dropdown-item <?= (GFunc::isSite('covenant', 'fees')) ? 'active' : FALSE; ?>" href="<?= Config::HOME_URI; ?>/covenant">Convênios / Planos</a>
                            <a class="dropdown-item" href="#">Tabela de Honorários</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown <?= (GFunc::isSite('pay', 'receive', '', '', '', '')) ? 'active' : FALSE; ?>">
                        <a class="nav-link dropdown-toggle" href="javascript:void(0);" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class='fal fa-chart-bar'></i> FINANÇAS
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item <?= (GFunc::isSite('pay')) ? 'active' : FALSE; ?>" href="<?= Config::HOME_URI; ?>/pay">Contas a Pagar</a>
                            <a class="dropdown-item <?= (GFunc::isSite('receive')) ? 'active' : FALSE; ?>" href="<?= Config::HOME_URI; ?>/receive">Contas a Receber</a>
                            <a class="dropdown-item" href="<?= Config::HOME_URI; ?>/finances-flow">Fluxo de caixa</a>
                            <a class="dropdown-item" href="<?= Config::HOME_URI; ?>/finances-checks">Controle de Cheques</a>
                            <a class="dropdown-item" href="<?= Config::HOME_URI; ?>/finances-payments">Pagamentos</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="javascript:void(0);" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fal fa-users"></i> USUÁRIOS
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="<?= Config::HOME_URI; ?>/users/register-dentist">Inserir Dentista</a>
                            <a class="dropdown-item" href="<?= Config::HOME_URI; ?>/users/register-employee">Inserir Funcionario</a>
                            <a class="dropdown-item" href="<?= Config::HOME_URI; ?>/users">Listar cadastros</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Config::HOME_URI; ?>/patient-control" title="Gerenciar pacientes no sistema">
                            <i class="fal fa-handshake"></i> CLIENTES
                        </a>
                    </li>
                </ul>
            </div>
            <div class="navbar-text small text-truncate mt-1 w-50 text-right order-1 order-md-last"></div>
        </div>
    </nav><!--End navbar-->