var app = angular.module('CPSCDatabase', []);

app.factory('dataFactory', ['$http',
    function($http) {
        return {
            getJobs: function () {
                var promise = $http.get('/api/jobs')
                .then(function (response) {
                    console.log(response.data);
                    return response.data;
                }, function (response) {
                    //Error
                    console.log(response.error);
                });
            return promise;
            },
            postJob: function (postJobInfo) {
            /*
            var promise = $http.post('/api/jobs', {
                    "jobTitle": postJobInfo.jobTitle,
                    "companyName": postJobInfo.companyName,
                    "description": postJobInfo.description,
                    "location" : postJobInfo.location
                    
                }) 
            */
                var promise = $http.post('/api/jobs', postJobInfo) 
                .then(function (response){
                    console.log(response.data);
                    return response.data;
                }, function (response){
                    //Error
                    console.log(response.error);
                    console.log(response.e);
                });
                return promise;
            },
            getVolunteers: function () {
                var promise = $http.get('/api/volunteers')
                .then(function (response) {
                    console.log(response.data);
                    return response.data;
                }, function (response) {
                    //Error
                    console.log(response.error);
                });
            return promise;
            }
        };
    }
]);

app.controller('controller', ['$scope', 'dataFactory' ,
    function getJobs($scope, dataFactory) {
        
        $scope.jobs = undefined;
        $scope.searchTerms = []; //Contains the data from the search jobs form
        $scope.logInInfo = []; //Contains the data from the log in form
        $scope.postJobInfo = {
            "jobTitle" : "",
            "companyName": "",
            "description": "",
            "location": 00000,
            "email": "",
            "link": ""
        }; //Contains the data from the post a job form
        $scope.postVolunteerInfo = []; //Contains the data from a volunteer
        
        dataFactory.getJobs().then(function (data) {
            $scope.jobs = data;
        }, function (error) {
            console.log(error);
        });
        
        //Currently only captures input and prints it to the console
        $scope.postJobClicked = function postJobClicked() {
            console.log("Trying to post a job.");
            console.log($scope.postJobInfo);
            dataFactory.postJob($scope.postJobInfo);
        };
        
        //Currently only captures input and prints it to the console
        $scope.searchJobs = function searchJobs() {
            console.log($scope.searchTerms);
        };
        
        //Currently only captures input and prints it to the console
        $scope.postVolunteer = function postVolunteer() {
            console.log($scope.postVolunteerInfo);
        };
        
        //Currently only captures input and prints it to the console
        $scope.logIn = function logIn() {
            console.log($scope.logInInfo);
        };
    }
]);