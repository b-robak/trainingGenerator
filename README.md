# Workout Plan Generator
Application made for enginner degree in 2016 with fallowing topic: 

*Development of application that supports preparation of gym workout plan.*

Im not really satisfied  with this code since it was beginning with my programming, but still I think that its worth to mention. The interesting thing about it is that generating a plan is based on bounded knapsack problem.

Credits for bounded knapsack problem algorithm:
https://rosettacode.org/wiki/Knapsack_problem/Bounded#JavaScript

## Used technologies
- CSS
- HTML
- JavaScript
- PHP
- MySQL

## Features

#### Different roles

There are three roles of visitors of this application:
- guest (basic view of application)
- user (can use main features of application, its available after registration)
- admin (special role that have privilages from all roles and some additional, available only with a flag from database)


#### Register
<p align="center">
 <img src="https://raw.githubusercontent.com/b-robak/trainingGenerator/master/IMG/register.png"  title="hover text">
</p>


#### Login
<p align="center">
![login](https://raw.githubusercontent.com/b-robak/trainingGenerator/master/IMG/login.png)
</p>


#### Different workout goals

You can chose between two workout goals:
- to lose weight
- to keep your weight


<p align="center">
![workoutGoal](https://raw.githubusercontent.com/b-robak/trainingGenerator/master/IMG/workoutGoal.png)
</p>


#### Generate a plan form

In order to generate workout plan you have to give fallowing data:
- how many calories you want to burn during a day (available in lose weight option)
- how many calories you eat each day
- whats your gender
- how much you weight
- how tall are you
- how old are you


<p align="center">
![workoutForm](https://raw.githubusercontent.com/b-robak/trainingGenerator/master/IMG/workoutForm.png)
</p>


#### Generated plan short info

Thanks to data from generate a plan form, algorithm calculates whats a goal (in kilo calories) for user, then in help of bounded knapsack problems workout plan is generated with exercises for big and small muscles (half calories to burn for big and half to burn for small).

<p align="center">
![generatedPlan](https://raw.githubusercontent.com/b-robak/trainingGenerator/master/IMG/generatedPlan.png)
</p>


#### Generated workout plan

Here is example of generated workout plan, with fallowing info:
- exercise name
- whats the energy value of each exercise
- how many series for each exercise to do
- whats the type of muscle involved in this exercise (big/small)
- whats the muscle involved in this exercise

<p align="center">
![workoutPlan](https://raw.githubusercontent.com/b-robak/trainingGenerator/master/IMG/workoutPlan.png)
</p>

User can delete actual plan and generate new one, based on new goal.


#### Add new exercises

Admins can add new exercises to database with this form. It needs fallowing data:

- exercise name
- whats the energy value of each series
- efficiency factor 
- how many series is maximum for this exercise
- whats the type of muscle involved in this exercise (big/small)
- whats the muscle involved in this exercise

<p align="center">
![addExercise](https://raw.githubusercontent.com/b-robak/trainingGenerator/master/IMG/addExercise.png)
</p>


#### Actual list of all exercises

Admins can view list of all exercises from databasem and in case they can delete each of them.

<p align="center">
![exercisesList](https://raw.githubusercontent.com/b-robak/trainingGenerator/master/IMG/exercisesList.png)
</p>
