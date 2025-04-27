# Marketplace para Confeitarias

Este projeto é um marketplace para confeitarias, onde os usuários podem cadastrar, editar, excluir e consultar confeitarias, bem como visualizar os produtos associados a cada uma. O sistema também exibe as confeitarias em um mapa interativo, permitindo que os usuários visualizem informações sobre as confeitarias ao clicar nos marcadores.


## Tecnologias Utilizadas

- **Backend**: Laravel
- **Frontend**: Vue.js
- **Ponte entre Backend e Frontend**: Inertia.js
- **Banco de Dados**: PostgreSQL
- **Mapas**: Leaflet (OpenStreetMap)
- **Armazenamento de Imagens**: Laravel Storage

## Funcionalidades

- **Cadastro de Confeitarias**: Permite que os administradores do marketplace cadastrem novas confeitarias, com informações como nome, descrição, imagem, latitude e longitude.
- **Edição e Exclusão de Confeitarias**: Administradores podem editar ou excluir confeitarias cadastradas.
- **Cadastro de Produtos**: Cada confeitaria pode cadastrar produtos com informações como nome, descrição e preço.
- **Exibição de Produtos**: Usuários podem visualizar os produtos de cada confeitaria.
- **Mapa Interativo**: As confeitarias são exibidas em um mapa interativo usando Leaflet, com marcadores baseados nas coordenadas de latitude e longitude fornecidas.
- **Resumo da Confeitaria**: Ao clicar em um marcador no mapa, o usuário verá um resumo da confeitaria, incluindo o nome e imagem, além de um link para a página de detalhes.

## Pré-requisitos

- PHP >= 8.1
- Composer
- Node.js
- NPM ou Yarn
- PostgreSQL

## Instalação

### Backend (Laravel)

1. Clone o repositório:
   ```bash
   git clone https://github.com/seu-usuario/marketplace-confeitarias.git
   cd marketplace-confeitarias

# Instale as dependências do Laravel:
bash
Copiar
Editar
composer install

# Crie o arquivo .env a partir do .env.example:

bash
Copiar
Editar
cp .env.example .env

# Configure o banco de dados no arquivo .env:

env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=confeitaria_emanuelnerys
DB_USERNAME=postgres
DB_PASSWORD=123emanuel

# Inicie o servidor local:

bash
Copiar
Editar
php artisan serve

# Instale as dependências do frontend:
bash
Copiar
Editar
cd resources/js
npm install

# Acesso do projeto
http://localhost:8000/home