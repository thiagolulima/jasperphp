<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JasperPHP;

class ControllerReport extends Controller
{
    public function getDatabaseConfig()
    {
      /* $jdbc_dir : Informe o caminho real onde o driver jdbc.
      Adicione o jdbc_driver conforme array abaixo.
      jdbc_url : informe o IP e a porta da instancia do seu banco e databasename informe o nome do banco */
      
      $jdbc_dir = 'C:\xampp\htdocs\JasperReport\vendor\cossou\jasperphp\src\JasperStarter\jdbc';
       return [
         'driver'   => 'generic',
         'host'     => env('DB_HOST'),
         'port'     => env('DB_PORT'),
         'username' => env('DB_USERNAME'),
         'password' => env('DB_PASSWORD'),
         'database' => env('DB_DATABASE'),
         'jdbc_driver' => 'com.microsoft.sqlserver.jdbc.SQLServerDriver',
         'jdbc_url' => 'jdbc:sqlserver://192.168.1.250:1433;databaseName='.env('DB_DATABASE').'',
         'jdbc_dir' =>  $jdbc_dir
      ];
   }

   public function getDatabaseConfigMysql()
   {
       return [
           'driver'   => 'mysql',
           'host'     => env('DB_HOST'),
           'port'     => env('DB_PORT'),
           'username' => env('DB_USERNAME'),
           'password' => env('DB_PASSWORD'),
           'database' => env('DB_DATABASE')
       ];
   }

   public function generateReport()
   {   
         
    $extensao = 'pdf' ;
    $nome = 'testeJasper';
    $filename =  $nome  . time();
    $output = base_path('/public/reports/' . $filename);

    JasperPHP::compile(storage_path('app/public'). '/relatorios/reportJasper.jrxml')->execute();
   
    JasperPHP::process(
      storage_path('app/public/relatorios/reportJasper.jasper') ,
      $output,
      array($extensao),
      array('user_name' => ''),
      $this->getDatabaseConfigMysql(),
      "pt_BR"
    )->execute();

    /* verificando possiveis erros - Try to output the command using the function output();
    Comente o comando acima e descomente o que esta abaixo, pegue o rerultado e execute no termnial 
    para verificar o erro */

   /* echo JasperPHP::process(
      storage_path('app/public/relatorios/reportJasper.jasper') ,
      $output,
      array($extensao),
      array('user_name' => ''),
      $this->getDatabaseConfigMysql(),
      "pt_BR"
    )->output();
     exit(); */
   
   $file = $output .'.'.$extensao ;

   if (!file_exists($file)) {
     abort(404);
   }
   if($extensao == 'xls')
    {
      header('Content-Description: Arquivo Excel');
      header('Content-Type: application/x-msexcel');
      header('Content-Disposition: attachment; filename="'.basename($file).'"');
      header('Expires: 0');
      header('Cache-Control: must-revalidate');
      header('Pragma: public');
      header('Content-Length: ' . filesize($file));
      flush(); // Flush system output buffer
      readfile($file);
      unlink($file) ;
      die();
    }
    else if ($extensao == 'pdf')
     {
       return response()->file($file)->deleteFileAfterSend();
     }
   
   }
  
   public function getParametros()
	{
	  $output = 
        JasperPHP::list_parameters(storage_path('app/public'). '/relatorios/reportJasper.jrxml')->execute();
   
        foreach($output as $parameter_description)
        {
            $parameter_description = trim($parameter_description);
            //echo $parameter_description . '<br>' ;
            $dados = explode(" ", trim($parameter_description), 4 );
            echo '<strong>Parametro:</strong>  ' .  $dados[1] . 
                ' <strong>Tipo de Dados:</strong>  ' . $dados[2] .   
                ' <strong>Descricao do Campo:</strong>   ' . $dados[3] . '<br>';
        }
	}
      
}
