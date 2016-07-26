angular.module('app.controllers')
        .controller('ProjectNotesEditController', ['$scope', '$location', '$routeParams', 'ProjectNotes', function($scope, $location, $routeParams, ProjectNotes){
        	$scope.note = ProjectNotes.get({id: $routeParams.id, idNote: $routeParams.idNote});
            $scope.save = function(){
            	if($scope.form.$valid){
            		ProjectNotes.update({id: $scope.note.project_id, idNote: $scope.note.note_id}, $scope.note, function(projectNote){
            			if(!projectNote.error){
            				$location.path('project/' + $routeParams.id + '/notes');
            			}
            		});
            	}
            }
        }]);