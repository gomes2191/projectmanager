    <?php if(($this->login_required && !$this->logged_in) && !defined ('ABSPATH') ) {   return;   } ?>

        <nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top top-mix"><!-- Fixed navbar -->
            <div class="container">
                <a class="navbar-brand" href="#"><b>BETA</b></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item <?= (isSite('soc')) ? 'active' : '' ?>">
                            <a class="nav-link" href="<?= HOME_URI; ?>" title="Página inicial">
                                <i class="fas fa-home fa-lg"></i> HOME
                                <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item <?= (isSite('agenda')) ? 'active' : FALSE; ?>">
                            <a class="nav-link" href="<?= HOME_URI; ?>/agenda" title="Agenda"><i class='fas fa-calendar-alt fa-lg'></i> AGENDA</a>
                        </li>
                        <li class="nav-item dropdown <?= (isSite('covenant', 'fees', 'providers', 'patrimony', 'stock', 'laboratory')) ? 'active' : FALSE; ?>">
                            <a class="nav-link dropdown-toggle" href="javascript:void(0);" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class='fas fa-building fa-lg'></i> EMPRESA
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item <?= (isSite('providers')) ? 'active' : FALSE; ?>" href="<?= HOME_URI; ?>/providers">Fornecedores</a>
                                <a class="dropdown-item <?= (isSite('patrimony')) ? 'active' : FALSE; ?>" href="<?= HOME_URI; ?>/patrimony">Patrimônio</a>
                                <a class="dropdown-item <?= (isSite('stock')) ? 'active' : FALSE; ?>" href="<?= HOME_URI; ?>/stock">Controle de Estoque</a>
                                <a class="dropdown-item <?= (isSite('laboratory')) ? 'active' : FALSE; ?>" href="<?= HOME_URI; ?>/laboratory">Laboratório</a>
                                <a class="dropdown-item <?= (isSite('covenant', 'fees')) ? 'active' : FALSE; ?>" href="<?= HOME_URI; ?>/covenant">Convênios / Planos</a>
                                <a class="dropdown-item" href="#">Tabela de Honorários</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown <?= (isSite('pay', 'receive', '', '', '', '')) ? 'active' : FALSE; ?>">
                            <a class="nav-link dropdown-toggle" href="javascript:void(0);" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class='fas fa-chart-bar fa-lg'></i> FINANÇAS
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item <?= (isSite('pay')) ? 'active' : FALSE; ?>" href="<?= HOME_URI; ?>/pay">Contas a Pagar</a>
                                <a class="dropdown-item <?= (isSite('receive')) ? 'active' : FALSE; ?>" href="<?= HOME_URI; ?>/receive">Contas a Receber</a>
                                <a class="dropdown-item" href="<?= HOME_URI; ?>/finances-flow">Fluxo de caixa</a>
                                <a class="dropdown-item" href="<?= HOME_URI; ?>/finances-checks">Controle de Cheques</a>
                                <a class="dropdown-item" href="<?= HOME_URI; ?>/finances-payments">Pagamentos</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="javascript:void(0);" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-users fa-lg"></i> USUÁRIOS
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="<?= HOME_URI; ?>/users/register-dentist">Inserir Dentista</a>
                                <a class="dropdown-item" href="<?= HOME_URI; ?>/users/register-employee">Inserir Funcionario</a>
                                <a class="dropdown-item" href="<?= HOME_URI; ?>/users">Listar cadastros</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= HOME_URI; ?>/patient-control" title="Gerenciar pacientes no sistema">
                                <i class="fas fa-handshake fa-lg"></i> CLIENTES
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav> <!--End navbar-->
        <main role="main" class="container"><!-- Start Main container principal -->
