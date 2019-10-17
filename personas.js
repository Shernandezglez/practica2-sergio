angular.module('app', [])
	.controller('view-Personas', ['$scope','$http', function ($scope, $http)
	{
		var event; 
		var id;
		//var rutA=<?php echo $url;?>;
		
		$http.get('./angular.php?index=1').then(function (res)
		{	
			$scope.personas = res.data;
			console.log(res.data);
		});

		$scope.submit = function () 
		{
			if(event) {
				$scope.create();
			} else {
				$scope.update();
			}
		};

		$scope.view = function ($id) 
		{
			event = false;
			id = $id;
			//console.log($id);
			$('#title').text("Detalles persona");
			$("#contentModal").modal("show");
			$('#personaId').show();
			$http.get('./angular.php?index=1&id=' + $id)
				.then(function (res){	
					$scope.persona = res.data;
					console.log(res.data);
				 })
				/*.catch(function(response) {
  					console.error('Persona error', response.status, response.data);
				});*/
		};

		$scope.add = function() {
			event = true;
			$('#title').text("Registrar persona");
			$("#contentModal").modal("show");
			$('#personaId').hide();
			$scope.persona = {};
		};

		$scope.create = function () 
		{
			var data=$scope.persona;
			$http.post('./create.php?index=1', data)
				.then(function(res) {
					console.log("Create:");
					console.log(res.data);
					location.reload();
				});
		};

		$scope.update = function () 
		{
			console.log($scope.persona);
			$http.put('./update.php?index=1&id=' + id, $scope.persona)
				.then(function(res) {
					console.log("Update:");
					console.log(res.data);
					location.reload();
				});
		}

		$scope.delete = function ($id) 
		{
			$http.delete('./delete.php?index=1&id=' + $id, $scope.persona)
				.then(function(res) {
					console.log("Delete:");
					console.log(res.data);
					location.reload();
			});
		};
	}]);