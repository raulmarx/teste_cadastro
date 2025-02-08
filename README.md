### Passo a passo
Clone Repositório
```sh
git clone https://github.com/raulmarx/teste_cadastro.git
```

```sh
cd teste_cadastro
```

Crie o Arquivo .env
```sh
cp .env.example .env
```

Atualize as variáveis de ambiente do arquivo .env
```dosini
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=nome_que_desejar_db
DB_USERNAME=nome_usuario
DB_PASSWORD=senha_aqui

```

Instale as dependências do projeto
```sh
composer install
```

Gere a key do projeto Laravel
```sh
php artisan key:generate
```

Gera tabela usario
```sh
php artisan migrate
```

Gera usarios 
```sh
php artisan db:seed
```

Startartando Servidor
```sh
php artisan serve
```


