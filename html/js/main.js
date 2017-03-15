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
        
        
        dataFactory.getJobs().then(function(data)
        {
            $scope.jobs = data;
        }, function (error) {
            console.log(error);
        });
        $scope.search = function search() {
            console.log($scope.searchTerms);
        }
    }
]);