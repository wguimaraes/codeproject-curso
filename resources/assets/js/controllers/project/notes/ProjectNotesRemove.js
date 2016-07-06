angular.module('app.controllers')
        .controller('ProjectNotesRemoveController', ['$scope', '$location', '$routeParams', 'ProjectNotes', function($scope, $location, $routeParams, ProjectNotes){
            $scope.projectNotes = ProjectNotes.get({id: $routeParams.id});
            $scope.remove = function(){
            	$scope.projectNotes.$delete().then(function(){
            		$location.path('project/' + $routeParams.id + '/notes');
            	});
            }
        }]);