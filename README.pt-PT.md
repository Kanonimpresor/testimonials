# Plugin Testemunhos para e107

#### (Elija su idioma abajo / Choose your language below / Escolha o seu idioma abaixo)

[![Language-English](https://img.shields.io/badge/Language-English-blue)](README.md) 
[![Language-Português](https://img.shields.io/badge/Language-Português-green)](README.pt-PT.md) 
[![Language-Español](https://img.shields.io/badge/Language-Español-red)](README.es-ES.md) 

Um plugin moderno de testemunhos para **e107 v2.x** que apresenta testemunhos de clientes num carrossel Bootstrap 5 e disponibiliza um formulário de envio no frontend.

## Funcionalidades

- **Carrossel Bootstrap 5** — Slider responsivo de testemunhos com indicadores e controlos de navegação.
- **Formulário de Envio no Frontend** — Utilizadores autenticados podem enviar testemunhos diretamente no site.
- **Suporte a Captcha** — Captcha opcional com imagem segura do e107 no formulário de envio.
- **Fluxo de Aprovação** — Os testemunhos enviados podem requerer aprovação do administrador antes de serem publicados.
- **Painel de Administração** — Gestão CRUD completa via Admin UI do e107 (listar, criar, editar, eliminar, reordenar).
- **Truncagem de Texto** — Limite configurável de caracteres com alternância interativa "Ler mais / Ler menos".
- **URLs SEF** — Suporte a URLs amigáveis com alias editável através do gestor de URLs do e107.
- **Multi-idioma** — Suporte completo a i18n com traduções em Inglês, Espanhol e Português.
- **Acessível** — Etiquetas ARIA, navegação por teclado e suporte a leitores de ecrã.

## Requisitos

- e107 v2.3.1 ou superior
- PHP 8.0 ou superior
- Bootstrap 5.x (carregado pelo e107 ou tema)
- FontAwesome 5.x (carregado pelo e107 ou tema)

## Instalação

1. Carregue a pasta `testimonials` para `e107_plugins/`.
2. Aceda a **Admin > Gestor de Plugins** e instale o plugin.
3. Aceda a **Admin > Menus** e coloque `testimonials_menu` numa área de menu da(s) página(s) desejada(s).
4. Configure o plugin em **Admin > Testemunhos**.

## Configuração

Navegue até **Admin > Testemunhos > Definições**:

| Definição | Descrição | Predefinição |
|-----------|-----------|--------------|
| Número de itens no menu | Quantos testemunhos mostrar no carrossel | 3 |
| Mensagem até máximo de carateres | Limite de caracteres das mensagens apresentadas (0 = sem limite) | 250 |
| Classe de utilizador que pode enviar | Qual classe de utilizador pode aceder ao formulário de envio | Membros |
| Usar captcha no formulário de envio | Ativar/desativar verificação por captcha | Sim |
| É necessária aprovação? | Exigir aprovação do administrador para novos envios | Sim |

## Configuração de URLs

O plugin regista uma rota de URL SEF. Pode personalizar o alias da URL em:

**Admin > Definições > Configuração de URLs** (`eurl.php?mode=main&action=simple`)

URL predefinido: `/testimonials`

## Estrutura de Ficheiros

```
testimonials/
├── admin_config.php          # Controlador do painel de administração
├── e_header.php              # Carregamento condicional de CSS/JS
├── e_url.php                 # Configuração de URLs SEF
├── plugin.xml                # Manifesto do plugin
├── testimonials.php          # Página de envio no frontend
├── testimonials_menu.php     # Renderizador do menu carrossel
├── testimonials_setup.php    # Rotinas de instalação/atualização
├── testimonials_sql.php      # Esquema da base de dados
├── css/
│   └── testimonials.css      # Estilos do plugin
├── images/
│   ├── testimonials_16.png   # Ícone admin (16px)
│   └── testimonials_32.png   # Ícone admin (32px)
├── js/
│   └── testimonials.js       # Alternância Ler mais/menos
├── languages/
│   ├── English/
│   │   ├── English_admin.php
│   │   ├── English_front.php
│   │   └── English_global.php
│   ├── Portuguese/
│   │   ├── Portuguese_admin.php
│   │   ├── Portuguese_front.php
│   │   └── Portuguese_global.php
│   └── Spanish/
│       ├── Spanish_admin.php
│       ├── Spanish_front.php
│       └── Spanish_global.php
├── shortcodes/
│   └── batch/
│       └── testimonials_shortcodes.php
└── templates/
    └── testimonials_template.php
```

## Base de Dados

O plugin cria uma tabela única `testimonials`:

| Coluna | Tipo | Descrição |
|--------|------|-----------|
| `tm_id` | INT(11) | Chave primária, auto-incremento |
| `tm_name` | VARCHAR(50) | Autor no formato `IDUtilizador.Nome` (0 = anónimo) |
| `tm_url` | VARCHAR(255) | URL da página pessoal do autor |
| `tm_message` | TEXT | Texto do testemunho |
| `tm_datestamp` | INT(10) | Timestamp Unix da criação |
| `tm_blocked` | TINYINT(3) | 0 = ativo, 1 = aguarda aprovação |
| `tm_ip` | VARCHAR(45) | Endereço IP do autor |
| `tm_order` | TINYINT(3) | Ordem de apresentação |

## Traduções

O plugin inclui três idiomas:

- **Inglês** (predefinição/fallback)
- **Espanhol** (Español)
- **Português** (Português)

Para adicionar um novo idioma, crie uma pasta em `languages/` com o nome do idioma e107 (ex.: `French/`) e copie os ficheiros ingleses, renomeando-os e traduzindo-os adequadamente.

## Créditos

- **Autor Original**: [lonalore](http://lonalore.hu) (v3.0, 2015)
- **Modernizado por**: Equipa do projeto Royal Bus (2026)
- **Tema**: Aeolus para e107 por [Jimako](https://www.e107sk.com)

## Licença

Este plugin é disponibilizado sob a [GNU General Public License v2](https://www.gnu.org/licenses/gpl-2.0.html).