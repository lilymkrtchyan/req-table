<?php

const TYPE = array(
  0 => 'To Declare',
  1 => 'Concentration',
  2 => 'Elective',
  3 => 'Math',
  4 => 'Statistics',
  5 => 'Coding'
);

// open database
$db = open_sqlite_db('secure/site.sqlite');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">



  <link rel="stylesheet" type="text/css" href="/public/styles/site.css" media="all">
</head>

<body>


    <?php
    // query DB
    $result = exec_sql_query($db, 'SELECT * FROM courses;');
    $records = $result->fetchAll();
    ?>

    <ul>
      <?php foreach ($records as $record) { ?>

        <li>
          <div>
            <h3><?php echo htmlspecialchars($record['name']); ?></h3>

            <p><?php echo htmlspecialchars($record['department']); ?> </p>

            <p><?php echo htmlspecialchars($record['code']); ?> </p>

            <div>
              <?php echo htmlspecialchars(TYPE[$record['type']]); ?>
            </div>

            <p><?php echo htmlspecialchars($record['description']); ?> </p>

            <p><?php echo htmlspecialchars($record['pre-req']); ?> </p>

          </div>

        </li>

      <?php } ?>
    </ul>

  </main>


</body>

</html>
