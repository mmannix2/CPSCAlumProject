//These are for testing purposes. Eventually this data will come from the DB.
var job1 = new Object();
job1.name = 'Java Developer';
job1.companyName = 'Company A';
job1.description = 'You will write programs in Java.';

var job2 = new Object();
job2.name = 'Unix System Admin';
job2.companyName = 'Company B';
job2.description = 'You will make sure the computers work.';

var job3 = new Object();
job3.name = 'Summer Intern';
job3.companyName = 'Company C';
job3.description = 'You will get the coffee.';

var jobs = [ job1, job2, job3];

//var jobs = undefined;

var app = angular.module('CPSCDatabase', []);
app.controller('controller', function($scope) {
    $scope.jobs = jobs;
});