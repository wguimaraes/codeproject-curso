angular.module('app.controllers')
        .controller('ProjectFilesRemoveController', ['$scope', '$location', '$routeParams', 'ProjectFiles', function($scope, $location, $routeParams, ProjectFiles){
            $scope.file = ProjectFiles.get({id: null, idFile: $routeParams.fileId});
            $scope.remove = function(){
            	$scope.file.$delete({id: $routeParams.id, idFile: $routeParams.fileId}).then(function(){
            		$location.path('project/' + $routeParams.id + '/files');
            	});
            }
        }]);