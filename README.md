# Agro Coop - Sistema de Gestão para Cooperativa Agropecuária

[![linter](https://github.com/joaoxaviersilva/agro-coop/actions/workflows/lint.yml/badge.svg)](https://github.com/joaoxaviersilva/agro-coop/actions/workflows/lint.yml)

> 🟩 **Badge Verde (Passing):** Garante que o código está estável, seguro e compilando perfeitamente sem erros.

## Sobre o Projeto

O **Agro Coop** é uma aplicação web desenvolvida utilizando o framework Laravel seguindo a arquitetura MVC (Model-View-Controller).

O sistema foi criado como atividade prática da disciplina **Programação Web III (PWIII)** com o objetivo de simular o gerenciamento operacional de uma cooperativa agropecuária, permitindo o registro, controle, edição e acompanhamento de safras recebidas dos cooperados.

A aplicação possui módulos para:

* Controle Operacional Reativo
* Registro e Gestão de Lotes (CRUD Completo)
* Inteligência de Estoque e Volumetria Física
* Monitoramento Dinâmico de Silos
* Visualização de Indicadores Agrícolas e Cotações

---

# Tecnologias Utilizadas

* PHP 8+
* Laravel 12
* Blade Template Engine
* Eloquent ORM
* MySQL
* Tailwind CSS
* HTML5
* CSS3
* JavaScript

---

# Arquitetura do Projeto

O sistema foi desenvolvido seguindo o padrão MVC.

## Model

Responsável pela comunicação com o banco de dados.

Arquivo:

```php
app/Models/Safra.php

```

Tabela utilizada:

```sql
safras

```

Campos:

| Campo | Tipo |
| --- | --- |
| id | bigint |
| lote_codigo | varchar |
| cooperado_nome | varchar |
| safra_tipo | varchar |
| safra_quantidade | double |
| classificacao | varchar |
| status | varchar |
| created_at | timestamp |
| updated_at | timestamp |

---

## Controller

Arquivo:

```php
app/Http/Controllers/CooperativaController.php

```

Responsável por centralizar toda a lógica de negócio do sistema.

### Método home()

Consulta e processa o acumulado físico do banco de dados (convertendo KG para Toneladas no caso de grãos) para alimentar os contadores da página inicial.

```php
public function home()

```

### Método operation()

Carrega todos os lotes cadastrados e calcula dinamicamente o status de lotação dos Silos 01 e 02 com base no volume geral armazenado.

```php
public function operation()

```

### Método stock()

Calcula a taxa de ocupação percentual e volumétrica do Silo Norte (Grãos) e Silo Sul (Pecuária) em tempo real, disparando travas visuais no front-end caso a capacidade passe do limite de segurança.

```php
public function stock()

```

### Método report()

Renderiza o formulário de cadastro e exibe um mini-histórico lateral com os 3 últimos registros do banco.

```php
public function report()

```

### Método storeReport()

Valida a entrada, gera um código de lote único baseado no ano corrente (`#LT-2026-XX`), aplica regras de classificação automática e persiste o registro no banco.

```php
public function storeReport(Request $request)

```

### Métodos edit() e update()

Módulo de atualização do CRUD. `edit()` busca o lote selecionado para preencher o formulário e `update()` valida e salva as correções operacionais efetuadas pelo usuário.

```php
public function edit($id)
public function update(Request $request, $id)

```

### Método destroy()

Módulo de exclusão física do CRUD. Remove o registro selecionado permanentemente da base de dados.

```php
public function destroy($id)

```

---

# Estrutura do Banco de Dados

Migration:

```php
database/migrations/create_safras_table.php

```

Estrutura:

```php
Schema::create('safras', function (Blueprint $table) {
    $table->id();
    $table->string('lote_codigo')->unique();
    $table->string('cooperado_nome');
    $table->string('safra_tipo');
    $table->double('safra_quantidade', 15, 2);
    $table->string('classificacao')->default('Em Análise');
    $table->string('status')->default('Pendente');
    $table->timestamps();
});

```

---

# Rotas da Aplicação

Arquivo:

```php
routes/web.php

```

## Páginas Principais e Leitura (Read)

* `GET /` -> `home()` -> Nome: `coop.home` (Home com contadores dinâmicos)
* `GET /operacoes` -> `operation()` -> Nome: `coop.operation` (Painel com tabela de lotes)
* `GET /mercado` -> `stock()` -> Nome: `coop.stock` (Dashboard de volumetria e cotações)
* `GET /relatorio` -> `report()` -> Nome: `coop.report` (Tela de cadastro)

## Criação de Dados (Create)

* `POST /relatorio` -> `storeReport()` -> Nome: `coop.storeReport`

## Atualização de Dados (Update)

* `GET /operacoes/{id}/editar` -> `edit()` -> Nome: `coop.edit` (Formulário de edição)
* `PUT /operacoes/{id}` -> `update()` -> Nome: `coop.update` (Processa alteração)

## Exclusão de Dados (Delete)

* `DELETE /operacoes/{id}` -> `destroy()` -> Nome: `coop.destroy`

## Tratamento de Erros

* `Route::fallback(...)` -> Captura requisições inválidas e renderiza uma view personalizada de erro 404.

---

# Demonstração do Sistema

## Página Inicial
![Página Inicial](img/print1.png)

## Controle Operacional & Ações do CRUD
![Controle Operacional](img/print2.png)

## Mercado, Cotações & Ocupação de Silos
![Mercado e Estoque](img/print3.png)

## Cadastro de Safras
![Cadastro de Safras](img/print4.png)

---

# Instalação e Execução

Para rodar o projeto localmente, execute a sequência de passos abaixo no seu terminal de comando:

1. **Clonar o Repositório:** git clone https://github.com/joaoxaviersilva/agro-coop.git
2. **Acessar a Pasta:** cd agro-coop
3. **Instalar Dependências:** composer install
4. **Criar Configuração de Ambiente:** cp .env.example .env
5. **Gerar Chave de Segurança:** php artisan key:generate
6. **Configuração da Base de Dados:** Abra o arquivo .env criado e ajuste as credenciais do seu MySQL local.
7. **Rodar Estrutura de Tabelas:** php artisan migrate
8. **Subir Servidor do Laravel:** php artisan serve

Após concluir a execução dos passos, abra o seu navegador de internet e digite o endereço local: http://127.0.0.1:8000

---

# Estrutura Simplificada do Projeto

```text
app
├── Http
│   └── Controllers
│       └── CooperativaController.php
│
├── Models
│   └── Safra.php

database
└── migrations
    └── create_safras_table.php

resources
└── views
    ├── home.blade.php
    ├── operation.blade.php
    ├── edit.blade.php
    ├── report.blade.php
    ├── stock.blade.php
    └── errors
        └── 404.blade.php
    └── layouts
        └── app.blade.php

routes
└── web.php

```

---

# Principais Funcionalidades Implementadas

* **CRUD Ciclo Completo:** Mecanismos de cadastro, listagem, edição rápida de pátio e exclusão com caixas de confirmação nativas.
* **Geração Inteligente de Lotes:** Identificadores gerados de maneira procedural via string contendo o ano civil atual.
* **Lógica de Negócio Dinâmica (Back-to-Front):** O status das unidades físicas (Silos e Frigorífico) muda de cor e texto com base nas somas e pendências de documentos reais do MySQL.
* **Barras de Progresso Nativas:** Gráficos de capacidade renderizados de forma matemática via Blade style strings e Tailwind CSS, sem dependência de bibliotecas externas de JavaScript.
* **Tratamento de Erros:** Middleware de fallback interceptando rotas inexistentes com layout customizado da aplicação.

---

# Autor

**João Victor Xavier da Silva**

Projeto desenvolvido para a disciplina de Programação Web III (PWIII).

Centro Paula Souza - ETEC.
