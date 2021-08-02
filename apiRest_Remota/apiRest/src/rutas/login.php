<?php
error_reporting(-1);
ini_set('display_errors', 1);
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


//$userData

$app->post('/login-check',function(Request $request, Response $response){
    $id_usuario = $request->getParam('id_usuario');
    $sql = "SELECT id_usuario FROM usuario 
    WHERE id_usuario='$id_usuario' ";
    try{
       
        $db = new db();
        $db = $db -> conectionDB();  
        $data='';
 
        $result = $db -> prepare ($sql);
        $result->bindParam(':id_usuario',$id_usuario);        
        $result->execute();
        
        $count = $result->rowCount();
        $data=$result->fetch(PDO::FETCH_OBJ); 
        if(!empty($data)){
            $user_id=$data->id_usuario;
        }  
        $db=null;
        if($userData){
            $userData=json_encode($userData);
            echo '{"token": ' .$userData . '}';   
        }else{
            echo '{"error":{"text":"No esta logeado"}}';
        }
        
    }catch(PDOException $e){
        echo '{"error" : {"texto":'.$e->getMessage().'}'; 
    }
    

});


//LOGIN QUE REPARADO AHORA
/*
$app->post('/login',function(Request $request, Response $response){
    $id_usuario = $request->getParam('id_usuario');
    $contrasena = $request->getParam('contrasena');
    $contrasena=hash('sha256',$contrasena);
    $sql = "SELECT id_usuario FROM usuario 
    WHERE (id_usuario='$id_usuario' OR email_usuario='$id_usuario') 
    AND contrasena ='$contrasena'";

    try{
        $db = new db();
        $db = $db -> conectionDB();  
        $data='';
 
        $result = $db -> prepare ($sql);
        $result->bindParam(':id_usuario',$id_usuario);        
        $result->bindParam(':contrasena',$contrasena);
        $result->execute();
        
        $count = $result->rowCount();
        $data=$result->fetch(PDO::FETCH_OBJ);       
        //$result=null;
        $count = null;
        if(!empty($data)){
            $count=null;       
            //$data='';
            //esto es si el usuario cuenta como oferente
            
            $sql2="SELECT usuario FROM oferente WHERE usuario='$id_usuario'";
            $result2= $db -> prepare ($sql2);
            $result2->bindParam(':usuario',$id_usuario);
            $result2->excecute();
            
            $count=$result2->rowCount();
            $data2=$result2->fetch(PDO::FETCH_OBJ);
            /*if($count>0){
                    
                $user_id=$data2->id_usuario;
                $data2->token = apiToken($user_id);
                /*if($data){
                    
                    echo '{"data": Es OFERENTE}';            
                }*/
            //}
            /*
            $count= null;
            $sql="SELECT usuario FROM moderador WHERE usuario='$id_usuario'";
            $result= $db -> prepare ($sql);
            $result->bindParam(':usuario',$id_usuario);
            $result->excecute();
            $count=$result->rowCount();
            if($count>0){
                $user_id=$data->id_usuario;
                $data->token = apiToken($user_id);
                if($data){
                    
                    echo '{"data": Es MODERADOR}';             
                }
            }
            //esto es si el usuario no cuenta ni como oferente ni como moderador
            
            $user_id=$data->id_usuario;
            $data->token = apiToken($user_id);
        }
        $db=null;

        if($data){
            $data=json_encode($data);
            echo '{"data": ' .$data . '}';            
        }else{
            echo '{"error":{"text":"Bad request wrong username and password"}}';
        }
    }catch(PDOException $e){
        echo '{"error" : {"texto":'.$e->getMessage().'}'; 
    }
});*/
// ACA ESTA EL LOGIN VIEJO POR SI DEJA DE FUNCIONAR EL NUEVO

$app->post('/login',function(Request $request, Response $response){
    $id_usuario = $request->getParam('id_usuario');
    $contrasena = $request->getParam('contrasena');
    $contrasena=hash('sha256',$contrasena);
    $sql = "SELECT id_usuario FROM usuario 
    WHERE (id_usuario='$id_usuario' OR email_usuario='$id_usuario') 
    AND contrasena ='$contrasena'";

    try{
        $db = new db();
        $db = $db -> conectionDB();  
        $data='';
 
        $result = $db -> prepare ($sql);
        $result->bindParam(':id_usuario',$id_usuario);        
        $result->bindParam(':contrasena',$contrasena);
        $result->execute();
        
        $count = $result->rowCount();
        $data=$result->fetch(PDO::FETCH_OBJ);       

        if(!empty($data)){
            $user_id=$data->id_usuario;
            $data->token = apiToken($user_id);
        }
        $db=null;

        if($data){
            $data=json_encode($data);
            echo '{"data": ' .$data . '}';            
        }else{
            echo '{"error":{"text":"Bad request wrong username and password"}}';
        }
    }catch(PDOException $e){
        echo '{"error" : {"texto":'.$e->getMessage().'}'; 
    }
});



