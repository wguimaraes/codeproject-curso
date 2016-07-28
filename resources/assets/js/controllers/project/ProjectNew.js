angular.module('app.controllers')
        .controller('ProjectNewController', ['$scope', '$location', 'Project', 'Client', 'appConfig', function($scope, $location, Project, Client, appConfig){
            $scope.note = new Project();
            $scope.clients = Client.query();
            $scope.status = appConfig.project.status;
            $scope.save = function(){
            	if($scope.form.$valid){
            		$scope.note.$save({}, function(project, a){
            			if(!project.error){
            				$location.path('projects');
            			}
            		});
            	}
            }
        }]);