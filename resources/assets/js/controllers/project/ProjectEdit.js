angular.module('app.controllers')
        .controller('ProjectEditController',
        ['$scope', '$location', '$routeParams', '$cookies', 'Project', 'Client', 'appConfig',
        function($scope, $location, $routeParams, $cookies, Project, Client, appConfig){
        	$scope.project = Project.get({id: $routeParams.id});
        	$scope.clients = Client.query();
        	$scope.status = appConfig.project.status;
        	$scope.project.due_date = new Date($scope.project.due_date);
            $scope.save = function(){
            	if($scope.form.$valid){
            		$scope.project.owner_id = $cookies.getObject('user').id;
            		Project.update({id: $scope.project.project_id}, $scope.project, function(project){
            			if(!project.error){
            				$location.path('/projects');
            			}
            		});
            	}
            }
        }]);