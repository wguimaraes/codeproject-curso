angular.module('app.controllers')
        .controller('ProjectNotesNewController', ['$scope', '$location', '$routeParams', 'ProjectNotes', function($scope, $location, $routeParams, ProjectNotes){
            $scope.note = new ProjectNotes();
            $scope.note.project_id = $routeParams.id;
            $scope.save = function(){
            	if($scope.form.$valid){
            		$scope.note.$save({id: $scope.note.project_id}, function(projectNotes, a){
            			if(!projectNotes.error){
            				$location.path('project/' + $routeParams.id + '/notes');
            			}
            		});
            	}
            }
        }]);