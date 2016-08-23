angular.module('app.controllers')
        .controller('ProjectFilesEditController', ['$scope', '$location', '$routeParams', 'ProjectFiles', function($scope, $location, $routeParams, ProjectFiles){
        	$scope.file = ProjectFiles.get({id: $routeParams.id, idFile: $routeParams.idFile});
            $scope.save = function(){
            	if($scope.form.$valid){
            		ProjectFiles.update({id: $scope.file.project_id, idFile: $scope.file.file_id}, $scope.file, function(projectFile){
            			if(!projectFile.error){
            				$location.path('project/' + $routeParams.id + '/files');
            			}
            		});
            	}
            }
        }]);