angular.module('app.controllers')
        .controller('ProjectEditController',
        ['$scope', '$location', '$routeParams', '$cookies', 'Project', 'Client', 'appConfig',
        function($scope, $location, $routeParams, $cookies, Project, Client, appConfig){
        	Project.get({id: $routeParams.id}, function(data){
        		$scope.project = data;
        		$scope.clientSelected = $scope.project.client.data;
        		$scope.project.due_date = new Date($scope.project.due_date);
        	});
        	$scope.status = appConfig.project.status;
            $scope.save = function(){
            	if($scope.form.$valid){
            		$scope.project.owner_id = $cookies.getObject('user').id;
            		Project.update({id: $scope.project.project_id}, $scope.project, function(project){
            			if(!project.error){
            				$location.path('/projects');
            			}
            		});
            	}
            };
            $scope.formatName = function(model){
            	if(model){
            		return model.name
            	}
            	return '';
            };
            $scope.getClients = function(name){
            		var clients = Client.query({
            			search: name,
            			searchFields: 'name:like'
            		}).$promise;
            		return clients;
            };
            $scope.getClientId = function(item){
            	if(item){
            		$scope.project.client_id = item.id;
            	}
            }
        }]);