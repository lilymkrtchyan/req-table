<?php


$title = 'Flowershop Confirmation';
$nav_flowershop_class = 'active_page';

$name = $_POST["name"];
$department = $_POST["department"];
$type = $_POST["type"];
$code = $_POST["code"];
$description = $_POST["description"];

const TYPE = array(
    0 => 'Core',
    1 => 'Elective',
    2 => 'Concentration',
    3 => 'Math',
    4 => 'Statistics',
    5 => 'Coding'
  );

  $db = open_sqlite_db('secure/site.sqlite');

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Info Sci Courses</title>

  <link rel="stylesheet" type="text/css" href="/public/styles/site.css" media="all">
</head>

<body>

<?php
    // query DB
    $result = exec_sql_query($db, 'SELECT * FROM courses;');
    $records = $result->fetchAll();
    ?>
<center>
    <h1>INFORMATION SCIENCE MAJOR REQUIREMENTS</h1>
<table>
      <?php foreach ($records as $record) { ?>
       <tr>

          <div class="course">
            <th><?php echo htmlspecialchars($record['name']); ?></th>

            <th><?php echo htmlspecialchars($record['code']); ?></th>

            <th><?php echo htmlspecialchars($record['department']); ?></th>


             <th> <?php echo htmlspecialchars(TYPE[$record['type']]); ?> </th>


          </div>
      </tr>
      <?php } ?>
      </table>

      <p>The list of the courses (course numbers, codes, departments, and some of the descriptions) are copied from Cornell University's Information Science website.</p>
</center>

<form method="post" action="/" novalidate>

        <div class="label-input">
          <label for="name">Class name:</label>
          <input id="name" type="text" name="name" />
        </div>

        <div class="label-input">
          <label for="department">Department:</label>
          <input id="department" type="text" name="department" />
        </div>

        <div class="label-input">
          <label for="code">Course Code:</label>
          <input id="code" type="text" name="code" />
        </div>

        <div class="label-input">
          <label for="description">Course Description:</label>
          <input id="description" type="text" name="description" />
        </div>

        <div class="label-input">
          <label for="phone_field">Department:</label>
          <input id="department" type="text" name="department" />
        </div>

        <div class="form-group label-input" role="group" aria-labelledby="requirement_type">
          <div id="type">Requirement Type:</div>

          <div>
            <div>
              <input type="radio" id="core" name="type" value="core" />
              <label for="core">Core Requirement</label>
            </div>
            <div>
              <input type="radio" id="math" name="type" value="math" />
              <label for="math">Mathematics Requirement</label>
            </div>
            <div>
              <input type="radio" id="cs" name="type" value="cs" />
              <label for="cs">Computer Science Requirement</label>
            </div>
            <div>
              <input type="radio" id="elective" name="type" value="elective" />
              <label for="elective">Elective</label>
            </div>
            <div>
              <input type="radio" id="concentration" name="type" value="concentration" />
              <label for="concentration">Concentration Requirement</label>
            </div>
          </div>
        </div>

        <div class="align-right">
          <input type="submit" value="Sumbit Course" />
        </div>
      </form>

      <p>We added the course with the following information: </p>

<dl>
  <dt>Course Name</dt>
  <dd><?php echo htmlspecialchars($name); ?></dd>

  <dt>Requirement Type</dt>
  <dd><?php echo htmlspecialchars($type); ?></dd>

  <dt>Course Department</dt>
  <dd><?php echo htmlspecialchars($department); ?></dd>

  <dt>Course Code</dt>
  <dd><?php echo htmlspecialchars($code); ?></dd>

  <dt>Course Description</dt>
  <dd><?php echo htmlspecialchars($description); ?></dd>

</dl>


</body>

</html>
