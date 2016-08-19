angular.module('app.controllers')
        .controller('ProjectNewController', ['$scope', '$location', '$cookies', 'Project', 'Client', 'appConfig', function($scope, $location, $cookies, Project, Client, appConfig){
            $scope.project = new Project();
            $scope.status = appConfig.project.status;
            
            $scope.popup1 = {
            	opened: false
            };
            
            $scope.open1 = function($event){
            	$scope.popup1.opened = true;
            };
            
            $scope.save = function(){
            	if($scope.form.$valid){
            		$scope.project.owner_id = $cookies.getObject('user').id;
            		$scope.project.due_date = new Date($scope.project.due_date);
            		$scope.project.$save().then(function(){
            			$location.path('/projects');
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