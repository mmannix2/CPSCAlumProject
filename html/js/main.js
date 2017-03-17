var app = angular.module('CPSCDatabase', []);

app.factory('dataFactory', ['$http',
    function($http) {
        return {
            getJobs: function () {
                var promise = $http.get('/api/jobs')
                .then(function (response) {
                    console.log(response.data);
                    console.log(response.status);
                    return response.data;
                }, function (error) {
                    //Error
                    console.log("Error getting all jobs.")
                })
            return promise;
            }
        }
    }
]);

app.controller('controller', ['$scope', 'dataFactory',
    function getJobs($scope, dataFactory) {
        
        $scope.jobs = undefined;
        $scope.searchTerms = [];
        $scope.logInInfo = []; 
        
        dataFactory.getJobs().then(function(data)
        {
            $scope.jobs = data;
        }, function (error) {
            console.log(error);
        });
        
        //Currently only captures input and prints it to the console
        $scope.search = function search() {
            console.log($scope.searchTerms);
        }
        
        //Currently only captures input and prints it to the console
        $scope.logIn = function logIn() {
            console.log($scope.logInInfo);
        }
    }
]);