//
$app->post('/signup',function(Request $request, Response $response){
/*    
    $data = json_decode($request->getBody());


    $id_usuario=$data->id_usuario;
    $nombre_usuario=$data->nombre_usuario;
    $contrasena=$data->contrasena;
    $email_usuario=$data->email_usuario;
*/
    
    $id_usuario = $request->getParam('id_usuario');
    $nombre_usuario=$request->getParam('nombre_usuario');
    $contrasena = $request->getParam('contrasena');
    $email_usuario=$data=$request->getParam('email_usuario');
  

    /*$sql = "SELECT id_usuario FROM usuario 
    WHERE (id_usuario='$id_usuario' OR email_usuario='$email_usuario') 
    AND contrasena =:contrasena";
    */
    try{
        $username_check = preg_match('~^[A-Za-z0-9_]{3,20}$~i', $id_usuario);
        $email_check = preg_match('~^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$~i', $email_usuario);
        $password_check = preg_match('~^[A-Za-z0-9!@#$%^&*()_]{6,20}$~i', $contrasena);
        
        /*echo $email_check.'<br/>'.$email;*/
        
        if (strlen(trim($id_usuario))>0 && strlen(trim($contrasena))>0 && strlen(trim($email_usuario))>0 && $email_check>0 && $username_check>0 && $password_check>0)
        {
           /* echo 'here';*/
            $db =  new db();
            $db = $db -> conectionDB();
            $userData = '';
            $sql = "SELECT id_usuario FROM usuario WHERE id_usuario='$id_usuario' or email_usuario='$email_usuario'";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id_usuario", $id_usuario,PDO::PARAM_STR);
            $stmt->bindParam("email_usuario", $email_usuario,PDO::PARAM_STR);
            $stmt->execute();
            $mainCount=$stmt->rowCount();
            $created=time();
            if($mainCount==0)
            {
                
                /*Inserting user values*/
                $sql1="INSERT INTO usuario(id_usuario,contrasena,email_usuario,nombre_usuario)
                VALUES(:id_usuario,:contrasena,:email_usuario,:nombre_usuario)";
                $stmt1 = $db->prepare($sql1);
                $stmt1->bindParam("id_usuario", $id_usuario,PDO::PARAM_STR);
                $contrasena=hash('sha256',$contrasena);
                //echo $contrasena;
                $stmt1->bindParam("contrasena", $contrasena,PDO::PARAM_STR);
                $stmt1->bindParam("email_usuario", $email_usuario,PDO::PARAM_STR);
                $stmt1->bindParam("nombre_usuario", $nombre_usuario,PDO::PARAM_STR);
                $stmt1->execute();
                //echo"PASE EL IF";
                $userData=internalUserDetails($email_usuario);
                
            }
            
            $db = null;
         

            if($userData){
                $userData = json_encode($userData);
                echo '{"userData": ' .$userData . '}';
            } else {
              
                

                
                echo '{"error":{"text":"Enter valid data '.$id_usuario.','.$nombre_usuario.','.$contrasena.','.$email_usuario.'"}}';
            }

           
        }
        else{
            
            
            echo '{"error":{"text":"Enter valid data '.$id_usuario.','.$nombre_usuario.','.$contrasena.','.$email_usuario.'"}}';
        }
    }
    catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }

});


//DETALLES INTERNOS DE USUARIO
function internalUserDetails($input) {
    
    try {
        $db =  new db();
        $db = $db -> conectionDB();
        
        $sql = "SELECT id_usuario, nombre_usuario, email_usuario 
        FROM usuario WHERE id_usuario=:input or email_usuario=:input";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("input", $input,PDO::PARAM_STR);
        $stmt->execute();
        $usernameDetails = $stmt->fetch(PDO::FETCH_OBJ);
        $usernameDetails->token = apiToken($usernameDetails->id_usuario);
        $db = null;
        return $usernameDetails;
        
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
    
}


$app->post('/userImage','userImage'); /* User Details */
function userImage(){
    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());
    $user_id=$data->user_id;
    $token=$data->token;
    $imageB64=$data->imageB64;
    $systemToken=apiToken($user_id);
    try {
        if(1){
            $db = getDB();
            $sql = "INSERT INTO imagesData(b64,user_id_fk) VALUES(:b64,:user_id)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("user_id", $user_id, PDO::PARAM_INT);
            $stmt->bindParam("b64", $imageB64, PDO::PARAM_STR);
            $stmt->execute();
            $db = null;
            echo '{"success":{"status":"uploaded"}}';
        } else{
            echo '{"error":{"text":"No access"}}';
        }
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

$app->post('/getImages', 'getImages');
function getImages(){
    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());
    $user_id=$data->user_id;
    $token=$data->token;
    
    $systemToken=apiToken($user_id);
    try {
        if(1){
            $db = getDB();
            $sql = "SELECT b64 FROM imagesData";
            $stmt = $db->prepare($sql);
           
            $stmt->execute();
            $imageData = $stmt->fetchAll(PDO::FETCH_OBJ);
            $db = null;
            echo '{"imageData": ' . json_encode($imageData) . '}';
        } else{
            echo '{"error":{"text":"No access"}}';
        }
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
