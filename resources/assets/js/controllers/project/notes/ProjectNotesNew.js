angular.module('app.controllers')
        .controller('ProjectNotesController', ['$scope', '$location', 'ProjectNotes', function($scope, $location, ProjectNotes){
            $scope.projectNotes = new ProjectNotes();
            $scope.save = function(){
            	if($scope.form.$valid){
            		$scope.projectNotes.$save(function(projectNotes, a){
            			if(!projectNotes.error){
            				$location.path('project/' + $scope.projectNotes.projectId + '/notes');
            			}
            		});
            	}
            }
        }]);