<?php 
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


                         
$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");

    return $response;
});

//CREATE 
$app->post('/api/senddata', function (Request $request, Response $response, array $args) {
	$fullname=$request->getParam('fullname');
	$username=$request->getParam('username');
	$pass=$request->getParam('password');
	$sql="INSERT INTO users(fullname,username,password) VALUES (:fullname,:username,:password)";

	try{
		$dbobj= new Db;
		$dbobj=$dbobj->connect();
		$stat=$dbobj ->prepare($sql);
		$stat-> bindParam(':fullname',$fullname);
		$stat->bindParam(':username',$username);
		$stat->bindParam(':password',$pass);
		$stat -> execute();
		echo '{"success":{"text": "User has been inserted "}}';
 
	}catch(PDOException $e){

		echo '{"Error":{"text": .' .$e ->getMessage().'}}';
	}


});

//READ
$app->get('/api/readdata', function (Request $request, Response $response, array $args) {
	$sql="SELECT * FROM users";
	try{
		$dbobj= new Db;
		$dbobj=$dbobj->connect();
		$stat=$dbobj ->query($sql);
		$all_users=$stat->fetchAll(PDO::FETCH_OBJ);
		echo json_encode($all_users);

	}catch(PDOException $e){

		echo '{"Error":{"text": .' .$e ->getMessage().'}}';
	}


});


//READ
$app->get('/api/readdata/{id}', function (Request $request, Response $response, array $args) {
	
	$id=$request->getAttribute('id');
	$sql="SELECT * FROM users WHERE id=$id";
	try{
		$dbobj= new Db;
		$dbobj=$dbobj->connect();
		$stat=$dbobj ->query($sql);
		$all_users=$stat->fetchAll(PDO::FETCH_OBJ);
		echo json_encode($all_users);

	}catch(PDOException $e){

		echo '{"Error":{"text": .' .$e ->getMessage().'}}';
	}


});

//DELETE
$app->delete('/api/deletedata/{id}', function (Request $request, Response $response, array $args) {
	$id=$request->getAttribute('id');
	$sql="DELETE FROM users WHERE id=$id";

	try{
		$dbobj= new Db;
		$dbobj=$dbobj->connect();
		$stat=$dbobj ->prepare($sql);
		$stat -> execute();
		
		echo '{"success":{"text": "User has been deleted "}}';

	}catch(PDOException $e){

		echo '{"Error":{"text": .' .$e ->getMessage().'}}';
	}

	

});
//UPDATE

$app->put('/api/updatedata/{id}', function (Request $request, Response $response, array $args) {
	$id=$request->getAttribute('id');
	
	$fullname=$request->getParam('fullname');
	$username=$request->getParam('username');
	$pass=$request->getParam('password');
	$sql="UPDATE users SET fullname=:fullname,username=:username,
		   password=:password WHERE id=$id";

	try{
		$dbobj= new Db;
		$dbobj=$dbobj->connect();
		$stat=$dbobj ->prepare($sql);
		$stat-> bindParam(':fullname',$fullname);
		$stat->bindParam(':username',$username);
		$stat->bindParam(':password',$pass);
		$stat -> execute();
		echo '{"success":{"text": "User has been updated "}}';

	}catch(PDOException $e){

		echo '{"Error":{"text": .' .$e ->getMessage().'}}';
	}




});