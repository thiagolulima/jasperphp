# Conteúdo desenvolvido na playlist sobre Jasper Reports com Laravel.

** [Link Video Aulas](https://www.youtube.com/playlist?list=PL5o2Kk3hauP_SOnVv5lz9TwZp1np8i_4G) **

## Configure seu banco de dados no arquivo .env

```
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=seudb
DB_USERNAME=root
DB_PASSWORD=
```

## Rode os comandos no terminal
```
composer install
php artisan migrate
php artisan db:seed
php artisan key:generate
php artisan serve --port=80

```
## routes 
```
localhost/report   :  gera um exemplo de relatorio em PDF 
localhost/parametros : lista os parametros do relatório
```
## Verificando possíveis erros

###### No caminho : vendor/cossou/jasperphp/src/jasperPHP  
###### Acesse a classe JasperPHP.php  
###### Na Function : public function output()  retorno o comando:

```
 public function output() {
        return $this->the_command;
}
```
###### No controller ControllerReport  e na Function generateReport
###### Altere a funcão para a função a seguir:

```
echo JasperPHP::process(
      storage_path('app/public/relatorios/reportJasper.jasper') ,
      $output,
      array($extensao),
      array('user_name' => ''),
      $this->getDatabaseConfigMysql(),
      "pt_BR"
    )->output();
     exit();
```

 ###### Pegue o comando gerado e execute no terminal para verificar o erro.

