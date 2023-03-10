<?php

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

</body>

</html>
