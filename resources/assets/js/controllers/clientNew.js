angular.module('app.controllers')
        .controller('ClientNewController', ['$scope', '$location', 'Client', function($scope, $location, Client){
            $scope.client = new Client();
            $scope.save = function(){
            	if($scope.form.$valid){
            		$scope.client.$save(function(client, a){
            			if(!client.error){
            				$location.path('client');
            			}
            		});
            	}
            }
        }]);