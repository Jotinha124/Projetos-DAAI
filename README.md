# Projetos — Plataforma de Gestão de Projetos de Investigação

Trabalho final de **Desenvolvimento Avançado de Aplicações para Internet (DAAI)**
Escola Superior de Tecnologia de Abrantes — Instituto Politécnico de Tomar

**Autor:** João Matias (81983)

## Relatório

📄 **[Ver o relatório do projeto (PDF)](Relat%C3%B3rio%20de%20DAII.pdf)**

---

## Índice

- [Relatório](#relatório)
- [Tecnologias](#tecnologias)
- [Funcionalidades](#funcionalidades)
- [Estrutura do projeto](#estrutura-do-projeto)
- [Instalação](#instalação)
- [Referências](#referências)

---

## Tecnologias

| Tecnologia | Utilização |
|---|---|
| [Laravel 12](https://laravel.com/) (PHP ^8.2) | Framework principal (MVC, Eloquent, rotas, migrations) |
| [Livewire 3](https://livewire.laravel.com/) | Interfaces dinâmicas sem recarregar a página |
| [Laravel UI](https://github.com/laravel/ui) + Bootstrap | Autenticação e componente visual |
| [PHPMailer](https://github.com/PHPMailer/PHPMailer) | Envio de e-mails através de uma conta Gmail |
| Vite + Node.js | Compilação dos assets (CSS/JS) |
| MySQL | Base de dados |

## Funcionalidades

- **Autenticação** com dois tipos de utilizador: **Investigador** e **Técnico de Apoio**.
- **Estado do utilizador** (ativo/inativo) — utilizadores inativos ficam impedidos de entrar.
- **Gestão de utilizadores** — listar, criar e editar.
- **Gestão de projetos** — criar, editar, rever, verificar e comentar projetos.
- **Anexos** guardados num disco privado (`storage/app/public/documentos`) e servidos através de uma rota própria.
- **Equipas** — um projeto pode ter vários investigadores.
- **Comentários** e comunicação entre técnicos de apoio.
- **Dashboard** personalizado para cada tipo de utilizador.
- **Logs** das ações efetuadas e **notificações por e-mail**.

### Ciclo de vida de um projeto

```
Draft ──► Enviado para autorização ──► Autorizado ──┬──► Iniciado ──┬──► Terminado
                                                    │               └──► Reprovado
                                                    └──► Cancelado
```

Os estados e tipos de utilizador são configurados no `.env` (ver [Variáveis de ambiente](#variáveis-de-ambiente-da-aplicação)).

## Estrutura do projeto

```
app/
├── Http/
│   ├── Controllers/        # Login, Home, SendEmail, Logs
│   └── Livewire/
│       ├── Dashboard.php
│       ├── Projeto/        # CriarProjeto, EditarProjeto, VerProjeto, MeuProjeto,
│       │                   # ReverProjeto, VerificarProjeto, ComentarProjeto
│       └── Utilizador/     # CriarUtilizadores, EditarUtilizadores, VerUtilizadores
└── Models/                 # User, Investigador, TecnicoApoio, Projeto, Anexo, Equipa,
                            # Comentario, Financiamento, Log, Status, TipoProjeto, ...
database/migrations/        # Estrutura completa da base de dados
resources/views/livewire/   # Views Blade dos componentes Livewire
routes/web.php              # Rotas da aplicação
```

### Rotas principais

| Rota | Descrição |
|---|---|
| `/login` | Autenticação |
| `/dashboard` | Dashboard do utilizador |
| `/projetos` | Lista de projetos |
| `/projetos/criar` · `/projetos/editar/{id}` | Criar / editar projeto |
| `/projetos/ver/{id}` · `/projetos/rever/{id}` | Ver / rever projeto |
| `/projetos/verificar/{id}` · `/projetos/comentar/{id}` | Verificar / comentar projeto (Técnico de Apoio) |
| `/utilizadores` · `/utilizadores/criar` · `/utilizadores/editar/{id}` | Gestão de utilizadores |
| `/ficheiro/{id}` | Acesso a um anexo |

Todas as rotas exceto login, logout e ficheiro estão protegidas pelo middleware `auth`.

---

## Instalação

### Requisitos

- **PHP** 8.2 ou superior
- **Composer** — [getcomposer.org/download](https://getcomposer.org/download/) (no Windows, descarregar e executar o `Composer-Setup.exe`)
- **Node.js** — [nodejs.org/en/download](https://nodejs.org/en/download) (no Windows, usar o *Windows Installer (.msi)* e clicar em "Next" até concluir)
- **MySQL** (opcionalmente uma ferramenta de administração como o [DBeaver](https://dbeaver.io/))

Para confirmar que as ferramentas estão instaladas e no `PATH`:

```bash
php -v
composer -v
node -v
```

### Passo a passo

1. **Obter o projeto** — clonar o repositório ou descompactar a pasta:
   ```bash
   git clone https://github.com/<utilizador>/Projetos-DAAI
   cd Projetos-DAAI
   ```
2. **Criar a base de dados** no MySQL (apenas a base de dados vazia; guardar o nome para o passo seguinte).
3. **Configurar o ambiente** — copiar o `.env.example` para `.env` e preencher as credenciais nos campos vazios (`DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`, e as credenciais de e-mail):
   ```bash
   cp .env.example .env
   ```
4. **Instalar as dependências** na raiz do projeto:
   ```bash
   composer install
   npm install
   ```
5. **Gerar a chave da aplicação:**
   ```bash
   php artisan key:generate
   ```
6. **Criar as tabelas** da base de dados:
   ```bash
   php artisan migrate
   ```
7. **Compilar os assets:**
   ```bash
   npm run build
   ```
8. **Arrancar o servidor:**
   ```bash
   php artisan serve
   ```
   A aplicação fica disponível em <http://127.0.0.1:8000>.

> Em alternativa, os passos 3 a 7 podem ser executados de uma só vez com `composer run setup` (depois de preencher o `.env`).

### Variáveis de ambiente da aplicação

Para além das configurações habituais do Laravel, a aplicação usa as seguintes variáveis no `.env`. Os valores têm de corresponder aos IDs dos registos nas tabelas `tipo_utilizador` e `status`:

| Variável | Valor | Significado |
|---|---|---|
| `TIPO_INVESTIGADOR` | 1 | Tipo de utilizador Investigador |
| `TIPO_TECNICO` | 2 | Tipo de utilizador Técnico de Apoio |
| `STATUS_DRAFT` | 1 | Projeto em rascunho |
| `STATUS_ENVIADO` | 2 | Projeto enviado |
| `STATUS_ENVIADO_AUTORIZACAO` | 3 | Enviado para autorização |
| `STATUS_AUTORIZACAO` | 4 | Autorizado |
| `STATUS_INICIADO` | 5 | Iniciado |
| `STATUS_TERMINADO` | 6 | Terminado |
| `STATUS_REPROVADO` | 7 | Reprovado |
| `STATUS_CANCELADO` | 8 | Cancelado |

**E-mail (Gmail via SMTP):** preencher `MAIL_USERNAME` com a conta Gmail e `MAIL_PASSWORD` com uma [palavra-passe de aplicação](https://myaccount.google.com/apppasswords) da Google.

---

## Referências

- <https://laravel.com/>
- <https://livewire.laravel.com/>
- <https://laravel.com/docs/12.x/mail>
- <https://www.webappfix.com/post/how-to-send-mail-using-phpmailer-in-laravel.html>
- <https://laracasts.com/>
- <https://raviyatechnical.medium.com/laravel-12-bootstrap-5-auth-scaffolding-tutorial-with-laravel-ui-package-9ec9c640ffdc>
