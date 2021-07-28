# STHS-Attendance
Attendance Page for Mom's School, STHS 

<h3>Features</h3>
<ul>
  <li>Take Attendance</li>
  <li>View Attendance for a single day</li>
  <li>View Atteandance for a whole class</li>
</ul>

<h3>Operation</h3>
<ol>
  <li>Import database Attendance_Database.sql</li>
  <li>Install apache and PHP 7.1 or later (sudo apt-get install apache2 && sudo apt-get install php)</li>
  <li>Add all the files to the public directory</li>
</ol>

<h3>Database Operation</li>
  Once in the database, there will be three tables
  <ul><li>login (contains login username and password with access level. Password doesnt follow the best practises as this has to be developed quick)</li><li>register (attendance data in the form of JSON file)</li><li>stud_list (All students list)</li></ul>
 To add a teacher, insert into login with INSERT INTO `login` (`user`, `pass`, `sub`, `authorise`) VALUES ('${teacher-name}', '${teacher-password}', '${Subject}, ${Subject-2}', '${Class}, ${Class-2}'). Separate the Classes and Subjects with a coma(','). Then, in stud_list add the students name INSERT INTO `stud_list` (`Sl No`, `Name`, `Class`, `Avatar`) VALUES (NULL, '${name}', '${class}', NULL). Avatar was used to identify differently named Google accounts in Google Meet/ Classroom, but was later discarded and is now deprecated. Sl No is the primary key here, so one can modify that and make it Admission number.
