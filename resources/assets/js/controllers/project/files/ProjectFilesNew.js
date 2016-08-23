angular.module('app.controllers')
        .controller('ProjectFilesNewController', ['$scope', '$location', '$routeParams', 'ProjectFiles', function($scope, $location, $routeParams, ProjectFiles){
            $scope.file = new ProjectFiles();
            $scope.file.project_id = $routeParams.id;
            $scope.save = function(){
            	if($scope.form.$valid){
            		$scope.file.$save({id: $scope.file.project_id}, function(projectFiles, a){
            			if(!projectFiles.error){
            				$location.path('project/' + $routeParams.id + '/files');
            			}
            		});
            	}
            }
        }]);