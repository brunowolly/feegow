## Requerimentos
Laravel - <https://laravel.com/> Versão ^8<br/>
Quasar - <https://quasar.dev/> Versão ^2 <br/>
Composer - <https://getcomposer.org/><br/>
NPM - <https://www.npmjs.com/> Versão ^8<br/>
MySQL -<https://www.mysql.com/><br/>


## Como testar

#### Criar um diretório e entrar no mesmo

```bash
mkdir DesafioBruno
cd DesafioBruno
```

#### Fazer clone deste repositório

O passo abaixo criará um diretório chamado feegow,  dentro do diretório criando anteriormente (DesafioBruno)

```console
git clone git@github.com:brunowolly/feegow.git
```

##### Entre no diretório criado

```
cd feegow
```

<br/>

### Como executar o back-end

#### Executar os seguintes passos

```bash
cd back-end
composer install
vendor/bin/sail up -d
````

#### Executar migration para criação das tabelas

```bash
docker exec -it back-end-feegow-1 php artisan migrate
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
npm install
quasar dev
```

### Para acessar a aplicação

Feegow - App <http://localhost:8081>

### Para ver os agendamentos

Feegow - Agendamentos <http://localhost:8081/appointment>
