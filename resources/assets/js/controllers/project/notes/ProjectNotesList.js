angular.module('app.controllers')
        .controller('ProjectNotesController', ['$scope', 'ProjectNotes', function($scope, ProjectNotes){
            $scope.projectNotes = ProjectNotes.query();
        }]);