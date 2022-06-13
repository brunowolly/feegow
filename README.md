##Tecnologias utilizadas
Laravel - <https://laravel.com/>
Quasar Dev - <https://quasar.dev/>
Composer - <https://getcomposer.org/>
MySQL -<https://www.mysql.com/>

## Como testar

#### Criar um diretório e entrar no mesmo

```bash
mkdir feegow
cd fegoow
```

#### Fazer clone deste repositório

```console
git clone git@github.com:brunowolly/feegow.git
```

<br/>

### Como executar o back-end

#### Entrar no diretório back-end e executar o sail

```bash
cd back-end
vendor/bin/sail up -d
````

#### Executar migration para criação das tabelas

```bash
docker exec -it back-end-laravel.test-1 php artisan migrate
```

#### Voltar para o diretório principal

```bash
cd ..
````

<br/>

### Como executar o front-end

#### Entrar no diretório front-end
Entrar no diretório front-end, executar o composer para instalação dos pacotes e execurtar o quasar

```bash
cd front-end/
composer install
quasar dev
```

### Para acessar a aplicação

Feegow - App <http://localhost:8081>

### Para ver os agendamentos

Feegow - Agendamentos <http://localhost:8081/appointment>
