angular.module('app.controllers')
        .controller('ProjectNotesRemoveController', ['$scope', '$location', '$routeParams', 'ProjectNotes', function($scope, $location, $routeParams, ProjectNotes){
            $scope.note = ProjectNotes.get({id: $routeParams.id, idNote: $routeParams.idNote});
            $scope.remove = function(){
            	$scope.note.$delete({id: $routeParams.id, idNote: $routeParams.idNote}).then(function(){
            		$location.path('project/' + $routeParams.id + '/notes');
            	});
            }
        }]);