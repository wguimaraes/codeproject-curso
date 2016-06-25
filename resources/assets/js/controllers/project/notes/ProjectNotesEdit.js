angular.module('app.controllers')
        .controller('ProjectNotesController', ['$scope', '$location', '$routeParams', 'ProjectNotes', function($scope, $location, $routeParams, ProjectNotes){
            $scope.projectNotes = ProjectNotes.get({id: $routeParams.id});
            $scope.save = function(){
            	if($scope.form.$valid){
            		ProjectNotes.update({id: $scope.projectNotes.id}, $scope.projectNotes, function(projectNote){
            			if(!projectNote.error){
            				$location.path('project/' + $routeParams.id + '/notes');
            			}
            		});
            	}
            }
        }]);