<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JasperPHP;

class ControllerReport extends Controller
{
    public function getDatabaseConfig()
    {
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

   public function generateReport()
   {   
         
    $extensao = 'pdf' ;
    $nome = 'testeJasper';
    $filename =  $nome  . time();
    $output = base_path('/public/reports/' . $filename);

    JasperPHP::compile(storage_path('app/public'). '/relatorios/teste10.jrxml')->execute();
   
    
    JasperPHP::process(
      storage_path('app/public/relatorios/teste10.jasper') ,
      $output,
      array($extensao),
      array('AdataIni' => '2020-01-15 00:00:04.340' , 'Bdatafim' => '2020-03-15 23:56:04.340'),
      $this->getDatabaseConfig(),
      "pt_BR"
    )->output();
/*
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
   
   */
   }
  
   public function getParametros()
	{
	  $output = 
        JasperPHP::list_parameters(storage_path('app/public'). '/relatorios/teste10.jrxml')->execute();
   
        foreach($output as $parameter_description)
        {
            echo $parameter_description . '<br>' ;
            $parameter_description = trim($parameter_description);
            $parameter_description  = str_replace("  " , " " , $parameter_description);
            $parameter_description  = str_replace("   " , " " , $parameter_description);
            $parameter_description  = str_replace("    " , " " , $parameter_description);
            $dados = explode(" ", trim($parameter_description), 4 );
          // echo 'Parametros:  ' .  $dados[1] . '  Tipo de Dados:  ' . $dados[2] . ' Descricao do Campo:   ' . $dados[3] . '<br>';
            foreach($dados as $d)
            {
              echo $d . '-'. '<br>'  ;
            }
           $dados = null ;
           $parameter_description = null;
        }
	}
      
}
