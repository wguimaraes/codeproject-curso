angular.module('app.controllers')
        .controller('ProjectListController', ['$scope', '$routeParams', 'Project', function($scope, $routeParams, Project){
        	$scope.project = Project.query();
        }]);