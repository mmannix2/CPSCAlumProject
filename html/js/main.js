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
                var promise = $http.post('/api/jobs', postJobInfo) 
                .then(function (response){
                    console.log(response.data);
                    return response.data;
                }, function (response){
                    //Error
                    console.log(response.error);
                    console.log(response.message);
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
        
        //Contains the data from the search jobs form
        $scope.searchTerms = {
            "jobTitle": undefined,
            "companyName": undefined,
            "keywords": undefined,
            "location": undefined,
            "distance": undefined
        }; 
        
        //Contains the data from the log in form
        $scope.logInInfo = {
            "username": undefined,
            "password": undefined
        }; 
        
        //Contains the data from the post a job form
        $scope.postJobInfo = {
            "jobTitle": undefined,
            "companyName": undefined,
            "description": undefined,
            "location": undefined,
            "email": undefined,
            "link": undefined
        };
        
        $scope.postJobStatus = "Job not yet submitted.";
        
        //Contains the data from a volunteer
        $scope.postVolunteerInfo = []; 
        
        dataFactory.getJobs().then(function (data) {
            $scope.jobs = data;
        }, function (error) {
            console.log(error);
        });
        
        //Currently only captures input and prints it to the console
        $scope.postJobClicked = function postJobClicked() {
            console.log("Trying to post a job.");
            console.log($scope.postJobInfo);
            dataFactory.postJob($scope.postJobInfo)
            /* TODO Find a way to notify the user that the form was submitted successfully.
            if(success == true ) {
                $scope.postJobStatus = "Job posted successfully!";
                $scope.$apply();
            }
            */
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