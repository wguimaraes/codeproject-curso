angular.module('app.controllers')
        .controller('ProjectFilesEditController', ['$scope', '$location', '$routeParams', 'ProjectFiles', function($scope, $location, $routeParams, ProjectFiles){
        	$scope.file = ProjectFiles.get({id: $routeParams.id, idFile: $routeParams.fileId});
            $scope.save = function(){
            	if($scope.form.$valid){
            		ProjectFiles.update({id: $routeParams.id, idFile: $scope.file.id}, $scope.file, function(projectFile){
            			if(!projectFile.error){
            				$location.path('project/' + $routeParams.id + '/files');
            			}
            		});
            	}
            }
        }]);