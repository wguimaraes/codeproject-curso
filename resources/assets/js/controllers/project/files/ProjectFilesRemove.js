angular.module('app.controllers')
        .controller('ProjectFilesRemoveController', ['$scope', '$location', '$routeParams', 'ProjectFiles', function($scope, $location, $routeParams, ProjectFiles){
            $scope.file = ProjectFiles.get({id: $routeParams.id, idFile: $routeParams.idFile});
            $scope.remove = function(){
            	$scope.file.$delete({id: $routeParams.id, idFile: $routeParams.idFile}).then(function(){
            		$location.path('project/' + $routeParams.id + '/files');
            	});
            }
        }]);