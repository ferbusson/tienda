<?php
// Routes

/*$app->get('/[{name}]', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});*/

/*$app->get("/test/{name}",function($request,$response,$args){
  $name = $args["name"];
  $body = $response->getBody();
  $body->write("Hola ".$name);
  return $response;
});*/

$app->get('/usuario',function($request,$response,$args){

  $query = $this->db->prepare("SELECT * FROM usuario");
  $query->execute();
  $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
  $response = $response->withStatus(200);
  $response = $response->withHeader("Content-Type","application/json");
  $body = $response->getBody();
  $body->write(json_encode($resultado));

  return $response;
});


//obtener usuario por id
$app->get('/usuario{id}',function($request,$response,$args){

  $query = $this->db->prepare("SELECT * FROM usuario WHERE id_usuario= :id");

  $query->execute(array(':id'=>$args["id"]));

  $resultado = $query->fetchAll(PDO::FETCH_ASSOC);

  if(count($resultado)>0){
        $response = $response->withStatus(200);
        $body = $response->getBody();
        $body->write(json_encode($resultado[0]));
    }
    else {
      $response = $response->withStatus(404);
    }

  $response = $response->withHeader("Content-Type","application/json");


  return $response;
});



//post
//insertar usuario

$app->post('/usuario',function($request,$response,$args){

  $body = $request->getBody();
  $objeto = json_decode($body);
  $query = $this->db-prepare("INSERT INTO usuario(cedula,nombre,apellido,fecha_nacimiento,imagen)
                            VALUES(:n,:a,:f,:i)");
  $query->execute(array(':n'=>$objeto->nombre,':a'=>$objeto->apellido,':f'=>$objeto->fecha_nacimiento,':i'=>$objeto->imagen,));

  if($state){
      $response = $response->withStatus(200);
      $rta = json_encode(array('state'=>'ok'));
  }else {
    $response = $response->withStatus(500);
    $rta = json_encode(array('state'=>'fail'));
  }
  $body = $response->getBody();
  $body->write($rta);

  $response = $response->withHeader("Content-Type","application/json");

  return $response;
});
