<?php
error_reporting(-1);
ini_set('display_errors', 1);
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


//GET de todas las etiqueta

$app->get('/etiqueta/{id}', function (Request $request, Response $response){
    $id_publicacion = $request->getAttribute('id');

    
    $sql = "SELECT * FROM etiqueta WHERE id_publicacion='$id_publicacion'";
    try {
        $db = new db();
        $db = $db -> conectionDB();
        $result = $db -> query($sql);
        
        if($result -> rowCount() > 0){
            $usuarios = $result -> fetchAll (PDO::FETCH_OBJ);
            echo json_encode($usuarios);

        }else{
            echo "No hay usuarios aun!.";
        }
        $result = null;
        $db = null;

    }catch(PDOException $e){
        echo '{"error" : {"texto":'.$e->getMessage().'}';
    }
}); 


//POST Agregar nueva etiqueta

$app->post('/etiqueta/new', function(Request $request, Response $response){
    
    $etiqueta = $request->getParam('etiqueta');
    $id_publicacion = $request->getParam('id_publicacion');
    
     

    $sql= "INSERT INTO etiqueta (id_publicacion,  etiqueta) 
    VALUES (:id_publicacion, :etiqueta)";

    try{
       

        $etiqueta_check = preg_match('~^\#[a-zA-Z0-9]{4,9}$~i', $etiqueta);
        if ($etiqueta_check>0){
            $db = new db();
            $db = $db -> conectionDB();
            $result = $db -> prepare ($sql);
            $result->bindParam(':id_publicacion',$id_publicacion);
            $result->bindParam(':etiqueta',$etiqueta);
           
            
    
    
            $result->execute();
            echo json_encode("Etiqueta Guardada");
            $result=null;
            $db=null;
        }else {
            echo "Etiqueta no valida";
        }
       
    }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}'; 
    }

});