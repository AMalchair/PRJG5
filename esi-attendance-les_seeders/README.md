# ESI - ATTENDANCE 

## Seeder order
php artisan db:seed
- StudentSeeder
- GroupSeeder
- LiaisonStudentGroup
- TeacherSeeder
- CourseSeeder
- PaeSeeder
- SeanceSeeder

## Heroku

### How to use heroku :
- create an application in heroku;
#### in the terminal positionned in the app directory
- init your repository with the laravel app;
- add the postgreSQL addons with heroku :  
```
heroku addons:create heroku-postgresql:hobby-dev
```
- open the heroku bash
```
heroku run bash
```
- in the bash run the migrate and the seeds

```
php artisan migrate/db:seed ...
```

## Admin
### Make sure to update the composer
```
composer update
```
### Make sure to migrate the admin database table
```
php artisan admin:install
```
## What's done

- Heroku
- Consulter la liste
- Import des fichiers groupe
- La prise des présences
- Supression d'élève
- Import fichier horaire
- Ajout d'élève
- Ajouter fichier horaire dans la db
- Schéma de la DB
- Admin pane
## What we are working on


## Website

http://lit-atoll-02597.herokuapp.com/

## Schéma de la base de donnée
les différentes tables  
- Student
`un étudiant a un PAE et est associé à un groupe`
- Pae
`PAE est le programme annuel de l'étudiant qui appartient a un'étudiant etcontient  tous les cours qu'il devra suivre durant l'année`
- Teacher
`un teacher donne cour durant une séance et prend des présences liées aux étudiants d'un groupe`
- Course
`un cour et inscrit dans un Pae et est dispendé durant une séance`
- Liaison_Student_Group
`la liaison entre un groupe et un étudiant permet d'avoir plusieurs  étudiant dans un groupe et plusieurs  groupes pour un étudiant`
- Group
`un groupe a une seule liaison avec un étudiant et un groupe suit un cour à un moment donné`
- Seance
`une séance de cour est donné par un teacher à un ou plusieurs groupes et permettant à un teacher de dire quels étudiants étaient présents`
- Attendance
`Attendance est une table qui nous donnera la liste des présences des étudiants durant une séance de cour.`
