<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>SGRD - Sistema de Gestão de Reembolso de Despesas</title>
        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->
        <link rel="stylesheet" href="css/materialize.min.css">

        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <style>
            ul li {
                text-align: justify;
                padding: auto;
                margin: auto;
            }
        </style>
    </head>
    <body>
        <div class="container col s12 l12">
            <p style="text-align: center"><h5>Seja bem vindo ao SGRD - Sistema de Gestão de Reembolso de Despesas !</h5></p>
    </div>
    <div class="row">
        <div class="col s12 l12">
            <p><b>Objetivo</b></p>
            <p style="text-align: justify">O SGRD foi projetado para atender empresas que contam com colaboradores que atuam externamente, ao qual repassam os valores gastos com despesas diversas de viagens realizadas por estes colaboradores. O sistema permite ao colaborador registrar as solicitações, declarando as justificativas das despesas e registrando os respectivos comprovantes, bem como os valores e as datas das realizações destas, e através de um fluxo de aprovação que passa tanto pela gestão direta do colaborador quanto pelo responsável financeiro da empresa, o sistema provê um controle centralizado dos custos e comprovantes, evitando perdas para o colaborador e para a empresa no fluxo normal de solicitação de reembolsos.</p>
        </div>
    </div> 
    <div class="row">
        <div class="col s12 l12">
            <p><b>Premissas</b></p>
            <p style="text-align: justify">A estrurura da aplicação possui as seguintes premissas:</p>
            <ul>
                <li><b><em>Etapas de um pedido</em></b> - o pedido pode estar em um de 7 etapas por vez. "Aguardando aprovação Gestor","Aguardando aprovação Financeiro","Aguardando Pagamento","Pago","Rascunho","Reprovado" e "Cancelado pelo Solicitante".</li>
                <br />
                <li><b><em>Fluxo de aprovação:</em></b></li>
                <ul>
                    <li style="text-align: justify"><i class="material-icons tiny">flag</i> Etapa 1 - Aguardando aprovação do Gestor - validação a ser realizada pelo Gestor da área - quando o colaborador solicita o pedido de reembolso;</li>
                    <li><i class="material-icons tiny">flag</i> Etapa 2 - Aguardando aprovação do Financeiro - validação a ser realizada pelo Financeiro da empresa -quando o pedido foi aprovado pelo gestor da área do solicitante;</li>
                    <li><i class="material-icons tiny">flag</i> Etapa 3 - Aguardando pagamento - validação a ser realizada pelo Financeiro da empresa - o pagamento foi autorizado na etapa 2, e está aguardando o pagamento ser efetivado na prática, conforme as políticas da empresa (transferência bancária, em espécie para o colaborador, em folha de pagamento, etc.), de forma externa ao SGRD;</li>
                    <li><i class="material-icons tiny">flag</i> Etapa 4 - Pago - validação a ser realizada pelo Financeiro da empresa - após o pagamento ser efetivado na etapa 3, o Financeiro valida no SGRD a confirmação do pagamento.</li>
                </ul>
                <br />
                <li><b><em>Usuários</em></b> - os usuários, ao serem cadastrados, têm seu login vinculado a um perfil, que define quais módulos se terá acesso, conforme segue:</li>
                <ul>
                    <li><i class="material-icons tiny">flag</i> Perfil Colaborador - solicita pedidos de reembolso e consulta/cancela seus pedidos;</li>
                    <li><i class="material-icons tiny">flag</i> Perfil Gestor - mesmos acessos do perfil Colaborador, mais a consulta e análise (aprovação/reprovação) de pedidos da sua área em primeiro nível;</li>
                    <li><i class="material-icons tiny">flag</i> Perfil Financeiro - mesmos acessos do perfil Gestor, mais a consulta e análise (aprovação/reprovação) de pedidos da sua empresa, nas etapas 2 e 3;</li>
                    <li><i class="material-icons tiny">flag</i> Perfil Administrador - mesmos acessos do perfil Financeiro, mais o acesso ao cadastro dos usuários de sua empresa, além de inclusão/alteração de tipos de despesas e logs de registro das ações das etapas dos pedidos de sua empresa;</li>
                    <li><i class="material-icons tiny">flag</i> Perfil Master - "root" do sistema. Possui os mesmos acessos do Administrador, mas para qualquer empresa. Possui também acesso a cadastro de novas empresas. Este perfil é quem cria a empresa e cadastra um Administrador para a mesma, permitindo a este Administrador cadastrar seus colaboradores conforme os perfis competentes.</li>
                </ul>
                <br />
                <li><b><em>Empresas</em></b> - No momento da implementação deste sistema, 4 empresas estão pré cadastradas. A empresa fictícia "SGRD - Desenvolvimento de Software Ltda" possui a função de "gerenciar" a aplicação, contendo um usuário perifl Master, para a realização da primeira das etapas - cadastrar nova empresa e criar um usuário "Administrador" para esta empresa. Conforme citado anteriormente, apesar de ser possível o procedimento ser realizado com o perfil "Master", é de responsabilidade do novo usuário de perfil "Administrador" cadastrar os usuários da sua empresa conforme escopos/competências;</li>
                <ul>
                    <li><i class="material-icons tiny orange-text">warning</i> Para fins de demonstração, o login de perfil Master é: "<b>mm446021</b>", e sua senha é: "<b>d3spes@</b>"</li>
                </ul>
                <br />
                <li>Após o logon com sucesso, o usuário é redirecionado para a página inicial, onde são exibidos resumos, conforme perfil:</li>
                <ul>
                    <li><i class="material-icons tiny">flag</i> <b><em>Perfil Colaborador</em></b> - exibe seus pedidos em aberto e pedidos já quitados;</li>
                    <li><i class="material-icons tiny">flag</i> <b><em>Perfil Gestor</em></b> - exibe seus pedidos em aberto e pedidos já quitados, além de pedidos de sua área que estão na etapa 1 (pendentes de aprovação Gestor);</li>
                    <li><i class="material-icons tiny">flag</i> <b><em>Perfil Financeiro</em></b> - exibe seus pedidos em aberto e pedidos já quitados, além de pedidos de sua empresa que estão na etapa 2 ou 3 (pendentes de aprovação Financeiro ou Aguardando Pagamento);</li>
                    <li><i class="material-icons tiny">flag</i> <b><em>Perfil Administrador</em></b> - assim como o financeiro, por ser o "admin" da ferramenta em sua empresa, exibe seus pedidos em aberto e pedidos já quitados, além de pedidos de sua empresa que estão na etapa 2 ou 3 (pendentes de aprovação Financeiro ou Aguardando Pagamento);</li>
                    <li><i class="material-icons tiny">flag</i> <b><em>Perfil Master</em></b> - assim como o financeiro, por ser o "admin" da ferramenta, exibe seus pedidos em aberto e pedidos já quitados, além de pedidos de todas as empresas que estão na etapa 2 ou 3 (pendentes de aprovação Financeiro ou Aguardando Pagamento);</li>
                    <ul>
                        <li><i class="material-icons tiny orange-text">warning</i> Apesar de permitido, não é boa prática o usuário de perfil Master efetuar operações de análise de pedidos das demais empresas, somente em casos emergenciais.</li>
                    </ul>
                </ul>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col s12 l12">
            <p><b>Módulos (por ordem de "prioridade")</b></p>
            <ul>
                <li><i class="material-icons tiny">flag</i> <b><em>(Perfil Master)</em></b> Cadastros -> Empresas -> Adicionar Empresa - consiste em criar uma nova empresa no sistema, equivalente ao cadastro de um novo cliente. Clique <a href="#">aqui</a> e veja como cadastrar uma nova empresa;</li>
                <li><i class="material-icons tiny">flag</i> <b><em>Perfil Master)(Perfil Administrador - após ser cadastrado/vinculado à nova empresa)</em></b> Cadastros -> Usuarios -> Novo - consiste em adicionar um novo usuário, vinculando a uma empresa já existente, definindo sua área e seu perfil de acesso. Todo usuário criado é marcado como "inativo", devendo o mesmo ser "ativado" logo após o cadastro. Clique <a href="#">aqui</a> e veja como cadastrar um novo usuário;</li>
                <li><i class="material-icons tiny">flag</i> <b><em>(Perfil Master)(Perfil Administrador)</em></b> Cadastros -> Tipos de item - consiste em criar novos itens passíveis de solicitação de reembolso. Clique <a href="#">aqui</a> e veja como cadastrar um novo item;</li>
                <li><i class="material-icons tiny">flag</i> <b><em>(Todos os perfis)</em></b> Pedidos -> Novo Pedido - consiste em registrar um pedido de reembolso, devendo o solicitante registrar o período da viagem, uma justificativa, um destino, e adicionar as informações de cada despesa desta viagem, sendo cada item (combustível, hospedagem, etc. ) um registro de item. Clique <a href="#">aqui</a> e veja como solicitar um pedido de reembolso;</li>
                <li><i class="material-icons tiny">flag</i> <b><em>(Todos os perfis)</em></b> Pedidos -> Consulta pedidos - exibe (conforme perfil) todos os pedidos já efetuados, independentemente do status atual, sendo passível de filtros. Clique <a href="#">aqui</a> e veja como consultar pedidos;</li>
                <ul>
                    <li><i class="material-icons tiny">arrow_forward</i> Perfil Colaborador - exibe somente seus pedidos;</li>
                    <li><i class="material-icons tiny">arrow_forward</i> Perfil Gestor - exibe todos os pedidos da sua área;</li>
                    <li><i class="material-icons tiny">arrow_forward</i> Perfil Financeiro e Administrador - exibe todos os pedidos da sua empresa;</li>
                    <li><i class="material-icons tiny">arrow_forward</i> Perfil Master - exibe todos os pedidos de todas as empresas;</li>
                </ul>
                <li><i class="material-icons tiny">flag</i><b><em>(Perfil Administrador)(Perfil Master)</em></b> Logs - consiste em exibir as ações realizadas em cada análise de pedido, informando data/hora, usuário que realizou, tipo de ação, e acesso ao pedido consultado. Clique <a href="#">aqui</a> e veja como visualizar os registros de ações dos pedidos.</li>        
            </ul>
        </div>
    </div> 
    <div class="row">
        <div class="col s12 l12">
            <p><b>Considerações finais</b></p>
            <p style="text-align: justify">Este sistema é objeto de Projeto de Conclusão do Curso Superior de Tecnologia em Sistemas para Internet da Universidade Luterana do Brasil - ULBRA, elaborado pelo aluno Uiliam Foschiera de Mello;</p>
            <p style="text-align: justify">Este sistema é baseado na linguagem PHP, com componentes em JavaScript, e utilizando CSS para definições de layout;</p>
            <p style="text-align: justify">Site responsivo. Use-o à vontade em seu tablet/smartphone;</p>
            <p style="text-align: justify">Neste momento, o intuito deste portal é meramente educativo, porém a reprodução parcial ou total de seu conteúdo é expressamente proibida, exceto se explicitamente autorizada pelo autor do site;</p>
            <p style="text-align: justify">Dúvidas, críticas ou sugestões são sempre bem vindas! Envie seus comentários para o e-mail foschierauiliam [at] gmail.com.</p>
        </div>
    </div>
    <footer>
        <div class="page-footer red">
            <div class="footer-copyright red">
                <div class="text-lighten-5">
                    <h6 style="text-align: left; margin:10px;">SGRD - Sistema de Gestão de Reembolso de Despesas</h6>
                    <h6 style="text-align: left; margin:10px;">© <?php echo date('Y'); ?> - Uiliam Mello - Todos os direitos reservados</h6>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>