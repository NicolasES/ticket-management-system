# 🎫 Ticket Management System

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
[![React](https://img.shields.io/badge/React-19-61DAFB?style=for-the-badge&logo=react)](https://reactjs.org)
[![Inertia](https://img.shields.io/badge/Inertia.js-2.0-9553E9?style=for-the-badge&logo=inertia)](https://inertiajs.com)
[![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-4.0-38B2AC?style=for-the-badge&logo=tailwind-css)](https://tailwindcss.com)
[![Tests Status](https://img.shields.io/github/actions/workflow/status/NicolasES/ticket-management-system/tests.yml?branch=main&label=Tests&style=for-the-badge&logo=github)](https://github.com/NicolasES/ticket-management-system/actions)
[![Lint Status](https://img.shields.io/github/actions/workflow/status/NicolasES/ticket-management-system/lint.yml?branch=main&label=Lint&style=for-the-badge&logo=github)](https://github.com/NicolasES/ticket-management-system/actions)

Este é um projeto de demonstração para portfólio, focado na aplicação de **Clean Architecture** e **Domain-Driven Design (DDD)** dentro do ecossistema Laravel. O objetivo é construir um sistema de gerenciamento de tickets robusto, testável e de fácil manutenção.

---

## 🏛️ Arquitetura e Design

O projeto foi estruturado seguindo os princípios da **Clean Architecture**, garantindo que o núcleo do negócio (Domain) seja independente de frameworks, bancos de dados ou qualquer externalidade.

### Camadas da Aplicação

1.  **Domain (`app/Domain`)**: Contém as entidades, value objects, contratos de repositórios, enums e exceções. É o núcleo puro da aplicação, sem dependências de frameworks.
2.  **Application (`app/Application`)**: Onde residem os casos de uso (Use Cases). Eles orquestram as entidades do domínio para realizar ações específicas do negócio.
3.  **Infrastructure (`app/Infrastructure`)**: Implementações técnicas. Aqui ficam as comunicações com banco de dados (Eloquent Repositories), serviços externos, filas (RabbitMQ) e outras ferramentas.
4.  **Presentation (`app/Http` & `resources/js`)**: A camada de entrega. Controladores Laravel que funcionam como adaptadores entre a web e os casos de uso.

### Padrões Aplicados
- **Entities & Aggregates**: Representação rica do estado do negócio.
- **Value Objects**: Para garantir integridade de dados (e.g., Status, Email).
- **Repository Pattern**: Abstração total da camada de dados.
- **Dependency Injection**: Desacoplamento entre contratos e implementações.
- **Event-Driven Architecture**: Utilização de filas para processos assíncronos.

---

## 🚀 Tecnologias

- **Backend**: PHP 8.2+ & Laravel 12
- **Frontend**: React 19 (Modern Hooks, Components)
- **Comunicação**: Inertia.js (Server-side rendering com experiência de SPA)
- **CSS**: Tailwind CSS 4.0
- **UI Components**: Radix UI (Shadcn style)
- **Database**: MySQL 8
- **Messaging**: RabbitMQ
- **Testes**: Pest PHP (Unitários e de Integração)
- **Dev Environment**: Docker & PHP 8.2+

---

## ✨ Funcionalidades Principais

- [x] **Gestão de Tickets**: Criação, listagem e acompanhamento de chamados.
- [x] **Departamentos**: Organização de fluxos por áreas (Suporte, Financeiro, etc.).
- [x] **Gestão de Usuários**: Fluxo completo de autenticação e atribuição.
- [x] **Impersonação**: Ferramenta premium para suporte (login como outro usuário para depuração).
- [x] **Filas Assíncronas**: Processamento de tarefas em background via RabbitMQ.
- [x] **Design Moderno**: Interface responsiva, dark mode e micro-animações.

---

## 🛠️ Instalação e Setup

1.  **Clonar o Repositório**:
    ```bash
    git clone https://github.com/NicolasES/ticket-management-system.git
    cd order-management-system
    ```

2.  **Instalar Dependências e Configurar**:
    ```bash
    composer install
    cp .env.example .env
    php artisan key:generate
    ```

3.  **Ambiente Docker**:
    Certifique-se de que o Docker está rodando e inicie os serviços:
    ```bash
    docker-compose up -d
    ```

4.  **Banco de Dados**:
    ```bash
    php artisan migrate --seed
    ```

5.  **Executar Aplicação**:
    Este comando inicia o servidor e o Vite simultaneamente:
    ```bash
    composer run dev
    ```

6.  **Acesse no Navegador**: `http://localhost:8000`

---

## 🧪 Testes

A qualidade do código é garantida através de testes rigorosos com [Pest](https://pestphp.com/).

```bash
# Rodar todos os testes
php artisan test

# Rodar com cobertura (requer PCOV ou Xdebug)
php artisan test --coverage
```

---

## 📦 Estrutura de Pastas

```text
app/
├── Application/       # Casos de Uso (Orquestração)
├── Domain/            # Núcleo do Negócio (Entidades, VOs, Contratos)
├── Infrastructure/    # Implementações Técnicas (Databases, APIs)
├── Http/              # Controllers e Camada Web
└── Models/            # Modelos Eloquent (usados pela Infra)
resources/
├── js/                # Frontend React 19
└── css/               # Tailwind CSS 4
```

---

Criado por [Nicolas](https://github.com/NicolasES) para fins de demonstração técnica. 🚀
