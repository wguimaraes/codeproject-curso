angular.module('app.controllers')
        .controller('ProjectNotesShowController', ['$scope', '$location', '$routeParams', 'ProjectNotes', function($scope, $location, $routeParams, ProjectNotes){
            $scope.projectNotes = ProjectNotes.get({id: $routeParams.id});
        }]);